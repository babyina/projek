//common function
function edit_jawapan(id,status){
	document.detail.jawapan_id.value = id;		
	document.detail.status_id.value = status;
	document.detail.EditJawapan.click();
}
function edit_jawapan_bahas(id,jawapan_id,status){
	document.perkara_berbangkit.id.value = id;	
	document.perkara_berbangkit.jawapan_id.value = jawapan_id;		
	document.perkara_berbangkit.status_id.value = status;
	document.perkara_berbangkit.EditJawapanBahas.click();
}

function edit_korperat(){
	document.detail.EditKorperat.click();
}

function edit_korperat_bahas(){
	document.bahas.EditKorperatBahas.click();
}

function edit_pengurusan(){
	document.detail.EditPengurusan.click();
}

function edit_pengurusan4(){
	alert('yooooo');
	//document.detail.EditPengurusan4.click();
}


function edit_pengurusan_bahas(){
	document.bahas.EditPengurusanBahas.click();
}



function edit_pengesahan(){
	document.detail.EditPengesahan.click();
}

function edit_pengesahan_bahas(){
	document.bahas.EditPengesahanBahas.click();
}

function edit_final(){
	document.detail.EditFinal.click();
}

function edit_final_bahas(){
	document.bahas.EditFinalBahas.click();
}

//function getSoalan(id){
	
	//window.open('../parlimen/frm_soalan.php?id='+id,'mywin');
	//window.soalan.Soalan.value = window.entry_form.Soalan.value;
	//return(false);
//}



function RadioKorperat(val){
	
	if (val=="1"){
		edit_jawapann.Pengesahan2.checked=false;
		edit_jawapann.pengesahan_status.value=val;
		var el, els = document.getElementsByName("salinan[]"); 
  		 for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = true; 
			el.checked=false;
    	 }
		
		 var el, els = document.getElementsByName("Agensi[]"); 
  		 for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = false; 
    	 }
	
	}
	
	if (val=="2"){
		edit_jawapann.Pengesahan1.checked=false;
		edit_jawapann.pengesahan_status.value=val;
		
		var el, els = document.getElementsByName("salinan[]"); 
  		 for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = false; 
    	 }

 		var el, els = document.getElementsByName("Agensi[]"); 
  		 for(var n=0, len=els.length; n<len; n++){
     		el = els[n];
			el.disabled = true; 
			el.checked=false;
    	 } 
	}
}

function RadioSelect(val){
	
	if (val=="1"){
		edit_jawapann.Pengesahan_Status2.checked=false;
		edit_jawapann.jawapan.disabled=true;
		 var el, els = document.getElementsByName("salinan[]"); 
  		 for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = true; 
			el.checked=false;
    	 }
		
		edit_jawapann.pengesahan_status.value=val;
		
		 var el, els = document.getElementsByName("Agensi[]"); 
  		 for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = false; 
    	 }
	
	}
	
	if (val=="2"){
		edit_jawapann.Pengesahan_Status1.checked=false;
		edit_jawapann.jawapan.disabled=false;
		var el, els = document.getElementsByName("salinan[]"); 
  		 for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = false; 
    	 }
		edit_jawapann.pengesahan_status.value=val;
		
 		var el, els = document.getElementsByName("Agensi[]"); 
  		 for(var n=0, len=els.length; n<len; n++){
     		el = els[n];
			el.disabled = true; 
			el.checked=false;
    	 } 
	}
}


function RadioPengurusan(val){
	
	if (val=="1"){
		edit_jawapann.Pengesahan_Status2.checked=false;
 		var el, els = document.getElementsByName("salinan[]"); 
  		 for(var n=0, len=els.length; n<len; n++){
     		el = els[n];
			el.disabled = true; 
			el.checked=false;
    	 } 
		edit_jawapann.pengesahan_status.value=val;
	}
	
	if (val=="2"){
		edit_jawapann.Pengesahan_Status1.checked=false;
		edit_jawapann.pengesahan_status.value=val;
		 var el, els = document.getElementsByName("salinan[]"); 
  		 for(var n=0, len=els.length; n<len; n++){
     		el = els[n];
			el.disabled = false; 
    	 } 
	}
}

function OpenWindow(){		
	window.open('http://localhost/parlimen/parlimen/perkara_berbangkit.php','mywindow','width=1000,height=450')
}

function verify(){
    msg = "Anda ingin hapus rekod ini?";
    return confirm(msg);
}

function deleteDoc(id){				
	if(confirm("Anda ingin hapus rekod ini?")){						
		document.bahas.del.value = id;
		document.bahas.deletePP.click();				
	}
	return false;
}

