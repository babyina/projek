var ff = new Array();var ft = new Array(); var fm = new Array();

function inputValidation(form,fields,fieldsType,fieldsMsg){
	for(var i=0;i<fields.length;i++){
		if(fieldsType[i]=='text'){				
			if((eval('form.'+fields[i]+'.value'))==''){
				alert(fieldsMsg[i]);
				eval('form.'+fields[i]+'.focus()');
				return false;
			}
		}else if(fieldsType[i]=='select'){
			if(eval('form.'+fields[i]+'[form.'+fields[i]+'.selectedIndex].text')==''){
				alert(fieldsMsg[i]);
				return false;
			}
			
		}
	}
	return true;
}