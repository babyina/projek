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
	
	document.detail.EditPengurusan4.click();
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
		
		//Hidekan Semakan
		var el, els = document.getElementsByName("kod"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.style.visibility='hidden';
    	 }
		
		 var el, els = document.getElementsByName("Korperat_Catatan"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.style.visibility='visible';
    	 }
		 
		var el, els = document.getElementsByName("salinan[]"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = true; 
			el.checked=false;
			el.style.visibility='hidden';
    	 }
		 
		var el, els = document.getElementsByName("catatan_semak[]"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = false;
			el.style.visibility='hidden';
    	 }
		
		//Visiblekan Agensi
		var el, els = document.getElementsByName("Agensi[]"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = false;
			el.style.visibility='visible';
    	 }
		 
		 
		 var el, els = document.getElementsByName("Agen_Pind"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = false;
			el.style.visibility='visible';
    	 }
	
	}
	
	if (val=="2"){
		edit_jawapann.Pengesahan1.checked=false;
		edit_jawapann.pengesahan_status.value=val;
		//edit_jawapann.Korperat_Catatan.editable=false;
		
		var el, els = document.getElementsByName("kod"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.style.visibility='visible';
    	 }
		 var el, els = document.getElementsByName("Korperat_Catatan"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.style.visibility='hidden';
    	 }
		
		
		var el, els = document.getElementsByName("salinan[]"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = false;
			el.style.visibility='visible';
    	 }
		
		var el, els = document.getElementsByName("catatan_semak[]"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = false;
			el.style.visibility='visible';
    	 }
		
		//Hidekan agensi yg perlu buat pindaan 
		var el, els = document.getElementsByName("Agensi[]"); 
  		for(var n=0, len=els.length; n<len; n++){
     		el = els[n];
			el.disabled = true; 
			el.checked=false;
			el.style.visibility='hidden';
    	 }
		 
		 
		var el, els = document.getElementsByName("Agen_Pind"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = true; 
			el.style.visibility='hidden';
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
		
		 var el, els = document.getElementsByName("Agensi[]"); 
  		 for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = false; 
    	 }
		 
		 var el, els = document.getElementsByName("catatan_semak[]"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = false;
			el.style.visibility='hidden';
    	 }
		 
		 var el, els = document.getElementsByName("Pengurusan_Catatan"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = false;
			el.style.visibility='visible';
    	 }
		 
		 var el, els = document.getElementsByName("Catatan_Pindaan"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = false;
			el.style.visibility='visible';
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
			el.style.visibility='visible';
    	 }
		 
		 var el, els = document.getElementsByName("catatan_semak[]"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = false;
			el.style.visibility='visible';
    	 }
		 
		 
		 var el, els = document.getElementsByName("Agensi[]"); 
  		 for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = true; 
    	 }
		 
		 var el, els = document.getElementsByName("Pengurusan_Catatan"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = false;
			el.style.visibility='hidden';
    	 }
		 
		 var el, els = document.getElementsByName("Catatan_Pindaan"); 
  		for(var n=0, len=els.length; n<len; n++){ 
     		el = els[n];
			el.disabled = false;
			el.style.visibility='hidden';
    	 }
		 
		 edit_jawapann.pengesahan_status.value=val;
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
	if(form.NoSoalan.value == ""){
		alert("Sila masukkan nombor soalan");
		form.NoSoalan.focus();
		return(false);
	}
	if(form.Kawasan.value == ""){
		alert("Sila pilih sekurang-kurangnya Kawasan");
		form.Kawasan.focus();
		return(false);
	}
	if (form.BentukSoalan[0].checked)
	{
	if(form.TkhBentang.value == ""){
		alert("Sila pilih tarikh soalan akan dibentangkan");
		form.TkhBentang.focus();
		form.imgCalendar3.click();
		return(false);
	}
	}
}

