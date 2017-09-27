<?php
namespace app\components;	
use yii;
use yii\base\Component;
class ErpGlobal extends Component
{
	public function init()
	{
		if(!Yii::$app->erpUserComponent->booSession())
		{
			if(!(Yii::$app->request->getUrl() === '/user/login' || Yii::$app->request->getUrl() === '/'))
				Yii::$app->getResponse()->redirect('/user/login');
		}
	}
}