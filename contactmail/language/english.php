<?php

//language file
//english NP_ContactMail
define('__NPCM_OPT_DONT_DELETE_TABLES','Delete this plugin\'s table and data when uninstalling?');

//send mess:
define('__NPCM_SEND_MESS_OK',   ' Your mail message has been done successfully.');
define('__NPCM_SEND_MESS_NG',   ' Your mail message was attempted but failed to send for some reason.');
define('__NPCM_CAPTCHA_MESS',   ' Please key-in six chars appearing in the picture below (ignore case). ');

//button disp:
define('__NPCM_BTN_SEND',   ' Send ');
define('__NPCM_BTN_CONFIRM','Confirm');
define('__NPCM_BTN_BACK',   ' Back ' );
define('__NPCM_BTN_RETURNTOP', 'Once More' );
define('__NPCM_BTN_ERASE',   ' Erase ' );

//error mess:
define('__NPCM_MES_ERR_MUST',' is must item.');
define('__NPCM_MES_ERR_NUMRTIC',' should be numeric.');
define('__NPCM_MES_ERR_ALPHANUMERIC',' should be alphanumeric.');
define('__NPCM_MES_ERR_MULTIBYTE',' should be multibyte.');
define('__NPCM_MES_ERR_MAILADDR',' is invalid.');

//errors:
define('__NPCM_ERR_CONTACTMAIL_NOT_CONFIG','The ContactMail hasn\'t been configured.');
define('__NPCM_ERR_BAD_TEMPLATE','Bad template name');
define('__NPCM_ERR_NO_UPD_TEMPLATE','There was a problem updating the template');
define('__NPCM_ERR_BAD_FUNCTION','Function not defined');
define('__NPCM_ERR_NOT_ADMIN','Need to be administrator to perform this function');

//admin page:
//tabs:
define('__NPCM_ADMIN_TITLE','ContactMail Admin Page');
define('__NPCM_ADMIN_TAB_CONFIG','Configuration');
define('__NPCM_ADMIN_TAB_TEMPLATES','Templates');
define('__NPCM_ADMIN_TAB_TEMPLATE_ITEMS','Template Items');

//configuration tab
define('__NPCM_ADMIN_GEN_OPTIONS','General Options');
define('__NPCM_TO_MAIL_MEMBER','Send mail to the attention of');
define('__NPCM_SELECTED_BLOG','Selected blog');
define('__NPCM_ADMIN_ACTIVETEMPLATE','Active template');
define('__NPCM_ADMIN_CAPTCHA','Use NP_Captcha');
define('__NPCM_ADMIN_INVALID_PLUS','Use Invalid Page');

//templates tab
define('__NPCM_ADMIN_TEMPLATES','Templates');
define('__NPCM_ADMIN_RETURN','Return to ContactMail Admin Top');

//template items tab
define('__NPCM_ADMIN_TEMPLATE_ITEMS','Edit Template Items');
define('__NPCM_ADMIN_TEMPLATE_ITEMS_CB','Edit Checkbox Messages');

define('__NPCM_TITEM_NAME','Name');
define('__NPCM_TITEM_DESC','Desc');
define('__NPCM_TITEM_VALUE','Substitute');
define('__NPCM_TITEM_CHECK','Check');
define('__NPCM_TITEM_TYPE','Type');
define('__NPCM_TITEM_COMMENT','Five checkboxes in Check column are ordered by must, numeric, alphanumeric, multibyte, mailaddress in a direction from left to right.');
//define('__NPCM_TITEM_COMMENT','チェックのチェックボックスの並び順は、/必須/数字/英数字/全角/メールアドレス/です。');
define('__NPCM_CB_NAME','Name');
define('__NPCM_CB_ON_MES','On message');
define('__NPCM_CB_OFF_MES','Off message');
define('__NPCM_ADMIN_GEN_TEMPL_ITEM_OPTIONS','Send Mail Options');
define('__NPCM_SELECTED_FROMNAME','Tell nucleus which item "from name" is');
define('__NPCM_SELECTED_FROMADDR','Tell nucleus which item "from address" is');
define('__NPCM_SELECTED_SUBJECT','Tell nucleus which item "subject" is');
define('__NPCM_SELECTED_COPY','Tell nucleus which item "send copy" is');

//forms

//general form
define('__NPCM_FORM_SUBMIT_CHANGES','Submit changes');
define('__NPCM_FORM_USER','User');
define('__NPCM_FORM_NAME','Name');
define('__NPCM_FORM_TITLE','Title');
define('__NPCM_FORM_DESC','Description');
define('__NPCM_FORM_YES','Yes');
define('__NPCM_FORM_ACTIONS','Actions');
define('__NPCM_FORM_IMAGES', 'Images');
define('__NPCM_FORM_OWNER','Owner');
define('__NPCM_FORM_SETTINGS','Settings');
define('__NPCM_FORM_DELETE','Delete');
define('__NPCM_FORM_CLONE','Clone');
define('__NPCM_FORM_EDIT','Edit');

//template
define('__NPCM_FORM_TEMPLATE_CREATE_HEADER','CreateMail Header');
define('__NPCM_FORM_TEMPLATE_CREATE_BODY','CreateMail Body');
define('__NPCM_FORM_TEMPLATE_CREATE_FOOTER','CreateMail Footer');
define('__NPCM_FORM_TEMPLATE_INVALID_HEADER','InvalidMail Header');
define('__NPCM_FORM_TEMPLATE_INVALID_BODY','InvalidMail Body');
define('__NPCM_FORM_TEMPLATE_INVALID_FOOTER','InvalidMail Footer');
define('__NPCM_FORM_TEMPLATE_CONFIRM_HEADER','ConfirmMail Header');
define('__NPCM_FORM_TEMPLATE_CONFIRM_BODY','ConfirmMail Body');
define('__NPCM_FORM_TEMPLATE_CONFIRM_FOOTER','ConfirmMail Footer');
define('__NPCM_FORM_TEMPLATE_SEND_HEADER','SendMail Header');
define('__NPCM_FORM_TEMPLATE_SEND_BODY','SendMail Body');
define('__NPCM_FORM_TEMPLATE_SEND_FOOTER','SendMail Footer');
define('__NPCM_FORM_TEMPLATE_CREATE','CreateMail');
define('__NPCM_FORM_TEMPLATE_INVALID','InvalidMail');
define('__NPCM_FORM_TEMPLATE_CONFIRM','ConfirmMail');
define('__NPCM_FORM_TEMPLATE_SEND','SendMail');

define('__NPCM_FORM_EDIT_TEMPLATE','Edit Template');
define('__NPCM_FORM_TEMPLATE_NAME','Template Name');
define('__NPCM_FORM_TEMPLATE_DESC','Template Description');
define('__NPCM_FORM_TEMPLATE_SETTINGS','Template Settings');
define('__NPCM_FORM_NEWTEMPLATE','New Template');
define('__NPCM_FORM_TEMPLATE_COMMENTS','Comments');
define('__NPCM_FORM_CREATENEWTEMPLATE','Create new template');
