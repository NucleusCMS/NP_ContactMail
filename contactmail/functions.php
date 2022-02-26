<?php
//support functions for NP_contactmail

//this function is called in several places to generate the links	

/****************************************************************
    generateLink_contactmail()
****************************************************************/
function generateLink_contactmail($type,$vars = 'date') {
	global $manager;

	$base = 'action.php?action=plugin&amp;name=ContactMail&amp;type=';
	switch($type) {
		case 'confirmMail': $link = $base.$type;
		case 'invalidMail': $link = $base.$type;
		case 'sendMail': $link = $base.$type;
		case ' createMail': $link = $base.$type;
		default: $link = $base.$type;
			break;
	}
	return $link;
}

/****************************************************************
    allowedTemplateTags_NPCM()
****************************************************************/
function allowedTemplateTags_NPCM($template) {
	switch ($template) {
		default:
			break;
	}
	return $tags;
}
/****************************************************************
    getNPCMConfig()
****************************************************************/
function getNPCMConfig() {
	$result = mysql_query('select * from '.sql_table('plug_contactmail_config') );
	if($result) {
		while ($row = mysql_fetch_assoc($result)) {
			$NPCM_config[$row['oname']] = $row['ovalue'];
		}
	}
	
	if(isset($NPCM_config['template'])){
		$id = $NPCM_config['template'];
	
		$result = mysql_query('select * from '.sql_table('plug_contactmail_templ_config').' where oid='.$id );
		if($result) {
			while ($row = mysql_fetch_assoc($result)) {
				$NPCM_config[$row['oname']] = $row['ovalue'];
			}
		}
	}
	return $NPCM_config;
}

/****************************************************************
    setNPCMoption()
****************************************************************/
function setNPCMoption($oname, $ovalue) {
	$result = mysql_query("select * from ".sql_table('plug_contactmail_config')." where oname='$oname'" );
	if(@ mysql_num_rows($result)) {
		sql_query("update ".sql_table('plug_contactmail_config')." set ovalue='$ovalue' where oname='$oname'");
	} else {
		sql_query("insert into ".sql_table('plug_contactmail_config')." values ('$oname', '$ovalue' )");
	}
}

/****************************************************************
    getNPCMConfig_templ()
****************************************************************/
function getNPCMConfig_templ($id) {
	$result = mysql_query('select * from '.sql_table('plug_contactmail_templ_config').' where oid='.$id );
	if($result) {
		while ($row = mysql_fetch_assoc($result)) {
			$NPCM_config[$row['oname']] = $row['ovalue'];
		}
	}
	return $NPCM_templ_config;
}

/****************************************************************
    setNPCMoption_templ()
****************************************************************/
function setNPCMoption_templ($oname, $ovalue, $oid) {
	$result = mysql_query("select * from ".sql_table('plug_contactmail_templ_config')." where oname='$oname' and oid='$oid'" );
	if(@ mysql_num_rows($result)) {
		sql_query("update ".sql_table('plug_contactmail_templ_config')." set ovalue='$ovalue' where oname='$oname' and oid='$oid'");
	} else {
		sql_query("insert into ".sql_table('plug_contactmail_templ_config')." values ('$oname', '$ovalue', '$oid' )");
	}	
}
/****************************************************************
    get_tempid()
****************************************************************/
function get_tempid() {

	$NPCM_CONF = getNPCMConfig();
	if(isset($NPCM_CONF['template']))
		$id = $NPCM_CONF['template'];
	else 	$id = 1;
	
	return $id;
}
/****************************************************************
    checkcontactmailconfig()
****************************************************************/
function checkcontactmailconfig() {
	global $NP_BASE_DIR,$NPCM_CONF;
	
	$status = array();
	
		$bname = $NPCM_CONF['bname'];
		$toaddr = $NPCM_CONF['toaddr'];
	//check for presence of NPGallery skin
	if(!$bname || !$toaddr) {
		$status['message'] .= 'NPContactMail was not configured<br/>';
	}
			
	if($status['message']) $status['configured'] = false; else $status['configured'] = true;
	
	return $status;
	
}
/****************************************************************
    set_TempItem()
****************************************************************/
	function set_TempItem($str1, $token, $str2) {
	
		$tok1=NULL;
		$tok = strtok($str1, $token);

		while ($tok !== false) {
		if(strcmp ( $tok,$str2) == 0)
		{
			$tok1 = strtok($token);
			return $tok1;
		}
		$tok = strtok($token);
	}
	return NULL;
}
	
