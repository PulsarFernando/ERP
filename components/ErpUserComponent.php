<?php
namespace app\components;
use yii;
use yii\base\Component;
class ErpUserComponent extends Component
{
	public function startSession($objLogin)
	{
		Yii::$app->session->open();
		Yii::$app->session->set('strIdErpUser', $objLogin->INT_PK_ID_ERP_USER);
		Yii::$app->session->set('intErpRole', $objLogin->INT_FK_ERP_ROLE_ID);	
		Yii::$app->session->set('strUserName', $objLogin->STR_USER_NAME);
		Yii::$app->session->set('strLogin', $objLogin->STR_LOGIN);
		Yii::$app->session->set('strEmail', $objLogin->STR_EMAIL);
	}
	public function booSession()
	{
		if(Yii::$app->session->get('strIdErpUser'))
			return true;
		return false;
	}
	public function endSession()
	{
		Yii::$app->session->destroy();
		Yii::$app->session->close();
	}
}