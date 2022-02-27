<?php
//NP_ContactMail config

global $DIR_NUCLEUS,$DIR_LIBS;

global $NP_CONTACTMAIL_DIR, $NP_BASE_DIR;
$NP_CONTACTMAIL_DIR = $DIR_NUCLEUS . 'plugins/contactmail/';
$NP_BASE_DIR = substr($DIR_NUCLEUS,0,strlen($DIR_NUCLEUS) - 8);
global ${'data_array'};
global ${'ipos_array'};
global ${'ichk_array'};
global ${'must_chk'};
global ${'alphanumeric_chk'};
global ${'numeric_chk'};
global ${'multibyte_chk'};
global ${'mailaddr_chk'};
global ${'on_mes_array'};
global ${'off_mes_array'};
global ${'cb_mes_array'};
global ${'substitute'};
global ${'substitute_cb'};
global ${'substitute_array'};

include_once($NP_CONTACTMAIL_DIR.'functions.php');
include_once($NP_CONTACTMAIL_DIR.'createMail_class.php');
include_once($NP_CONTACTMAIL_DIR.'confirmMail_class.php');
include_once($NP_CONTACTMAIL_DIR.'sendMail_class.php');
include_once($NP_CONTACTMAIL_DIR.'invalidMail_class.php');
include_once($NP_CONTACTMAIL_DIR.'admin.php');
include_once($NP_CONTACTMAIL_DIR.'template.php');

switch(getLanguageName())
{
	case 'japanese-utf8':
		include_once($NP_CONTACTMAIL_DIR.'language/japanese_utf8.php'); 
		break;
	case 'japanese-euc':
		include_once($NP_CONTACTMAIL_DIR.'language/japanese_euc.php'); 
		break;
	default:
		include_once($NP_CONTACTMAIL_DIR.'language/english.php'); 
		break;
}

global $NPCM_CONF, $NPCM_TEMPL_CONF, $member;
$NPCM_CONF = getNPCMConfig();

	if($NPCM_CONF['configured']) {
		$id = $NPCM_CONF['template'];

		$result3 = sel_contactmail_templ_item($id);
		$result4 = sel_contactmail_templ_item_sub($id);
		$result5 = sel_contactmail_templ_chk($id);
		$result6 = sel_contactmail_templ_item_cb($id);
		
		$substitute_array = array();
		$substitute = array();
		$substitute_cb = array();
		$idesc_array = array();
		$ichk_array = array();
		$must_chk = array();
		$alphanumeric_chk = array();
		$numeric_chk = array();
		$multibyte_chk = array();
		$mailaddr_chk = array();
		$ipos_array = array();
		$data_array = array();
		$on_mes_array = array();
		$off_mes_array = array();
		$cb_mes_array = array();
		
		while ($row = mysql_fetch_object($result4)) {
				$ws=substr($row->iname,2,strlen($row->iname)-4);
			array_push($substitute_array, $ws);
		}
		while ($row = mysql_fetch_object($result4)) {
				$ws=substr($row->iname,1,strlen($row->iname)-2);
			array_push($substitute, $ws);
		}
		
		$i=0;
		while ($row = mysql_fetch_object($result5)) {
			$ichk_array[$i] = array('chkno'=>$row->chkno,'itemno'=>$row->itemno,'flg'=>$row->flg);
			$i++;
		}
			
			while ($row = mysql_fetch_object($result6)) {
				$ws='%'.$row->iname.'%';
				make_associative_array($row->iname, $ws, $cb_mes_array);
				make_associative_array($row->iname, $row->off_mes, $off_mes_array);
				make_associative_array($row->iname, $row->on_mes, $on_mes_array);
				$i++;
		}
		
		$i=0;
		while ($row = mysql_fetch_object($result3)) {
		$ws='<'.$substitute[$i].'>';
			make_associative_array($row->iname, $row->ipos, $ipos_array);
			$data_array[$i] = array('name'=>$row->iname,'desc'=>$row->idesc,'val'=>$ws);
			$i++;
		}
		
		for($i=0; $i<count($ichk_array); $i++){
			$w_array = array();

			$w_array = array($data_array[$ichk_array[$i]['itemno']]['name']=>$data_array[$ichk_array[$i]['itemno']]['desc']);
			switch($ichk_array[$i]['chkno']) {
				case 0: 
					$must_chk = array_merge($must_chk, $w_array);
					break;
				case 1: 
					$numeric_chk = array_merge($numeric_chk, $w_array);
					break;
				case 2: 
					$alphanumeric_chk = array_merge($alphanumeric_chk, $w_array);
					break;
				case 3: 
				$multibyte_chk = array_merge($multibyte_chk, $w_array);
					break;
				case 4: 
				$mailaddr_chk = array_merge($mailaddr_chk, $w_array);
					break;
				default:
					break;
			}
		}
		
	}
