<?php

//language file
//english NP_ContactMail
define('__NPCM_OPT_DONT_DELETE_TABLES','���󥤥󥹥ȡ�����ˤ��Υץ饰����Υơ��֥��Drop���ޤ���?');

//send mess:
define('__NPCM_SEND_MESS_OK',   ' �᡼�����������������ޤ�����');
define('__NPCM_SEND_MESS_NG',   ' �᡼����������ߤޤ����������餫����ͳ�ˤ�������˼��Ԥ��ޤ�����');
define('__NPCM_CAPTCHA_MESS',   ' ���ޤΣ�ʸ�������Ϥ��Ƥ������� (��ʸ������ʸ����̵�뤵��ޤ�)�� ');

//button disp:
define('__NPCM_BTN_SEND',   ' ���� ');
define('__NPCM_BTN_CONFIRM','��ǧ');
define('__NPCM_BTN_BACK',   ' ��� ' );
define('__NPCM_BTN_RETURNTOP', '�����᡼�����' );
define('__NPCM_BTN_ERASE',   ' �õ� ' );

//error mess:
define('__NPCM_MES_ERR_MUST','��ɬ�ܹ��ܤǤ���');
define('__NPCM_MES_ERR_NUMRTIC','�Ͽ��͹��ܤǤ���');
define('__NPCM_MES_ERR_ALPHANUMERIC','�ϱѿ������ܤǤ���');
define('__NPCM_MES_ERR_MULTIBYTE','������ʸ�����ܤǤ���');
define('__NPCM_MES_ERR_MAILADDR','�η����������Ǥ���');

//errors:
define('__NPCM_ERR_CONTACTMAIL_NOT_CONFIG','ContactMail�Υ���ե����졼�����̤����Ǥ���');
define('__NPCM_ERR_BAD_TEMPLATE','�ƥ�ץ졼��̾�������Ǥ���');
define('__NPCM_ERR_NO_UPD_TEMPLATE','�ƥ�ץ졼�Ȥι��������꤬ȯ�����ޤ�����');
define('__NPCM_ERR_BAD_FUNCTION','̤����ε�ǽ�Ǥ���');
define('__NPCM_ERR_NOT_ADMIN','���ε�ǽ����Ѥ���ˤϡ�Admim���¤�ɬ�פǤ���');

//admin page:
//tabs:
define('__NPCM_ADMIN_TITLE','ContactMail�������ꥢ');
define('__NPCM_ADMIN_TAB_CONFIG','����ե����졼�����');
define('__NPCM_ADMIN_TAB_TEMPLATES','�ƥ�ץ졼��');
define('__NPCM_ADMIN_TAB_TEMPLATE_ITEMS','�ƥ�ץ졼�ȹ���');

//configuration tab
define('__NPCM_ADMIN_GEN_OPTIONS','����Ū������');
define('__NPCM_TO_MAIL_MEMBER','�᡼�������������С�');
define('__NPCM_SELECTED_BLOG','�ץ饰�����ɽ������֥�');
define('__NPCM_ADMIN_ACTIVETEMPLATE','�����ȡ��ƥ�ץ졼��');
define('__NPCM_ADMIN_CAPTCHA','NP_Captcha����Ѥ���');
define('__NPCM_ADMIN_INVALID_PLUS','Invalid�ڡ�������Ѥ���');

//templates tab
define('__NPCM_ADMIN_TEMPLATES','�ƥ�ץ졼��');
define('__NPCM_ADMIN_RETURN','ContactMail�������ꥢ���ȥåפ����');

//template items tab
define('__NPCM_ADMIN_TEMPLATE_ITEMS','�ƥ�ץ졼�ȹ����Խ�');
define('__NPCM_ADMIN_TEMPLATE_ITEMS_CB','Checkbox ON/OFF���Υ�å������Խ�');

define('__NPCM_TITEM_NAME','Name');
define('__NPCM_TITEM_DESC','Desc');
define('__NPCM_TITEM_VALUE','Substitute');
define('__NPCM_TITEM_CHECK','Check');
define('__NPCM_TITEM_TYPE','Type');
define('__NPCM_TITEM_COMMENT','Check�Υ����å��ܥå������¤ӽ�ϡ�/ɬ��/����/�ѿ���/����/�᡼�륢�ɥ쥹/�Ǥ���');
define('__NPCM_CB_NAME','Name');
define('__NPCM_CB_ON_MES','ON���Υ�å�����');
define('__NPCM_CB_OFF_MES','OFF���Υ�å�����');
define('__NPCM_ADMIN_GEN_TEMPL_ITEM_OPTIONS','�᡼���������ץ����');
define('__NPCM_SELECTED_FROMNAME','�᡼����������̾������');
define('__NPCM_SELECTED_FROMADDR','�᡼���������Υ᡼�륢�ɥ쥹����');
define('__NPCM_SELECTED_SUBJECT','�᡼���������Υ����ȥ����');
define('__NPCM_SELECTED_COPY','�᡼���������ԡ�����');

//forms

//general form
define('__NPCM_FORM_SUBMIT_CHANGES','�ѹ�����¸');
define('__NPCM_FORM_USER','�桼����');
define('__NPCM_FORM_NAME','̾��');
define('__NPCM_FORM_TITLE','�����ȥ�');
define('__NPCM_FORM_DESC','����');
define('__NPCM_FORM_YES','�Ϥ�');
define('__NPCM_FORM_ACTIONS','���������');
define('__NPCM_FORM_IMAGES', '����');
define('__NPCM_FORM_OWNER','��ͭ��');
define('__NPCM_FORM_SETTINGS','����');
define('__NPCM_FORM_DELETE','���');
define('__NPCM_FORM_CLONE','ʣ��');
define('__NPCM_FORM_EDIT','�Խ�');

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

define('__NPCM_FORM_EDIT_TEMPLATE','�ƥ�ץ졼�Ȥ��Խ�');
define('__NPCM_FORM_TEMPLATE_NAME','�ƥ�ץ졼��̾');
define('__NPCM_FORM_TEMPLATE_DESC','�ƥ�ץ졼�Ȥ�����');
define('__NPCM_FORM_TEMPLATE_SETTINGS','�ƥ�ץ졼�Ȥ�����');
define('__NPCM_FORM_NEWTEMPLATE','�����ƥ�ץ졼��');
define('__NPCM_FORM_TEMPLATE_COMMENTS','������');
define('__NPCM_FORM_CREATENEWTEMPLATE','�����ƥ�ץ졼�Ȥκ���');
