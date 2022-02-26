<?php
//    require("define.php");
 
class confirmMail {
	var $template;
	
/****************************************************************
    confirmMail()
****************************************************************/
	function confirmMail() {}
	
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
		global $gmember;
		global ${'data_array'};
		global ${'on_mes_array'};
		global ${'off_mes_array'};
		global ${'cb_mes_array'};
		global ${'substitute_array'};

		global $NPCM_CONF, $CONF;
		
		if(!$NPCM_CONF['template']) $NPCM_CONF['template'] = 1;
		
		$this->template = & new NPCM_TEMPLATE($NPCM_CONF['template']);
		make_associative_array_sub1(&$sub_array, $data_array);
          		
		$template_header = "<style type='text/css'>@import '".$CONF['IndexURL']."nucleus/plugins/contactmail/".get_css()."';</style>";
		$template_header .= $this->template->section['CONFIRMMAIL_HEADER'];
		$template_body = $this->template->section['CONFIRMMAIL_BODY'];
		$template_footer = $this->template->section['CONFIRMMAIL_FOOTER'];
		$actionuri = NP_ContactMail::MakeLink("confirmMail");
		$actionuri = NP_ContactMail::MakeLink("confirmMail");
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
			$ww='<%'.$substitute_array[$i++].'%>';
   	   		$template_body=str_replace($ww, nl2br($val), $template_body);
		}
		
   		$from = array('<%btn_back%>','<%btn_send%>');
   		$to = array(__NPCM_BTN_BACK,__NPCM_BTN_SEND);
   		for ($i=0; $i<sizeof($from); $i++) {
			$template_footer=str_replace($from[$i],$to[$i],$template_footer);
		}

		$actions = new CONFIRMMAIL_ACTIONS();

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

class CONFIRMMAIL_ACTIONS extends BaseActions {
	var $CurrentRow; //query object
	var $parser;
	
	
/****************************************************************
    CONFIRMMAIL_ACTIONS()
****************************************************************/
	function CONFIRMMAIL_ACTIONS() {
		$this->BaseActions();
	}

/****************************************************************
    getdefinedActions()
****************************************************************/
	function getdefinedActions() {
		return array(
			'confirmmail',
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
    parse_confirmmail()
****************************************************************/
	function parse_confirmmail($extra2 = 0) {
//	printf("*****parse_confirmmail****");
		$type = requestvar('type');
		echo NP_ContactMail::MakeLink($type,$extraparams);
	}
}
?>
