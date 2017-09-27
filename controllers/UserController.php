<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;	
use app\models\ErpLogin;
class UserController extends Controller
{
	public function actionLogin()
	{
		$objModelErpLogin = new ErpLogin();
		if(Yii::$app->erpUserComponent->booSession())
			$this->redirect(['user/dashboard']);
		if($objModelErpLogin->load(Yii::$app->request->post()) && $objModelErpLogin->login())
			$this->redirect(['user/dashboard']);
		return $this->render(
			'login',
			[
				'objModelErpLogin' => $objModelErpLogin,			
			]
		);
	}	
	public function actionDashboard()
	{
		echo Yii::$app->session->get('intErpRole');
		
		return $this->render(
			'dashboard',
			[]
		);
	}
	public function actionLogout()
	{
		yii::$app->erpUserComponent->endSession();
		$this->redirect(['user/login']);
	}
}