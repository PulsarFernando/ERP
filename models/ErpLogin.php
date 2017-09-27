<?php
namespace app\models;
use Yii;
use yii\base\Model;
class ErpLogin extends Model
{
	public $strLogin;
	public $strPassword;
	public $mixLoginUser = false;
	public function rules()
	{
		return [
			[['strLogin', 'strPassword'], 'required'],
			['strPassword','validatePassword']
		];
	}
	public function validatePassword($attribute, $params)
	{
		if(!$this->hasErrors())
		{
			$objUser = $this->getUser();
			if($objUser || $objUser->validate($this->strPassword))
			{
				yii::$app->erpUserComponent->startSession($objUser);
			}
			else 
				$this->addError($attribute, 'Incorrect login or password');
		}
	}
	public function attributeLabels()
	{
		return [
			'strLogin' => 'Login',
			'strPassword' => 'Senha',
		];
	}
	public function login()
	{
		if($this->validate())
			return true;
		return false;
	}
	public function getUser()
	{
		if($this->mixLoginUser === false)
			return $this->mixLoginUser = ErpUser::findOne(['STR_LOGIN' => $this->strLogin, 'STR_PASSWORD' => $this->strPassword,'BOO_ERP_USER_STATUS' => 1]);	
		return $this->mixLoginUser;
	}
}