function validateForm(form){			
	if(form.TkhMulaBersidang.value == ''){
		alert("Sila pilih Tarikh Mula Persidangan");
		form.TkhMulaBersidang.focus();
		return(false);
		
	}
	if(form.TkhAkhirBersidang.value == ''){
		alert("Sila masukkan Tarikh Akhir Persidangan");
		form.TkhAkhirBersidang.focus();
		return(false);
	}
if(form.dewan_.value != "2")
	{
	if(form.Kawasan.value == ""){
		alert("Sila pilih sekurang-kurangnya Kawasan");
		form.Kawasan.focus();
		return(false);
	}
	}
	if (form.BentukSoalan[0].checked)
	{
	//alert(form.ben_sol.value)
	if(form.ben_sol.value=='Lisan')
	{
		if(form.TkhBentang.value == ''){
		alert("Sila masukkan Tarikh Jawab Soalan Di Parlimen");
		form.TkhBentang.focus();
		return(false);
	
		}
	}
	
	}
	if(form.tkh_jawab.value == ''){
		alert("Sila masukkan Tarikh Jawapan hendaklah sampai ke Urusetia Penyelarasan Parlimen KKM sebelum");
		form.tkh_jawab.focus();
		return(false);
	}
	
	var val = form.TkhMulaBersidang.value;
	var temp = new Array(3);
	var temp = val.split("/");
	var tkh_mulasidang = (temp[2]+temp[1]+temp[0]);
	
	var val = form.TkhAkhirBersidang.value;
	var temp = new Array(3);
	var temp = val.split("/");
	var tkh_akhirsidang = (temp[2]+temp[1]+temp[0]);
	
	var val = form.TkhBentang.value;
	var temp = new Array(3);
	var temp = val.split("/");
	var tkh_soalan = (temp[2]+temp[1]+temp[0]);
	
	var val = form.tkh_jawab.value;
	var temp = new Array(3);
	var temp = val.split("/");
	var tkh_jawab = (temp[2]+temp[1]+temp[0]);
	
	if(tkh_akhirsidang <= tkh_mulasidang){
		alert("\Tarikh Akhir Persidangan mestilah lebih lewat dari Tarikh Mula Persidangan ");
		form.TkhAkhirBersidang.focus();
		return(false);
	}
	
	  if (form.BentukSoalan[0].checked)
	{
	//if(tkh_soalan >= tkh_akhirsidang){
	if(form.ben_sol.value=='Lisan')
	{
		if(tkh_soalan > tkh_akhirsidang){
		alert("\Tarikh Jawab Soalan Di Parlimen mestilah lebih awal dari Tarikh Akhir Persidangan ");
		form.TkhBentang.focus(); 
		return(false); 
	}
	}
	}
	
	/*if(tkh_soalan <= tkh_jawab){
		alert("Tarikh hendaklah sampai ke YB MKll  mestilah lebih awal dari Tarikh Jawab Di Parlimen ");
		form.tkh_jawab.focus();
		return(false);
	}*/
	
	
	if(form.NoSoalan.value == ''){
		alert("Sila masukkan No. Soalan");
		form.NoSoalan.focus();
		return(false);
	}

	if(form.Perkara.value == ''){
		alert("Sila masukkan Perkara");
		form.Perkara.focus();
		return(false);
	}

	var valid, el, els = document.getElementsByName("Agensi[]"); 
	var j=0;
	valid = false;
	for(var n=0, len=els.length; n<len; n++){
	    el = els[n];
		if(el.checked == 1){
			j=j+1;
			valid = true;
		}
	} 	

	if(valid==false)
	{
		alert("Sila pilih Untuk Tindakan");
		return(false);
	}
	else
	 if(valid==true && j > 1)
	{
		alert("Sila pilih satu pilihan Tindakan sahaja"); 
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
	alert("Sila pilih Pindaan/Pertanyaan");
	return(false);
}

if(form.Pengesahan2.checked) // tiada pindaan
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


if(form.Pengesahan2.checked && form.Korperat_Jawapan.value == ''){
	form.img_collapse.click();
	//form.div_jaw.display.style='';
	if(form.Korperat_Jawapan.value == '')
	{
		alert("Sila masukkan jawapan dan biarkan kotak jawapan terbuka");
		return(false);
	}
}

}


