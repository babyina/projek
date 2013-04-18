//common function
function number_only(me,evt)
{ //alert(me.id)
//alert(evt)
//tim leary

	var key = window.event ? evt.keyCode : evt.which;
	//alert(key);
	if(isNaN(me.value+String.fromCharCode(key)) || String.fromCharCode(key)==" ")  
	{
		blok_nilai(evt,key);
	} 
	// titik perpuluhan 
	theval=me.value+String.fromCharCode(key);
	decimal = theval.indexOf(".");
	if(decimal>=1)
	{
		if(decimal+4<theval.length)
			{
				blok_nilai(evt,key);
			}
	}
	

}
function blok_nilai(evt,key)
{
	if(window.event)
			{ 
				event.returnValue = false;
			}else
			{
				if(key==8||key==0) //if delete  atau backspace pressed..
				{
					
				}
				else
				{
					evt.preventDefault();
				}
			}
}



function edit_jawapan(id){
	document.detail.jawapan_id.value = id;		
	document.detail.EditJawapan.click();
}

function edit_korperat(){
	document.detail.EditKorperat.click();
}

function edit_pengurusan(){
	document.detail.EditPengurusan.click();
}

function edit_pengesahan(){
	document.detail.EditPengesahan.click();
}

function checkNumeric(objName,minval, maxval,comma,period,hyphen)
{
	var numberfield = objName;
	if (chkNumeric(objName,minval,maxval,comma,period,hyphen) == false)
	{
		numberfield.select();
		numberfield.focus();
		return false;
	}
	else
	{
		return true;
	}
}

function verify(){
    msg = "Anda ingin hapus rekod ini?";
    return confirm(msg);
}

function chkNumeric(objName,minval,maxval,comma,period,hyphen)
{
// only allow 0-9 be entered, plus any values passed
// (can be in any order, and don't have to be comma, period, or hyphen)
// if all numbers allow commas, periods, hyphens or whatever,
// just hard code it here and take out the passed parameters
var checkOK = "0123456789" + comma + period + hyphen;
var checkStr = objName;
var allValid = true;
var decPoints = 0;
var allNum = "";

for (i = 0;  i < checkStr.value.length;  i++)
{
ch = checkStr.value.charAt(i);
for (j = 0;  j < checkOK.length;  j++)
if (ch == checkOK.charAt(j))
break;
if (j == checkOK.length)
{
allValid = false;
break;
}
if (ch != ",")
allNum += ch;
}
if (!allValid)
{	
//alertsay = "Sila masukkan nombor " +checkOK + " pada medan ini"
alertsay = "Sila masukkan aksara berjenis nomor sahaja";
alert(alertsay);
return (false);
}

}

function validateFormPengurusan(form){			

if(!form.Pengesahan_Status1.checked && !form.Pengesahan_Status2.checked)
{
	alert("Sila pilih Pindaan/Kuiri");
	return(false);
}

if(form.Pengesahan_Status2.checked)
{
	var valid, el, els = document.getElementsByName("salinan"); 
	valid = false;
	for(var n=0, len=els.length; n<len; n++){
	    el = els[n];
		if(el.checked == 1){
			valid = true;
		}
	} 
	
	if(valid==false)
	{
		alert("Sila pilih Untuk Semakan");
		return(false);
	}
}
}

