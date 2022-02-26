<?php 

//to only be included by np_contactmail script or update scripts

if(isset($template)) unset($template);
$template = new NPCM_TEMPLATE(NPCM_TEMPLATE::createnew('defaiult_long_eng','defaiult_long eng'));
//if(!$NPCM_CONF['template']) setNPEMOption('template', $template->getID());
// ----------------------------------------------------------------------------------------------------
$name = 'CREATEMAIL_HEADER';
$content = '<!-- FormHead --><div id="npcm_form"><div class="npcm_head"><h2>message to blogmaster</h2><p><em class="spanred">*</em> are must items.</p><form method="post" action="<%actionuri%>" ><input type="hidden" name="action" value="plugin" /><input type="hidden" name="name" value="ContactMail" /><input type="hidden" name="type" value="createMail" /></div>';
$template->setTemplate($name, $content);

$name = 'CREATEMAIL_BODY';
$content = '<!-- TextArea --><div class="npcm_create_body"><table summary="mail form"><tbody><tr><th>name<em class="spanred">*</em></th><td><input type="text" name="from_name" value="<%from_name%>" /></td></tr><tr><th>mail addr.<em class="spanred">*</em></th><td><input type="text" name="from_email" value="<%from_email%>"  /></td></tr><tr><th>phone no.</th><td><input type="text" name="from_phone" value="<%from_phone%>" /></td></tr><tr><th>region</th><td><select name="from_region" value="<%from_region%>" readonly="readonly"><option value="africa">africa</option><option value="america">america</option><optgroup label="asia"><option value="near and middle" >near and middle</option><option value="west" >west</option><option value="south" >south</option><option value="central" >central</option><option value="north" >north</option><option value="southeast">southeast</option><option value="east" >east</option><option value="far east" selected>far east</option></optgroup><option value="europe">europe</option><option value="oceania">oceania</option></select></td></tr><tr><th>gender</th><td><input type="radio" name="from_sex" value="female" checked />female<input type="radio" name="from_sex" value="male" />male</td></tr><tr><th>subject<em class="spanred">*</em></th><td><input type="text" name="from_subject" value="<%from_subject%>" /></td></tr><tr><th>message<em class="spanred">*</em></th><td><textarea name="from_message" rows="10" cols="32" warp="hard"><%from_message%></textarea></td></tr><tr><th>option</th><td><input type="checkbox" name="from_copy" value="on" />receive a copy at your email address</td></tr></tbody></table></div>';
$template->setTemplate($name, $content);

$name = 'CREATEMAIL_FOOTER';
$content = '<!-- Submit buttom --><br /><div class="npcm_foot"><input type="submit" value="<%btn_confirm%>" class="formbutton" /><!-- Reset -->  <input type="reset" value="<%btn_erase%>" class="formbutton" /><br /></div></form></div>';
$template->setTemplate($name, $content);
// ----------------------------------------------------------------------------------------------------
$name = 'INVALIDMAIL_HEADER';
$content = '<!-- FormHead --><div id="npcm_form"><div class="npcm_head"><h2>message to blogmaster INVALID</h2><p><em class="spanred">*</em> are must items.</p><form method="post" action="<%actionuri%>" ><input type="hidden" name="action" value="plugin" /><input type="hidden" name="name" value="ContactMail" /><input type="hidden" name="type" value="invalidMail" /></div>';
$template->setTemplate($name, $content);

