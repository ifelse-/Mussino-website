<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<title></title>
</head>

<body>
<script type="text/javascript">

/***********************************************
* Local Time script- © Dynamic Drive (http://www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for this script and 100s more.
***********************************************/

var weekdaystxt=["Sun", "Mon", "Tues", "Wed", "Thurs", "Fri", "Sat"]

function showLocalTime(container, servermode, offsetMinutes, displayversion){
if (!document.getElementById || !document.getElementById(container)) return
this.container=document.getElementById(container)
this.displayversion=displayversion
var servertimestring=(servermode=="server-php")? '<? print date("F d, Y H:i:s", time())?>' : (servermode=="server-ssi")? '<!--#config timefmt="%B %d, %Y %H:%M:%S"--><!--#echo var="DATE_LOCAL" -->' : '<%= Now() %>'
this.localtime=this.serverdate=new Date(servertimestring)
this.localtime.setTime(this.serverdate.getTime()+offsetMinutes*60*1000) //add user offset to server time
this.updateTime()
this.updateContainer()
}

showLocalTime.prototype.updateTime=function(){
var thisobj=this
this.localtime.setSeconds(this.localtime.getSeconds()+1)
setTimeout(function(){thisobj.updateTime()}, 1000) //update time every second
}

showLocalTime.prototype.updateContainer=function(){
var thisobj=this
if (this.displayversion=="long")
this.container.innerHTML=this.localtime.toLocaleString()
else{
var hour=this.localtime.getHours()
var minutes=this.localtime.getMinutes()
var seconds=this.localtime.getSeconds()
var ampm=(hour>=12)? "PM" : "AM"
var dayofweek=weekdaystxt[this.localtime.getDay()]
this.container.innerHTML=formatField(hour, 1)+":"+formatField(minutes);

}
setTimeout(function(){thisobj.updateContainer()}, 60000) //update container every second
}

function formatField(num, isHour){
if (typeof isHour!="undefined")
return (num < 10 ? "0" + num : num);
}
return (num<=9)? "0"+num : num//if this is minute or sec field
}

</script>


Current Server Time:<span id="timecontainer"></span><br />
London:<span id="timecontainer2"></span><br />
Frankfurt:<span id="timecontainer3"></span><br />
Toronto: <span id="timecontainer4"></span><br />
Chicago: <span id="timecontainer5"></span><br />
New York: <span id="timecontainer6"></span><br />


<script type="text/javascript">
new showLocalTime("timecontainer", "server-php", 0, "long") //GMT -5


new showLocalTime("timecontainer2", "server-php", 300, "long") //GMT +1
new showLocalTime("timecontainer3", "server-php", 420, "long") //GMT +2
new showLocalTime("timecontainer4", "server-php", 0, "long") //GMT -5
new showLocalTime("timecontainer5", "server-php", -60, "long") //GMT -6
new showLocalTime("timecontainer6", "server-php", 0, "long") //GMT -5



</script>