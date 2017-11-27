<?php
namespace app\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ErpLicenseFile;
class ErpLicenseFileSearch extends ErpLicenseFile
{
    public function rules()
    {
        return [
            [['INT_PK_ID_ERP_LICENSE_FILE', 'INT_FK_ERP_LICENSE_ID', 'INT_FK_ERP_PRICE_ID', 'BOO_FINISHED', 'BOO_REUSE'], 'integer'],
            [['STR_FILE_CODE', 'STR_SUBJECT', 'STR_AUTHOR', 'STR_AUTHOR_ACRONYM'], 'safe'],
            [['FLO_AMOUNT_FILE', 'FLO_DISCOUNT', 'FLO_AMOUNT_FINAL'], 'number'],
        ];
    }
    public function scenarios()
    {
        return Model::scenarios();
    }
    public function search($params)
    {
        $query = ErpLicenseFile::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        		
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'INT_PK_ID_ERP_LICENSE_FILE' => $this->INT_PK_ID_ERP_LICENSE_FILE,
            'INT_FK_ERP_LICENSE_ID' => $this->INT_FK_ERP_LICENSE_ID,
            'INT_FK_ERP_PRICE_ID' => $this->INT_FK_ERP_PRICE_ID,
            'FLO_AMOUNT_FILE' => $this->FLO_AMOUNT_FILE,
            'FLO_DISCOUNT' => $this->FLO_DISCOUNT,
            'FLO_AMOUNT_FINAL' => $this->FLO_AMOUNT_FINAL,
            'BOO_FINISHED' => $this->BOO_FINISHED,
            'BOO_REUSE' => $this->BOO_REUSE,
        ]);
        $query->andFilterWhere(['like', 'STR_FILE_CODE', $this->STR_FILE_CODE])
            ->andFilterWhere(['like', 'STR_SUBJECT', $this->STR_SUBJECT])
            ->andFilterWhere(['like', 'STR_AUTHOR', $this->STR_AUTHOR])
            ->andFilterWhere(['like', 'STR_AUTHOR_ACRONYM', $this->STR_AUTHOR_ACRONYM]);

        return $dataProvider;
    }
}