/****************************************************************
    search_input_form()
****************************************************************/
function search_input_form(&$str,&$retpos,$pin,$pin2) {
	
	$pos1= strpos($str, $pin);
	if($pos1==false) return NULL;
	$pos2 = strpos($str, $pin2, $pos1);
	$str1 = substr($str,$pos1,$pos2-$pos1+1);

	$search1 = array("=\"",$pin, "/>");
	$search2 = array("\" ");
	$search3 = array(" ","\"");
	$search4 = array("//");
	$str2 = str_replace($search1, "/", $str1);
	$str3 = str_replace($search2, "/", $str2);
	$str4 = str_replace($search3, "", $str3);
	$str5 = str_replace($search4, "/ /", $str4);

	$retpos=$pos1;
	return $str5 ;
		
}
/****************************************************************
    check_input_form()
****************************************************************/
function check_input_form() {
	global $NPCM_CONF,$contactmailaction;
	
	$contactmailconfig = checkcontactmailconfig();
		
}
	
/****************************************************************
    set_templ_item_createbody()
****************************************************************/
function set_templ_item_createbody($str,$itype,$pin1,$pin2,$id) {

	$flg=false;
	$sv_pos=0;

	while($flg==false)
	{
		$str_input = search_input_form(&$str ,&$pos, $pin1, $pin2);
		$sv_pos=$sv_pos+$pos+strlen($str_input);
		if($str_input==NULL) $flg=true;
		if($itype=="type") $str_type = set_TempItem($str_input, "/", "type");
		else $str_type = $itype;		
		$str_name = set_TempItem($str_input, "/", "name");		
		$str_value = set_TempItem($str_input, "/", "value");		
		if($str_input) {
			$query = 'insert into '.sql_table('plug_contactmail_templ_item')." (tiid, tempid, itype, iname, idesc, ipos, tempsect) values (NULL,$id,'$str_type','$str_name',NULL,$sv_pos,'CREATEMAIL_BODY')";
			sql_query($query);
		}
		$str1 = substr($str,$pos+strlen($str_input));

		$str = $str1 ;
	}
}
/****************************************************************
    set_templ_item_confirmbody()
****************************************************************/
function set_templ_item_confirmbody($str,$itype,$pin1,$pin2,$id) {

	$flg=false;
	$sv_pos=0;
	$pin01="<%";
	$pin02="%>";

	while($flg==false)
	{
		$str_input = search_input_form(&$str ,&$pos, $pin1, $pin2);
		$sv_pos=$sv_pos+$pos+strlen($str_input);
		if($str_input==NULL) $flg=true;
		$str_type = $itype;		
		$str_name1 = substr($str_input,1,strlen($str_input)-2);	
		$str_name = $pin01.$str_name1.$pin02;	
		$str_value = NULL;		
		if($str_input) {
			$query = 'insert into '.sql_table('plug_contactmail_templ_item')." (tiid, tempid, itype, iname, idesc, ipos, tempsect) values (NULL,$id,'$str_type','$str_name',NULL,$sv_pos,'CONFIRMMAIL_BODY')";
			sql_query($query);
		}
		$str1 = substr($str,$pos+strlen($str_input));

		$str = $str1 ;
	}
}
/****************************************************************
    del_contactmail_templ_item()
****************************************************************/
function del_contactmail_templ_item($id){

	$query = 'delete from '.sql_table('plug_contactmail_templ_item').' where tempid='.$id;
	sql_query($query);
}

/****************************************************************
    del_contactmail_templ_chk()
****************************************************************/
function del_contactmail_templ_chk($id){

	$query = 'delete from '.sql_table('plug_contactmail_templ_chk').' where tempid='.$id;
	sql_query($query);
}

/****************************************************************
    ins_contactmail_template()
****************************************************************/
function ins_contactmail_template($t){

	$vars = array('CREATEMAIL_HEADER','CREATEMAIL_BODY','CREATEMAIL_FOOTER','INVALIDMAIL_HEADER','INVALIDMAIL_BODY','INVALIDMAIL_FOOTER','CONFIRMMAIL_HEADER','CONFIRMMAIL_BODY','CONFIRMMAIL_FOOTER','SENDMAIL_HEADER','SENDMAIL_BODY','SENDMAIL_FOOTER','FORM_LOGGED','FORM_NOTLOGGED');

	foreach($vars as $j) {
		if(isset($_POST[$j])) {
			$t->update($j,$_POST[$j]);
		}
	}
}
			
