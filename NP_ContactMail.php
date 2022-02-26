<?php
/*
NP_ContactMail
ContactMail Plugin for nucleus cms http://nucleuscms.org
*/
//var_dump($_POST);
global $DIR_NUCLEUS;
include_once($DIR_NUCLEUS.'/plugins/contactmail/config.php');

class NP_ContactMail extends NucleusPlugin {

	function getName() {return 'Nucleus ContactMail';}
	function getAuthor()  {	return 'ondee';	}
	function getURL() 	{ return 'http://aquapianis.org/miwiki/doku.php?id=np_contactmail'; 	}
	function getVersion() { return '0.92'; }
	function getMinNucleusVersion() { return '322'; }
	function getDescription() { return 'ContactMail for Nucleus CMS'; 	}
	function supportsFeature($what) { switch($what) {
		case 'SqlTablePrefix': return 1; break;
		default: return 0; break;
		}
	}
/****************************************************************
    getTableList()
****************************************************************/
	function getTableList() {
		return array(sql_table('plug_contactmail_template'),
		sql_table('plug_contactmail_template_desc'), 
		sql_table('plug_contactmail_config'), 
		sql_table('plug_contactmail_templ_chk') , 
		sql_table('plug_contactmail_templ_item') ,
		sql_table('plug_contactmail_templ_config') );
	}

/****************************************************************
    getEventList()
****************************************************************/
	function getEventList() {
		return array('QuickMenu','PreItem');
	}
	
/****************************************************************
    hasAdminArea()
****************************************************************/
	function hasAdminArea() {
		return 1;
	}
	
/****************************************************************
    event_QuickMenu()
****************************************************************/
	function event_QuickMenu(&$data) {
		global $member;

		if (!($member->isLoggedIn() )) return;
		array_push(
			$data['options'], 
			array(
				'title' => 'ContactMail',
				'url' => $this->getAdminURL(),
				'tooltip' => 'NP ContactMail admin'
			)
		);
	}
	
/****************************************************************
    event_PreItem()
****************************************************************/
	function event_PreItem(&$data) {
		
		$actions = new NPCM_EXT_ITEM_ACTIONS();
		$parser = new NPCM_PREPARSER($actions->getdefinedActions(),$actions);
		$actions->setparser($parser);
		ob_start();
		$parser->parse($data['index']->body);
		$data['index']->body = ob_get_contents();
		ob_end_clean();
		
	}
	
/****************************************************************
    install()
****************************************************************/
	function install() {
		global $NPCM_CONF,$DIR_NUCLEUS;
		
		$this->createOption('deletetables',__NPCM_OPT_DONT_DELETE_TABLES,'yesno','no'); 
		
		//create tables
		
		$query = 'CREATE TABLE IF NOT EXISTS '.sql_table('plug_contactmail_template').' ( '.
				'tdesc int unsigned, '.
				'name varchar(20), '.
				'content text ) ';
		sql_query($query);
		
		$query = 'CREATE TABLE IF NOT EXISTS '.sql_table('plug_contactmail_template_desc').' ( '.
				'tdid int unsigned not null auto_increment PRIMARY KEY, '.
				'tdname varchar(20), '.
				'tddesc varchar(200) )';
		sql_query($query);
		
		$query = 'CREATE TABLE IF NOT EXISTS '.sql_table('plug_contactmail_config').' ( '.
				'oname varchar(20), ovalue varchar(60), '.
				'PRIMARY KEY(oname))';
		sql_query($query);
				
		$query = 'CREATE TABLE IF NOT EXISTS '.sql_table('plug_contactmail_templ_item').' ( '.
				'tiid int unsigned not null auto_increment PRIMARY KEY, '.
				'tempid int unsigned,'.
				'tempsect varchar(50),'.
				'itype varchar(50), '.
				'iname varchar(50), '.
				'idesc varchar(50), '.
				'ipos int,'.
				'on_mes varchar(60), '.
				'off_mes varchar(60)) ';
		sql_query($query);
		
		$query = 'CREATE TABLE IF NOT EXISTS '.sql_table('plug_contactmail_templ_chk').' ( '.
				'tempid int unsigned , '.
				'ipos int unsigned NOT NULL , '.
				'itemno int unsigned NOT NULL , '.
				'chkno int unsigned NOT NULL , '.
				'flg varchar(10), '.
				'PRIMARY KEY(ipos, tempid, itemno, chkno))';
		sql_query($query);		
										
		$query = 'CREATE TABLE IF NOT EXISTS '.sql_table('plug_contactmail_templ_config').' ( '.
				'oname varchar(20), ovalue varchar(60), oid int unsigned, '.
				'PRIMARY KEY(oname, oid))';
		sql_query($query);

		//set default options
		$NPCM_CONF = getNPCMconfig();

		//set default templates
		switch(getLanguageName())
		{
			case 'japanese-utf8':
				include($DIR_NUCLEUS.'/plugins/contactmail/templates/default_long_utf8.inc');
				include($DIR_NUCLEUS.'/plugins/contactmail/templates/default_short_utf8.inc');
				include($DIR_NUCLEUS.'/plugins/contactmail/templates/default_long.inc');
				include($DIR_NUCLEUS.'/plugins/contactmail/templates/default_short.inc');
				break;
			case 'japanese-euc':
				include($DIR_NUCLEUS.'/plugins/contactmail/templates/default_long_euc.inc');
				include($DIR_NUCLEUS.'/plugins/contactmail/templates/default_short_euc.inc');
				include($DIR_NUCLEUS.'/plugins/contactmail/templates/default_long.inc');
				include($DIR_NUCLEUS.'/plugins/contactmail/templates/default_short.inc');
				break;
			default:
				include($DIR_NUCLEUS.'/plugins/contactmail/templates/default_long.inc');
				include($DIR_NUCLEUS.'/plugins/contactmail/templates/default_short.inc');
				break;
		}

		$chk = checkContactMailconfig();
		if($chk['configured'] == false) setNPCMoption('configured',false); else setNPCMoption('configured',true);

	}
	
/****************************************************************
    unInstall()
****************************************************************/
	function unInstall() {
		if ($this->getOption('deletetables') == 'yes') { 
			
			sql_query('DROP TABLE '.sql_table('plug_contactmail_template'));
			sql_query('DROP TABLE '.sql_table('plug_contactmail_template_desc'));
			sql_query('DROP TABLE '.sql_table('plug_contactmail_templ_item'));
			sql_query('DROP TABLE '.sql_table('plug_contactmail_templ_chk'));
			sql_query('DROP TABLE '.sql_table('plug_contactmail_config'));
			sql_query('DROP TABLE '.sql_table('plug_contactmail_templ_config'));			
		}
//		this->deleteOption('deletetables');

	}
/****************************************************************
    doAction()
****************************************************************/
	function doAction($type) {
		global $member, $CONF, $NPCM_CONF;
		global $skinid,$manager,$blog,$blogid,$extraparams;

		switch($type) {
			//display -- these are done in doSkinVar
			case 'createMail': 
				$errstr = $this->action_checkInputData();
				if(strlen($errstr) == 0){
					$this->currentPage = "confirmMail";
				}
				else{
					$_POST['errstr'] = hschars_encode($errstr);
					if ($NPCM_CONF['invalidplus'] ==  "no") {
						$this->currentPage = "createMail";
					} else {
						$this->currentPage = "invalidMail";
					}
				}
				break;
			case 'confirmMail':  
				$confirmbtn = postVar('confirmbtn');
				if($confirmbtn==__NPCM_BTN_SEND){
					$sendresult=$this->action_sendMail();
					$_POST['sendresult'] = hschars_encode($sendresult);
					$this->currentPage = "sendMail";
				} else {
					$this->currentPage = "createMail";
				}
				break;
			case 'sendMail': 
				$this->currentPage = "createMail";
				break;
			case 'invalidMail': 
				$this->currentPage = "createMail";
				break;
			default: 
				break;
		}
		
		$blogid = $NPCM_CONF['bname'];		
		if (!$blogid)
			$blogid = $CONF['DefaultBlog'];
		$b =& $manager->getBlog($blogid);
		$blog = $b;
		$query = 'SELECT b.sdname as currentskin FROM  '. sql_table('blog') .' a, '. sql_table('skin_desc') .' b WHERE b.sdnumber=a.bdefskin and a.bnumber='.$blogid;

		$result = mysql_query($query);
		while($row=mysql_fetch_object($result)) {
			$currentskin=$row->currentskin;
		}
		selectSkin($currentskin);
		
		$skin =& new SKIN($skinid);
		$skin->parse('index');
	}
	
/****************************************************************
    doSkinVar()
****************************************************************/
	function doSkinVar() {
		global $NPCM_CONF, $member, $manager, $CONF ;
		
		$params = func_get_args();
		$numargs = func_num_args();
		$skinType = $params[0];
				
		if(!$NPCM_CONF['configured']) {
			echo '<p>'.__NPCM_ERR_CONTACTMAIL_NOT_CONFIG.'</p><br />';
		}
		else
		{
			//things to display
			switch($this->currentPage) {
				case 'createMail': 
					$l = new createMail();
					$t = new NPCM_TEMPLATE($NPCM_CONF['template']);
					$l->settemplate($t);
					$l->display(); 
					break;
				case 'confirmMail':
					$l = new confirmMail();
					$t = new NPCM_TEMPLATE($NPCM_CONF['template']);
					$l->settemplate($t);
					$l->display(); 
					break;
				case 'sendMail': 
					$l = new sendMail();
					$t = new NPCM_TEMPLATE($NPCM_CONF['template']);
					$l->settemplate($t);
					$l->display(); 
					break;
				case 'invalidMail':
					$l = new invalidMail();
					$t = new NPCM_TEMPLATE($NPCM_CONF['template']);
					$l->settemplate($t);
					$l->display(); 
					break;
				default: 
					$l = new createMail();
					$t = new NPCM_TEMPLATE($NPCM_CONF['template']);
					$l->settemplate($t);
					$l->display(); 
					break;
			}
		}
	}
	
/****************************************************************
    MakeLink()
****************************************************************/
	function MakeLink($type, $extraparams = array()) {
		global $CONF;

//2006-10-30 added start
		if(customurlEnabled()==true){
			$base = 'action.php?action=plugin&amp;name=ContactMail&amp;type=';
			$sep1 = '&';
			$sep2 = '=';		
			return $base.$type.$extra;
		}
//2006-10-30 added end
		
		else if($CONF['URLMode'] == 'pathinfo') { 
			$base = 'action.php/plugin/name/ContactMail/type/';
			$sep1 = '/';
			$sep2 = '/';
		}
		else {
			$base = 'action.php?action=plugin&amp;name=ContactMail&amp;type=';
			$sep1 = '&';
			$sep2 = '=';		
		}
		//if extraparams is assoc array
		if(is_array($extraparams) && array_keys($extraparams)!==range(0,sizeof($extraparams)-1)) {
			foreach($extraparams as $key => $value) 
				$extra = $extra . $sep1 . $key . $sep2 . $value;
			}

		return $base.$type.$extra;
	}	

/****************************************************************
    action_checkInputData()
****************************************************************/
	function action_checkInputData() {
		global $member, $CONF, $NPCM_CONF;
		global $manager;

		global ${'data_array'};
		global ${'must_chk'};
		global ${'alphanumeric_chk'};
		global ${'numeric_chk'};
		global ${'multibyte_chk'};
		global ${'mailaddr_chk'};

		make_associative_array_sub1(&$sub_array, $data_array);
		
		$errstr ="";
		ob_start();
				
		if (!$member->isLoggedIn()) {
			if (captchaEnabled()) { //is captcha test passed?
				$captchaPlugin =& $manager->getPlugin('NP_Captcha');
				$captchaSolution = strip_tags(undoMagic(requestVar('captcha')));
				$captchaKey 	 = strip_tags(undoMagic(requestVar('captchakey')));
				if (!$captchaPlugin->check($captchaKey,$captchaSolution)) {
					echo $captchaPlugin->getOption('FailedMsg')."\n\n";
					$errstr = ob_get_contents();
					ob_end_clean();

					$_POST['errstr'] = hschars_encode($errstr); 
					$this->currentPage = "invalidMail";
					return $errstr ;
				}
			}
        	}

		foreach($sub_array as $key => $val){

			if($must_chk[$key]){
				check_must($must_chk[$key], $val);
			}
			if($mailaddr_chk[$key]){
				check_mailaddr($mailaddr_chk[$key], $val);
			}
			if($alphanumeric_chk[$key]){
				check_alphanumeric($alphanumeric_chk[$key], $val);
			}
			if($numeric_chk[$key]){
				check_numeric($numeric_chk[$key], $val);
			}
			if($multibyte_chk[$key]){
				check_multibyte($multibyte_chk[$key], $val);
			}
					
			// HAN TO ZEN (kana)
			if (extension_loaded('mbstring')) $val = mb_convert_kana($val, "KV",_CHARSET);
			else HANtoZEN($val ,0);
			$temp .= $key.' : '.$val."\n";
		}
		$errstr = ob_get_contents();
		ob_end_clean();
		
		return $errstr ;
	}

/****************************************************************
    action_sendMail()
****************************************************************/
	function action_sendMail(){
		global $NPCM_CONF;
		global ${'data_array'};
		global ${'ipos_array'};
		global ${'on_mes_array'};
		global ${'off_mes_array'};
		global ${'cb_mes_array'};

		$success = $success1 = true;
		$NPCM_CONF = getNPCMConfig();		

		striptags(&$from_data, 'from_data');
		make_associative_array_sub(&$sub_array, $data_array, $from_data);
				
		$toaddr = set_addr($NPCM_CONF['toaddr']);
		$fromaddr = set_sendmail_option($ipos_array, $sub_array, $NPCM_CONF['fromaddr_item']);
		$from_subject = set_sendmail_option($ipos_array, $sub_array, $NPCM_CONF['fromsubject_item']);
		$from_copy = set_sendmail_option($ipos_array, $sub_array, $NPCM_CONF['fromcopy_item']);
		set_cb_mes(&$sub_array, $cb_mes_array, $on_mes_array, $off_mes_array);

		$body="";
		foreach($sub_array as $key => $val){
			$body.= '['.$key.']'.$val."\n";
		}

		$title2 = 'ContactMail:'.$from_subject;
		$char = _CHARSET;
		
		if (extension_loaded('mbstring')) { 
			mb_language("Japanese");
			mb_internal_encoding($char);
			$success = @mb_send_mail($toaddr, $title2, $body, "From: ". $fromaddr );
			if($from_copy=="on")
				$success1 = @mb_send_mail($fromaddr, $title2, $body, "From: ". $fromaddr );
			}
		else{ 
			$title2 = "=?iso-2022-jp?B?" . base64_encode(JcodeConvert($title, 0, 3)) . "?="; 
			$success = @mail($toaddr, $title2, JcodeConvert($body, 0, 3), "From: ". $fromaddr); 
			if($from_copy=="on")
			$success1 = @mail($fromaddr, $title2, JcodeConvert($body, 0, 3), "From: ". $fromaddr); 
		} 
		
		if(!$success || !$success1){
			$ret = false;
		}else{
			$ret = true;
		}
		return $ret;
	}
}

