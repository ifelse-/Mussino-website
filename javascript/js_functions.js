/*  File Name       : js_functions.js
 *  Description     : All Reusable javascript function .
 *  Author          : Social Dating Software - www.socialdatingsoftware.com
 *  Date Modified   : Feb 2012
 *  Version   		: 1.0
 */

function trim(str) {
	return str.replace(/^\s+|\s+$/g,"");
}

var http;
function createRequestObject()	{
	if (window.XMLHttpRequest)
		objXMLHttp=new XMLHttpRequest();
	else if (window.ActiveXObject)
		objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP");
	return objXMLHttp;
}

function alertkey(e) {
	if( !e ) {
		if( window.event ) {
			//Internet Explorer
			e = window.event;
        } else {
			return;
		}
	}
	if( typeof( e.keyCode ) == 'number'  ) {
		//DOM
		e = e.keyCode;
	} else if( typeof( e.which ) == 'number' ) {
		//NS 4 compatible
		e = e.which;
	} else if( typeof( e.charCode ) == 'number'  ) {
		//also NS 6+, Mozilla 0.9+
		e = e.charCode;
	} else {
		//total failure, we have no way of obtaining the key code
		return;
	}
	if(e==13) {
		validatelogin();
		return;
	}
}
function makeempty() {
var hiddenval = document.getElementById('searchval').value;

	if(hiddenval == 'Search' || hiddenval == '') {
		document.getElementById('searchval').style.color="#000000";
		document.getElementById('searchval').value = '';
	}
}

function fill() {
var hiddenval = document.getElementById('searchval').value;

	if(hiddenval == 'Search' || hiddenval == '') {
		document.getElementById('searchval').style.color="#666666";
		document.getElementById('searchval').value = 'Search';
	}
}	

function filldata(val) {
	document.getElementById('searchval').value = val;

}		

function filldatafirst() {

	document.getElementById('searchval').style.color="#666666";
	document.getElementById('searchval').value = 'Search';

}	