/****************************************************************
    ins_contactmail_template1()
****************************************************************/
function ins_contactmail_template1($t){

	$vars = array('CREATEMAIL_HEADER','CREATEMAIL_BODY','CREATEMAIL_FOOTER','INVALIDMAIL_HEADER','INVALIDMAIL_BODY','INVALIDMAIL_FOOTER','CONFIRMMAIL_HEADER','CONFIRMMAIL_BODY','CONFIRMMAIL_FOOTER','SENDMAIL_HEADER','SENDMAIL_BODY','SENDMAIL_FOOTER','FORM_LOGGED','FORM_NOTLOGGED');

	foreach($vars as $j) {
			$t->update($j,$_POST[$j]);
	}
}
			
/****************************************************************
    ins_contactmail_templ_item()
****************************************************************/
function ins_contactmail_templ_item($str1, $str2, $id){

	set_templ_item_createbody($str1,"type","<input ", ">",$id) ;
	set_templ_item_createbody($str1,"textarea","<textarea ", ">",$id) ;
	set_templ_item_createbody($str1,"select","<select ", ">",$id) ;
	set_templ_item_confirmbody($str2,"substitute","<%", "%>",$id) ;
}

/****************************************************************
    ins_contactmail_templ_chk()
****************************************************************/
function ins_contactmail_templ_chk($p_ipos_array, $p_id, $p_ichk_array,$i){

	for ($j=0; $j<5; $j++){
		if($p_ichk_array[$j][$i]){
			$query = 'insert into '.sql_table('plug_contactmail_templ_chk').' (ipos, tempid, itemno, chkno, flg) values ('.$p_ipos_array[$i].', '.$p_id.', '.$i.', '.$j.', "'.$p_ichk_array[$j][$i].'")';
			sql_query($query);
		}
	}
}

/****************************************************************
    sel_contactmail_templ_item()
****************************************************************/
function sel_contactmail_templ_item($id){

	$query = '(SELECT * FROM '.sql_table('plug_contactmail_templ_item').' WHERE tempid='.$id.' AND itype="text" ) union (SELECT *  FROM '.sql_table('plug_contactmail_templ_item').' WHERE tempid='.$id.' and itype="radio" group by iname) union (SELECT *  FROM '.sql_table('plug_contactmail_templ_item').' WHERE tempid='.$id.' and itype="checkbox" )  union (SELECT *  FROM '.sql_table('plug_contactmail_templ_item').' WHERE tempid='.$id.' and itype="textarea" ) union (SELECT *  FROM '.sql_table('plug_contactmail_templ_item').' WHERE tempid='.$id.' and itype="select" ) order by ipos asc ';
	$result = sql_query($query);
	return $result ;
}
/****************************************************************
    sel_contactmail_templ_item_sub()
****************************************************************/
function sel_contactmail_templ_item_sub($id){

		$query = 'SELECT * FROM '.sql_table('plug_contactmail_templ_item').' WHERE tempid='.$id.' AND itype="substitute" order by ipos asc ';
	$result = sql_query($query);
	return $result ;
}
/****************************************************************
    sel_contactmail_templ_item_cb()
****************************************************************/
function sel_contactmail_templ_item_cb($id){

	$query = 'SELECT * FROM '.sql_table('plug_contactmail_templ_item').' WHERE tempid='.$id.' AND itype="checkbox" order by ipos asc ';
	$result = sql_query($query);
	return $result ;
}

/****************************************************************
    sel_contactmail_templ_chk()
****************************************************************/
function sel_contactmail_templ_chk($id){

		$query = 'SELECT * FROM '.sql_table('plug_contactmail_templ_chk').' WHERE tempid='.$id;
	$result = sql_query($query);
	return $result ;
}

