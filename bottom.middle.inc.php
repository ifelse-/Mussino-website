<script language="javascript">

function validateFormOnSubmit(theForm) {
var reason = "";

	reason += validateEmpty(theForm.Ad_Name);
	reason += validateEmpty1(theForm.Ad_Image);
	reason += validateEmpty2(theForm.Ad_Image_Alt_Text);
	reason += validateEmpty3(theForm.Ad_Target_Url);
	reason += validateEmpty4(theForm.Ad_Plan);
	
         
  if (reason != "") {
    alert("You must fill out the following fields :\n\n" + reason);
    return false;
  } else
	{ return true; }
}


function validateEmpty(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Name Of Advertise \n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}

function validateEmpty1(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Image  \n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}

function validateEmpty2(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Image Alt Text  \n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}

function validateEmpty3(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Target URL   \n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}
function validateEmpty4(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Advertising Plan   \n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}
</script>
<script language="javascript">
function validateFileExtension1234(fld) 
	{

		if(!/(\.png|\.gif|\.jpg|\.jpeg)$/i.test(fld.value)) 
		{
		alert("Invalid image file type.");
		fld.form.reset();
		fld.focus();
		return false;
		}
		return true;
	}
</script>
