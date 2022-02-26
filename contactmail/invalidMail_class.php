<?php

class invalidMail {
	var $template;
	
/****************************************************************
    invalidMail()
****************************************************************/
	function invalidMail() {}
	
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
		global ${'data_array'};
		global ${'on_mes_array'};
		global ${'off_mes_array'};
		global ${'cb_mes_array'};
		global ${'substitute_array'};
		
		if(!$NPCM_CONF['template']) $NPCM_CONF['template'] = 1;
		
		$this->template = & new NPCM_TEMPLATE($NPCM_CONF['template']);
		make_associative_array_sub1(&$sub_array, $data_array);

		$template_header = "<style type='text/css'>@import '".$CONF['IndexURL']."nucleus/plugins/contactmail/".get_css()."';</style>";
		$template_header .= $this->template->section['INVALIDMAIL_HEADER'];
		$template_body = $this->template->section['INVALIDMAIL_BODY'];
		$template_footer = $this->template->section['INVALIDMAIL_FOOTER'];
		$actionuri = NP_ContactMail::MakeLink("invalidMail");

		$template_header = str_replace("<%actionuri%>", $actionuri, $template_header);
		
		$i=0;
		foreach($sub_array as $key => $val){
			$template_body .= '<input type="hidden" name="from_data['.$i++.']" value="'.$val.'" />';
		}

		foreach($sub_array as $key => $val){
			if($val=="on"){
				if($cb_mes_array[$key]){
				$ws='<'.$cb_mes_array[$key].'>';
              		$template_body = str_replace($ws,nl2br($on_mes_array[$key]),$template_body);				
				}
			}
			else{
				if($cb_mes_array[$key]){
				$ws='<'.$cb_mes_array[$key].'>';
              		$template_body = str_replace($ws,nl2br($off_mes_array[$key]),$template_body);				
				}
			}
		}
		
		$i=0;
 		foreach($sub_array as $key => $val){
			$ws='<%'.$substitute_array[$i++].'%>';
              		$template_body = str_replace($ws,$val,$template_body);
		}
		
 		$errstr = nl2br(postVar('errstr'));
		$template_body .= "<div class='npcm_err'><%errstr%></div>";
		$template_body = str_replace("<%errstr%>", $errstr, $template_body);

  		$from = array('<%btn_back%>');
   		$to = array(__NPCM_BTN_BACK);
   		for ($i=0; $i<sizeof($from); $i++) {
			$template_footer=str_replace($from[$i],$to[$i],$template_footer);
		}
		
		$actions = new INVALIDMAIL_ACTIONS();
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

class INVALIDMAIL_ACTIONS extends BaseActions {
	var $CurrentRow; //query object
	var $parser;
	
/****************************************************************
    INVALIDMAIL_ACTIONS()
****************************************************************/
	function INVALIDMAIL_ACTIONS() {
		$this->BaseActions();
		
	}

/****************************************************************
    getdefinedActions()
****************************************************************/
	function getdefinedActions() {
		return array(
			'confirmMail',
			'createMail',
			'sendMail',
			'invalidMail'
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
    parse_invalidMail()
****************************************************************/
	function parse_invalidMail($extra2 = 0) {
		$type = requestvar('type');
		echo NP_ContactMail::MakeLink($type,$extraparams);
	}
}
?>
