<?php 

//to only be included by np_contactmail script or update scripts

if(isset($template)) unset($template);
$template = new NPCM_TEMPLATE(NPCM_TEMPLATE::createnew('defaiult_long','defaiult_long euc'));
//if(!$NPCM_CONF['template']) setNPEMOption('template', $template->getID());
// ----------------------------------------------------------------------------------------------------
$name = 'CREATEMAIL_HEADER';
$content = '<!-- FormHead --><div id="npcm_form"><div class="npcm_head"><h2>blogmasterへのメール</h2><p><em class="spanred">*</em>は必須項目です</p><form method="post" action="<%actionuri%>" ><input type="hidden" name="action" value="plugin" /><input type="hidden" name="name" value="ContactMail" /><input type="hidden" name="type" value="createMail" /></div>';
$template->setTemplate($name, $content);

$name = 'CREATEMAIL_BODY';
$content = '<!-- TextArea --><div class="npcm_create_body"><table summary="メール送信フォーム"><tbody><tr><th>名前<em class="spanred">*</em></th><td><input type="text" name="from_name" value="<%from_name%>" /></td></tr><tr><th>メールアドレス<em class="spanred">*</em></th><td><input type="text" name="from_email" value="<%from_email%>"  /></td></tr><tr><th>連絡先電話番号</th><td><input type="text" name="from_phone" value="<%from_phone%>" /></td></tr><tr><th>地域</th><td><select name="from_region" value="<%from_region%>"><option value="北海道">北海道</option><option value="東北">東北</option><optgroup label="関東"><option value="栃木" >栃木</option><option value="群馬" >群馬</option><option value="茨城" >茨城</option><option value="千葉" >千葉</option><option value="埼玉" >埼玉</option><option value="東京" selected>東京</option><option value="神奈川" >神奈川</option></optgroup><option value="中部">中部</option><option value="関西">関西</option><option value="中国">中国</option><option value="四国">四国</option><option value="九州">九州</option></select></td></tr><tr><th>性別</th><td><input type="radio" name="from_sex" value="女性" checked />女性<input type="radio" name="from_sex" value="男性" />男性</td></tr><tr><th>タイトル<em class="spanred">*</em></th><td><input type="text" name="from_subject" value="<%from_subject%>" /></td></tr><tr><th>通信欄<em class="spanred">*</em></th><td><textarea name="from_message" rows="10" cols="32" warp="hard"><%from_message%></textarea></td></tr><tr><th>オプション</th><td><input type="checkbox" name="from_copy" value="on" />送信内容のコピーをE-mailで受信する</td></tr></tbody></table></div>';
$template->setTemplate($name, $content);

$name = 'CREATEMAIL_FOOTER';
$content = '<!-- Submit buttom --><br /><div class="npcm_foot"><input type="submit" value="<%btn_confirm%>" class="formbutton" /><!-- Reset -->  <input type="reset" value="<%btn_erase%>" class="formbutton" /><br /></div></form></div>';
$template->setTemplate($name, $content);
// ----------------------------------------------------------------------------------------------------
$name = 'INVALIDMAIL_HEADER';
$content = '<!-- FormHead --><div id="npcm_form"><div class="npcm_head"><h2>blogmasterへのメール INVALID</h2><p><em class="spanred">*</em>は必須項目です</p><form method="post" action="<%actionuri%>" ><input type="hidden" name="action" value="plugin" /><input type="hidden" name="name" value="ContactMail" /><input type="hidden" name="type" value="invalidMail" /></div>';
$template->setTemplate($name, $content);

