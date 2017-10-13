<?php
namespace app\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SiteDownload;
class SiteDownloadSearch extends SiteDownload
{
	public $STR_NAME;
	public $STR_FILE_CODE;
	public $INT_FK_ERP_AUTHOR_ID;
	public $STR_MAIN_SUBJECT_PT;
    public function rules()
    {
        return [
            [['INT_PK_ID_SITE_DOWNLOAD', 'INT_FK_ID_SITE_USER', 'INT_FK_ID_SITE_FILE', 'BOO_INVOICE', 'INT_FK_ERP_PRICE_ID', 'BOO_DOWNLOAD_SITE', 'INT_FK_ERP_AUTHOR_ID'], 'integer'],
            [['TST_CREATION_DATE', 'STR_IP', 'STR_NAME', 'STR_NOTE', 'STR_PROJECT_NAME', 'STR_FORMAT', 'STR_CIRCULATION', 'STR_IMPRESSION', 'STR_NAME', 'STR_FILE_CODE', 'INT_FK_ERP_AUTHOR_ID', 'STR_MAIN_SUBJECT_PT'], 'safe'],
        ];
    }
    public function scenarios()
    {
        return Model::scenarios();
    }
    public function search($params)
    {
    	$query = SiteDownload::find()->joinWith('siteFile');
    	if(isset($params['intUserId']))
    		$query->where(['INT_FK_ID_SITE_USER' => $params['intUserId']]);
    	$dataProvider = new ActiveDataProvider([
    			'query' => $query,
    	]);
    	$dataProvider->sort->attributes['STR_FILE_CODE'] = [
    			'asc' => [SiteFile::tableName().'.STR_FILE_CODE' => SORT_ASC],
    			'desc' => [SiteFile::tableName().'.STR_FILE_CODE' => SORT_DESC],
    	];
    	$dataProvider->sort->attributes['INT_FK_ERP_AUTHOR_ID'] = [
    			'asc' => [SiteFile::tableName().'.INT_FK_ERP_AUTHOR_ID' => SORT_ASC],
    			'desc' => [SiteFile::tableName().'.INT_FK_ERP_AUTHOR_ID' => SORT_DESC],
    	];
    	$dataProvider->sort->attributes['STR_MAIN_SUBJECT_PT'] = [
    			'asc' => [SiteFile::tableName().'.STR_MAIN_SUBJECT_PT' => SORT_ASC],
    			'desc' => [SiteFile::tableName().'.STR_MAIN_SUBJECT_PT' => SORT_DESC],
    	];
    	$this->load($params);
    	if (!$this->validate()) 
    	{
    		return $dataProvider;
    	}
    	$query->andFilterWhere([
    		'INT_PK_ID_SITE_DOWNLOAD' => $this->INT_PK_ID_SITE_DOWNLOAD,
    		'INT_FK_ID_SITE_USER' => $this->INT_FK_ID_SITE_USER,
    		'INT_FK_ID_SITE_FILE' => $this->INT_FK_ID_SITE_FILE,
    		'TST_CREATION_DATE' => $this->TST_CREATION_DATE,
    		'BOO_INVOICE' => $this->BOO_INVOICE,
    		'INT_FK_ERP_PRICE_ID' => $this->INT_FK_ERP_PRICE_ID,
    		'BOO_DOWNLOAD_SITE' => $this->BOO_DOWNLOAD_SITE,
    		'STR_FILE_CODE' => $this->STR_FILE_CODE,	
    		'INT_FK_ERP_AUTHOR_ID' => $this->INT_FK_ERP_AUTHOR_ID,	
    		'STR_MAIN_SUBJECT_PT' => $this->STR_MAIN_SUBJECT_PT	
    	]);
    	$query->andFilterWhere(['like', 'STR_IP', $this->STR_IP])
	    	->andFilterWhere(['like', 'STR_NAME', $this->STR_NAME])
	    	->andFilterWhere(['like', 'STR_NOTE', $this->STR_NOTE])
	    	->andFilterWhere(['like', 'STR_PROJECT_NAME', $this->STR_PROJECT_NAME])
	    	->andFilterWhere(['like', 'STR_FORMAT', $this->STR_FORMAT])
	    	->andFilterWhere(['like', 'STR_CIRCULATION', $this->STR_CIRCULATION])
	    	->andFilterWhere(['like', 'STR_IMPRESSION', $this->STR_IMPRESSION])
    		->andFilterWhere(['like', SiteFile::tableName().'.STR_FILE_CODE', $this->STR_FILE_CODE])
    		->andFilterWhere(['like', SiteFile::tableName().'.INT_FK_ERP_AUTHOR_ID', $this->INT_FK_ERP_AUTHOR_ID])
    		->andFilterWhere(['like', SiteFile::tableName().'.STR_MAIN_SUBJECT_PT', $this->STR_MAIN_SUBJECT_PT])
    	;
    	return $dataProvider;
    }
}