function validateFormPengurusan(form){			

if(!form.Pengesahan_Status1.checked && !form.Pengesahan_Status2.checked)
//if(!form.Pengesahan_Status1.checked )
{
	alert("Sila pilih Pindaan/Pertanyaan");
	return(false);
}

if(form.Pengesahan_Status1.checked) //strat  this for validation pindaan tksp
{

if(form.Pengurusan_Catatan.value== ''){
	alert("masukkan catatan pindaan") 
	form.Pengurusan_Catatan.focus();
	return false;
	}
	

}
//end  for validation tksp
if(form.Pengesahan_Status2.checked)
{
	//var valid, el, els = document.getElementsByName("salinan[]"); 
	var valid, el, els = document.getElementsByName("semaktksp[]"); 
	var j=0;
	valid = false;
	for(var n=0, len=els.length; n<len; n++){
	    el = els[n];
		if(el.checked == 1){
			j=j+1;
 			valid = true;
		}
	} 
	
	 
	
	if(valid==false)
	{
		alert("Sila pilih Untuk Semakan");
		return(false);
	}
	
	    else
	 if(valid==true && j > 1)
	{
		alert("Sila pilih satu pilihan Semakan sahaja");
		return(false);
	}
	
	
}
}

function validateFormPengesahan(form){			

/*var valid, el, els = document.getElementsByName("Pengesahan_Status"); 
valid = false;
for(var n=0, len=els.length; n<len; n++){
	   el = els[n];
	if(el.checked == 1){
		valid = true;
	}
} 
	
if(valid==false)
{
	alert("Sila pilih Pindaan/Pertanyaan");
	return(false);
}*/
if(!form.KSP_Status1.checked && !form.KSP_Status2.checked)
{
	alert("Sila pilih Pindaan KSP");
	return(false);
}

if(form.KSP_Status1.checked)
{
	//alert("test")
	//var valid, el, els = document.getElementsByName("salinan[]"); 
	//var valid = document.getElementsByName("Pengesahan_Catatan").value; 
	
	if (form.Pengesahan_Catatan.value == '')
	{
	alert("masukkan catatan")
	form.Pengesahan_Catatan.focus();
	return(false);
	}

}



}

function validateFormdrafakhir(form){			

//if(!detail.mk_Status1.checked && !detail.mk_Status2.checked)
//{
	//alert("Sila pilih Pindaan MKll/SUSK MKll");
	//return(false);
//}

if(detail.mk_Status1.checked)
{
	
	 var EditorInstance = FCKeditorAPI.GetInstance('akhir_Catatan');    //location_info is name of text area.
     var contents = EditorInstance.GetXHTML(true);
        if(!contents)
        {
		
            alert("masukkan catatan");
            EditorInstance.Focus();
             return false;
        }
		else{
		//alert(contents);
      	 form.drafakhirjawapan.value=contents; 
		 }
		 
	//if (detail.akhir_Catatan.value == '')
	//{
	//alert("masukkan catatan")
	//detail.akhir_Catatan.focus();
	//return(false);
	//}
  // form.drafakhirjawapan.value=detail.akhir_Catatan.value; 
	
	
}

var EditorInstance_catatan_dasar = FCKeditorAPI.GetInstance('catatan_dasar');    //location_info is name of text area.
var content_catatan_dasar = EditorInstance_catatan_dasar.GetXHTML(true);
form.draf_catatan_dasar.value=content_catatan_dasar; 

}

