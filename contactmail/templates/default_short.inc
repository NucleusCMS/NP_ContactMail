<?php 

//to only be included by np_contactmail script or update scripts

if(isset($template)) unset($template);
$template = new NPCM_TEMPLATE(NPCM_TEMPLATE::createnew('defaiult_short_eng','defaiult_short eng'));
//if(!$NPCM_CONF['template']) setNPEMOption('template', $template->getID());
// ----------------------------------------------------------------------------------------------------
$name = 'CREATEMAIL_HEADER';
$content = '<!-- FormHead --><div class="npcm_form"><div class="npcm_head"><h2>message to blogmaster</h2><form method="post" action="<%actionuri%>" ><input type="hidden" name="action" value="plugin" /><input type="hidden" name="name" value="ContactMail" /><input type="hidden" name="type" value="createMail" /></div>';
$template->setTemplate($name, $content);

$name = 'CREATEMAIL_BODY';
$content = '<!-- TextArea --><div class="npcm_create_body"><table summary="mail form"><tbody><tr><th>name</th><td><input type="text" name="from_name" value="<%from_name%>" /></td></tr><tr><th>mail addr.</th><td><input type="text" name="from_email" value="<%from_email%>"  /></td></tr><tr><th>subject</th><td><input type="text" name="from_subject" value="<%from_subject%>" /></td></tr><tr><th>message</th><td><textarea name="from_message" rows="12" cols="32" warp="hard"><%from_message%></textarea></td></tr><tr><th>option</th><td><input type="checkbox" name="from_copy" value="on" />receive a copy at your email address</td></tr></tbody></table></div>';
$template->setTemplate($name, $content);

$name = 'CREATEMAIL_FOOTER';
$content = '<!-- Submit buttom --><br /><div class="npcm_foot"><input type="submit" value="<%btn_confirm%>" class="formbutton" /><!-- Reset -->  <input type="reset" value="<%btn_erase%>" class="formbutton" /><br /></div></form></div>';
$template->setTemplate($name, $content);
// ----------------------------------------------------------------------------------------------------
$name = 'INVALIDMAIL_HEADER';
$content = '<!-- FormHead --><div class="npcm_form"><div class="npcm_head"><h2>message to blogmaster INVALID</h2><form method="post" action="<%actionuri%>" ><input type="hidden" name="action" value="plugin" /><input type="hidden" name="name" value="ContactMail" /><input type="hidden" name="type" value="invalidMail" /></div>';
$template->setTemplate($name, $content);

$name = 'INVALIDMAIL_BODY';
$content = '<!-- TextArea --><div class="npcm_invalid_body"><table summary="mail form"><tbody><tr><th>name</th><td><input type="text" name="from_name" value="<%from_name%>" readonly="readonly" /></td></tr><tr><th>mail addr.</th><td><input type="text" name="from_email" value="<%from_email%>" readonly="readonly"  /></td></tr><tr><th>subject</th><td><input type="text" name="from_subject" value="<%from_subject%>" readonly="readonly" /></td></tr><tr><th>message</th><td><textarea name="from_message" rows="12" cols="32" warp="hard" readonly="readonly"><%from_message%></textarea></td></tr><tr><th>option</th><td><input type="checkbox" name="from_copy" value="on" />receive a copy at your email address</td></tr></tbody></table></div>';
$template->setTemplate($name, $content);

$name = 'INVALIDMAIL_FOOTER';
$content = '<!-- Submit buttom --><br /><div class="npcm_foot"><input type="submit" value="<%btn_back%>" class="formbutton" /></div></form></div>';
$template->setTemplate($name, $content);
// ----------------------------------------------------------------------------------------------------
$name = 'CONFIRMMAIL_HEADER';
$content = '<!-- FormHead --><div class="npcm_form"><div class="npcm_head"><h2>message to blogmaster CONFIRM</h2><form method="post" action="<%actionuri%>" ><input type="hidden" name="action" value="plugin" /><input type="hidden" name="name" value="ContactMail" /><input type="hidden" name="type" value="confirmMail" /></div>';
$template->setTemplate($name, $content);

$name = 'CONFIRMMAIL_BODY';
$content = '<!-- TextArea --><div class="npcm_confirm_body"><table summary="mail form"><tbody><tr><th>name</th><td><%from_name%></td></tr><tr><th>mail addr.</th><td><%from_email%></td></tr><tr><th>subject</th><td><%from_subject%></td></tr><tr><th>message</th><td><%from_message%></td></tr><tr><th>option</th><td><%from_copy%></td></tr></tbody></table></div>';
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