//kalendar purposes
function delDoc(mode,id,pid){
	if(confirm("Hapus rekod ini?")){								
		document.delete_form.id.value = id;
		document.delete_form.pid.value = pid;
		document.delete_form.mode.value = mode;
		document.delete_form.deleteDoc.click();				
	}
	return false;
}

var win = null;
function NewWindow(mypage,myname,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0; 
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0; 
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+1+',resizable=1'
	win = window.open(mypage,myname,settings) 
	if(win.window.focus){
		win.window.focus();
	} 
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
alertsay = "Sila masukkan nombor " +checkOK + " pada No. Soalan"
alert(alertsay);
return (false);
}

}

function validateFormSimpan(form){
	if(form.TkhMulaBersidang.value == ''){
		alert("Sila pilih sekurang-kurangnya Tarikh Mula Persidangan dan Kawasan ");
		form.TkhMulaBersidang.focus();
		form.imgCalendar1.click();
		return(false);
	}
	
	if(form.Kawasan.value == ''){
		alert("Sila pilih sekurang-kurangnya Kawasan");
		form.Kawasan.focus();
		return(false);
	}
}

function validateForm(form){			
	if(form.TkhMulaBersidang.value == ''){
		alert("Sila pilih Tarikh Mula Persidangan");
		form.TkhMulaBersidang.focus();
		form.imgCalendar1.click();
		return(false);
		
	}
	if(form.TkhAkhirBersidang.value == ''){
		alert("Sila masukkan Tarikh Akhir Persidangan");
		form.imgCalendar2.click();
		form.TkhAkhirBersidang.focus();
		return(false);
	}
	if(form.TkhBentang.value == ''){
		alert("Sila masukkan Tarikh Soalan");
		form.imgCalendar3.click();
		form.TkhBentang.focus();
		return(false);
	}
	if(form.tkh_jawab.value == ''){
		alert("Sila masukkan Tarikh Jawab Sebelum/Pada");
		form.imgCalendar4.click();
		form.tkh_jawab.focus();
		return(false);
	}
	
	
	var val = form.TkhBentang.value;
	var temp = new Array(3);
	var temp = val.split("/");
	var tkh_soalan = (temp[2]+temp[1]+temp[0]);
	
	var val = form.tkh_jawab.value;
	var temp = new Array(3);
	var temp = val.split("/");
	var tkh_jawab = (temp[2]+temp[1]+temp[0]);
	
	if(tkh_soalan <= tkh_jawab){
		alert("Tarikh Jawab Sebelum/Pada mestilah lebih awal dari Tarikh Soalan ");
		form.tkh_jawab.focus();
		return(false);
	}
	
	if(form.NoSoalan.value == ''){
		alert("Sila masukkan No. Soalan");
		form.NoSoalan.focus();
		return(false);
	}
	if(form.Kawasan.value == ''){
		alert("Sila pilih Kawasan");
		form.Kawasan.focus();
		return(false);
	}
	if(form.ahli_dewan_id.value == ''){
		alert("Sila pilih Kawasan");
		form.ahli_dewan_id.focus();
		return(false);
	}
	if(form.parti_id.value == ''){
		alert("Sila pilih Kawasan");
		form.parti_id.focus();
		return(false);
	}
	if(form.Perkara.value == ''){
		alert("Sila masukkan Perkara");
		form.Perkara.focus();
		return(false);
	}
	if(form.Soalan.value == ''){
		alert("Sila masukkan Soalan");
		form.Soalan.focus();
		return(false);
	}
	
	var valid, el, els = document.getElementsByName("Agensi[]"); 
	valid = false;
	for(var n=0, len=els.length; n<len; n++){
		el = els[n];
		if(el.checked == 1){
			valid = true;
		}
		
	} 	
	
	if(valid==false)
	{
		alert("Sila pilih Untuk Tindakan");
		return(false);
	}
	
	
	//var valid, el, els = document.getElementsByName("salinan[]"); 
		
	//valid = false;
	//for(var n=0, len=els.length; n<len; n++){
	//    el = els[n];
	//	if(el.checked == 1){
	//		valid = true;
	//	}
	//} 	
	
	//if(valid==false)
	//{
	//	alert("Sila pilih Salinan Kepada");
	//	return(false);
	//}	//	return true;
}


function validateFormKorperat(form){			

if(!form.Pengesahan1.checked && !form.Pengesahan2.checked)
{
	alert("Sila pilih Pindaan/Kuiri");
	return(false);
}

if(form.Pengesahan2.checked)
{
	form.Pengesahan1.checked=false;
	var valid, el, els = document.getElementsByName("salinan[]"); 
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
		form.Pengesahan1.checked=false;
		return(false);
	}
}