class NPCM_PREPARSER extends PARSER {
	
/****************************************************************
    doAction()
****************************************************************/
	function doAction($action) {
		 if (!$action) return;
		 $action_raw = '<%'.$action.'%>';
		 
	printf("****NPCM_PREPARSER doAction****");
		// split into action name + arguments
		if (strstr($action,'(')) {
			$paramStartPos = strpos($action, '(');
			$params = substr($action, $paramStartPos + 1, strlen($action) - $paramStartPos - 2);
			$action = substr($action, 0, $paramStartPos);
			$params = explode ($this->pdelim, $params);
			$params = array_map('trim',$params);
		} else {
			$params = array();
		}

		$actionlc = strtolower($action);

		if (in_array($actionlc, $this->actions) || $this->norestrictions ) {
			call_user_func_array(array(&$this->handler,'parse_' . $actionlc), $params);
		} else {
			echo $action_raw;
		}

	 }
}	 

class NPCM_EXT_ITEM_ACTIONS extends BaseActions {
	var $parser;
	
/****************************************************************
    NPCM_EXT_ACTIONS()
****************************************************************/
	function NPCM_EXT_ACTIONS() {
		$this->BaseActions();
	}
/****************************************************************
    getdefinedActions()
****************************************************************/
	function getdefinedActions() {
		return array( 'ContactMail' );
	}
/****************************************************************
    setParser()
****************************************************************/
	function setParser(&$parser) {$this->parser =& $parser; }
}
?>
