
jQuery.validator.addMethod("checkExcel", checkExcel);
function checkExcel(value){
    if(value!=""){
        var ext = value.split('.').pop().toLowerCase();
        if(jQuery.inArray(ext, ['xlsx','xls']) == -1) {
            return false;
        }
        else{
            return true;
        }
    }
    else{
        return true;
    }
}
