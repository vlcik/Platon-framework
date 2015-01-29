/**
 * @author janko
 */

(function($) {
	
/**
 * formStore() saves actual data into form element, use formResetToStored() to change state back
 *
 */
$.fn.formStore = function() {
    
	var dForm = this[0];
    var els = dForm.elements;
    if (!els) return;
	
	var jForm=$(dForm);
	jForm.data("valueStore",jForm.formToArray());
	// jForm.formInvalidateStoreReset();
	
	// alert(dForm.valueStore.length);    
};

/*
$.fn.formInvalidateStore = function() {    
    var form = this[0];
    form.invalidStore=true;    
};

$.fn.formInvalidateStoreReset = function() {    
    var form = this[0];
    delete form.invalidStore;    
};
*/

$.fn.formResetToStored = function(){
    
	var jForm=this;
     
	// if(dForm.invalidStore!==true)
	//	return;
	
	if(!jForm.data("valueStore"))
		return;
	
	var arr=jForm.data("valueStore");
	var el;
	for(var i=0;i<arr.length;i++)
	{		
		el=$("[name="+arr[i].name+"]",jForm);		
		el.val(arr[i].value);
	}
	
	jForm.removeData("valueStore");
};


})(jQuery);