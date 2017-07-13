window.onload = function()
{
	changePic();
}

function changePic()
{
	try{
		style = document.getElementById("jform_params_image_style");
		var strStyle = style.value;
		var strNewSrc="../modules/mod_zmaxlogin/images/"+strStyle+"_preview.jpg" ;
		preview = document.getElementById("stylePreview");
		preview.src=strNewSrc;
	}catch(e)
	{
		alert(e.message);
	}
}