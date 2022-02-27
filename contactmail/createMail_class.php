<?php

class createMail {
	var $template;
	
/****************************************************************
    createMail()
****************************************************************/
	function createMail() {
		}
	
/****************************************************************
    settemplate()
****************************************************************/
	function settemplate($template) {
		$this->template = & $template;
	}
	
/****************************************************************
    display()
****************************************************************/
	//the general idea behind the display was to have a simple list that could be ordered by clicking on the headers -- flexible and simple
	function display() {	
		global $member;
		global $NPCM_CONF, $CONF;
		global ${'ipos_array'};
		global ${'data_array'};
		global ${'substitute_array'};

		if(!$NPCM_CONF['template']) $NPCM_CONF['template'] = 1;
		
		$this->template = & new NPCM_TEMPLATE($NPCM_CONF['template']);
		//$this->template->readall();
		$errstr = nl2br(postVar('errstr'));

		if(!strlen($errstr)){
			striptags($from_data, 'from_data');

			$first_flg = false;
			if(count($from_data) == 0) $first_flg = true;
				make_associative_array_sub($sub_array, $data_array, $from_data);
		} else {
			make_associative_array_sub1($sub_array, $data_array);
		}
		
		$template_header = "<style type='text/css'>@import '".$CONF['IndexURL']."nucleus/plugins/contactmail/".get_css()."';</style>";
		$template_header .= $this->template->section['CREATEMAIL_HEADER'];
		$template_body = $this->template->section['CREATEMAIL_BODY'];
		$template_footer = $this->template->section['CREATEMAIL_FOOTER'];
		$actionuri = NP_ContactMail::MakeLink("createMail");

		$template_header = str_replace("<%actionuri%>", $actionuri, $template_header);

		$user = cookieVar($CONF['CookiePrefix'] .'user');
	        
		if ($member->isLoggedIn()) {
           	 	$uname = $member->getDisplayName();
           	 	$memberid = $member->getID();
			$uaddr = set_addr($memberid);
	   		$captchaImage = "";
			if($first_flg){		
				$uname_key = conv_option_to_value($ipos_array, $NPCM_CONF['fromname_item']);
				$uaddr_key = conv_option_to_value($ipos_array, $NPCM_CONF['fromaddr_item']);

				set_associative_array_value($sub_array, $uname, $uname_key);
				set_associative_array_value($sub_array, $uaddr, $uaddr_key);
			}
    		}
		else {
			if (captchaEnabled()) {
				global $manager;
				//add captcha hidden field with key
				$captchaPlugin =& $manager->getPlugin('NP_Captcha');
				$captchaKey = $captchaPlugin->generateKey();
	   			$captchaImage = $captchaPlugin->generateImgHtml($captchaKey, -1, -1);
				   
				$template_body .= "<div class=\"captcha_area\"><table><tbody>";
				$template_body .= "<tr><td><%captcha%></td></tr><br />";
				$template_body .= "<tr><td><input type='text' name='captcha' /></td></tr></tbody></table></div>";
				$template_body .= "<input type='hidden' name='captchakey' value='$captchaKey' />";
			}
   		} 
   
		$i=0;
		foreach($sub_array as $key => $val){
			$ww='<%'.$substitute_array[$i++].'%>';
   	   		$template_body=str_replace($ww, $val, $template_body);
		}
	
   		$from = array('<%captcha%>');
   		$to = array($captchaImage);
   		for ($i=0; $i<sizeof($from); $i++) {
			$template_body=str_replace($from[$i],$to[$i],$template_body);
		}

		$errstr = nl2br(postVar('errstr'));
		if ($NPCM_CONF['invalidplus'] ==  "no" && strlen($errstr) > 0) {
			$template_body .= "<div class='npcm_err'><%errstr%></div>";
			$template_body = str_replace("<%errstr%>", $errstr, $template_body);
		}
		
	   	$from = array('<%btn_confirm%>','<%btn_erase%>');
   		$to = array(__NPCM_BTN_CONFIRM,__NPCM_BTN_ERASE);
   		for ($i=0; $i<sizeof($from); $i++) {
		$template_footer=str_replace($from[$i],$to[$i],$template_footer);
		}
		
		$actions = new CREATEMAIL_ACTIONS();
		$parser = new PARSER($actions->getdefinedActions(),$actions);
		$actions->setparser($parser);
		//header
		$parser->parse($template_header);
		
		//body
		$parser->parse($template_body);
		
		//footer
		$parser->parse($template_footer);
	} //end of display function
	
} //end of list class

class CREATEMAIL_ACTIONS extends BaseActions {
	var $CurrentRow; //query object
	var $parser;
		
/****************************************************************
    CREATEMAIL_ACTIONS()
****************************************************************/
	function CREATEMAIL_ACTIONS() {
		$this->BaseActions();
	}

/****************************************************************
    getdefinedActions()
****************************************************************/
	function getdefinedActions() {
		return array(
			'createmail',
			'endif'
 );			
	}
	
/****************************************************************
    setParser()
****************************************************************/
	function setParser(&$parser) {$this->parser =& $parser; }
	
/****************************************************************
    setCurrentRow()
****************************************************************/
	function setCurrentRow(&$currentrow) { $this->CurrentRow =& $currentrow; }
	
/****************************************************************
    parse_createmail()
****************************************************************/
	function parse_createmail($extra2 = 0) {
//	printf("*****parse_createmail****");
		$type = requestvar('type');
		echo NP_ContactMail::MakeLink($type,$extraparams);
	}
}
?>
