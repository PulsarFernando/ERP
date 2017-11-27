<?php
namespace app\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ErpCustomer;
use app\components\SystemComponent;
class ErpCustomerSearch extends ErpCustomer
{
	public $STR_CNPJ;
	public $STR_SOCIAL_REASON;
	public $STR_FANTASY_NAME;
    public function rules()
    {
        return [
            [['INT_PK_ID_ERP_CUSTOMER', 'INT_FK_CUSTOMER_ERP_CITY_ID', 'INT_FK_ERP_COMPANY_ID', 'BOO_STATUS'], 'integer'],
            [['STR_ADDRESS', 'STR_ZIP_CODE', 'STR_DDI_PHONE', 'STR_DDD_PHONE', 'STR_PHONE', 'STR_DDI_FAX', 'STR_DDD_FAX', 'STR_FAX', 'TST_CREATION_DATE', 'STR_NOTE', 'BOO_REGISTRATION_FLAG_BY_ERP','STR_CNPJ','STR_SOCIAL_REASON','STR_FANTASY_NAME'], 'safe'],
            [['FLO_DISCOUNT_VALUE', 'FLO_DISCOUNT_PERCENTAGE'], 'number'],
        ];
    }
    public function scenarios()
    {
        return Model::scenarios();
    }
    public function search($params)
    {
        $query = ErpCustomer::find()->joinWith(['erpCompany']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        	'sort' => ['defaultOrder' => [
        			'STR_SOCIAL_REASON' => SORT_ASC
        		]	
        	]	
        ]);
        $dataProvider->sort->attributes['STR_CNPJ'] = [
        	'asc' => [ErpCompany::tableName().'.STR_CNPJ' => SORT_ASC],
        	'desc' => [ErpCompany::tableName().'.STR_CNPJ' => SORT_DESC]	
        ];
        $dataProvider->sort->attributes['STR_SOCIAL_REASON'] = [
        	'asc' => [ErpCompany::tableName().'.STR_SOCIAL_REASON' => SORT_ASC],
        	'desc' => [ErpCompany::tableName().'.STR_SOCIAL_REASON' => SORT_DESC]
        ];
        $dataProvider->sort->attributes['STR_FANTASY_NAME'] = [
        	'asc' => [ErpCompany::tableName().'.STR_FANTASY_NAME' => SORT_ASC],
        	'desc' => [ErpCompany::tableName().'.STR_FANTASY_NAME' => SORT_DESC]
        ];
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'INT_PK_ID_ERP_CUSTOMER' => $this->INT_PK_ID_ERP_CUSTOMER,
            'INT_FK_CUSTOMER_ERP_CITY_ID' => $this->INT_FK_CUSTOMER_ERP_CITY_ID,
            'INT_FK_ERP_COMPANY_ID' => $this->INT_FK_ERP_COMPANY_ID,
            'BOO_STATUS' => $this->BOO_STATUS,
            'FLO_DISCOUNT_VALUE' => $this->FLO_DISCOUNT_VALUE,
            'FLO_DISCOUNT_PERCENTAGE' => $this->FLO_DISCOUNT_PERCENTAGE,
        	'STR_CNPJ' => $this->STR_CNPJ,
        	'STR_SOCIAL_REASON' => $this->STR_SOCIAL_REASON,
        	'STR_FANTASY_NAME' => $this->STR_FANTASY_NAME,	
        ]);
        $query->andFilterWhere(['like', 'STR_ADDRESS', $this->STR_ADDRESS])
            ->andFilterWhere(['like', 'STR_ZIP_CODE', $this->STR_ZIP_CODE])
            ->andFilterWhere(['like', 'STR_DDI_PHONE', $this->STR_DDI_PHONE])
            ->andFilterWhere(['like', 'STR_DDD_PHONE', $this->STR_DDD_PHONE])
            ->andFilterWhere(['like', 'STR_PHONE', $this->STR_PHONE])
            ->andFilterWhere(['like', 'STR_DDI_FAX', $this->STR_DDI_FAX])
            ->andFilterWhere(['like', 'STR_DDD_FAX', $this->STR_DDD_FAX])
            ->andFilterWhere(['like', 'STR_FAX', $this->STR_FAX])
            ->andFilterWhere(['like', 'TST_CREATION_DATE', ($this->TST_CREATION_DATE == '' ? '' : SystemComponent::getDateForDb($this->TST_CREATION_DATE))])
            ->andFilterWhere(['like', 'STR_NOTE', $this->STR_NOTE])
            ->andFilterWhere(['like', 'BOO_REGISTRATION_FLAG_BY_ERP', $this->BOO_REGISTRATION_FLAG_BY_ERP])
        	->andFilterWhere(['like', ErpCompany::tableName().'.STR_CNPJ', $this->STR_CNPJ])
        	->andFilterWhere(['like', ErpCompany::tableName().'.STR_SOCIAL_REASON', $this->STR_SOCIAL_REASON])
        	->andFilterWhere(['like', ErpCompany::tableName().'.STR_FANTASY_NAME', $this->STR_FANTASY_NAME]);
        return $dataProvider;
    }
}