/****************************************************************
    sel_addr()
****************************************************************/
function sel_addr($id)
{
	$query = 'SELECT * FROM '.sql_table('member').' WHERE mnumber='.$id;
	$result = sql_query($query);
	return $result ;
}
/****************************************************************
    make_associative_array()
****************************************************************/
function make_associative_array($p_key, $p_val, &$p_array){

	$w_array = array();
	$w_array = array($p_key=>$p_val);
	$p_array = array_merge($p_array, $w_array);

}
/****************************************************************
    make_array_substitute()
****************************************************************/
function make_array_substitute(&$p_array,$id){

	$query = 'SELECT * FROM '.sql_table('plug_contactmail_templ_item').' WHERE tempid='.$id.' AND itype="substitute" order by ipos asc ';
	$result = sql_query($query);

	while ($row = mysql_fetch_object($result)) {
		$w_substitute = substr($row->iname,2,strlen($row->iname)-4);

		array_push($p_array, $w_substitute);
	}

}
/****************************************************************
    make_array_ipos()
****************************************************************/
function make_array_ipos(&$p_array,$id){

	$result = sel_contactmail_templ_item($id);

	while ($row = mysql_fetch_object($result)) {
		array_push($p_array, $row->ipos);
	}

}
/****************************************************************
    make_array_ichk()
****************************************************************/
function make_array_ichk(&$p_array,$id){

	$query = 'SELECT * FROM '.sql_table('plug_contactmail_templ_chk').' WHERE tempid='.$id;
	$result = sql_query($query);

	while ($row = mysql_fetch_object($result)) {
		$p_array[$row->chkno][$row->itemno]=$row->flg;
	}

}
/****************************************************************
    upd_contactmail_templ_item()
****************************************************************/
function upd_contactmail_templ_item($idesc_array, $on_mes_array, $off_mes_array, $id){

    	$result = sel_contactmail_templ_item($id);
	    
	while ($row = mysql_fetch_object($result)) {
		foreach($idesc_array as $key => $val){
			$val = strip_tags($val);

			if($key == $row->iname){
				$query1 = 'UPDATE '.sql_table('plug_contactmail_templ_item')." SET idesc='".$idesc_array[$key]."', on_mes='".$on_mes_array[$key]."', off_mes='".$off_mes_array[$key]."' WHERE tempid=".$id." and iname='".$key."'";
			sql_query($query1);
			}
		}
	}
}
/****************************************************************
    check_must()
****************************************************************/
function check_must($p_key,$p_val){

	if(!$p_val || ereg("^( |　)*$",$p_val)){
		echo "{$p_key}".__NPCM_MES_ERR_MUST."\n";
	}
}
/****************************************************************
    check_mailaddr()
****************************************************************/
function check_mailaddr($p_key,$p_val){

	if($p_val && !isValidMailAddress($p_val)){
		echo "{$p_key}".__NPCM_MES_ERR_MAILADDR."\n";
	}
}
/****************************************************************
    check_numeric()
****************************************************************/
function check_numeric($p_key,$p_val){

	       if($p_val && !ereg("^[0-9 \']+$", $p_val)){
		echo "{$p_key}".__NPCM_MES_ERR_NUMRTIC."\n";
	}
}
/****************************************************************
    check_alphanumeric()
****************************************************************/
function check_alphanumeric($p_key,$p_val){

	       if($p_val && !ereg("^[0-9a-zA-Z \']+$", $p_val)){
		echo "{$p_key}".__NPCM_MES_ERR_ALPHANUMERIC."\n";
	}
}
/****************************************************************
    check_multibyte()
****************************************************************/
function check_multibyte($p_key,$p_val){

    //if magic_quotes_gpc=on remove escapes
    if (get_magic_quotes_gpc()) {
        $p_val = stripslashes($p_val);
    }
    if (strlen($p_val) != mb_strlen($p_val) * 2) {
	echo "{$p_key}".__NPCM_MES_ERR_MULTIBYTE."\n";
    }
}

/****************************************************************
    captchaEnabled()
****************************************************************/
function captchaEnabled() {
	global $NP_BASE_DIR,$NPCM_CONF;
	 global $manager;
	 if($NPCM_CONF['captcha'] == 'yes' && $manager->pluginInstalled('NP_Captcha')) {
	 	return true;
	 }
	 return false;
 }
//2006-10-30 added start
/****************************************************************
    customurlEnabled()
****************************************************************/
function customurlEnabled() {
	global $NP_BASE_DIR,$NPCM_CONF;
	global $manager;
	
	 if($manager->pluginInstalled('NP_CustomURL')) {
	 	return true;
	 }
	 return false;
 }
 //2006-10-30 added end
/****************************************************************
    hschars_encode()
****************************************************************/
function hschars_encode($str)
{
//	return htmlspecialchars(mb_convert_encoding($str,_CHARSET,"auto")); 
	return htmlspecialchars($str); 
}
/****************************************************************
    gpc_stripslashes()
****************************************************************/
function gpc_stripslashes($st)
{
	if (get_magic_quotes_gpc() == 1){
		return stripslashes($st);
	}
	else{
		return $st;
	}
}

/****************************************************************
    gpc_addslashes()
****************************************************************/
function gpc_addslashes()
{
	if (get_magic_quotes_gpc() == 1){
		return $st;
	}
	else{
		return addslashes($st);
	}
}

