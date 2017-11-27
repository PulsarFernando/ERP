<?php
namespace app\components;	
use yii;
use yii\base\Component;
class ErpGlobal extends Component
{
	private $strPreviewImage = 'https://s3-sa-east-1.amazonaws.com/pulsar-media/fotos/previews/';
	private $strImageHome = 'http://www.pulsarimagens.com.br/images/home/';
	protected $strExtensionJpg = '.jpg';
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
	public function getUrlImageHome($strFileCode)
	{
		return $this->strImageHome.$strFileCode;
	}
	public function getExtensionJpg()
	{
		return $this->strExtensionJpg;
	}
	
}