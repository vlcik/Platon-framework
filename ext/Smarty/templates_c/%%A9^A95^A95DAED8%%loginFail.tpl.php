<?php /* Smarty version 2.6.20, created on 2009-11-02 18:16:23
         compiled from ./common/loginFail.tpl */ ?>
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


        <script type="text/javascript" src="./web/js/common/common.js"></script>
</head>

<body>

	<div style="text-align:right">
            <a href="#" onclick="return window.open('index.php?action=source');">Zobraz zdrojov&eacute; k&oacute;dy</a>
        </div>
        <h1>Autentifik&aacute;cia</h1>

        <div>

           
			
                <?php if ($this->_tpl_vars['message']): ?>
                    <p style="color:red">
                        <?php echo $this->_tpl_vars['message']; ?>

                    </p>
                <?php endif; ?>

                <h2>Prihl&aacute;senie</h2>
                <div>
                    <form id="login" enctype="multipart/form-data" action="index.php?mode=common&module=auth&action=login" method="post">
                        <table>

                            <tr>
                                <td><b>Prihlasovacie meno:</b></td>

                                <td><input type="text" name="login" value=""/></td>
                            </tr>
                            <tr>
                                <td><b>Heslo:</b></td>

                                <td><input type="password" name="pass" value=""/></td>
                            </tr>
                            <tr>

                                <td><input type="submit" name="ok" value="Odoslat"/></td>
                            </tr>
                        </table>
                     </form>
                </div>


        </div>

  
   

</body>
</html>