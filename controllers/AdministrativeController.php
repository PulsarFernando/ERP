<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;	
use app\models\ErpCustomerSearch;
use app\models\ErpCustomer;
use app\models\ErpCompany;
use app\models\ErpState;
use app\models\ErpLicenseFileSearch;
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
	public function actionErpCustomer()
	{
		$objSearchModel = new ErpCustomerSearch();
		$objDataProvider = $objSearchModel->search(Yii::$app->request->queryParams);
		return $this->render('erpCustomer', [
				'objSearchModel' => $objSearchModel,
				'objDataProvider' => $objDataProvider,
		]);
	}
	public function actionErpCustomerAdd()
	{
		$objErpCustomer = new ErpCustomer(['scenario' => ErpCustomer::SCENARIO_ERP_CUSTOMER]);
		$objErpCompany = new ErpCompany();
		if ($objErpCompany->load(Yii::$app->request->post()) && $objErpCompany->save())
		{
			
			$objErpCustomer->setAttribute('INT_FK_ERP_COMPANY_ID', $objErpCompany->getAttribute('INT_PK_ID_ERP_COMPANY'));
			$objErpCustomer->setAttribute('INT_FK_CUSTOMER_ERP_CITY_ID',Yii::$app->request->post('ErpCity'));
			$arrPost = Yii::$app->request->post('ErpCustomer');
			$objErpCustomer->setAttribute('STR_ZIP_CODE', $arrPost['STR_ZIP_CODE']);
			$objErpCustomer->setAttribute('STR_ADDRESS',$arrPost['STR_ADDRESS']);
			$objErpCustomer->setAttribute('STR_NOTE', $arrPost['STR_NOTE']);
			$objErpCustomer->setAttribute('STR_PHONE',$arrPost['STR_PHONE']);
			$objErpCustomer->setAttribute('STR_FAX', $arrPost['STR_FAX']);
			$objErpCustomer->setAttribute('BOO_REGISTRATION_FLAG_BY_ERP',1);
			if ($objErpCustomer->load(Yii::$app->request->post()) && $objErpCustomer->save())
				return $this->redirect(['erp-customer']);
		}
		else
		{
			return $this->render('erpCustomerAdd', [
					'objErpCustomer' => $objErpCustomer,
					'objErpCompany' => $objErpCompany,
			]);
		}
		
	}
	public function actionErpCustomerUpdate($id)
	{
		$objErpCustomer = $this->findModelErpCustomer($id);
		$objErpCompany = $this->findModelErpCompany($objErpCustomer->INT_FK_ERP_COMPANY_ID);
		if ($objErpCompany->load(Yii::$app->request->post()) && $objErpCompany->save())
		{
			if ($objErpCustomer->load(Yii::$app->request->post()) && $objErpCustomer->save()) 
				return $this->redirect(['erp-customer']);
		}
		else 
		{
			$erpState = new ErpState();
			$objResultState = $erpState->getStateCountryByIdCity($objErpCustomer->INT_FK_CUSTOMER_ERP_CITY_ID);
			return $this->render('erpCustomerUpdate', [
				'objErpCustomer' => $objErpCustomer,
				'objErpCompany' => $objErpCompany,
				'objResultState' => $objResultState,	
			]);
		}
	}
	public function actionErpCustomerDelete($id)
	{
		
 		$objErpCustomer = $this->findModelErpCustomer($id);
 		$this->findModelErpCustomer($id)->delete();
 		$this->findModelErpCompany($objErpCustomer->INT_FK_ERP_COMPANY_ID)->delete();
			return $this->redirect(['erp-customer']);
	}
	protected function findModelErpCustomer($id)
	{
		if (($objErpCustomer = ErpCustomer::findOne($id)) !== null)
			return $objErpCustomer;
		else
			throw new NotFoundHttpException('The requested page does not exist.');
	}
	protected function findModelErpCompany($id)
	{
		if (($objErpCompany = ErpCompany::findOne($id)) !== null)
			return $objErpCompany;
			else
				throw new NotFoundHttpException('The requested page does not exist.');
	}
	public function actionDownloadLui()
	{
		/**
		 * @todo fazer o STR_FILE_CODE vir o nome do arquivo na vir
		 * @todo fazer o order by desc 
		 * @todo trazer o resultado do que estiver finalizado
		 */
		$objSearchModel = new ErpLicenseFileSearch();
		$objDataProvider = $objSearchModel->search(Yii::$app->request->queryParams);
		return $this->render('erpDownloadLui', [
				'objSearchModel' => $objSearchModel,
				'objDataProvider' => $objDataProvider,
		]);
	}
}