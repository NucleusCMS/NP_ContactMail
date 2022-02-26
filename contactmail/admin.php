<?php

//NP_contactmail admin class

class NPCM_ADMIN {

	var $action;
	var $tabs;
	
/****************************************************************
    NPCM_ADMIN()
****************************************************************/
	function NPCM_ADMIN() {
		global $manager;
		
		//admin tabs
		$this->tabs = array();
		array_push($this->tabs, array('action' => 'config', 'active' =>'config', 'title'=>__NPCM_ADMIN_TAB_CONFIG));
		array_push($this->tabs, array('action' => 'templates', 'active' =>'templates', 'title'=>__NPCM_ADMIN_TAB_TEMPLATES));
		array_push($this->tabs, array('action' => 'template_items', 'active' =>'template_items', 'title'=>__NPCM_ADMIN_TAB_TEMPLATE_ITEMS));

		$manager->notify('NPgAdminTab', array('tabs' => &$this->tabs ));
	}
	
/****************************************************************
    action()
****************************************************************/
	function action($action) {
		global $NPCM_CONF, $manager;
		
		$methodName = 'action_' . $action;

		$this->action = strtolower($action);
		
		//if nucleus version 3.2, check ticket
		
		/*if(getNucleusVersion() >= 320) {
			$aActionsNotToCheck = array();

			if (!in_array($this->action, $aActionsNotToCheck))
			{
				if (!$manager->checkTicket())
					$this->error(_ERROR_BADTICKET);
			}
			
		}*/
		
		if (method_exists($this, $methodName))
			call_user_func(array(&$this, $methodName));
		else
			$this->error(_BADACTION . " ($action)");

	}
	
/****************************************************************
    error()
****************************************************************/
	function error($msg) {
		?>
		<h2>Error!</h2>
		<?php		echo $msg;
		echo "<br />";
		echo "<a href='index.php' onclick='history.back()'>"._BACK."</a>";
		exit;
	}
/****************************************************************
    display_tabs()
****************************************************************/
	function display_tabs($active = 'config') {
		global $member, $NPCM_CONF, $contactmailaction;
		
		echo '<ul id="tabmenu">';
		foreach($this->tabs as $tab) {
			if($tab['user'] || $member->isAdmin() ) {
				echo '<li><a ';
				if( $active == $tab['active'] ) echo 'class="active" ';
				echo 'href="'.$contactmailaction;
				if($tab['action']) echo '?action='.$tab['action'];
				echo '">'.$tab['title'].'</a></li>';
			}
		}
		echo '</ul>';

	}
/****************************************************************
    display_options()
****************************************************************/
	function display_options() {
		global $NPCM_CONF,$contactmailaction;
	
		$contactmailconfig = checkcontactmailconfig();
		
		if(!$contactmailconfig['configured']) {
			setNPCMoption('configured', false);
			echo '<div class="error">'.$contactmailconfig['message'].'</div>';
		}
		else setNPCMoption('configured', true);
		
		$NPCM_CONF = getNPCMConfig();
		
		if(!$NPCM_CONF['configured']) echo '<div class="error">'.__NPCM_ERR_CONTACTMAIL_NOT_CONFIG . '</div><br/><br/>';
		
		echo '<form method="post" action="'.$contactmailaction.'?action=editoptions" ><div>';
		echo '<fieldset>';
		echo '<legend>'.__NPCM_ADMIN_GEN_OPTIONS.'</legend>';
		echo '<p>';
		echo '<label for="toaddr">'.__NPCM_TO_MAIL_MEMBER.':</label>';
		echo '<select name="toaddr" id="toaddrf">';
		echo '<option value=""';
		$query = 'select * from '.sql_table('member');
		$result = sql_query($query);
		while($row=mysql_fetch_object($result)) {
			echo '<option value="'.$row->mnumber.'"';
			if ($NPCM_CONF['toaddr'] == $row->mnumber) echo ' selected';
			echo '>'.$row->mname;
		}
		echo '</select></p>';
		
		echo '<p><label for="bname">'.__NPCM_SELECTED_BLOG.': </label>';
		echo '<select name="bname" id="bnamef">';
		echo '<option value=""';
		$query = 'select bshortname, bdefskin, bnumber from ' . sql_table('blog');
		$result = mysql_query($query);
		while($row=mysql_fetch_object($result)) {
			echo '<option value="'.$row->bnumber.'"';
			if ($NPCM_CONF['bname'] == $row->bnumber) echo ' selected';
			echo '>'.$row->bshortname;
		}
		echo '</select></p>';
		
		echo '<p><label for="templatef">'.__NPCM_ADMIN_ACTIVETEMPLATE.': </label>';
		echo '<select name="template" id="templatef">';
		$query = 'select * from '.sql_table('plug_contactmail_template_desc');
		$result = sql_query($query);
		while($row=mysql_fetch_object($result)) {
			echo '<option value="'.$row->tdid.'"';
			if ($NPCM_CONF['template'] == $row->tdid) echo ' selected';
			echo '>'.$row->tdname;
		}
		echo '</select></p>';

		echo '<p>';
		echo '<label for="captcha">'.__NPCM_ADMIN_CAPTCHA.':</label>';
		echo '<select name="captcha" id="captcha">';
		echo '<option value="yes" ';
		if($NPCM_CONF['captcha'] == 'yes' ) echo 'selected'; 
		echo '>yes';
		echo '<option value="no" ';
		if($NPCM_CONF['captcha'] == 'no' ) echo 'selected';
		echo '>no';
		echo '</select></p>';
			
		echo '<p>';
		echo '<label for="invalidplus">'.__NPCM_ADMIN_INVALID_PLUS.':</label>';
		echo '<select name="invalidplus" id="invalidplus">';
		echo '<option value="yes" ';
		if($NPCM_CONF['invalidplus'] == 'yes' ) echo 'selected'; 
		echo '>yes';
		echo '<option value="no" ';
		if($NPCM_CONF['invalidplus'] == 'no' ) echo 'selected';
		echo '>no';
		echo '</select></p>';			
			
		echo '</fieldset>';
			
		echo '<br /><input type="submit" value="'.__NPCM_FORM_SUBMIT_CHANGES.'" />';
		echo '</div></form>';
		
	}
	
/****************************************************************
    display_templates()
****************************************************************/
	function display_templates() {
		global $NPCM_CONF, $contactmailaction;
	
		echo '<h3>'.__NPCM_ADMIN_TEMPLATES.'</h3>';
		echo '<table><thead><tr><th>'.__NPCM_FORM_NAME.'</th><th>'.__NPCM_FORM_DESC.'</th><th colspan=\'3\' >'.__NPCM_FORM_ACTIONS.'</th></tr></thead><tbody>';
		$query = 'select * from '.sql_table('plug_contactmail_template_desc');
		$result = sql_query($query);
		while ($row = mysql_fetch_object($result)) {
			echo '<tr onmouseover=\'focusRow(this);\' onmouseout=\'blurRow(this);\'>';
			echo '<td>'.$row->tdname.'</td>';
			echo '<td>'.$row->tddesc.'</td>';
			echo '<td><a href="'.$contactmailaction.'?action=edittemplateF&amp;id='.$row->tdid.'">'.__NPCM_FORM_EDIT.'</a></td>';
			echo '<td><a href="'.$contactmailaction.'?action=clonetemplate&amp;id='.$row->tdid.'">'.__NPCM_FORM_CLONE.'</td>';
			echo '<td><a href="'.$contactmailaction.'?action=deletetemplate&amp;id='.$row->tdid.'">'.__NPCM_FORM_DELETE.'</td></tr>';
		}
		
		echo '</tbody></table>';
		
		$this->display_newtemplate();

	}
	
/****************************************************************
    display_newtemplate()
****************************************************************/
	function display_newtemplate() {
//		global $contactmailaction;
		
		echo '<h3>'.__NPCM_FORM_NEWTEMPLATE.'</h3>';
		echo '<form method="post" action="'.$contactmailaction.'?action=addtemplate"><table>';
		echo '<tr><td>'.__NPCM_FORM_TEMPLATE_NAME.'</td><td><input name="tname" maxlength="20" size="20" /></td></tr>';
		echo '<tr><td>'.__NPCM_FORM_TEMPLATE_DESC.'</td><td><input name="tdesc" maxlength="200" size="50" /></td></tr>';
		echo '<tr><td></td><td><input type="submit" value="'.__NPCM_FORM_CREATENEWTEMPLATE.'" /></table></form>';
	}
	
/****************************************************************
    action_edittemplateF()
****************************************************************/
	function action_edittemplateF() {
		global $member,$contactmailaction;
		
		$id = requestvar('id');
		if($member->isAdmin() && $id) { 
			$query = "select * from ".sql_table('plug_contactmail_template')." where tdesc=".$id;
			$result = sql_query($query);
			if(!mysql_num_rows($result)) {
				echo __NPCM_ERR_BAD_TEMPLATE.'<br/>';
				return false;
			}

			if(mysql_num_rows($result)) {
				while ($row = mysql_fetch_object($result)) {
					$section[$row->name] = stripslashes($row->content);
				}
			}
			
			$query2 = 'select * from '.sql_table('plug_contactmail_template_desc').' where tdid='.$id;
			$result2 = sql_query($query2) ;//or die('Query Error : ' . $query2);
			if(!mysql_num_rows($result2)) {
				echo __NPCM_ERR_BAD_TEMPLATE.'<br/>';
				return false;
			}
			$row = mysql_fetch_object($result2);
			$section['name'] = stripslashes($row->tdname);
			$section['desc'] = stripslashes($row->tddesc);
			
			echo '<h3>'.__NPCM_FORM_EDIT_TEMPLATE.': '.$section['name'].'</h3>';
			echo '<br/><a href="'.$contactmailaction.'">'.__NPCM_ADMIN_RETURN.'</a>';
			echo '<form method="post" action="'.$contactmailaction.'?action=edittemplate"><div>';
			echo '<input type="hidden" name="oid" value="'.$id.'" />';
			echo '<input type="hidden" name="id" value="'.$id.'" />';
			echo '<table><thead><tr><th colspan="2" >'.__NPCM_FORM_TEMPLATE_SETTINGS.'</th></tr></thead>';
			echo '<tbody>';
			echo '<tr><td class="left">'.__NPCM_FORM_TEMPLATE_NAME.'</td>';
			echo '<td><input name="tname" size="20" maxlength="20" value="';
			echo htmlspecialchars($section['name']);
			echo '" /></td></tr>';
			echo '<tr><td class="left">'.__NPCM_FORM_TEMPLATE_DESC.'</td>';
			echo '<td><input name="tdesc" size="50" maxlength="200" value="';
			echo htmlspecialchars($section['desc']);
			echo '" /></td></tr>';
			echo '<tr><td></td><td><input type="submit" value="'.__NPCM_FORM_SUBMIT_CHANGES.'" /></td></tr>';
			echo '</tbody></table>';
			
			echo '<table><thead><tr><th colspan="2" >'.__NPCM_FORM_TEMPLATE_CREATE.'</th></tr></thead>';
			echo '<tbody>';
			$tags = allowedTemplateTags_NPCM('CREATEMAIL_HEADER');
			echo '<tr><td class="left" >'.__NPCM_FORM_TEMPLATE_CREATE_HEADER.'<br/></td>';
			echo '<td><textarea class="templateedit" name="CREATEMAIL_HEADER" cols="50" rows="5">';
			echo htmlspecialchars($section['CREATEMAIL_HEADER']);
			echo '</textarea></td></tr><tr><td colspan="2">'.$tags.'</td></tr>';
			$tags = allowedTemplateTags_NPCM('CREATEMAIL_BODY');
			echo '<tr><td class="left" >'.__NPCM_FORM_TEMPLATE_CREATE_BODY.'<br/></td>';
			echo '<td><textarea class="templateedit" name="CREATEMAIL_BODY" cols="50" rows="8">';
			echo htmlspecialchars($section['CREATEMAIL_BODY']);
			echo '</textarea></td></tr><tr><td colspan="2">'.$tags.'</td></tr>';
			$tags = allowedTemplateTags_NPCM('CREATEMAIL_FOOTER');
			echo '<tr><td class="left" >'.__NPCM_FORM_TEMPLATE_CREATE_FOOTER.'<br/></td>';
			echo '<td><textarea class="templateedit" name="CREATEMAIL_FOOTER" cols="50" rows="5">';
			echo htmlspecialchars($section['CREATEMAIL_FOOTER']);
			echo '</textarea></td></tr><tr><td colspan="2">'.$tags.'</td></tr>';
			echo '<tr><td></td><td><input type="submit" value="'.__NPCM_FORM_SUBMIT_CHANGES.'" /></td></tr>';
			echo '</tbody></table>';
			
			echo '<table><thead><tr><th colspan="2" >'.__NPCM_FORM_TEMPLATE_INVALID.'</th></tr></thead>';
			echo '<tbody>';
			$tags = allowedTemplateTags_NPCM('INVALIDMAIL_HEADER');
			echo '<tr><td class="left" >'.__NPCM_FORM_TEMPLATE_INVALID_HEADER.'<br/></td>';
			echo '<td><textarea class="templateedit" name="INVALIDMAIL_HEADER" cols="50" rows="5">';
			echo htmlspecialchars($section['INVALIDMAIL_HEADER']);
			echo '</textarea></td></tr><tr><td colspan="2">'.$tags.'</td></tr>';
			$tags = allowedTemplateTags_NPCM('INVALIDMAIL_BODY');
			echo '<tr><td class="left" >'.__NPCM_FORM_TEMPLATE_INVALID_BODY.'<br/></td>';
			echo '<td><textarea class="templateedit" name="INVALIDMAIL_BODY" cols="50" rows="8">';
			echo htmlspecialchars($section['INVALIDMAIL_BODY']);
			echo '</textarea></td></tr><tr><td colspan="2">'.$tags.'</td></tr>';
			$tags = allowedTemplateTags_NPCM('INVALIDMAIL_FOOTER');
			echo '<tr><td class="left" >'.__NPCM_FORM_TEMPLATE_INVALID_FOOTER.'<br/></td>';
			echo '<td><textarea class="templateedit" name="INVALIDMAIL_FOOTER" cols="50" rows="5">';
			echo htmlspecialchars($section['INVALIDMAIL_FOOTER']);
			echo '</textarea></td></tr><tr><td colspan="2">'.$tags.'</td></tr>';
			echo '<tr><td></td><td><input type="submit" value="'.__NPCM_FORM_SUBMIT_CHANGES.'" /></td></tr>';
			echo '</tbody></table>';
			
			echo '<table><thead><tr><th colspan="2" >'.__NPCM_FORM_TEMPLATE_CONFIRM.'</th></tr></thead>';
			echo '<tbody>';
			$tags = allowedTemplateTags_NPCM('CONFIRMMAIL_HEADER');
			echo '<tr><td class="left" >'.__NPCM_FORM_TEMPLATE_CONFIRM_HEADER.'<br/></td>';
			echo '<td><textarea class="templateedit" name="CONFIRMMAIL_HEADER" cols="50" rows="5">';
			echo htmlspecialchars($section['CONFIRMMAIL_HEADER']);
			echo '</textarea></td></tr><tr><td colspan="2">'.$tags.'</td></tr>';
			$tags = allowedTemplateTags_NPCM('CONFIRMMAIL_BODY');
			echo '<tr><td class="left" >'.__NPCM_FORM_TEMPLATE_CONFIRM_BODY.'<br/></td>';
			echo '<td><textarea class="templateedit" name="CONFIRMMAIL_BODY" cols="50" rows="8">';
			echo htmlspecialchars($section['CONFIRMMAIL_BODY']);
			echo '</textarea></td></tr><tr><td colspan="2">'.$tags.'</td></tr>';
			$tags = allowedTemplateTags_NPCM('CONFIRMMAIL_FOOTER');
			echo '<tr><td class="left" >'.__NPCM_FORM_TEMPLATE_CONFIRM_FOOTER.'<br/></td>';
			echo '<td><textarea class="templateedit" name="CONFIRMMAIL_FOOTER" cols="50" rows="5">';
			echo htmlspecialchars($section['CONFIRMMAIL_FOOTER']);
			echo '</textarea></td></tr><tr><td colspan="2">'.$tags.'</td></tr>';
			echo '<tr><td></td><td><input type="submit" value="'.__NPCM_FORM_SUBMIT_CHANGES.'" /></td></tr>';
			echo '</tbody></table>';
			
			echo '<table><thead><tr><th colspan="2" >'.__NPCM_FORM_TEMPLATE_SEND.'</th></tr></thead>';
			echo '<tbody>';
			$tags = allowedTemplateTags_NPCM('SENDMAIL_HEADER');
			echo '<tr><td class="left" >'.__NPCM_FORM_TEMPLATE_SEND_HEADER.'<br/></td>';
			echo '<td><textarea class="templateedit" name="SENDMAIL_HEADER" cols="50" rows="5">';
			echo htmlspecialchars($section['SENDMAIL_HEADER']);
			echo '</textarea></td></tr><tr><td colspan="2">'.$tags.'</td></tr>';
			$tags = allowedTemplateTags_NPCM('SENDMAIL_BODY');
			echo '<tr><td class="left" >'.__NPCM_FORM_TEMPLATE_SEND_BODY.'<br/></td>';
			echo '<td><textarea class="templateedit" name="SENDMAIL_BODY" cols="50" rows="8">';
			echo htmlspecialchars($section['SENDMAIL_BODY']);
			echo '</textarea></td></tr><tr><td colspan="2">'.$tags.'</td></tr>';
			$tags = allowedTemplateTags_NPCM('SENDMAIL_FOOTER');
			echo '<tr><td class="left" >'.__NPCM_FORM_TEMPLATE_SEND_FOOTER.'<br/></td>';
			echo '<td><textarea class="templateedit" name="SENDMAIL_FOOTER" cols="50" rows="5">';
			echo htmlspecialchars($section['SENDMAIL_FOOTER']);
			echo '</textarea></td></tr><tr><td colspan="2">'.$tags.'</td></tr>';
			echo '<tr><td></td><td><input type="submit" value="'.__NPCM_FORM_SUBMIT_CHANGES.'" /></td></tr>';
			echo '</tbody></table>';
			
			echo '</div></form>';
			
		}
	}
	
/****************************************************************
    action_addtemplate()
****************************************************************/
	function action_addtemplate() {
		global $member;
		
		$name = addslashes(postvar('tname'));
		$desc = addslashes(postvar('tdesc'));
printf(" name=%s  desc=%s ",$name,$desc);
		if($member->isAdmin() && $name && $desc) {
			$query = 'insert into '.sql_table('plug_contactmail_template_desc')." (tdid, tdname, tddesc) values (NULL,'$name','$desc')";
			sql_query($query);
		}
		
		$this->action_templates();
	}
	
/****************************************************************
    action_clonetemplate()
****************************************************************/
	function action_clonetemplate() {
		global $member;
		
		//get postvars: templateid from template to clone
		$id = requestvar('id');
		if($id && $member->isAdmin()) {
			//get template data from plg_contactmail_template_desc and plug_contactmail_template
			$origtemplate = new NPCM_TEMPLATE($id);

			//write data to database tables, generating a new tdid for the same data
			$newtemplate = new NPCM_TEMPLATE(NPCM_TEMPLATE::createnew('cln_'.$origtemplate->getname(), 'Clone of '.$origtemplate->getdesc()));
			foreach($origtemplate->section as $name => $content) 
				$newtemplate->settemplate($name,$content);
		}
		
		$this->action_templates();
	}
	
/****************************************************************
    action_deletetemplate()
****************************************************************/
	function action_deletetemplate() {
		global $member;
		$id = requestvar('id');
		
		//don't delete if it's the only template in the database -- you need at least one
		$query = 'select count(*) from '.sql_table('plug_contactmail_template_desc');
		$res = sql_query($query);
		$nr = mysql_fetch_row($res);
		if ($nr[0] > 1 && $id && NPCM_TEMPLATE::existsID($id) && $member->isAdmin()) {
			$query = 'delete from '.sql_table('plug_contactmail_template_desc').' where tdid='.$id;
			sql_query($query);
			$query = 'delete from '.sql_table('plug_contactmail_template').' where tdesc='.$id;
			sql_query($query);
		}
		
		$this->action_templates();
		
	}
	
/****************************************************************
    action_edittemplate()
****************************************************************/
	function action_edittemplate() {
		global $member;
		
		$ipos_array = array();
		$idesc_array = array();
		$ichk_array = array();
		$on_mes_array = array();
		$off_mes_array = array();
	
		if(isset($NPCM_CONF['template']))
			$id = $NPCM_CONF['template'];
		else 	$id = 1;
		$id = requestvar('id');
		
		if($member->isAdmin() && $id) { 
			$t = new NPCM_TEMPLATE($id);
			
			if(isset($_POST['tname']) && isset($_POST['tdesc'])) {
				$t->updategeneralinfo($_POST['tname'],$_POST['tdesc']);
			}
			ins_contactmail_template($t);
			
    			$result = sel_contactmail_templ_item($id);

			make_array_ipos(&$ipos_array,$id);
			make_array_ichk(&$ichk_array,$id);	
			
			while ($row = mysql_fetch_object($result)) {
				make_associative_array($row->iname, $row->idesc, &$idesc_array);
				make_associative_array($row->iname, $row->off_mes, &$off_mes_array);
				make_associative_array($row->iname, $row->on_mes, &$on_mes_array);
			}

			del_contactmail_templ_item($id);
			$str1 = $_POST['CREATEMAIL_BODY'];
			$str2 = $_POST['CONFIRMMAIL_BODY'];
			ins_contactmail_templ_item($str1,$str2, $id);

			upd_contactmail_templ_item($idesc_array , $on_mes_array, $off_mes_array, $id);
			
			del_contactmail_templ_chk($id);
			for ($i=0; $i<count($idesc_array); $i++){			
				ins_contactmail_templ_chk($ipos_array, $id, $ichk_array,$i);
			}
		}
		
		$this->action_templates();
	}
/****************************************************************
    action_edittemplate_items()
****************************************************************/
	function action_edittemplate_items() {
		global $member;
		global $NPCM_CONF,$contactmailaction;
		global ${'off_mes_array'};
		global ${'on_mes_array'};
		
		striptags(&$ichk_array, 'ichk');
		striptags(&$ipos_array, 'ipos');
		striptags(&$idesc, 'idesc');
		striptags(&$iname_array, 'iname');
		striptags(&$iname_cb_array, 'iname_cb');
		striptags(&$off_mes, 'off_mes');
		striptags(&$on_mes, 'on_mes');
		
//2006-10-30 modified start

		if(isset($NPCM_CONF['template']))
			$id = $NPCM_CONF['template'];
		else 	$id = 1;

		$idesc_array = array();
		$off_mes_array = array();
		$on_mes_array = array();

		if($member->isAdmin() && $id) {
		
			if (isset($_POST['fromname_item'])) {
				striptags(&$wk_item, 'fromname_item');
				setNPCMoption_templ('fromname_item', $wk_item,$id);
			}
			if (isset($_POST['fromaddr_item'])) {
				striptags(&$wk_item, 'fromaddr_item');
				setNPCMoption_templ('fromaddr_item', $wk_item,$id);
			}
			if (isset($_POST['fromsubject_item'])) {
				striptags(&$wk_item, 'fromsubject_item');
				setNPCMoption_templ('fromsubject_item', $wk_item,$id);
			}
			if (isset($_POST['fromcopy_item'])) {
				striptags(&$wk_item, 'fromcopy_item');
				setNPCMoption_templ('fromcopy_item', $wk_item,$id);
			}
//2006-10-30 modified end

			for ($i=0; $i<count($idesc); $i++){			
				make_associative_array($iname_array[$i], hschars_encode($idesc[$i]), &$idesc_array);
			}
			
			for ($i=0; $i<count($iname_cb_array); $i++){			
				make_associative_array($iname_cb_array[$i], hschars_encode($off_mes[$i]), &$off_mes_array);
				make_associative_array($iname_cb_array[$i], hschars_encode($on_mes[$i]), &$on_mes_array);
			}
			
			upd_contactmail_templ_item($idesc_array , $on_mes_array, $off_mes_array, $id);

			del_contactmail_templ_chk($id);
			
			for ($i=0; $i<count($idesc); $i++){			

				ins_contactmail_templ_chk($ipos_array, $id, $ichk_array,$i);
			}
		}
		
		$this->action_template_items();
	}
	
/****************************************************************
    action_templates()
****************************************************************/
	function action_templates() {
		global $member;
		
		$this->display_tabs('templates');
		if($member->isAdmin()) { 
				echo '<div id="admin_content">';
				$this->display_templates();
				echo '</div>';
			}
			else echo _ERROR_DISALLOWED;
	}
		
/****************************************************************
    action_editoptions()
****************************************************************/
	function action_editoptions() {
		global $NPCM_CONF,$contactmailaction;
		global ${'off_mes_array'};

	
//		$contactmailconfig = checkcontactmailconfig();
			
		$ipos_array = array();
		$idesc_array = array();
		$ichk_array = array();
		$data_array = array();
		$on_mes_array = array();
		$off_mes_array = array();

		if(isset($NPCM_CONF['template']))
			$id = $NPCM_CONF['template'];
		else 	$id = 1;
		//need more error checking here
		if (isset($_POST['toaddr'])) {
			setNPCMoption('toaddr', $_POST['toaddr']);
		}
		if (isset($_POST['bname'])) {
			setNPCMoption('bname', $_POST['bname']);
		}
		if (isset($_POST['template'])) {
			setNPCMoption('template', $_POST['template']);
		}
		if (isset($_POST['captcha'])) {
			setNPCMoption('captcha', $_POST['captcha']);
		}
		if (isset($_POST['invalidplus'])) {
			setNPCMoption('invalidplus', $_POST['invalidplus']);
		}
		
		if(isset($NPCM_CONF['template']))
			$id = $NPCM_CONF['template'];
		else 	$id = 1;

		$query = "select * from ".sql_table('plug_contactmail_template')." where tdesc=".$id;
		$result = sql_query($query);
		if(!mysql_num_rows($result)) {
			return false;
			}

		if(mysql_num_rows($result)) {
			while ($row = mysql_fetch_object($result)) {
				$section[$row->name] = stripslashes($row->content);
			}
		}
		
		$t = new NPCM_TEMPLATE($id);
			
		if(isset($_POST['tname']) && isset($_POST['tdesc'])) {
			$t->updategeneralinfo($_POST['tname'],$_POST['tdesc']);
		}
		
		$query = "select * from ".sql_table('plug_contactmail_templ_item')." where tempid=".$id;
		$result = sql_query($query);
		if(!mysql_num_rows($result)) {

		$str1 = $section['CREATEMAIL_BODY'];
		$str2 = $section['CONFIRMMAIL_BODY'];

		ins_contactmail_templ_item($str1,$str2, $id);
    		$result = sel_contactmail_templ_item($id);

		make_array_ipos(&$ipos_array,$id);
		make_array_ichk(&$ichk_array,$id);	
			
		while ($row = mysql_fetch_object($result)) {
			make_associative_array($row->iname, $row->idesc, &$idesc_array);
			make_associative_array($row->iname, $row->off_mes, &$off_mes_array);
			make_associative_array($row->iname, $row->on_mes, &$on_mes_array);
		}
		upd_contactmail_templ_item($idesc_array , $on_mes_array, $off_mes_array, $id);
			
		del_contactmail_templ_chk($id);
		for ($i=0; $i<count($idesc_array); $i++){			
			ins_contactmail_templ_chk($ipos_array, $id, $ichk_array,$i);
		}}
			
		$this->action_config();
	}

/****************************************************************
    action_config()
****************************************************************/
	function action_config() {
		global $NPCM_CONF, $member;
		
		$NPCM_CONF = getNPCMConfig();
		
		$this->display_tabs('config');
		if($member->isAdmin()) { 
			echo '<div id="admin_content">';
			$this->display_options();
			echo '</div>';
		}
	}

/****************************************************************
    action_template_items()
****************************************************************/
	function action_template_items() {
		global $NPCM_CONF,$member;
		
		$NPCM_CONF = getNPCMConfig();
		
		$this->display_tabs('template_items');
		if($member->isAdmin()) { 
			echo '<div id="admin_content">';
			$this->display_template_items();
			echo '</div>';
		}
	}
	
/****************************************************************
    display_template_items()
****************************************************************/
	function display_template_items() {
		global $member;
		global $NPCM_CONF,$contactmailaction;
		global ${'substitute'};
			
		echo '<h3>'.__NPCM_ADMIN_TEMPLATE_ITEMS.'</h3>';
		echo '<form method="post" action="'.$contactmailaction.'?action=edittemplate_items" ><div>';
		echo '<table><thead><tr><th>'.__NPCM_TITEM_NAME.'</th><th>'.__NPCM_TITEM_TYPE.'</th><th>'.__NPCM_TITEM_DESC.'</th><th>'.__NPCM_TITEM_VALUE.'</th><th colspan=\'3\' >'.__NPCM_TITEM_CHECK.'</th></tr></thead><tbody>';
		
		$NPCM_CONF = getNPCMConfig();
		if(isset($NPCM_CONF['template']))
			$id = $NPCM_CONF['template'];
		else 	$id = 1;

		if($member->isAdmin() && $id) { 
			$query = 'select * from '.sql_table('plug_contactmail_template')." where tdesc = $id";
			$result = sql_query($query);
			if(mysql_num_rows($result)) {
				while ($row = mysql_fetch_object($result)) {
					$section[$row->name] = stripslashes($row->content);
				}
			}
			
			$query2 = 'select * from '.sql_table('plug_contactmail_template_desc')." where tdid = $id";
			$result2 = sql_query($query2);
			if(!mysql_num_rows($result2)) {
				echo __NPCM_ERR_BAD_TEMPLATE.'<br/>';
				return false;
			}
			$row = mysql_fetch_object($result2);
			$section['name'] = stripslashes($row->tdname);
			$section['desc'] = stripslashes($row->tddesc);
		
			$result3 = sel_contactmail_templ_item($id);
			$result5 = sel_contactmail_templ_chk($id);
			$result6 = sel_contactmail_templ_item_cb($id);
		
			$substitute = array();
			$iname = array();
			$iname_cb = array();
			$idesc = array();
			$ichk = array();
			$ipos = array();
			$ipos_cb = array();
			$on_mes = array();
			$off_mes = array();
		
			make_array_substitute(&$substitute,$id);
			make_array_ichk(&$ichk,$id);
		
			$i=0;
			while ($row = mysql_fetch_object($result3)) {
				echo '<tr onmouseover=\'focusRow(this);\' onmouseout=\'blurRow(this);\'>';
				echo '<td>'.$row->iname.'</td>';
				echo '<td>'.$row->itype.'</td>';
				echo '<td><input name="idesc['.$i.']" value="'.$row->idesc.'" maxlength="16" size="16" /></td>';
				echo '<input type="hidden" name="iname['.$i.']" value="'.$row->iname.'" />';
				echo '<input type="hidden" name="ipos['.$i.']" value="'.$row->ipos.'" />';
				echo '<td>'.$substitute[$i].'</td>';
			
				echo '<td>';
			
				if($row->itype=="checkbox" || $row->itype=="select" || $row->itype=="radio")
				{
					if($ichk[0][$i]!=NULL){
						echo '<input type="checkbox" name="ichk[0]['.$i.'] value="on" checked />';
					}
					else{
						echo '<input type="checkbox" name="ichk[0]['.$i.'] value="on" />';
					}
			
					for($j=1; $j<5; $j++){
						echo '<input type="checkbox" name="ichk['.$j.']['.$i.'] value="1" disabled />';
					}
				}
				else
				{
					for($j=0; $j<5; $j++){
						if($ichk[$j][$i]!=NULL){
							echo '<input type="checkbox" name="ichk['.$j.']['.$i.'] value="on" checked />';
						}
						else{
							echo '<input type="checkbox" name="ichk['.$j.']['.$i.'] value="on" />';
						}
					}
				}
			
				echo '</td></tr>';	
				$i++;			
			}

			echo '<input type="hidden" name="id" value="'.$id.'" />';
			echo '</tbody></table>';
					
			echo '<p>'.__NPCM_TITEM_COMMENT.'</p>';
			echo '<br /><input type="submit" value="'.__NPCM_FORM_SUBMIT_CHANGES.'" />';
		
			echo '<h3>'.__NPCM_ADMIN_TEMPLATE_ITEMS_CB.'</h3>';
			echo '<table><thead><tr><th>'.__NPCM_CB_NAME.'</th><th>'.__NPCM_CB_ON_MES.'</th><th>'.__NPCM_CB_OFF_MES.'</th></tr></thead><tbody>';
			$i=0;
			while ($row = mysql_fetch_object($result6)) {
				echo '<tr onmouseover=\'focusRow(this);\' onmouseout=\'blurRow(this);\'>';
				echo '<td>'.$row->iname.'</td>';
				echo '<td><input name="on_mes['.$i.']" value="'.$row->on_mes.'" maxlength="50" size="36" /></td>';
				echo '<td><input name="off_mes['.$i.']" value="'.$row->off_mes.'" maxlength="50" size="36" /></td>';
				echo '<input type="hidden" name="ipos_cb['.$i.']" value="'.$row->ipos.'" />';
				echo '<input type="hidden" name="iname_cb['.$i.']" value="'.$row->iname.'" />';
				echo '</tr>';	
				$i++;			
			}
		
			echo '</tbody></table>';
			echo '<br /><input type="submit" value="'.__NPCM_FORM_SUBMIT_CHANGES.'" />';
		
			echo '<h3>'.__NPCM_ADMIN_GEN_TEMPL_ITEM_OPTIONS.'</h3>';
			echo '<table><thead><tr></tr></thead><tbody>';
			echo '<fieldset>';
			echo '<legend></legend>';
		
			echo '<p><label for="fromaddr_item">'.__NPCM_SELECTED_FROMNAME.': </label>';
			echo '<select name="fromname_item" id="fromname_itemf">';
			echo '<option value=""';
			$result3 = sel_contactmail_templ_item($id);
			while($row=mysql_fetch_object($result3)) {
				echo '<option value="'.$row->ipos.'"';
				if (intval($NPCM_CONF['fromname_item']) == $row->ipos) echo ' selected';
				echo '>'.$row->iname;
			}
			echo '</select></p>';
		
			echo '<p><label for="fromaddr_item">'.__NPCM_SELECTED_FROMADDR.': </label>';
			echo '<select name="fromaddr_item" id="fromaddr_itemf">';
			echo '<option value=""';
			$result3 = sel_contactmail_templ_item($id);
			while($row=mysql_fetch_object($result3)) {
				echo '<option value="'.$row->ipos.'"';
				if (intval($NPCM_CONF['fromaddr_item']) == $row->ipos) echo ' selected';
				echo '>'.$row->iname;
			}
			echo '</select></p>';
		
			echo '<p><label for="fromsubject_item">'.__NPCM_SELECTED_SUBJECT.': </label>';
			echo '<select name="fromsubject_item" id="fromsubject_itemf">';
			echo '<option value=""';
			$result3 = sel_contactmail_templ_item($id);
			while($row=mysql_fetch_object($result3)) {
				echo '<option value="'.$row->ipos.'"';
				if (intval($NPCM_CONF['fromsubject_item']) == $row->ipos) echo ' selected';
				echo '>'.$row->iname;
			}
			echo '</select></p>';

			echo '<p><label for="fromcopy_item">'.__NPCM_SELECTED_COPY.': </label>';
			echo '<select name="fromcopy_item" id="fromcopy_itemf">';
			echo '<option value=""';
			$result3 = sel_contactmail_templ_item_cb($id);
			while($row=mysql_fetch_object($result3)) {
				echo '<option value="'.$row->ipos.'"';
				if (intval($NPCM_CONF['fromcopy_item']) == $row->ipos) echo ' selected';
				echo '>'.$row->iname;
			}
			echo '</select></p>';
					
			echo '</fieldset>';
							
			echo '</tbody></table>';
			echo '<br /><input type="submit" value="'.__NPCM_FORM_SUBMIT_CHANGES.'" />';
			echo '</div></form>';
		
		}
	}
}

?>