/****************************************************************
    stripslashes_deep()
****************************************************************/
function stripslashes_deep($value)
{
	$value = is_array($value) ?
	array_map('stripslashes_deep', $value) :
	stripslashes($value);

	return $value;
}

/****************************************************************
    striptags()
****************************************************************/
function striptags(&$p_data, $p_val)
{
	if (get_magic_quotes_gpc()){
//2006-10-30 modified start
		if(phpversion()<"4.1.0")
//			$p_data = array_map("stripslashes",$HTTP_POST_VARS[$p_val]);
			$p_data = stripslashes_deep($HTTP_POST_VARS[$p_val]);
			
		else{
//			$p_data = array_map("stripslashes",$_POST[$p_val]);
			$p_data = stripslashes_deep($_POST[$p_val]);
		}
//2006-10-30 modified end
	}
	else{
		$p_data = postVar($p_val);
	}
}

/****************************************************************
    make_associative_array_sub1()
****************************************************************/
function make_associative_array_sub1(&$sub_array, $data_array)
{
	$sub_array = array();
	$w_array = array();
	
	for ($j=0; $j<count($data_array); $j++) {
		$w_array = array($data_array[$j]['name'] => hschars_encode(postVar($data_array[$j]['name'])));
		$sub_array = array_merge($sub_array, $w_array);

	}

}
/****************************************************************
    make_associative_array_sub()
****************************************************************/
function make_associative_array_sub(&$sub_array, $data_array, $from_data)
{
	$sub_array = array();
	$w_array = array();
	
	if(count($from_data) == 0){
		make_nullvalue_array($from_data, $data_array);
	}
	for ($j=0; $j<count($data_array); $j++) {
		$w_array = array($data_array[$j]['name'] => hschars_encode($from_data[$j]));
		$sub_array = array_merge($sub_array, $w_array);
	}
}
/****************************************************************
    make_nullvalue_array()
****************************************************************/
function make_nullvalue_array(&$from_data, $data_array)
{
	$from_data = array();
	$w_array = array();
	
	for ($j=0; $j<count($data_array); $j++) {
		$w_array = array($data_array[$j]['name'] => NULL);
		$from_data = array_merge($from_data, $w_array);
	}
}

/****************************************************************
    set_associative_array_value()
****************************************************************/
function set_associative_array_value(&$p_array, $p_val, $p_key)
{
	foreach($p_array as $key => $val){
		if($key == $p_key){
			$p_array[$key] = $p_val;	
		}
	}
}

/****************************************************************
    set_cb_mes()
****************************************************************/
function set_cb_mes(&$sub_array, $cb_mes_array, $on_mes_array, $off_mes_array)
{
	foreach($cb_mes_array as $key => $val){
		if($sub_array[$key] == "on"){
			$sub_array[$key] = $on_mes_array[$key];	
		}
		else{
			$sub_array[$key] = $off_mes_array[$key];	
		}
	}
}

/****************************************************************
    set_sendmail_option()
****************************************************************/
function set_sendmail_option($ipos_array, $sub_array, $from_key)
{
	if (!$from_key) {
		$fromitem = '';
	}
	else {
		foreach($ipos_array as $key => $val){
			if($val == $from_key){
				$from_key1 = $key;			
			}
		}
		foreach($sub_array as $key => $val){
			if($key == $from_key1){
				$fromitem = $val;			
			}
		}
	}
	return $fromitem;
}
/****************************************************************
    conv_option_to_value()
****************************************************************/
function conv_option_to_value($pos_array, $p_key)
{
	if (!$p_key) {
		$ret = NULL;
	}
	else {
		foreach($pos_array as $key => $val){
			if($val == $p_key){
				$ret = $key;			
			}
		}
	}
	return $ret;
}
/****************************************************************
    set_addr()
****************************************************************/
function set_addr($addr_id)
{
	if (!$addr_id) $addr_id = 1;
	$result = sel_addr($addr_id);
	while ($row = mysql_fetch_object($result)) {
		$addr =  $row->memail;
	}
	return $addr;
}
/****************************************************************
    get_css()
****************************************************************/
function get_css()
{
	$ret="NP_contactmail.css";
	$ua = $_SERVER["HTTP_USER_AGENT"]; 
	if(stristr($ua, 'MSIE') != false)
	{
		if(stristr($ua, 'Opera') == false && stristr($ua, 'Sleipnir') == false)
		{
		
			$file="nucleus/plugins/contactmail/NP_contactmail_ie.css";
			if(file_exists($file)) {
				$ret="NP_contactmail_ie.css";
 			}
		}
	}
	return $ret;
}

?>
