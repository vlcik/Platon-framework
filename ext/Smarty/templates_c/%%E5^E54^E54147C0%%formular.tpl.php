<?php /* Smarty version 2.6.20, created on 2009-11-01 03:18:24
         compiled from ./common/formular.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Upload suborov</title>

        <meta http-equiv="content-type" content="text/html;charset=utf-8" />

	<meta http-equiv="Content-Style-Type" content="text/css" />
        <link rel="stylesheet" type="text/css" href="./web/css/style.css" />

</head>

<body>

	<div style="text-align:right">
            <a href="#" onclick="return window.open('index.php?action=source');">Zobraz zdrojov&eacute; k&oacute;dy</a>
        </div>
        <h1>Web gal&eacute;ria</h1>

        <div>
            <h2>Formul&aacute;r</h2>

            <form enctype="multipart/form-data" action="<?php echo '<?php'; ?>
 echo $_SERVER["PHP_SELF"];<?php echo '?>'; ?>
" method="post">
                <table>
                    <tr>
                        <td><b>Subor:</b></td>
                        <td><input type="file" name="image"/></td>

                    </tr>
                    <tr>
                        <td><b>Nazov:</b></td>
                        <td><input type="text" name="name" value=""/></td>
                    </tr>
                    <tr>
                        <td><b>Meno autora:</b></td>

                        <td><input type="text" name="autor" value=""/></td>
                    </tr>
                    <tr>
                        <td><b>Popis fotografie:</b></td>

                        <td><input type="text" name="popis" value=""/></td>
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