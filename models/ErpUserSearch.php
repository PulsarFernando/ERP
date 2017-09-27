<?php
namespace app\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ErpUser;
class ErpUserSearch extends ErpUser
{
	public $erpRole;
    public function rules()
    {
        return [
            [['INT_PK_ID_ERP_USER', 'INT_FK_ERP_ROLE_ID', 'BOO_ERP_USER_STATUS'], 'integer'],
            [['STR_USER_NAME', 'STR_LOGIN', 'STR_PASSWORD', 'STR_EMAIL', 'erpRole'], 'safe'],
        ];
    }
    public function scenarios()
    {
        return Model::scenarios();
    }
    public function search($params)
    {
    	$query = ErpUser::find();
    	$query->joinWith('erpRole');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        	
        ]);
        $dataProvider->sort->attributes['erpRole'] = [
        	'asc' => ['ERP_ROLE.STR_ROLE_NAME' => SORT_ASC],
       		'desc' => ['ERP_ROLE.STR_ROLE_NAME' => SORT_DESC],
        ];
       
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'INT_PK_ID_ERP_USER' => $this->INT_PK_ID_ERP_USER,
            'INT_FK_ERP_ROLE_ID' => $this->INT_FK_ERP_ROLE_ID,
            'BOO_ERP_USER_STATUS' => $this->BOO_ERP_USER_STATUS,
        ]);
        $query->andFilterWhere(['like', 'STR_USER_NAME', $this->STR_USER_NAME])
            ->andFilterWhere(['like', 'STR_LOGIN', $this->STR_LOGIN])
            ->andFilterWhere(['like', 'STR_PASSWORD', $this->STR_PASSWORD])
            ->andFilterWhere(['like', 'STR_EMAIL', $this->STR_EMAIL])
            ->andFilterWhere(['like', 'ERP_ROLE.STR_ROLE_NAME', $this->erpRole]);
       $query->orderBy('STR_USER_NAME'); 
            
        return $dataProvider;
    }
    public function getFilter($strParam)
    {
    	return ErpUser::find()->select('*')->innerJoinWith('erpRole')->orderBy($strParam)->asArray()->all();			
    }
    public function getErpUserCountByRole($intIdRole)
    {
    	return $this->find()->where(['INT_FK_ERP_ROLE_ID' => $intIdRole])->count();
    }
}