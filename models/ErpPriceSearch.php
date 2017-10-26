<?php
namespace app\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ErpPrice;
use yii\helpers\ArrayHelper;
class ErpPriceSearch extends ErpPrice
{
    public function rules()
    {
        return [
            [['INT_PK_ID_ERP_PRICE', 'INT_FK_ERP_PROJECT_TYPE_ID', 'INT_FK_ERP_DESCRIPTION_ID', 'INT_FK_ERP_UTILIZATION_ID', 'INT_FK_ERP_FORMAT_ID', 'INT_FK_ERP_PERIODICITY_ID', 'INT_FK_ERP_DISTRIBUTION_ID', 'BOO_STATUS', 'BOO_CURRENT_PRICE', 'BOO_PICTURE'], 'integer'],
            [['FLO_AMOUNT'], 'number'],
        ];
    }
    public function scenarios()
    {
        return Model::scenarios();
    }
    public function search($params)
    {
        $query = ErpPrice::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'INT_PK_ID_ERP_PRICE' => $this->INT_PK_ID_ERP_PRICE,
            'INT_FK_ERP_PROJECT_TYPE_ID' => $this->INT_FK_ERP_PROJECT_TYPE_ID,
            'INT_FK_ERP_DESCRIPTION_ID' => $this->INT_FK_ERP_DESCRIPTION_ID,
            'INT_FK_ERP_UTILIZATION_ID' => $this->INT_FK_ERP_UTILIZATION_ID,
            'INT_FK_ERP_FORMAT_ID' => $this->INT_FK_ERP_FORMAT_ID,
            'INT_FK_ERP_PERIODICITY_ID' => $this->INT_FK_ERP_PERIODICITY_ID,
            'INT_FK_ERP_DISTRIBUTION_ID' => $this->INT_FK_ERP_DISTRIBUTION_ID,
            'FLO_AMOUNT' => $this->FLO_AMOUNT,
            'BOO_STATUS' => $this->BOO_STATUS,
            'BOO_CURRENT_PRICE' => $this->BOO_CURRENT_PRICE,
        	'BOO_PICTURE' => $this->BOO_PICTURE,
        ]);
        return $dataProvider;
    }
    public function getPriceByFkIdAndField($arrField, $strReturnField = NULL, $booMutiple = true)
    {
    	$arrFieldValue['BOO_STATUS'] = 1;
    	foreach ($arrField as $strKey => $intValue)
    	{
    		if($strKey == 'BOO_PICTURE')
    			$arrFieldValue[$strKey] = $intValue;
    		else	
    			$arrFieldValue[$strKey] = ($intValue == 0 ? NULL : $intValue);
    	}
    	if($booMutiple)
    		return Self::find()->select($strReturnField)->where($arrFieldValue)->groupBy($strReturnField)->all();
    	else 
    		return Self::find()->select($strReturnField)->where($arrFieldValue)->groupBy($strReturnField)->one();
    }
    public function getPriceUtilization()
    {
    	return ArrayHelper::map(
    		ErpPrice::find()->joinWith(['erpDescription','erpFormat','erpDistribution','erpPeriodicity','erpUtilization','erpProjectType'])->asArray()->all(),
    		'INT_PK_ID_ERP_PRICE',
    		'erpUtilization.STR_UTILIZATION_PT'
    	);
    }
}
