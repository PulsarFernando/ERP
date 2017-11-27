<?php
namespace app\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SiteFtpFile;
class SiteFtpFileSearch extends SiteFtpFile
{
	public $STR_USER_NAME;
	public $STR_FILE_CODE;
	
    public function rules()
    {
        return [
            [['INT_PK_ID_SITE_FTP_FILE', 'INT_FK_SITE_FILE_ID', 'INT_SHELF_LIFE', 'INT_FK_SITE_USER_ID', 'INT_FK_ERP_USER_ID'], 'integer'],
            [['TST_CREATION_DATE', 'STR_NOTE', 'STR_USER_NAME', 'STR_FILE_CODE'], 'safe'],
        ];
    }
    public function scenarios()
    {
        return Model::scenarios();
    }
    public function search($params)
    {
        $query = SiteFtpFile::find()->joinWith(['erpUser'])->joinWith(['siteFile'])->orderBy('TST_CREATION_DATE');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['STR_USER_NAME'] = [
        		'asc' => [ErpUser::tableName().'.STR_USER_NAME' => SORT_ASC],
        		'desc' => [ErpUser::tableName().'.STR_USER_NAME' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['STR_FILE_CODE'] = [
        		'asc' => [SiteFile::tableName().'.STR_FILE_CODE' => SORT_ASC],
        		'desc' => [SiteFile::tableName().'.STR_FILE_CODE' => SORT_DESC],
        ];
        $this->load($params);
        if (!$this->validate()) 
        {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'INT_PK_ID_SITE_FTP_FILE' => $this->INT_PK_ID_SITE_FTP_FILE,
            'INT_FK_SITE_FILE_ID' => $this->INT_FK_SITE_FILE_ID,
            'TST_CREATION_DATE' => $this->TST_CREATION_DATE,
            'INT_SHELF_LIFE' => $this->INT_SHELF_LIFE,
            'INT_FK_SITE_USER_ID' => $this->INT_FK_SITE_USER_ID,
            'INT_FK_ERP_USER_ID' => $this->INT_FK_ERP_USER_ID,
        	'STR_USER_NAME' => $this->STR_USER_NAME,
        	'STR_FILE_CODE' => $this->STR_FILE_CODE,	
        ]);
        $query->andFilterWhere(['like', 'STR_NOTE', $this->STR_NOTE]);
        return $dataProvider;
    }
}