<?php
$params = require(__DIR__ . '/params.php');
$config = [
    'id' => 'app-frontend',
	'name'=>'ERP Pulsar',	
    'basePath' => dirname(__DIR__),
		'bootstrap' => ['log','erpGlobal'],
	'language' => 'pt-BR',
	'sourceLanguage' => 'pt-BR',
	'timezone' => 'America/Sao_Paulo',	
	'defaultRoute' => 'user/login',
	'modules' => [
		'gridview' =>  [
			'class' => '\kartik\grid\Module'
		],
		'datecontrol' =>  [
			'class' => '\kartik\datecontrol\Module'
		]
	],
    'components' => 
	[
		//Session	
		'class' => 'yii\web\DbSession',
		//Fornatter dates, money and etc. 	
		'formatter' => [
			'dateFormat' => 'dd/MM/yyyy',
			'datetimeFormat' => 'dd/MM/yyyy HH:mm:ss',
			'decimalSeparator' => ',',
			'thousandSeparator' => '.',
			'currencyCode' => 'R$',
		],
		//Multiple message sources	
		'i18n' => [
			'translations' => [
					'*' => [
						'class' 	=> 'yii\i18n\PhpMessageSource',
						'basePath' 	=> '@app/messages',
						//'sourceLanguage' => 'pt-BR',
						'fileMap' => [
							'erp' 		=> 'erp.php',
							'erpForm' 	=> 'erpForm.php',
						],	
					]
			],	
		],
// 		'commissionComponent' => [
// 			'class' => 'app\components\CommissionComponent',	
// 		],
		'menuComponent' => [
			'class' => 'app\components\MenuComponent',	
		],	
		'mailComponent' => [
			'class' => 'app\components\MailComponent',
		],
		'erpGlobal' => [
			'class' => 'app\components\ErpGlobal',	
		],
		'erpUserComponent' => [
			'class' => 'app\components\ErpUserComponent',
		],
		'systemComponent' => [
			'class' => 'app\components\SystemComponent',
		],
        'request' => 
		[
            'cookieValidationKey' => '**pu05tt**',
        ],
        'cache' => 
		[
            'class' => 'yii\caching\FileCache',
        ],
        'user' => 
		[
            'enableAutoLogin' => true,
        ],
        'errorHandler' => 
		[
            'errorAction' => 'user/error',
        ],
        'mailer' => 
		[
			'class' => 'yii\swiftmailer\Mailer',
			'useFileTransport' => false,
			'transport' => [
				'class' => 'Swift_SmtpTransport',
				'host' => 'smtp.gmail.com',
				'username' => 'pulsar@pulsarimagens.com.br',
				'password' => '**pu05tt**',
				'port' => '465',
				'encryption' => 'ssl',
				'streamOptions' => [ 
					'ssl' => [ 
						'allow_self_signed' => true,
						'verify_peer' => false,
						'verify_peer_name' => false,
					],
				],
			],
        ],
        'log' => 
		[
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => 
			[
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'dbPulsar' => require(__DIR__ . '/dbPulsar.php'),
		'db' => require(__DIR__ . '/dbPulsar.php'),
        'urlManager' => 
		[
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
		
    ],
    'params' => $params,
];
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 
    [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 
    [
        'class' => 'yii\gii\Module',
    ];
}
return $config;