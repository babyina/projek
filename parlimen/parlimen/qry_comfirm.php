
<script language="JavaScript">



function komfirm(){
    msg = "Anda pasti hantar kembali soalan ?";  
	//pppb_catatan
	//if(document.postback.pppb_catatan.value== ''){ 
	//alert("masukkan catatan pindaan") 
	//document.postback.pppb_catatan.focus();
	//return false;
	//}
	//else
	//{
	
     var EditorInstance = FCKeditorAPI.GetInstance('pppb_catatan');    //location_info is name of text area.
     var contents = EditorInstance.GetXHTML(true);
        if(!contents)
        {
		
            alert("masukkan catatan pindaan");
            EditorInstance.Focus();
             return false;
        }
		else{
		//alert(contents);
      	 return confirm(msg);
		 }
    
	//}
}

function test(){
    msg = "Anda pasti hantar kembali soalan ?"; 
	//pppb_catatan
	var val=document.getElementById("radio_pil");

	if(val=='0'){
		if(document.edit_jawapann.Pengurusan_Catatan.value== '')
		{
		alert("masukkan catatan pindaan") 
		document.postback.pppb_catatan.focus();
		return false;
		}
	}
	else
	{
    return confirm(val);
	}
}
</script>

