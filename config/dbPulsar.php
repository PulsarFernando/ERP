<?php
return [
   	'class' => 'yii\db\Connection',
    /* localhost */
    'dsn' => 'mysql:host=localhost;dbname=DB_PULSAR',
    'username' => 'root',
    'password' => 'root',
	/* dev */
// 	'dsn' => 'mysql:host=pulsar-dev.cgtvqlyxved2.sa-east-1.rds.amazonaws.com;dbname=db_pulsar',
// 	'username' => 'pulsaraws',
// 	'password' => 'v41qv412012',
	/* */
	/* prod */
// 	'dsn' => 'mysql:host=pulsar-innodb.cgtvqlyxved2.sa-east-1.rds.amazonaws.com;dbname=db_pulsar',
// 	'username' => 'pulsaraws',
// 	'password' => 'v41qv412012',
	/* */
    'charset' => 'utf8',
];
