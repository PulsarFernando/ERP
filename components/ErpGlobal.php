<?php
namespace app\components;	
use yii;
use yii\base\Component;
class ErpGlobal extends Component
{
	private $strPreviewImage = 'https://s3-sa-east-1.amazonaws.com/pulsar-media/fotos/previews/';
	private $strExtensionJpg = '.jpg';
	public function init()
	{
		if(!Yii::$app->erpUserComponent->booSession())
		{
			if(!(Yii::$app->request->getUrl() === '/user/login' || Yii::$app->request->getUrl() === '/'))
				Yii::$app->getResponse()->redirect('/user/login');
		}
	}
	public function getUrlPreviewImage($strFileCode)
	{
		return $this->strPreviewImage.$strFileCode.'p';
	}
	public function getExtensionJpg()
	{
		return $this->strExtensionJpg;
	}
}