function validateFormdrafakhir2(form){			
//alert("test");
//if(!detail.mk_Status1.checked && !detail.mk_Status2.checked)
//{
	//alert("Sila pilih Pindaan MKll/SUSK MKll");
	//return(false);
//}
if(detail.mk_Status1.checked)
{
	
	 var EditorInstance = FCKeditorAPI.GetInstance('akhir_Catatan');    //location_info is name of text area.
     var contents = EditorInstance.GetXHTML(true);
        if(!contents)
        {
		
            alert("masukkan catatan");
            EditorInstance.Focus();
             return false;
        }
		else{
		//alert(contents);
      	 form.drafakhirjawapan.value=contents; 
		 }
		 
	//if (detail.akhir_Catatan.value == '')
	//{
	//alert("masukkan catatan")
	//detail.akhir_Catatan.focus();
	//return(false);
	//}
  // form.drafakhirjawapan.value=detail.akhir_Catatan.value; 
	
	
}
if(detail.mk_Status2.checked)
{
	//alert("tidak");
	//alert(form.operasi_tindakan.value);
	if(detail.tksp_operasi_status2.checked)
	{
	//alert("catatan");
	 var EditorInstance_Catatan_operasi = FCKeditorAPI.GetInstance('Catatan_operasi');    //location_info is name of text area.
     var contents_Catatan_operasi = EditorInstance_Catatan_operasi.GetXHTML(true);
        if(!contents_Catatan_operasi)
        {
		
            alert("masukkan catatan");
            EditorInstance_Catatan_operasi.Focus();
             return false;
        }
		else{
		//alert(contents);
      	 form.catatan_operasi.value=contents_Catatan_operasi; 
		 }
		 
	//if (detail.akhir_Catatan.value == '')
	//{
	//alert("masukkan catatan")
	//detail.akhir_Catatan.focus();
	//return(false);
	//}
  // form.drafakhirjawapan.value=detail.akhir_Catatan.value; 
	
	
}
}


}



function validateFormFinal(form){			

//var xxx=document.getElementsByName("Jawapan_Final"); 
//document.edit_jawapan3.SimpanHantarJawapanAkhir.click();  
var EditorInstance_jawapan = FCKeditorAPI.GetInstance('jawapan');    //location_info is name of text area.
var jawapan = EditorInstance_jawapan.GetXHTML(true);
var EditorInstance_mak_tamb = FCKeditorAPI.GetInstance('mak_tamb');    //location_info is name of text area.
var mak_tamb = EditorInstance_mak_tamb.GetXHTML(true);


document.getElementById("jawapan_").value=jawapan;
//alert(jawapan);


document.getElementById("mak_tamb_").value=mak_tamb;

var EditorInstance = FCKeditorAPI.GetInstance('Jawapan_Final');    //location_info is name of text area.
    clear_text=strip_tags(FCKeditorAPI.GetInstance('Jawapan_Final').GetXHTML());   
	//var contents = EditorInstance.GetXHTML(true);
       // if(!contents)
	   if(clear_text=='')
        {
		
            alert("Sila masukkan jawapan akhir"); 
            EditorInstance.Focus();
             return false;
        }
		else{
		//alert(contents);
      	 return true;
		 }
//if(form.Jawapan_Final.value == ''){
	
	//alert(document.edit_jawapan3.Jawapan_Final.value)   
	//form.Jawapan_Final.focus();
	//document.edit_jawapan3.Jawapan_Final.focus();
	//return false; 
	//validateFormFinal2()

}
function strip_tags(html){
 
		//PROCESS STRING
		if(arguments.length < 3) {
			html=html.replace(/<\/?(?!\!)[^>]*>/gi, '');
		} else {
			var allowed = arguments[1];
			var specified = eval("["+arguments[2]+"]");
			if(allowed){
				var regex='</?(?!(' + specified.join('|') + '))\b[^>]*>';
				html=html.replace(new RegExp(regex, 'gi'), '');
			} else{
				var regex='</?(' + specified.join('|') + ')\b[^>]*>';
				html=html.replace(new RegExp(regex, 'gi'), '');
			}
		}
		//var regex3='&nbsp;';
       html=html.replace(/(&nbsp;)*/g,'');  

		//CHANGE NAME TO CLEAN JUST BECAUSE 
		var clean_string = html;
 
		//RETURN THE CLEAN STRING
		return clean_string;
	}




