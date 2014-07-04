// JavaScript Document
function GetXmlHttpObject()
		{
			try{ // Firefox, Opera, Safari
				xmlHttp=new XMLHttpRequest();
				return xmlHttp;
			   }catch (e){// Internet Explorer
		  				try{
							xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
							return xmlHttp;
						   }catch (e){
		  						    try{
										xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
										return xmlHttp;
			 							}catch (e){ 
													return null;
												  }
										}
							}
		}
function deleteImage(imageName,fileName,target,ProductID)
{ 
	var xmlHttp12=GetXmlHttpObject();
	if (xmlHttp12==null)
 		{
 			alert ("Browser does not support HTTP Request");
 			return;
 		}
	var el=$(target);
	$('<img src="loading.gif"/>').appendTo(el);
	var url=fileName;
	url=url+"?imageName="+imageName;
	if(ProductID)
	 {
		url=url+"&productID="+ProductID;
	 }
	xmlHttp12.onreadystatechange=function(){stateChanged(target,xmlHttp12)} ;
	xmlHttp12.open("GET",url,true);
	xmlHttp12.send(null);
}

function stateChanged(target,xmlHttp1) 
{
	var el=$(target);
	if(xmlHttp1.readyState==4)
				{
				el.html('');	
				}
}