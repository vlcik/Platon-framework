<?php /* Smarty version 2.6.20, created on 2009-10-26 00:25:30
         compiled from ./admin/users_show.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Spr&aacute;va už&iacute;vateľov :: </title>
<link rel="stylesheet" type="text/css" href="../web/css/theme.css" />
<link rel="stylesheet" type="text/css" href="../web/css/style.css" />
<link rel="stylesheet" type="text/css" href="../web/css/theme1.css"/>
<script type="text/javascript" src="../web/js/functions.js"></script>
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
                <li class="current"><a href="index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
" title="Spr&aacute;va už&iacute;vateľov">Spr&aacute;va už&iacute;vateľov</a></li>
              	
                <li><a href="index.php?module=images&amp;token=<?php echo $this->_tpl_vars['token']; ?>
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
            		Spr&aacute;va už&iacute;vateľov - Prehľad už&iacute;vateľov
            		
            	</div>
            	<div id="rightnow">
            		<div class="reallynow">
            			<h2>Spr&aacute;va už&iacute;vateľov</h2>	
            		</div>
            	</div><br/>
            	<p>
            		<img style="position:relative; top:5px;" src="../web/img/icons/add_user.png" alt="add user icon" />
            		<a href="index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=new_user">	
            			<b>Pridať už&iacute;vateľa</b>&nbsp;&nbsp;
            		<img style="position:relative; top:5px;" src="../web/img/icons/community-users-32x32.png" alt="login report icon" />
            		</a><a href="index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=login_report">
            			<b>Prehľad prihl&aacute;sen&iacute;</b>
            		</a>
            	</p>
            	<?php if ($this->_tpl_vars['message']): ?>
            	<div class="hlaska">
            			<span><?php echo $this->_tpl_vars['message']; ?>
</span>
            	</div>
            	<?php endif; ?>
            	<table class="show_users">
            		<tr>
            			<th>ID</th>
            			<th>Login</th>
            			<th>Mail</th>
            			<th>Posledn&eacute; prihl&aacute;senie</th>
            			<th>Stav</th>
            			<th>Oper&aacute;cie</th>
            		</tr>
            		<?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>
            		<?php if (( $this->_tpl_vars['i']++ % 2 ) == 1): ?>
            		<tr>
            			<td><?php echo $this->_tpl_vars['user']['id']; ?>
</td>
            			<td><?php echo $this->_tpl_vars['user']['login']; ?>
</td>
            			<td><?php echo $this->_tpl_vars['user']['mail']; ?>
</td>
            			<td><?php echo $this->_tpl_vars['user']['last_login']; ?>
</td>
            			<td><?php echo $this->_tpl_vars['user']['is_active']; ?>
</td>
            			<td>
            				<a href="index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=show_info&amp;id=<?php echo $this->_tpl_vars['user']['id']; ?>
" title="Zobraz detaily o už&iacute;vateľovi"><img src="../web/img/icons/one_user.png" alt="one user icon"/></a>
            				<a href="index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=edit_info&amp;id=<?php echo $this->_tpl_vars['user']['id']; ?>
" title="Uprav info o už&iacute;vateľovi"><img src="../web/img/icons/edit.png" alt="edit user icon"/></a>
            				<?php if (( $this->_tpl_vars['user']['state'] ) == 0): ?>
            					<a href="javascript:otazkaDelete('index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=deactivate&amp;id=<?php echo $this->_tpl_vars['user']['id']; ?>
')" title="Zneakt&iacute;vniť už&iacute;vateľa"><img src="../web/img/icons/user-remove.png" alt="delete user icon"/></a>
            				<?php else: ?>
            					<a href="javascript:otazkaDelete('index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=activate&amp;id=<?php echo $this->_tpl_vars['user']['id']; ?>
')" title="Zakt&iacute;vniť už&iacute;vateľa"><img src="../web/img/icons/user_accept.png" alt=""/></a>
            				<?php endif; ?>
            				<a href="index.php?module=privileges&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;id=<?php echo $this->_tpl_vars['user']['id']; ?>
" title="Nastavenie pr&aacute;v už&iacute;vateľa"><img src="../web/img/icons/privileges_show_users.png" alt="change priviles icon"/></a>
            			</td>
            		</tr>
            		<?php else: ?>
            		<tr style="background-color:#679ED2">
            			<td><?php echo $this->_tpl_vars['user']['id']; ?>
</td>
            			<td><?php echo $this->_tpl_vars['user']['login']; ?>
</td>
            			<td><?php echo $this->_tpl_vars['user']['mail']; ?>
</td>
            			<td><?php echo $this->_tpl_vars['user']['last_login']; ?>
</td>
            			<td><?php echo $this->_tpl_vars['user']['is_active']; ?>
</td>
            			<td>
            				<a href="index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=show_info&amp;id=<?php echo $this->_tpl_vars['user']['id']; ?>
" title="Zobraz detaily o už&iacute;vateľovi"><img src="../web/img/icons/one_user.png" alt="one user icon"/></a>
            				<a href="index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=edit_info&amp;id=<?php echo $this->_tpl_vars['user']['id']; ?>
" title="Uprav info o už&iacute;vateľovi"><img src="../web/img/icons/edit.png" alt="edit user icon"/></a>
            				<?php if (( $this->_tpl_vars['user']['state'] ) == 0): ?>
            					<a href="javascript:otazkaDelete('index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=deactivate&amp;id=<?php echo $this->_tpl_vars['user']['id']; ?>
')" title="Zneakt&iacute;vniť už&iacute;vateľa"><img src="../web/img/icons/user-remove.png" alt="delete user icon"/></a>
            				<?php else: ?>
            					<a href="javascript:otazkaDelete('index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=activate&amp;id=<?php echo $this->_tpl_vars['user']['id']; ?>
')" title="Zakt&iacute;vniť už&iacute;vateľa"><img src="../web/img/icons/user_accept.png" alt=""/></a>
            				<?php endif; ?>
            				<a href="index.php?module=privileges&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;id=<?php echo $this->_tpl_vars['user']['id']; ?>
" title="Nastavenie pr&aacute;v už&iacute;vateľa"><img src="../web/img/icons/privileges_show_users.png" alt="change priviles icon"/></a>
            			</td>
            		</tr>
            		<?php endif; ?>
            		<?php endforeach; endif; unset($_from); ?>
            	</table>
            	<div class="paging">
            		
            			<?php if ($this->_tpl_vars['prev_page']): ?>
            				<span style="color:#437539;"><a href="index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=show_users&amp;page=<?php echo $this->_tpl_vars['prev_page']; ?>
">Predch&aacute;dzaj&uacute;ca strana</a></span>
            			<?php endif; ?> &nbsp;|&nbsp;
            			<?php $_from = $this->_tpl_vars['pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page']):
?>
            			<?php if (( $this->_tpl_vars['act_page'] == $this->_tpl_vars['page']['cislo'] )): ?>
            				<?php echo $this->_tpl_vars['page']['cislo']; ?>

            			<?php else: ?>
            				<a href="index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=show_users&amp;page=<?php echo $this->_tpl_vars['page']['cislo']; ?>
"><?php echo $this->_tpl_vars['page']['cislo']; ?>
</a>
            			<?php endif; ?>
            			<?php endforeach; endif; unset($_from); ?>&nbsp;|&nbsp;
            			<?php if ($this->_tpl_vars['next_page']): ?>
            				<span style="color:#437539;"><a href="index.php?module=users&amp;token=<?php echo $this->_tpl_vars['token']; ?>
&amp;action=show_users&amp;page=<?php echo $this->_tpl_vars['next_page']; ?>
">Ďalšia strana</a></span>
            			<?php endif; ?>
            		
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