function validateFormFinalBcp(form){			

var EditorInstance = FCKeditorAPI.GetInstance('Jawapan_Final');    //location_info is name of text area.
   
   
   //var contents = EditorInstance.GetXHTML(true);
    clear_text=strip_tags(FCKeditorAPI.GetInstance('Jawapan_Final').GetXHTML());  
	    if(clear_text=='')
       // if(!contents)
        {
		
            alert("Sila masukkan jawapan akhir");
            EditorInstance.Focus();
             return false;
        }
		else if(form.jns_soalan.value == '')
		{
		alert("Sila Pilih Bentuk Soalan");
		return false;
		}

		else{
		//alert(contents);
      	 return true;
		 }
		 

	//form.Jawapan_Final.focus();
	//document.edit_jawapan3.Jawapan_Final.focus();
	//return false; 
	//validateFormFinal2()

}

function validateFormFinalksp(form){			

//var xxx=document.getElementsByName("Jawapan_Final"); 
//document.edit_jawapan3.SimpanHantarJawapanAkhir.click();  
//alert("test");

var EditorInstance = FCKeditorAPI.GetInstance('Jawapan_Final');    //location_info is name of text area.
    // var contents = EditorInstance.GetXHTML(true);
	 clear_text=strip_tags(FCKeditorAPI.GetInstance('Jawapan_Final').GetXHTML());  
       // if(!contents)
		 if(clear_text=='')
        {
		
            alert("Sila masukkan jawapan akhir");
            EditorInstance.Focus();
             return false;
        }
		else{
		//alert(contents);
      	 return true;
		 }
//if(form.Jawapan_Final.value == ''){
	
	//alert(document.edit_jawapan3.Jawapan_Final.value)   
	//form.Jawapan_Final.focus();
	//document.edit_jawapan3.Jawapan_Final.focus();
	//return false; 
	//validateFormFinal2()

}

//function validateFormFinal2(){		

//if(document.edit_jawapan3.Jawapan_Final.value ==''){   
//if(document.edit_jawapan3.Jawapan_Final.value ==''){ 

//if(form.Jawapan_Final.value == ''){
	//alert("Sila masukkan jawapan akhir"); 
	//return false

//}
//}

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
	if(form.YB.value == ''){
		alert("Sila pilih nama Ahli Parlimen");
		form.YB.focus();
		return(false);
	}
	if(form.Tarikh_Bahas.value == ''){
		alert("Sila pilih Tarikh Dibahas");
		form.Tarikh_Bahas.focus();
		form.imgCalendar1.click();
		return(false);
		
	}
	if(form.Tajuk.value == ''){
		alert("Sila masukkan Tajuk");
		form.Tajuk.focus();
		return(false);
	}

	if(form.Tarikh_Jawab.value == ''){
		alert("Sila masukkan Tarikh Jawab Sebelum/Pada");
		form.Tarikh_Jawab.focus();
		form.imgCalendar2.click();
		return(false);
	}

	//form.Tarikh_Jawab.focus();

	
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
	   // el = els[n];
		//if(el.checked == 1){
		//	valid = true;
		//}
	//} 	
	
	//if(valid==false)
	//{
		//alert("Sila pilih Salinan Kepada");
		//return(false);
	//}
}

function validateFormKorperatBahas(form){			

if(!form.Pengesahan_Status1.checked && !form.Pengesahan_Status2.checked)
{
	alert("Sila pilih Pindaan/Pertanyaan");
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


