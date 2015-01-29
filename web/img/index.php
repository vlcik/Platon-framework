<?php
if ($_GET['action'] == "source"){
        if (!headers_sent()) {
            header('Content-type: text/plain');
            $source = file_get_contents($_SERVER['SCRIPT_FILENAME']);
            echo $source;exit;
        }
    }

    include "Database.php";
    include "gallery.php";

    $conf = new Config();
    $gallery = new Gallery;
    $warning = "";

    try {
        $db = new Database($conf->configDatabase);
    }
    catch (Exception $e){
        echo $e;
    }

   
   
        if (isset($_FILES) && (!(empty($_FILES)))){

            $output = $gallery->upload_image($_FILES, $_POST);


            if ($output['result']){
                $url_thumb = $gallery->makeThumbnail(array(
                    'url' => $output['target'],
                    'name' => $output['name'],
                    'type' => $output['type'],
                ));

                $warning = "<b style=\"color:green\">Upload obr&aacute;zku bol úspešný</b>";

                $data = array(
                    'name' => $_POST['name'],
                    'autor' => $_POST['autor'],
                    'popis' => $_POST['popis'],
                    'url' => $output['target'],
                    'url_thumb' => $url_thumb,
                );

                try {
                    $db->insert_item($gallery->createSQLQuery($data));
                }
                catch (Exception $e){
                    echo $e;
                }

            }
            else {
                $warning = "<b style=\"color:red\">" . $output['message'] . "</b>";
            }

        
    }


    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Upload suborov</title>
        
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
	
	<meta http-equiv="Content-Style-Type" content="text/css" />
	

    <style type="text/css">
        body {
            
            margin: 100px 0 0 0;
            padding: 10px;
            background: #FFFFFF url('img01.gif') repeat-x;
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #333333;
        }
        @CHARSET "UTF-8";

        .galeria {
            //border: 1px solid #bbb;
            padding: 15px 30px 15px 0px;
            //text-align:center;
            margin-top: 50px;
            clear:both;
        }

        .galeria li {
            display: -moz-inline-box;
            display: inline-block;
        /*\*/ vertical-align: top; /**/
        text-align:center;
            margin: 0 7px 15px 7px;
            border: 1px solid #bbb;
            padding: 0;
        }

        .galeria li>div{
            /*\*/ display: table; /**/
            width: 169px;
        }

        .galeria a {
            display: block;
            text-decoration: none;
            color: #000;
            background-color: #f9fbff;
            cursor: pointer;
        }

        /* IE7? \*/
        .galeria>li .wrimg {
            display: table-cell;
            vertical-align: middle;
            width: 169px;
            height: 169px;
        }
        /**/

        .galeria img {
            border: solid 1px #fff;
            vertical-align: middle;
        }

        .galeria a:hover{
            background-color: #e5ecff;
        }

        /*\*//*/
        .galerie li .wrimg
        {
        display: block;
        font-size: 1px;
        }

        .galerie .wrimg span
        {
        display: inline-block;
        vertical-align: middle;
        height: 199px;
        width: 1px;
        }
        /**/

        .galeria .caption {
            display: block;
            padding: .3em 5px;
            font-size: .9em;
            line-height: 1.1;
            border-top: 1px solid #bbb;
            width: 159px;
            text-align:center;
        }

        @media all and (min-width: 0px) {

            .galeria {
            border-collapse: collapse;
            }

            .galeria a {
                display: inline-block;
                vertical-align: top;
            }

            .galeria {
                display: inline-block;
            }
        }

    </style>

</head>

<body>

	<div style="text-align:right">
            <a href="#" onclick="return window.open('index.php?action=source');">Zobraz zdrojov&eacute; k&oacute;dy</a>
        </div>
        <h1>Web gal&eacute;ria</h1>
        <?php
            if (strlen($warning) > 0)
            {
                echo $warning;
            }
        ?>

        <div>
            <h2>Formul&aacute;r</h2>

            <form enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
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

     <ul class="galeria">

			<?php

            $data = $db->return_array_result("SELECT * FROM images");

            if (count($data) > 0){
            foreach ($data as $item)
            {
            ?>
				<li>
					<div>
						<a  href="show.php?id=<?php echo $item['id']?>"><span class="wrimg">
							<span></span>
							<img alt="<?php echo $item['url']?>" src="image.php?id=<?php echo $item['id']?>&amp;view=thumb" /></span>
						</a>
                        <span class="caption"><b>Nazov: </b><?php echo $item['name']?></span>
                        <span class="caption"><b>Autor: </b><?php echo $item['autor']?></span>
						<span class="caption"><b>Popis: </b><?php echo $item['popis']?></span>
                                                
					
					</div>



				</li>
			<?php
            }}
            ?>
			</ul>
          
</body>
</html>


