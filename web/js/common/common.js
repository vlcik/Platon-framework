/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){


    $("#accordion").accordion({
        header: "h3",autoHeight: false
    });

    /*$("#registracia").validate({
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
                pass : {
                        required : true
                },
                pass2 : {
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
                pass : {
                        required : "Povinná polo\u017eka"
                },
                pass2 : {
                        required : "Povinná polo\u017eka"
                },
                mail : {
                        required : "Povinná polo\u017eka"
                }
        }*/
/*
        submitHandler : function(form)
        {
                var sUrl="index.php?mode=common&module=auth&action=register";

                var input = {
                        url : sUrl,
                        dataType : 'json',
                        type : 'POST'
                        
                };

                $(form).ajaxSubmit(input);
        }
*/
    //})

    



});

