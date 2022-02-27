<?php

class sendMail {
	var $template;
	
/****************************************************************
    settemplate()
****************************************************************/
	function settemplate($template) {
		$this->template = & $template;
	}
	
	//the general idea behind the display was to have a simple list that could be ordered by clicking on the headers -- flexible and simple
/****************************************************************
    display()
****************************************************************/
	function display() {	
		global $member;
		global $NPCM_CONF, $CONF;
		
		if(!$NPCM_CONF['template']) $NPCM_CONF['template'] = 1;
		
		$this->template = & new NPCM_TEMPLATE($NPCM_CONF['template']);
		//$this->template->readall();
		$template_header = "<style type='text/css'>@import '".$CONF['IndexURL']."nucleus/plugins/contactmail/".get_css()."';</style>";
		$template_header .= $this->template->section['SENDMAIL_HEADER'];
		$template_body = $this->template->section['SENDMAIL_BODY'];
		$template_footer = $this->template->section['SENDMAIL_FOOTER'];
		
		$actionuri = NP_ContactMail::MakeLink("createMail");
		$template_header = str_replace("<%actionuri%>", $actionuri, $template_header);
		
		$sendresult = postVar('sendresult');
		if($sendresult) {
			$template_body = str_replace("<%sendresult%>", __NPCM_SEND_MESS_OK, $template_body);		
		}		
		else{
			$template_body = str_replace("<%sendresult%>", __NPCM_SEND_MESS_NG, $template_body);		
		}
		
   		$from = array('<%btn_returntop%>');
   		$to = array(__NPCM_BTN_RETURNTOP);
   		for ($i=0; $i<sizeof($from); $i++) {
			$template_footer=str_replace($from[$i],$to[$i],$template_footer);
		}

		$actions = new SENDMAIL_ACTIONS();
		$parser = new PARSER($actions->getdefinedActions(),$actions);
		$actions->setparser($parser);
		
		//header
		$parser->parse($template_header);
		
		//body
		$parser->parse($template_body);
		
		//footer
		$parser->parse($template_footer);
	} //end of display function

}

class SENDMAIL_ACTIONS extends BaseActions {
	var $CurrentRow; //query object
	var $parser;
	
/****************************************************************
    SENDMAIL_ACTIONS()
****************************************************************/
	function SENDMAIL_ACTIONS() {
		$this->BaseActions();
		
	}

/****************************************************************
    getdefinedActions()
****************************************************************/
	function getdefinedActions() {
		return array(
			'breadcrumb',
			'if',
			'else',
			'endif' );
			
	}
/****************************************************************
    setParser()
****************************************************************/
	function setParser(&$parser) {$this->parser =& $parser; }
/****************************************************************
    setCurrentRow()
****************************************************************/
	function setCurrentRow(&$currentrow) { $this->CurrentRow =& $currentrow; }
	
}
