<?php
namespace app\controllers;
use yii\web\Controller;
class DataMiningController extends Controller
{
	public function actionComparativeSynonym()
	{
		$this->redirect(ERP_URL_OLD."/sinonimos.php");
	}
	public function actionThemeDescriptorRelationship()
	{
		$this->redirect(ERP_URL_OLD."/temas_descritores.php");
	}
}
