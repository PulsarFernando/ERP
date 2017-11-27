<?php
namespace app\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ErpLicense;
class ErpLicenseSearch extends ErpLicense
{
    public function rules()
    {
        return [
            [['INT_PK_ID_ERP_LICENSE', 'INT_FK_ERP_CUSTOMER_ID', 'INT_FK_ERP_USER_ID', 'INT_FK_ERP_COMPANY_ID', 'BOO_COMPLETED', 'BOO_CLOSED_INVOICE'], 'integer'],
            [['STR_DESCRIPTION', 'STR_SOCIAL_REASON', 'STR_FANTASY_NAME', 'STR_STATE_REGISTRATION', 'STR_CNPJ', 'DAT_CREATION_LICENSE', 'DAT_PAYDAY', 'TST_CREATION_DATE', 'STR_INVOICE'], 'safe'],
            [['FLO_TOTAL_AMOUNT'], 'number'],
        ];
    }
    public function scenarios()
    {
        return Model::scenarios();
    }
    public function search($params)
    {
        $query = ErpLicense::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'INT_PK_ID_ERP_LICENSE' => $this->INT_PK_ID_ERP_LICENSE,
            'INT_FK_ERP_CUSTOMER_ID' => $this->INT_FK_ERP_CUSTOMER_ID,
            'INT_FK_ERP_USER_ID' => $this->INT_FK_ERP_USER_ID,
            'INT_FK_ERP_COMPANY_ID' => $this->INT_FK_ERP_COMPANY_ID,
            'FLO_TOTAL_AMOUNT' => $this->FLO_TOTAL_AMOUNT,
            'DAT_CREATION_LICENSE' => $this->DAT_CREATION_LICENSE,
            'DAT_PAYDAY' => $this->DAT_PAYDAY,
            'TST_CREATION_DATE' => $this->TST_CREATION_DATE,
            'BOO_COMPLETED' => $this->BOO_COMPLETED,
            'BOO_CLOSED_INVOICE' => $this->BOO_CLOSED_INVOICE,
        ]);
        $query->andFilterWhere(['like', 'STR_DESCRIPTION', $this->STR_DESCRIPTION])
            ->andFilterWhere(['like', 'STR_SOCIAL_REASON', $this->STR_SOCIAL_REASON])
            ->andFilterWhere(['like', 'STR_FANTASY_NAME', $this->STR_FANTASY_NAME])
            ->andFilterWhere(['like', 'STR_STATE_REGISTRATION', $this->STR_STATE_REGISTRATION])
            ->andFilterWhere(['like', 'STR_CNPJ', $this->STR_CNPJ])
            ->andFilterWhere(['like', 'STR_INVOICE', $this->STR_INVOICE]);

        return $dataProvider;
    }
}