<?php
 
/**
 * TWITTER FEED PARSER
 * Credits:
 * Hashtag/username parsing based on: http://snipplr.com/view/16221/get-twitter-tweets/
 * Feed caching: http://www.addedbytes.com/articles/caching-output-in-php/
 * Feed parsing: http://boagworld.com/forum/comments.php?DiscussionID=4639
 */

// Get settings
require_once('config.php');

// Cache file
$cache_file = '../cache/tweets.txt';

// Time that the cache was last filled.
$cache_file_created = ((@file_exists($cache_file))) ? @filemtime($cache_file) : 0;

// A flag so we know if the feed was successfully parsed.
$tweet_found = false;

// Show file from cache if still valid.
if (time() - $twitter_cachetime < $cache_file_created) {

	$tweet_found = true;

	// Display tweets from the cache.
	@readfile($cache_file);	

} else {

	// Fetch the RSS feed from Twitter.
	//$url = 'http://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $your_twitter_username . '&count=20';
	$url = 'http://api.twitter.com/1/statuses/user_timeline.json?include_entities=true&include_rts=true&screen_name=' . $your_twitter_username . '&count=20';
	$count = 1;

	// Initiate the curl session
	$feed = curl_init();

	// Get tweets via CURL
	$feed = curl_init($url);
	curl_setopt($feed, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($feed, CURLOPT_HEADER, 0);
	$feed = curl_exec($feed);

	// Parse the RSS feed to an JSON object.
	$json = json_decode($feed);

	if (isset($json) && !empty($json)){

		/* If feed has error */
		if (is_object($json) && $json->error) {
			echo '<li>' . $json->error . '</li>';
			return;
		}

		// Start output buffering.
		ob_start();

		// Open the twitter wrapping element.
		$tweets = "";
		$tweet_found = true;


		// Iterate over tweets.
		foreach ($json as $tweet) {

			$tweet_text = $tweet->text;
			$tweet_first_char = substr($tweet_text, 0, 1);
 			
 			if ($tweet_first_char != '@' || $ignore_replies == false) {

				// check if any entites exist and if so, replace then with hyperlinked versions
				if (!empty($tweet->entities->urls) || !empty($tweet->entities->hashtags) || !empty($tweet->entities->user_mentions)){
					
					foreach ($tweet->entities->urls as $url) {
							$find = $url->url;
							$replace = '<a href="'.$find.'">'.$find.'</a>';
							$tweet_text = str_replace($find,$replace,$tweet_text);
					}
													
					foreach ($tweet->entities->hashtags as $hashtag) {
							$find = '#'.$hashtag->text;
							$replace = '<a href="http://twitter.com/#!/search/%23'.$hashtag->text.'">'.$find.'</a>';
							$tweet_text = str_replace($find, $replace, $tweet_text);
					}
													
					foreach ($tweet->entities->user_mentions as $user_mention) {
							$find = "@".$user_mention->screen_name;
							$replace = '<a href="http://twitter.com/'.$user_mention->screen_name.'">'.$find.'</a>';
							$tweet_text = str_replace($find, $replace, $tweet_text);
					}
				}
			}


			// Convert Tweet display time to a UNIX timestamp. Twitter timestamps are in UTC/GMT time.
			$tweet_time = strtotime($tweet->created_at);	

			if ($twitter_style_dates){

				// Current UNIX timestamp.
				$current_time = time();
				$time_diff = abs($current_time - $tweet_time);

				switch ($time_diff) {
					case ($time_diff < 60):
						$display_time = "$time_diff seconds ago";
					break;
					case ($time_diff >= 60 && $time_diff < 3600):
						$min = floor($time_diff/60);
						$display_time = "$min minute";
						if ($min > 1) $display_time .= "s";
						$display_time .= " ago";
					break;
					case ($time_diff >= 3600 && $time_diff < 86400):
						$hour = floor($time_diff/3600);
						$display_time = "about $hour hour";
						if ($hour > 1) $display_time .= "s";
						$display_time .= " ago";
					break;
					case ($time_diff >= 86400 && $time_diff < 604800):
						$day = floor($time_diff/86400);
						$display_time = "about $day day";
						if ($day > 1) $display_time .= "s";
						$display_time .= " ago";
					break;
					case ($time_diff >= 604800 && $time_diff < 2592000):
						$week = floor($time_diff/604800);
						$display_time = "about $week week";
						if ($week > 1) $display_time .= "s";
						$display_time .= " ago";
					break;
					case ($time_diff >= 2592000 && $time_diff < 31536000):
						$month = floor($time_diff/2592000);
						$display_time = "about $month month";
						if ($month > 1) $display_time .= "s";
						$display_time .= " ago";
					break;
					case ($time_diff > 31536000):
						$display_time = "more than a year ago";
					break;

					default:
						$display_time = date($date_format, $tweet_time);
					break;
				}

			} else {

				$display_time = date($date_format, $tweet_time);

			}

			// Render the tweet.
			$tweets .= "<li>$tweet_text<span class='date'><a href='https://twitter.com/$your_twitter_username/statuses/$tweet->id_str'>($display_time)</a></span></li>\n";

		}

		// Close the twitter wrapping element.
		echo $tweets;

		// Generate a new cache file.
		$file = @fopen($cache_file, 'w');

		// Save the contents of output buffer to the file, and flush the buffer. 
		@fwrite($file, ob_get_contents()); 
		@fclose($file); 
		ob_end_flush();

		
	}
}

// In case the RSS feed did not parse or load correctly, show a link to the Twitter account.
if (!$tweet_found){
	echo $tweets = "<li>Oops, our Twitter feed is unavailable at the moment - <a href='http://twitter.com/$your_twitter_username/'>Follow us on Twitter!</a></li>";
}