$name = 'INVALIDMAIL_BODY';
$content = '<!-- TextArea --><div class="npcm_invalid_body"><table summary="メール送信フォーム"><tbody><tr><th>名前<em class="spanred">*</em></th><td><input type="text" name="from_name" value="<%from_name%>" readonly="readonly" /></td></tr><tr><th>メールアドレス<em class="spanred">*</em></th><td><input type="text" name="from_email" value="<%from_email%>" readonly="readonly"  /></td></tr><tr><th>連絡先電話番号</th><td><input type="text" name="from_phone" value="<%from_phone%>" readonly="readonly" /></td></tr><tr><th>地域</th><td><select name="from_region" value="<%from_region%>" readonly="readonly"><option value="北海道">北海道</option><option value="東北">東北</option><optgroup label="関東"><option value="栃木" >栃木</option><option value="群馬" >群馬</option><option value="茨城" >茨城</option><option value="千葉" >千葉</option><option value="埼玉" >埼玉</option><option value="東京" selected>東京</option><option value="神奈川" >神奈川</option></optgroup><option value="中部">中部</option><option value="関西">関西</option><option value="中国">中国</option><option value="四国">四国</option><option value="九州">九州</option></select></td></tr><tr><th>性別</th><td><input type="radio" name="from_sex" value="女性" checked readonly="readonly" />女性<input type="radio" name="from_sex" value="男性" readonly="readonly" />男性</td></tr><tr><th>タイトル<em class="spanred">*</em></th><td><input type="text" name="from_subject" value="<%from_subject%>" readonly="readonly" /></td></tr><tr><th>通信欄<em class="spanred">*</em></th><td><textarea name="from_message" rows="10" cols="32" warp="hard" readonly="readonly"><%from_message%></textarea></td></tr><tr><th>オプション</th><td><input type="checkbox" name="from_copy" value="on" />送信内容のコピーをE-mailで受信する</td></tr></tbody></table></div>';
$template->setTemplate($name, $content);

$name = 'INVALIDMAIL_FOOTER';
$content = '<!-- Submit buttom --><br /><div class="npcm_foot"><input type="submit" value="<%btn_back%>" class="formbutton" /></div></form></div>';
$template->setTemplate($name, $content);
// ----------------------------------------------------------------------------------------------------
$name = 'CONFIRMMAIL_HEADER';
$content = '<!-- FormHead --><div class="npcm_form"><div class="npcm_head"><h2>blogmasterへのメール CONFIRM</h2><p><em class="spanred">*</em>は必須項目です</p><form method="post" action="<%actionuri%>" ><input type="hidden" name="action" value="plugin" /><input type="hidden" name="name" value="ContactMail" /><input type="hidden" name="type" value="confirmMail" /></div>';
$template->setTemplate($name, $content);

$name = 'CONFIRMMAIL_BODY';
$content = '<!-- TextArea --><div class="npcm_confirm_body"><table summary="メール送信フォーム"><tbody><tr><th>名前<em class="spanred">*</em></th><td><%from_name%></td></tr><tr><th>メールアドレス<em class="spanred">*</em></th><td><%from_email%></td></tr><tr><th>連絡先電話番号</th><td><%from_phone%></td></tr><tr><th>地域</th><td><%from_region%></td></tr><tr><th>性別</th><td><%from_sex%></td></tr><tr><th>タイトル<em class="spanred">*</em></th><td><%from_subject%></td></tr><tr><th>通信欄<em class="spanred">*</em></th><td><%from_message%></td></tr><tr><th>オプション</th><td><%from_copy%></td></tr></tbody></table></div>';
$template->setTemplate($name, $content);

$name = 'CONFIRMMAIL_FOOTER';
$content = '<!-- Submit buttom --><br /><div class="npcm_foot"><input type="submit" name="confirmbtn" value="<%btn_back%>" class="formbutton" />  <input type="submit" value="<%btn_send%>" name="confirmbtn" class="formbutton" /></div></form></div>';
$template->setTemplate($name, $content);
// ----------------------------------------------------------------------------------------------------
$name = 'SENDMAIL_HEADER';
$content = '<!-- FormHead --><div class="npcm_form"><div class="npcm_head"><h2>blogmasterへのメール SEND</h2><form method="post" action="<%actionuri%>"><input type="hidden" name="action" value="plugin" /><input type="hidden" name="name" value="ContactMail" /><input type="hidden" name="type" value="sendMail" /></div>';
$template->setTemplate($name, $content);

$name = 'SENDMAIL_BODY';
$content = '<!-- TextArea --><div class="npcm_send_body"><h3><%sendresult%></h3></div>';
$template->setTemplate($name, $content);

$name = 'SENDMAIL_FOOTER';
$content = '<!-- Submit buttom --><br /><div class="npcm_foot"><input type="submit" value="<%btn_returntop%>" class="formbutton" /></div></form></div>';
$template->setTemplate($name, $content);

?>
