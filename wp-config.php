<?php

switch ($_SERVER['HTTP_HOST'])
{
	case 'localhost':
	case 'renew.local':
	
		define('DB_NAME', 'renew');
		define('DB_USER', 'root');
		define('DB_PASSWORD', '');	

	
	break;
	
	default:
	
		define('DB_NAME', 'renew_wp');
		define('DB_USER', 'renew_wp');
		define('DB_PASSWORD', 'dyVL.^&LG^L!');

}


define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

define('AUTH_KEY',         'RreC=bk4qvf5+ZlRsp>n61[3a~,@:p:92`,uXvfg3@U_d+XOk|eo*|#p1GH|#-sY');

define('SECURE_AUTH_KEY',  'F9(]gm3!%-Q9Ou(~(Pfk|J^FztNc:VjB-1/B)l2$=(Q6wxWu[B6NVO32cCkEV~z*');

define('LOGGED_IN_KEY',    'VJ&dcO-<V<CF.8H G/+i(>kh5;H$0Z$I(!|J~|hTm+a5A,atSWOh7^iP6Gx2O1s{');

define('NONCE_KEY',        '@q4yT|@V&YW8Z-eUQM|O-.5ZOzL|;wMm&IwKJeNs(/l|McFsZN+5fgb,-LTEs+_N');

define('AUTH_SALT',        'c1aZ9sd)>|Q%L>|Vf (Z)95!VS!xMZD=4{<xl0Y*BVbKXD)UGKFLEW c#p;#pAB]');

define('SECURE_AUTH_SALT', 'H]O=#a0}3|CoFb +^AYIAXK1w*62E|Y0$--J`C&eabP1z:Q=KTQZ,y4]zN$~0)bB');

define('LOGGED_IN_SALT',   'ltRq,$$B}a|2Q8;*=+@yeg-e-4(#)JbKS(sIZYo2W|]NN)pCZwNX>k!v~x6yILh5');

define('NONCE_SALT',       '%NdH7M2%6`+`PhqFj+dhw+aQ|ee$PzYf+#w*uM ,~@s%J+&3[j[5fUkRO7h%`q&f');

$table_prefix  = 'rmh_';

define('WPLANG', '');

define('WP_DEBUG', false);

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');


require_once(ABSPATH . 'wp-settings.php');
