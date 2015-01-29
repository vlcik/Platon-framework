/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



$(document).ready(function(){
    
    jQuery.flash = new jQuery.Flash('#status_flash');

    $("#edit").validate({
        rules: {
                login : {
                        required : true
                },
                meno : {
                        required : true
                },
                priezvisko : {
                        required : true
                },
                adresa : {
                        required : false
                },
                id : {
                        required : true
                },
                mail : {
                        required : true
                }
        },
        messages: {

                login : {
                        required : "Povinná polo\u017eka"
                },
                meno : {
                        required : "Povinná polo\u017eka"
                },
                priezvisko : {
                        required : "Povinná polo\u017eka"
                },
                adresa : {
                        required : "Povinná polo\u017eka"
                },
                id : {
                        required : "Povinná polo\u017eka"
                },
                mail : {
                        required : "Povinná polo\u017eka"
                }
        },

        submitHandler : function(form){
            
                var Url="index.php?mode=user&module=user&action=editUser";

                var input = {
                        url : Url,
                        dataType : 'json',
                        type : 'POST',
                        success : jQuery.flash.success('Info', 'Editácia úspe\u0161ná')
                        
                };
                $(form).ajaxSubmit(input);
                
        }

    })

    



});

