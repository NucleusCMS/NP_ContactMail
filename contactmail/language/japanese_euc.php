<?php

//language file
//english NP_ContactMail
define('__NPCM_OPT_DONT_DELETE_TABLES','アンインストール時にこのプラグインのテーブルをDropしますか?');

//send mess:
define('__NPCM_SEND_MESS_OK',   ' メールは正しく送信されました。');
define('__NPCM_SEND_MESS_NG',   ' メールを送信を試みましたが、何らかの理由により送信に失敗しました。');
define('__NPCM_CAPTCHA_MESS',   ' 下図の６文字を入力してください (大文字／小文字は無視されます)。 ');

//button disp:
define('__NPCM_BTN_SEND',   ' 送信 ');
define('__NPCM_BTN_CONFIRM','確認');
define('__NPCM_BTN_BACK',   ' 戻る ' );
define('__NPCM_BTN_RETURNTOP', '新規メール作成' );
define('__NPCM_BTN_ERASE',   ' 消去 ' );

//error mess:
define('__NPCM_MES_ERR_MUST','は必須項目です。');
define('__NPCM_MES_ERR_NUMRTIC','は数値項目です。');
define('__NPCM_MES_ERR_ALPHANUMERIC','は英数字項目です。');
define('__NPCM_MES_ERR_MULTIBYTE','は全角文字項目です。');
define('__NPCM_MES_ERR_MAILADDR','の形式が不正です。');

//errors:
define('__NPCM_ERR_CONTACTMAIL_NOT_CONFIG','ContactMailのコンフィグレーションが未設定です。');
define('__NPCM_ERR_BAD_TEMPLATE','テンプレート名が不正です。');
define('__NPCM_ERR_NO_UPD_TEMPLATE','テンプレートの更新で問題が発生しました。');
define('__NPCM_ERR_BAD_FUNCTION','未定義の機能です。');
define('__NPCM_ERR_NOT_ADMIN','この機能を使用するには、Admim権限が必要です。');

//admin page:
//tabs:
define('__NPCM_ADMIN_TITLE','ContactMail管理エリア');
define('__NPCM_ADMIN_TAB_CONFIG','コンフィグレーション');
define('__NPCM_ADMIN_TAB_TEMPLATES','テンプレート');
define('__NPCM_ADMIN_TAB_TEMPLATE_ITEMS','テンプレート項目');

//configuration tab
define('__NPCM_ADMIN_GEN_OPTIONS','全般的な設定');
define('__NPCM_TO_MAIL_MEMBER','メールを送信するメンバー');
define('__NPCM_SELECTED_BLOG','プラグインを表示するブログ');
define('__NPCM_ADMIN_ACTIVETEMPLATE','カレント・テンプレート');
define('__NPCM_ADMIN_CAPTCHA','NP_Captchaを使用する');
define('__NPCM_ADMIN_INVALID_PLUS','Invalidページを使用する');

//templates tab
define('__NPCM_ADMIN_TEMPLATES','テンプレート');
define('__NPCM_ADMIN_RETURN','ContactMail管理エリア・トップに戻る');

//template items tab
define('__NPCM_ADMIN_TEMPLATE_ITEMS','テンプレート項目編集');
define('__NPCM_ADMIN_TEMPLATE_ITEMS_CB','Checkbox ON/OFF時のメッセージ編集');

define('__NPCM_TITEM_NAME','Name');
define('__NPCM_TITEM_DESC','Desc');
define('__NPCM_TITEM_VALUE','Substitute');
define('__NPCM_TITEM_CHECK','Check');
define('__NPCM_TITEM_TYPE','Type');
define('__NPCM_TITEM_COMMENT','Checkのチェックボックスの並び順は、/必須/数字/英数字/全角/メールアドレス/です。');
define('__NPCM_CB_NAME','Name');
define('__NPCM_CB_ON_MES','ON時のメッセージ');
define('__NPCM_CB_OFF_MES','OFF時のメッセージ');
define('__NPCM_ADMIN_GEN_TEMPL_ITEM_OPTIONS','メール送信オプション');
define('__NPCM_SELECTED_FROMNAME','メール送信元の名前項目');
define('__NPCM_SELECTED_FROMADDR','メール送信元のメールアドレス項目');
define('__NPCM_SELECTED_SUBJECT','メール送信元のタイトル項目');
define('__NPCM_SELECTED_COPY','メール送信コピー項目');

//forms

//general form
define('__NPCM_FORM_SUBMIT_CHANGES','変更を保存');
define('__NPCM_FORM_USER','ユーザー');
define('__NPCM_FORM_NAME','名前');
define('__NPCM_FORM_TITLE','タイトル');
define('__NPCM_FORM_DESC','説明');
define('__NPCM_FORM_YES','はい');
define('__NPCM_FORM_ACTIONS','アクション');
define('__NPCM_FORM_IMAGES', '画像');
define('__NPCM_FORM_OWNER','所有者');
define('__NPCM_FORM_SETTINGS','設定');
define('__NPCM_FORM_DELETE','削除');
define('__NPCM_FORM_CLONE','複製');
define('__NPCM_FORM_EDIT','編集');

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

define('__NPCM_FORM_EDIT_TEMPLATE','テンプレートの編集');
define('__NPCM_FORM_TEMPLATE_NAME','テンプレート名');
define('__NPCM_FORM_TEMPLATE_DESC','テンプレートの説明');
define('__NPCM_FORM_TEMPLATE_SETTINGS','テンプレートの設定');
define('__NPCM_FORM_NEWTEMPLATE','新規テンプレート');
define('__NPCM_FORM_TEMPLATE_COMMENTS','コメント');
define('__NPCM_FORM_CREATENEWTEMPLATE','新規テンプレートの作成');
