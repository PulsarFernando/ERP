<?php
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');
$config = require(__DIR__ . '/config/web.php');
/**
 * @todo When finish migrating to php7 quit that code 
 */
if($_SERVER['HTTP_HOST'] == 'dbpulsar.pulsarimagens.com.br')
{
	define('ERP_URL_OLD', 'http://dbpulsar.pulsarimagens.com.br');
	define('ERP_URL_FRAMEWORK5', 'http://dbpulsar.pulsarimagens.com.br');
	define('SITE_URL', 'http://dbpulsar.pulsarimagens.com.br');
}
elseif($_SERVER['HTTP_HOST'] == 'erp_dev.pulsarimagens.com.br' || $_SERVER['HTTP_HOST'] == 'homolog.pulsarimagens.com.br:81')
{
	define('ERP_URL_OLD', 'http://erp_dev.pulsarimagens.com.br');
	define('ERP_URL_FRAMEWORK7', 'http://www.pulsarimagens.com.br:81');
	define('SITE_URL', 'http://teste.pulsarimagens.com.br');
}
elseif($_SERVER['HTTP_HOST'] == 'erp.pulsarimagens.com.br' || $_SERVER['HTTP_HOST'] == 'proerp.pulsarimagens.com.br:81')
{
	define('ERP_URL_OLD', 'http://erp.pulsarimagens.com.br');
	define('ERP_URL_FRAMEWORK7', 'http://www.pulsarimagens.com.br:81');
	define('SITE_URL', 'http://www.pulsarimagens.com.br');
}
/**
 * @todo End hier
 */
(new yii\web\Application($config))->run();
