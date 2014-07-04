var OptionCounter=0;
var OptionArray=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
function createOption(obj,Count)
	{
	OptionCounter++;
	var El=$('#'+obj+' tbody>tr:last').clone(true);
	El.find('td:last input').val('');
	El.find('td:last input').attr('name','QOPTION[]');
	El.find('td:first').text('Option '+OptionArray[OptionCounter]);
	$('#'+obj).append(El);
	//alert($('#'+obj).html());
		
	}
function removeOption(obj,Count)
	{
	if(OptionCounter>0)
	var El=$('#'+obj+' tbody>tr:last').remove();
	OptionCounter--;
	}