<?php /* Smarty version 2.6.20, created on 2009-10-31 21:09:56
         compiled from ./admin/images.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Spr&aacute;va obr&aacute;zkov :: <?php echo $this->_tpl_vars['_name']; ?>
</title>
<link rel="stylesheet" type="text/css" href="../web/css/theme.css" />
<link rel="stylesheet" type="text/css" href="../web/css/style.css" />
<link rel="stylesheet" type="text/css" href="../web/css/theme1.css"/>
<script type="text/javascript" src="../web/js/functions.js"></script>
<?php echo '
<script type="text/javascript">
			
			
			function otvorNahlad(url){
				window.open(url, "Náhľad obrázku", "width=1024, height=768,menubar=yes,resizable=yes,left=0,top=0,scrollbars=yes"); 
			}
		</script>
'; ?>



<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->
</head>

<body>
	<div id="container">
    	<div id="header">
   			<img src="../web/img/logo.png" width="90" height="90" alt="logo"/><b class="header_title"><?php echo $this->_tpl_vars['_name']; ?>
</b>
      	
    	<div class="info">
    		<p>
      			<img src="../web/img/icons/user.png" width="25" height="25" alt="icon user"/>&nbsp;<span><b><?php echo $this->_tpl_vars['username']; ?>
</b></span>&nbsp;&nbsp;
      			<img src="../web/img/icons/calendar.png" width="25" height="25" alt="icon date"/>&nbsp;<span><b><?php echo $this->_tpl_vars['date']; ?>
</b></span>

      			<a href="index.php?action=log_out&amp;token=<?php echo $this->_tpl_vars['token']; ?>
"><img src="../web/img/icons/exit.png" width="25" height="25" alt="icon user"/>&nbsp;</a><span><b>Odhl&aacute;siť</b></span>
      		</p>
      	</div>
      	
    	<div id="topmenu">
           	<ul>
               	<li><a href="index.php?token=<?php echo $this->_tpl_vars['token']; ?>
" title="Domov">Domov</a></li>
                <li><a href="index.php?module=messaging&amp;token=<?php echo $this->_tpl_vars['token']; ?>
" title="Spr&aacute;vy">Spr&aacute;vy <?php if ($this->_tpl_vars['newMess'] != 0): ?>(<?php echo $this->_tpl_vars['newMess']; ?>
)<?php endif; ?></a></li>
                <li><a href="index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
" title="Spr&aacute;va už&iacute;vateľov">Spr&aacute;va už&iacute;vateľov</a></li>
              	<li class="current"><a href="index.php?module=images&amp;token=<?php echo $this->_tpl_vars['token']; ?>
" title="Spr&aacute;va obr&aacute;zkov">Spr&aacute;va obr&aacute;zkov</a></li>
                <li><a href="index.php?module=categories&amp;token=<?php echo $this->_tpl_vars['token']; ?>
" title="Spr&aacute;va kateg&oacute;ri&iacute;">Spr&aacute;va kateg&oacute;ri&iacute;</a></li>
                <li><a href="index.php?module=search&amp;token=<?php echo $this->_tpl_vars['token']; ?>
" title="Vyhľad&aacute;vanie">Vyhľad&aacute;vanie</a></li>
                <li><a href="index.php?module=statistics&amp;token=<?php echo $this->_tpl_vars['token']; ?>
" title="Štatistiky">Štatistiky</a></li>
                <li><a href="index.php?module=settings&amp;token=<?php echo $this->_tpl_vars['token']; ?>
" title="Nastavenia">Nastavenia</a></li>
            </ul>
        </div>
      	</div>
      	<div id="top-panel">
           
      	</div>
      	<div id="wrapper">
            <div id="content">
            
            	<div class="path">
            		<a href="index.php?token=<?php echo $this->_tpl_vars['token']; ?>
" title="Domov">Domov</a>
            		<img src="../web/img/icons/arrow.png" alt="right arrow"/>
            		Spr&aacute;va obr&aacute;zkov
        
            	
            	</div>
            	<div id="rightnow">
            		<div class="reallynow">
            			
            			
            			<h2>Spr&aacute;va obr&aacute;zkov</h2>
            			
            		</div>
            	</div>
            	
            	
            	<div style="width:280px;border:0px solid #a2a2a2; margin:0px 0px 0px 0px;">
            		<?php if ($this->_tpl_vars['message']): ?>
            			<div style="color:green" class="hlaska"><?php echo $this->_tpl_vars['message']; ?>
</div>
            		<?php endif; ?>
            		           			
            		<div>
            			<img style="position:relative; top:10px;" src="../web/img/icons/image-add-32x32.png" alt="add category"/>
            			<a style="text-decoration:underline;" href="index.php?module=images&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=add_new_images" title="Pridanie nov&yacute;ch obr&aacute;zkov"><b style="font-size:130%;">Pridanie nov&yacute;ch obr&aacute;zkov</b></a>
            		</div>
            		
            	</div>
            	
            	<br/>
            	
            	<div class="list_cat">
            		<div class="path">
            	            			
            		
            			<h3>Naposledy pridan&eacute; obr&aacute;zky</h3>
            			<ul class="galeria">
						
						<?php $_from = $this->_tpl_vars['newest_images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['image']):
?>
							
							<li style="border-width:1px 1px 1px 1px">
						
								<div>
									<a style="text-decoration:underline" href="index.php?module=images&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=detail&amp;id=<?php echo $this->_tpl_vars['image']['id']; ?>
">
										<img alt="<?php echo $this->_tpl_vars['image']['url']; ?>
" src="<?php echo $this->_tpl_vars['image']['url']; ?>
" width="95" height="64" />										
									</a>
								</div>			
					
							</li>
						<?php endforeach; endif; unset($_from); ?>
					
						</ul>
						<p style="text-align:right; padding-right:20px; font-size:150%">
							<a href="index.php?module=images&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=list&amp;filter=newest">Viac ...</a>
						</p>
            		</div>
            		
            		<div class="path">
            	            			
            		
            			<h3>Obr&aacute;zky podľa kateg&oacute;ri&iacute;</h3>
            			<ul class="galeria">
						
						<?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cat']):
?>
							
						<li style="border-width:0px 0px 0px 0px">
						
							<div>
								<a style="text-decoration:underline" href="index.php?module=images&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=list&amp;filter=category&amp;category_id=<?php echo $this->_tpl_vars['cat']['id']; ?>
">
									<h3><?php echo $this->_tpl_vars['cat']['name']; ?>
</h3>
										
								</a>
								<img style="float:left; position:relative; top:5px;" src="../web/img/icons/folder-32x32.png" alt="category"/>
								<div style="padding:0px;text-align:center;text-align:left;float:right;position:relative; top:0px; right:-5px;">
									<table>
										<tr>
											<td><b>Obr&aacute;zkov: </b><?php echo $this->_tpl_vars['cat']['images_count']; ?>
</td>
										</tr>
									</table>			
								</div>
								
							</div>	

						
					
						</li>
						<?php endforeach; endif; unset($_from); ?>
					
						</ul>
						<p style="text-align:right; padding-right:20px; font-size:150%">
							<a href="index.php?module=images&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=list&amp;filter=category&amp;category_id=0">Viac ...</a>
						</p>
            		</div>
            	</div>
            
            </div>
            <div id="sidebar">
  				<ul>
                	<li><h3><a href="index.php?module=messaging&amp;token=<?php echo $this->_tpl_vars['token']; ?>
" class="house">&nbsp;&nbsp;Spr&aacute;vy</a></h3>
                        <ul>
                        	<li><a href="index.php?module=messaging&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=new_message" class="report">&nbsp;&nbsp;Nov&eacute; spr&aacute;va</a></li>
                    		<li><a href="index.php?module=messaging&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=show_inbox" class="report_seo">&nbsp;&nbsp;Prijat&eacute; spr&aacute;vy</a></li>
                            <li><a href="index.php?module=messaging&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=show_outbox" class="search">&nbsp;&nbsp;Odoslan&eacute; spr&aacute;vy</a></li>
                        </ul>
                    </li>
                    <li><h3><a href="index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
" class="folder_table">&nbsp;&nbsp;Už&iacute;vatelia</a></h3>
          				<ul>
                        	<li><a href="index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=new_user" class="addorder">&nbsp;&nbsp;Pridať už&iacute;vateľa</a></li>
                          	<li><a href="index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=show_users" class="shipping">&nbsp;&nbsp;Zobraziť už&iacute;vateľov</a></li>
                           
                        </ul>
                    </li>
                    <li><h3><a href="index.php?module=images&amp;token=<?php echo $this->_tpl_vars['token']; ?>
" class="manage">&nbsp;&nbsp;Obr&aacute;zky</a></h3>
          				<ul>
                            <li><a href="index.php?module=images&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=new_images" class="manage_page">&nbsp;&nbsp;Pridať obr&aacute;zky</a></li>
                            <li><a href="index.php?module=images&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=show_images" class="cart">&nbsp;&nbsp;Prehľad obr&aacute;zkov</a></li>
                        </ul>
                    </li>
                  	<li><h3><a href="index.php?module=categories&amp;token=<?php echo $this->_tpl_vars['token']; ?>
" class="user">&nbsp;&nbsp;Kateg&oacute;rie</a></h3>
          				<ul>
                            <li><a href="index.php?module=categories&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=new_category" class="useradd">&nbsp;&nbsp;Pridať kateg&oacute;riu</a></li>
                            <li><a href="index.php?module=categories&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=show_categories" class="group">&nbsp;&nbsp;Prehľad kateg&oacute;ri&iacute;</a></li>                            
                        </ul>
                  	</li>
                  	<li><h3><a href="index.php?module=search&amp;token=<?php echo $this->_tpl_vars['token']; ?>
" class="search">&nbsp;&nbsp;Vyhľad&aacute;vanie</a></h3>
          				<ul>
                            <li><a href="index.php?module=search&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;type=advanced" class="advanced_search">&nbsp;&nbsp;Pokr. vyhľad&aacute;vanie</a></li>
                                                        
                        </ul>
                  	</li>
				</ul>       
    		</div>
      </div>
        <div id="footer">

			<div style="text-align:center;margin:auto 0px;">
				2009 &copy;
				<a href="https://www.st.fmph.uniba.sk/~vlk4">
					Juraj Vlk
				</a>&nbsp;|&nbsp; 
					Design is inspired by <a href="http://www.bloganje.com">Bloganje</a>
				</a>
			</div>
        </div>
</div>
</body>
</html>