<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Zadanie c. 4 :: IIA</title>

        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <link rel="stylesheet" type="text/css" href="./web/css/style.css" />
        <link rel="stylesheet" type="text/css" href="./web/css/jquery-ui-1.7.2.custom.css" />

        <script type="text/javascript" src="./web/js/jquery/jquery-1.2.6.js"></script>
        <script type="text/javascript" src="./web/js/jquery/jquery-1.2.6.min.js"></script>
        <script type="text/javascript" src="./web/js/jquery/jquery-1.2.6.pack.js"></script>

        <script type="text/javascript" src="./web/js/jquery/js/jquery-1.3.2.js"></script>
        <script type="text/javascript" src="./web/js/jquery/js/jquery-ui-1.7.2.custom.min.js"></script>
        
        <script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/validate/jquery.validate.js"></script>


        <script type="text/javascript" src="./web/js/user/user.js"></script>
</head>

<body>

	<div style="text-align:right">
            <a href="#" onclick="return window.open('index.php?action=source');">Zobraz zdrojov&eacute; k&oacute;dy</a>
        </div>
        <h1>Autentifik&aacute;cia</h1>

        <div>
            
            <a href="index.php?mode=user&amp;module=user&amp;action=index">N&aacute;vrat</a>

            <h3>Úprava profilu</h3>

            {if $message}
                <p style="color:black">
                    {$message}
                </p>
            {/if}
            <form id="edit" action="index.php?mode=user&module=user&action=editUser" method="post">
                <table>
                    <tr>
                        <td><b>Meno:</b></td>
                        <td><input type="hidden" name="id" value="{$id}"><input type="text" name="meno" value="{$meno}"/></td>

                    </tr>
                    <tr>
                        <td><b>Priezvisko:</b></td>
                        <td><input type="text" name="priezvisko" value="{$priezvisko}"/></td>
                    </tr>
                    <tr>
                        <td><b>Pohlavie:</b></td>

                        <td>
                            {if $pohlavie==1}
                                Muž <input type="radio" name="pohlavie" value="1" checked/>
                            {else}
                                Muž <input type="radio" name="pohlavie" value="1"/>
                            {/if}
                            {if $pohlavie == 0}
                                Žena <input type="radio" name="pohlavie" value="0" checked/>
                            {else}
                                Žena <input type="radio" name="pohlavie" value="0"/>
                            {/if}
                        </td>
                    </tr>
                    <tr>
                        <td><b>E - mail:</b></td>

                        <td><input type="text" name="mail" value="{$mail}"/></td>
                    </tr>
                    <tr>
                        <td><b>Poštová adresa:</b></td>
                        <td><input type="text" name="adresa" value="{$adresa}"/></td>
                    </tr>
                    <tr>
                        <td><b>Používateľské meno:</b></td>

                        <td><input type="text" name="login" value="{$login}" disabled/></td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td><input type="submit" name="ok" value="Odoslat"/></td>
                    </tr>
                </table>
             </form>

	</div>

   

</body>
</html>