$name = 'INVALIDMAIL_BODY';
$content = '<!-- TextArea --><div class="npcm_invalid_body"><table summary="mail form"><tbody><tr><th>name<em class="spanred">*</em></th><td><input type="text" name="from_name" value="<%from_name%>" readonly="readonly" /></td></tr><tr><th>mail addr.<em class="spanred">*</em></th><td><input type="text" name="from_email" value="<%from_email%>" readonly="readonly"  /></td></tr><tr><th>phone no.</th><td><input type="text" name="from_phone" value="<%from_phone%>" readonly="readonly" /></td></tr><tr><th>region</th><td><select name="from_region" value="<%from_region%>" readonly="readonly"><option value="africa">africa</option><option value="america">america</option><optgroup label="asia"><option value="near and middle" >near and middle</option><option value="west" >west</option><option value="south" >south</option><option value="central" >central</option><option value="north" >north</option><option value="southeast">southeast</option><option value="east" >east</option><option value="far east" selected >far east</option></optgroup><option value="europe">europe</option><option value="oceania">oceania</option></select></td></tr><tr><th>gender</th><td><input type="radio" name="from_sex" value="female" checked readonly="readonly" />female<input type="radio" name="from_sex" value="male" readonly="readonly" />male</td></tr><tr><th>subject<em class="spanred">*</em></th><td><input type="text" name="from_subject" value="<%from_subject%>" readonly="readonly" /></td></tr><tr><th>message<em class="spanred">*</em></th><td><textarea name="from_message" rows="10" cols="32" warp="hard" readonly="readonly"><%from_message%></textarea></td></tr><tr><th>option</th><td><input type="checkbox" name="from_copy" value="on" />receive a copy at your email address</td></tr></tbody></table></div>';
$template->setTemplate($name, $content);

$name = 'INVALIDMAIL_FOOTER';
$content = '<!-- Submit buttom --><br /><div class="npcm_foot"><input type="submit" value="<%btn_back%>" class="formbutton" /></div></form></div>';
$template->setTemplate($name, $content);
// ----------------------------------------------------------------------------------------------------
$name = 'CONFIRMMAIL_HEADER';
$content = '<!-- FormHead --><div class="npcm_form"><div class="npcm_head"><h2>message to blogmaster CONFIRM</h2><p><em class="spanred">*</em> are must items.</p><form method="post" action="<%actionuri%>" ><input type="hidden" name="action" value="plugin" /><input type="hidden" name="name" value="ContactMail" /><input type="hidden" name="type" value="confirmMail" /></div>';
$template->setTemplate($name, $content);

$name = 'CONFIRMMAIL_BODY';
$content = '<!-- TextArea --><div class="npcm_confirm_body"><table summary="mail form"><tbody><tr><th>name<em class="spanred">*</em></th><td><%from_name%></td></tr><tr><th>mail addr.<em class="spanred">*</em></th><td><%from_email%></td></tr><tr><th>phone no.</th><td><%from_phone%></td></tr><tr><th>region</th><td><%from_region%></td></tr><tr><th>gender</th><td><%from_sex%></td></tr><tr><th>subject<em class="spanred">*</em></th><td><%from_subject%></td></tr><tr><th>message<em class="spanred">*</em></th><td><%from_message%></td></tr><tr><th>option</th><td><%from_copy%></td></tr></tbody></table></div>';
$template->setTemplate($name, $content);

$name = 'CONFIRMMAIL_FOOTER';
$content = '<!-- Submit buttom --><br /><div class="npcm_foot"><input type="submit" name="confirmbtn" value="<%btn_back%>" class="formbutton" />  <input type="submit" value="<%btn_send%>" name="confirmbtn" class="formbutton" /></div></form></div>';
$template->setTemplate($name, $content);
// ----------------------------------------------------------------------------------------------------
$name = 'SENDMAIL_HEADER';
$content = '<!-- FormHead --><div class="npcm_form"><div class="npcm_head"><h2>message to blogmaster SEND</h2><form method="post" action="<%actionuri%>"><input type="hidden" name="action" value="plugin" /><input type="hidden" name="name" value="ContactMail" /><input type="hidden" name="type" value="sendMail" /></div>';
$template->setTemplate($name, $content);

$name = 'SENDMAIL_BODY';
$content = '<!-- TextArea --><div class="npcm_send_body"><h3><%sendresult%></h3></div>';
$template->setTemplate($name, $content);

$name = 'SENDMAIL_FOOTER';
$content = '<!-- Submit buttom --><br /><div class="npcm_foot"><input type="submit" value="<%btn_returntop%>" class="formbutton" /></div></form></div>';
$template->setTemplate($name, $content);

?>
