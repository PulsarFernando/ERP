<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SiteQuoteSent;
use app\components\SystemComponent;
class SiteQuoteSentSearch extends SiteQuoteSent
{
	public $STR_NAME;
	public $STR_USER_NAME;
	public $STR_EMAIL;
    public function rules()
    {
        return [
            [['INT_PK_ID_SITE_QUOTE_SENT', 'INT_FK_SITE_USER_ID', 'INT_FK_ERP_USER_ID', 'BOO_ATTENDED'], 'integer'],
            [['TST_LAST_ACESS', 'STR_CUSTOMER_MESSAGE', 'STR_SERVICE_DATE', 'STR_PULSAR_MESSAGE', 'STR_NAME', 'STR_USER_NAME','STR_EMAIL'], 'safe'],
        ];
    }
    public function scenarios()
    {
        return Model::scenarios();
    }
    public function search($params)
    {
        $query = SiteQuoteSent::find()->joinWith('erpUser')->joinWith('siteUser');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['STR_NAME'] = [
        	'asc' => [SiteUser::tableName().'.STR_NAME' => SORT_ASC],
        	'desc' => [SiteUser::tableName().'.STR_NAME' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['STR_USER_NAME'] = [
        	'asc' => [ErpUser::tableName().'.STR_USER_NAME' => SORT_ASC],
        	'desc' => [ErpUser::tableName().'.STR_USER_NAME' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['STR_EMAIL'] = [
        	'asc' => [ErpUser::tableName().'.STR_EMAIL' => SORT_ASC],
        	'desc' => [ErpUser::tableName().'STR_EMAIL' => SORT_DESC],	
        ];
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'INT_PK_ID_SITE_QUOTE_SENT' => $this->INT_PK_ID_SITE_QUOTE_SENT,
            'INT_FK_SITE_USER_ID' => $this->INT_FK_SITE_USER_ID,
            'INT_FK_ERP_USER_ID' => $this->INT_FK_ERP_USER_ID,
            'BOO_ATTENDED' => $this->BOO_ATTENDED,
        ]);
        $query->andFilterWhere(['like', 'STR_CUSTOMER_MESSAGE', $this->STR_CUSTOMER_MESSAGE])
        	->andFilterWhere(['like', SiteQuoteSent::tableName().'.TST_LAST_ACESS', $this->TST_LAST_ACESS])
        	->andFilterWhere(['like', SiteQuoteSent::tableName().'.STR_SERVICE_DATE', $this->STR_SERVICE_DATE])
        	->andFilterWhere(['like', 'STR_PULSAR_MESSAGE', $this->STR_PULSAR_MESSAGE])
        	->andFilterWhere(['like', SiteUser::tableName().'.STR_NAME', $this->STR_NAME])
        	->andFilterWhere(['like', ErpUser::tableName().'.STR_USER_NAME', $this->STR_USER_NAME])
        	->andFilterWhere(['like', ErpUser::tableName().'.STR_EMAIL', $this->STR_EMAIL])
        ;
        return $dataProvider;
    }
    public function getAllSiteQuoteSentByParam($arrParam)
    {
    	return $this->find()->joinWith('erpUser')->joinWith('siteUser')->where($arrParam)->all();
    }
    public function getOneSiteQuoteSentByParam($arrParam)
    {
    	return $this->find()->joinWith('erpUser')->joinWith('siteUser')->where($arrParam)->one();
    }
}