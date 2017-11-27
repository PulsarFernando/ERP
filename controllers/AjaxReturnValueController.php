<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\ErpPrice;
use app\components\SystemComponent;
use app\models\SiteFile;
use app\models\ErpCountry;
use app\models\ErpCity;
class AjaxReturnValueController extends Controller
{
	public function actionGetIdPrice()
	{
		$objErpPrice = new ErpPrice();
		$objSystemComponet = new SystemComponent();
		$objSystemComponet->getArrWhenDefaultValue(
			[	
				'intDescription' => '',
				'intProjectType' => '',
				'intUtilization' => '',
				'intFormat' => '',
				'intDistribution' => '',
				'intPeriodicity' => ''
			],
			Yii::$app->request->post(),
			NULL	
		);
		$objResultErpPrice = $objErpPrice->find()->where([
			'INT_FK_ERP_DESCRIPTION_ID' 	=> $objSystemComponet->getArrReturn('intDescription'),
			'INT_FK_ERP_PROJECT_TYPE_ID' 	=> $objSystemComponet->getArrReturn('intProjectType'),
			'INT_FK_ERP_DISTRIBUTION_ID'	=> $objSystemComponet->getArrReturn('intDistribution'),
			'INT_FK_ERP_UTILIZATION_ID' 	=> $objSystemComponet->getArrReturn('intUtilization'),
			'INT_FK_ERP_FORMAT_ID' 			=> $objSystemComponet->getArrReturn('intFormat'),
			'INT_FK_ERP_PERIODICITY_ID' 	=> $objSystemComponet->getArrReturn('intPeriodicity'),
			'BOO_STATUS' => 1,
		])->one();
		return $objResultErpPrice->INT_PK_ID_ERP_PRICE;
	}
	public function actionGetMutipleIdFileByStrCodeFile()
	{
		$objSystemComponet = new SystemComponent();
		$objSiteFile = new SiteFile();
		$objSystemComponet->getExplodeStringInArray(Yii::$app->request->post('strCodeFile'), ['.','/','"',':',';','|',',']);
		if(count($objSystemComponet->getArrReturn()) > 0)
		{
			$strReturn = ',';
			foreach ($objSystemComponet->getArrReturn() as $strFileCode)
			{
				$objReturnSiteFile = $objSiteFile->find()->where([
					'STR_FILE_CODE' => trim($strFileCode)
				])->one();	
				if($objReturnSiteFile->INT_PK_ID_SITE_FILE !== NULL)
					$strReturn .= ','.$objReturnSiteFile->INT_PK_ID_SITE_FILE;
				else
					return 0;
			}
			$strReturn = str_replace(',,',',', $strReturn);
			$strReturn = substr($strReturn, 1,strlen($strReturn));
			return $strReturn;
		}
		else 
			return 0;
	}
	public function actionGetNotFoundMutipleIdFileByStrCodeFile()
	{
		echo '<pre>';
		print_r(Yii::$app->request->post);
		die;
	}
	public function actionGetDdi()
	{
		$objErpCountry = new ErpCountry();
		$objReturn = $objErpCountry->getErpCountryByParam(['INT_PK_ID_ERP_COUNTRY' => Yii::$app->request->post(intId)]);
		return $objReturn->INT_DDI;
	}
	public function actionGetDdd()
	{
		$objErpCity = new ErpCity();
		$objReturn = $objErpCity->getErpCityByParam(['INT_PK_ID_ERP_CITY' => Yii::$app->request->post(intId)]);
		return $objReturn->INT_DDD;
	}
}