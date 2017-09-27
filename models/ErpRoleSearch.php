<?php
namespace app\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ErpRole;
class ErpRoleSearch extends ErpRole
{
    public function rules()
    {
        return [
            [['INT_PK_ID_ERP_ROLE', 'BOO_STATUS'], 'integer'],
            [['STR_ROLE_NAME', 'TST_CREATION_DATE'], 'safe'],
        ];
    }
    public function scenarios()
    {
        return Model::scenarios();
    }
    public function search($params)
    {
        $query = ErpRole::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'INT_PK_ID_ERP_ROLE' => $this->INT_PK_ID_ERP_ROLE,
            'TST_CREATION_DATE' => $this->TST_CREATION_DATE,
            'BOO_STATUS' => $this->BOO_STATUS,
        ]);
        $query->andFilterWhere(['like', 'STR_ROLE_NAME', $this->STR_ROLE_NAME]);
        return $dataProvider;
    }
    public function getFilter($strParam)
    {
    	return ErpRole::find()->select('*')->orderBy($strParam)->asArray()->all();
    }
    public function updateStatusRole($intIdRole, $booStatus)
    {
    	$this->updateAll(['BOO_STATUS' => $booStatus], ['INT_PK_ID_ERP_ROLE' => $intIdRole]);
    }
}