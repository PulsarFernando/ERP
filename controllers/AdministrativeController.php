<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;	
class AdministrativeController extends Controller
{
	public function actionLicense()
	{
		/**
		 * @todo Se vier pelo menu apresentará uma busca por data e ou LR ou cliente
		 * @todo do controller site/actionChangeInvoiceDownload estão vindo os ids de download de cliente para a criação de uma nova invoice
		 * @todo Aqui poderão se editadas, criadas, Finalizadas e excluídas (ao excluir tem que mudar o status de invoice na tabela de download) os invoices 
		 * @todo tenho que verificar, mas acredito que ao finalizar a invoice, ela terá que ir para tabela de historico
		 */
		echo '<pre>';
		print_r(Yii::$app->request->get());
		echo '<pre>';
		exit;
	}
}