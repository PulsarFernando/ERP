<?php
namespace app\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ErpMenu;
class ErpMenuSearch extends ErpMenu
{
    public function rules()
    {
        return [
            [['INT_PK_ID_ERP_MENU', 'BOO_STATUS', 'BOO_MAIN_MENU'], 'integer'],
            [['STR_MENU_NAME', 'STR_URL'], 'safe'],
        ];
    }
    public function scenarios()
    {
        return Model::scenarios();
    }
    public function search($params)
    {
    	if(isset($params['intTypeMenu']))
    	{
    		if($params['intTypeMenu'] == 0)
    			$query = ErpMenu::find()->where(['BOO_MAIN_MENU'=>1]);
    		else	
    			$query = ErpMenu::find()->where(['BOO_MAIN_MENU'=>0]);
    	}
    	else
    		$query = ErpMenu::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        	'sort'=> ['defaultOrder' => ['STR_MENU_NAME'=>SORT_ASC]]
        ]);
        $this->load($params);
        if (!$this->validate()) 
        {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'INT_PK_ID_ERP_MENU' => $this->INT_PK_ID_ERP_MENU,
            'BOO_STATUS' => $this->BOO_STATUS,
            'BOO_MAIN_MENU' => $this->BOO_MAIN_MENU,
        ]);
        $query->andFilterWhere(['like', 'STR_MENU_NAME', $this->STR_MENU_NAME])
            ->andFilterWhere(['like', 'STR_URL', $this->STR_URL]);
        return $dataProvider;
    }
}