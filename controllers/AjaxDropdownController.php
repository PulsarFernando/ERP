<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use app\models\ErpUtilization;
use app\models\ErpPriceSearch;
use app\models\ErpProjectType;
use app\models\ErpFormat;
use app\models\ErpDistribution;
use app\models\ErpPeriodicity;
use app\models\ErpDescription;
use app\models\ErpState;
use app\models\ErpCity;
use yii\helpers\Json;
class AjaxDropdownController extends Controller
{
	public function actionGetProjectType()
	{
		$objErpProjectType = new ErpProjectType();
		if(!Yii::$app->request->post('booIsPicture'))
			$strFieldFor = 'BOO_FOR_VIDEO';
		else 
			$strFieldFor = 'BOO_FOR_PICTURE';
		return $this->renderAjax('getDropdownForErp',
			[
				'strClassName' => Yii::$app->request->post('strClassName'),
				'strIdName' => Yii::$app->request->post('strIdName'),
				'strFieldName' => Yii::$app->request->post('strFieldName'),
				'strMessageTranslate' => Yii::$app->request->post('strMessageTranslate'),
				'strLabelName' => Yii::$app->request->post('strLabelName'),
				'strLabelClass' => Yii::$app->request->post('strLabelClass'),
				'arrDropdown' => $this->getArrDropdown(ArrayHelper::map($objErpProjectType->find()->where([$strFieldFor => 1, 'BOO_STATUS' => '1',])->orderBy('STR_PROJECT_TYPE_PT')->all(),'INT_PK_ID_PROJECT_TYPE','STR_PROJECT_TYPE_PT'))
			]		
		);
	}
	public function actionGetUtilization()
	{
		$objErpPriceSearch = new ErpPriceSearch();
		$objErpUtilization = new ErpUtilization();
		$objErpPrice = $objErpPriceSearch->getPriceByFkIdAndField( [ 'BOO_PICTURE' => Yii::$app->request->post('booIsPicture'), 'BOO_STATUS' => '1', 'INT_FK_ERP_PROJECT_TYPE_ID' => Yii::$app->request->post('intProjectType'), ],  'INT_FK_ERP_UTILIZATION_ID');
		foreach ($objErpPrice as $objLine)
			$arrFkErpUtilizationId[$objLine->INT_FK_ERP_UTILIZATION_ID] = $objLine->INT_FK_ERP_UTILIZATION_ID;
		return $this->renderAjax('getDropdownForErp',
			[
				'strClassName' => Yii::$app->request->post('strClassName'),
				'strIdName' => Yii::$app->request->post('strIdName'),
				'strFieldName' => Yii::$app->request->post('strFieldName'),
				'strMessageTranslate' => Yii::$app->request->post('strMessageTranslate'),
				'strLabelName' => Yii::$app->request->post('strLabelName'),
				'strLabelClass' => Yii::$app->request->post('strLabelClass'),
				'arrDropdown' => $this->getArrDropdown(ArrayHelper::map($objErpUtilization->find()->where(['IN','INT_PK_ID_ERP_UTILIZATION',$arrFkErpUtilizationId])->orderBy('STR_UTILIZATION_PT')->all(),'INT_PK_ID_ERP_UTILIZATION','STR_UTILIZATION_PT')),
			]
		);
	}
	public function actionGetFormat()
	{
		$objErpPriceSearch = new ErpPriceSearch();
		$objFormat = new ErpFormat();
		$objErpPrice = $objErpPriceSearch->getPriceByFkIdAndField(['BOO_PICTURE' =>Yii::$app->request->post('booIsPicture'),'BOO_STATUS' => '1','INT_FK_ERP_PROJECT_TYPE_ID' => Yii::$app->request->post('intProjectType'), 'INT_FK_ERP_UTILIZATION_ID' => Yii::$app->request->post('intUtilization')], 'INT_FK_ERP_FORMAT_ID');

		foreach ($objErpPrice as $objLine)
			$arrFkErpFormatId[$objLine->INT_FK_ERP_FORMAT_ID] = $objLine->INT_FK_ERP_FORMAT_ID;		
		return $this->renderAjax('getDropdownForErp',
			[
				'strClassName' => Yii::$app->request->post('strClassName'),
				'strIdName' => Yii::$app->request->post('strIdName'),
				'strFieldName' => Yii::$app->request->post('strFieldName'),
				'strMessageTranslate' => Yii::$app->request->post('strMessageTranslate'),
				'strLabelName' => Yii::$app->request->post('strLabelName'),
				'strLabelClass' => Yii::$app->request->post('strLabelClass'),
				'arrDropdown' => $this->getArrDropdown(ArrayHelper::map($objFormat->find()->where(['IN','INT_PK_ID_ERP_FORMAT',$arrFkErpFormatId])->orderBy('STR_FORMAT_PT')->all(),'INT_PK_ID_ERP_FORMAT','STR_FORMAT_PT')),
			]
		);
	}
	public function actionGetDistribution()
	{
		$objErpPriceSearch = new ErpPriceSearch();
		$objErpDistribution = new ErpDistribution();
		$mixProjectType = (Yii::$app->request->post('intProjectType') == 0 ? NULL : Yii::$app->request->post('intProjectType'));
		$mixUtilization = (Yii::$app->request->post('intUtilization') == 0 ? NULL : Yii::$app->request->post('intUtilization'));
		$mixFormat = (Yii::$app->request->post('intFormat') == 0 ? NULL : Yii::$app->request->post('intFormat'));
		$objErpPrice = $objErpPriceSearch->getPriceByFkIdAndField(['BOO_PICTURE' =>Yii::$app->request->post('booIsPicture'),'BOO_STATUS' => '1','INT_FK_ERP_PROJECT_TYPE_ID' => $mixProjectType, 'INT_FK_ERP_UTILIZATION_ID' => $mixUtilization, 'INT_FK_ERP_FORMAT_ID' => $mixFormat], 'INT_FK_ERP_DISTRIBUTION_ID');
		foreach ($objErpPrice as $objLine)
			$arrFkErpDistributionId[$objLine->INT_FK_ERP_DISTRIBUTION_ID] = $objLine->INT_FK_ERP_DISTRIBUTION_ID;
		return $this->renderAjax('getDropdownForErp',
			[
				'strClassName' => Yii::$app->request->post('strClassName'),
				'strIdName' => Yii::$app->request->post('strIdName'),
				'strFieldName' => Yii::$app->request->post('strFieldName'),
				'strMessageTranslate' => Yii::$app->request->post('strMessageTranslate'),
				'strLabelName' => Yii::$app->request->post('strLabelName'),
				'strLabelClass' => Yii::$app->request->post('strLabelClass'),
				'arrDropdown' => $this->getArrDropdown(ArrayHelper::map($objErpDistribution->find()->where(['IN','INT_PK_ID_ERP_DISTRIBUTION',$arrFkErpDistributionId])->orderBy('STR_DISTRIBUTION_PT')->all(),'INT_PK_ID_ERP_DISTRIBUTION','STR_DISTRIBUTION_PT')),
			]
		);
	}
	public function actionGetPeriodicity()
	{
		$objErpPriceSearch = new ErpPriceSearch();
		$objErpPeriodicity = new ErpPeriodicity();
		$mixProjectType = (Yii::$app->request->post('intProjectType') == 0 ? NULL : Yii::$app->request->post('intProjectType'));
		$mixUtilization = (Yii::$app->request->post('intUtilization') == 0 ? NULL : Yii::$app->request->post('intUtilization'));
		$mixFormat = (Yii::$app->request->post('intFormat') == 0 ? NULL : Yii::$app->request->post('intFormat'));
		$objErpPrice = $objErpPriceSearch->getPriceByFkIdAndField(['BOO_PICTURE' =>Yii::$app->request->post('booIsPicture'),'BOO_STATUS' => '1','INT_FK_ERP_PROJECT_TYPE_ID' => $mixProjectType, 'INT_FK_ERP_UTILIZATION_ID' => $mixUtilization, 'INT_FK_ERP_FORMAT_ID' => $mixFormat, 'INT_FK_ERP_DISTRIBUTION_ID' => Yii::$app->request->post('intDistribution')], 'INT_FK_ERP_PERIODICITY_ID');
		foreach ($objErpPrice as $objLine)
			$arrFkErpPeriodicityId[$objLine->INT_FK_ERP_PERIODICITY_ID] = $objLine->INT_FK_ERP_PERIODICITY_ID;
		return $this->renderAjax('getDropdownForErp',
			[
				'strClassName' => Yii::$app->request->post('strClassName'),
				'strIdName' => Yii::$app->request->post('strIdName'),
				'strFieldName' => Yii::$app->request->post('strFieldName'),
				'strMessageTranslate' => Yii::$app->request->post('strMessageTranslate'),
				'strLabelName' => Yii::$app->request->post('strLabelName'),
				'strLabelClass' => Yii::$app->request->post('strLabelClass'),
				'arrDropdown' => $this->getArrDropdown(ArrayHelper::map($objErpPeriodicity->find()->where(['IN','INT_PK_ID_ERP_PERIODICITY',$arrFkErpPeriodicityId])->orderBy('STR_PERIODICITY_PT')->all(),'INT_PK_ID_ERP_PERIODICITY','STR_PERIODICITY_PT')),
			]
		);
	}
	public function actionGetDescription()
	{
		$objErpPriceSearch = new ErpPriceSearch();
		$objErpDescription = new ErpDescription();
		$objErpPrice = $objErpPriceSearch->getPriceByFkIdAndField(['BOO_PICTURE' =>Yii::$app->request->post('booIsPicture'),'BOO_STATUS' => '1','INT_FK_ERP_PROJECT_TYPE_ID' => Yii::$app->request->post('intProjectType'), 'INT_FK_ERP_UTILIZATION_ID' => Yii::$app->request->post('intUtilization'), 'INT_FK_ERP_FORMAT_ID' => Yii::$app->request->post('intFormat'), 'INT_FK_ERP_DISTRIBUTION_ID' => Yii::$app->request->post('intDistribution')], 'INT_FK_ERP_DESCRIPTION_ID');
 		foreach ($objErpPrice as $objLine)
 			$arrFkErpDescriptionId[$objLine->INT_FK_ERP_DESCRIPTION_ID] = $objLine->INT_FK_ERP_DESCRIPTION_ID;
 		return $this->renderAjax('getDropdownForErp',
			[
				'strClassName' => Yii::$app->request->post('strClassName'),
				'strIdName' => Yii::$app->request->post('strIdName'),
				'strFieldName' => Yii::$app->request->post('strFieldName'),
				'strMessageTranslate' => Yii::$app->request->post('strMessageTranslate'),
				'strLabelName' => Yii::$app->request->post('strLabelName'),
				'strLabelClass' => Yii::$app->request->post('strLabelClass'),
				'arrDropdown' => $this->getArrDropdown(ArrayHelper::map($objErpDescription->find()->where(['IN','INT_PK_ID_ERP_DESCRIPTION', $arrFkErpDescriptionId])->orderBy('STR_DESCRIPTION_PT')->all(),'INT_PK_ID_ERP_DESCRIPTION','STR_DESCRIPTION_PT')),
			]
		);
	}
	public function actionGetShelfLife()
	{
		$arrShelfLife = [
				'7' => 'Validade de 1 semana', '14' => 'Validade de 2 semanas',	
				'21' => 'Validade de 3 semanas', '30' => 'Validade de 1 mês',
				'60' => 'Validade de 2 meses', '90' => 'Validade de 3 meses',
		];
		if(Yii::$app->request->post('intSelected'))
			$intSelected = Yii::$app->request->post('intSelected');
		else 
			$intSelected = 0;
		return $this->renderAjax('getDropdownForErp',
		[
				'strClassName' => Yii::$app->request->post('strClassName'),
				'strIdName' => Yii::$app->request->post('strIdName'),
				'strFieldName' => Yii::$app->request->post('strFieldName'),
				'strMessageTranslate' => Yii::$app->request->post('strMessageTranslate'),
				'strLabelName' => Yii::$app->request->post('strLabelName'),
				'strLabelClass' => Yii::$app->request->post('strLabelClass'),
				'intSelected' => $intSelected,
				'arrDropdown' => $this->getArrDropdown($arrShelfLife),
		]);
	}
	public function actionGetState()
	{
		$arrReturn = [];
		$strParents = Yii::$app->request->post('depdrop_parents');
		if ($strParents != null) 
		{
			$intIdState = $strParents[0];
			foreach (ErpState::getErpState(['INT_FK_ERP_COUNTRY_ID' => $intIdState]) as $intKey =>$strValue)
				$arrReturn[$intKey] = ['id' => $intKey, 'name' => $strValue];
			echo Json::encode(['output'=>$arrReturn, 'selected'=>'']);
			return;
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}
	public function actionGetCity()
	{
		$arrReturn = [];
		$strParents = Yii::$app->request->post('depdrop_parents');
		if ($strParents != null)
		{
			$intIdCountry = $strParents[0];
			foreach (ErpCity::getErpCityByFkStateId($intIdCountry) as $intKey =>$strValue)
				$arrReturn[$intKey] = ['id' => $intKey, 'name' => $strValue];
			echo Json::encode(['output'=>$arrReturn, 'selected'=>'']);
			return;
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}
	private function getArrDropdown($arrDb)
	{
		$arrDb[0] = 'Selecione';
		$arrDropdown = $arrDb;
		return $arrDropdown;
	}
}