if(form.Pengesahan1.checked)
{
	form.Pengesahan2.checked=false;
	var valid, el, els = document.getElementsByName("Agensi[]"); 
	valid = false;
	for(var n=0, len=els.length; n<len; n++){
	    el = els[n];
		if(el.checked == 1){
			valid = true;
		}
	} 
	
	if(valid==false)
	{
		alert("Sila pilih Untuk Tindakan");
		return(false);
	}
}



if(form.Korperat_Jawapan.value == ''){
	alert("Sila masukkan jawapan");
	form.Korperat_Jawapan.focus();
	return(false);
}

}


function validateFormPengurusan(form){			

if(!form.Pengesahan_Status1.checked && !form.Pengesahan_Status22.checked)
{
	alert("Sila pilih Pindaan/Kuiri");
	return(false);
}

if(form.Pengesahan_Status2.checked)
{	
	form.Pengesahan_Status1.checked=false;
	var valid, el, els = document.getElementsByName("salinan[]"); 
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

function validateFormPengesahan(form){			

var valid, el, els = document.getElementsByName("Pengesahan_Status"); 
valid = false;
for(var n=0, len=els.length; n<len; n++){
	   el = els[n];
	if(el.checked == 1){
		valid = true;
	}
} 
	
if(valid==false)
{
	alert("Sila pilih Pindaan/Kuiri");
	return(false);
}
}


function validateFormFinal(form){			

if(form.Jawapan_Final.value == ''){
	alert("Sila masukkan jawapan akhir");
	form.Jawapan_Final.focus();
	return(false);
}
}


function validateBahas(form){			
if(form.TarikhMula.value == ''){
	alert("Sila pilih Tarikh Mula Persidangan");
	form.TarikhMula.focus();
	form.imgCalendar1.click();
	return(false);
	
}
if(form.TarikhAkhir.value == ''){
	alert("Sila masukkan Tarikh Akhir Persidangan");
	form.TarikhAkhir.focus();
	form.imgCalendar2.click();
	return(false);
}
if(form.TkhGulung.value == ''){
	alert("Sila masukkan Tarikh Jawapan Akan Dibentang");
	form.TkhGulung.focus();
	form.imgCalendar3.click();	
	return(false);
}
}


function validateFormPB(form){			
if(form.Tarikh_Bahas.value == ''){
	alert("Sila pilih Tarikh Dibahas");
	form.Tarikh_Bahas.focus();
	form.imgCalendar1.click();
	return(false);
	
}
if(form.Tarikh_Jawab.value == ''){
	alert("Sila masukkan Tarikh Jawab Sebelum/Pada");
	form.Tarikh_Jawab.focus();
	form.imgCalendar2.click();
	return(false);
}

if(form.YB.value == ''){
	alert("Sila pilih nama Ahli Parlimen");
	form.YB.focus();
	return(false);
}
if(form.Perkara.value == ''){
	alert("Sila masukkan Perkara");
	form.Perkara.focus();
	return(false);
}
var valid, el, els = document.getElementsByName("Agensi[]"); 
valid = false;
for(var n=0, len=els.length; n<len; n++){
    el = els[n];
	if(el.checked == 1){
		valid = true;
	}
} 	

if(valid==false)
{
	alert("Sila pilih Untuk Tindakan");
	return(false);
}

var valid, el, els = document.getElementsByName("salinan[]"); 
	
valid = false;
for(var n=0, len=els.length; n<len; n++){
    el = els[n];
	if(el.checked == 1){
		valid = true;
	}
} 	

if(valid==false)
{
	alert("Sila pilih Salinan Kepada");
	return(false);
}
}

function validateFormKorperatBahas(form){			

if(!form.Pengesahan_Status1.checked && !form.Pengesahan_Status2.checked)
{
	alert("Sila pilih Pindaan/Kuiri");
	return(false);
}

if(form.Pengesahan_Status2.checked)
{
	form.Pengesahan_Status1.checked=false;
	var valid, el, els = document.getElementsByName("salinan[]"); 
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

if(form.Pengesahan_Status1.checked)
{
	form.Pengesahan_Status2.checked=false;
	var valid, el, els = document.getElementsByName("Agensi[]"); 
	valid = false;
	for(var n=0, len=els.length; n<len; n++){
	    el = els[n];
		if(el.checked == 1){
			valid = true;
		}
	} 
	
	if(valid==false)
	{
		alert("Sila pilih Untuk Tindakan");
		return(false);
	}
}

}


