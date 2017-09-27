<?php
namespace app\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SiteDownload;
class SiteDownloadSearch extends SiteDownload
{
	public $STR_NAME;
	public $STR_FILE_CODE;
    public function rules()
    {
        return [
            [['INT_PK_ID_SITE_DOWNLOAD', 'INT_FK_ID_SITE_USER', 'INT_FK_ID_SITE_FILE', 'BOO_INVOICE', 'INT_FK_ERP_PRICE_ID', 'BOO_DOWNLOAD_SITE'], 'integer'],
            [['TST_CREATION_DATE', 'STR_IP', 'STR_NAME', 'STR_NOTE', 'STR_PROJECT_NAME', 'STR_FORMAT', 'STR_CIRCULATION', 'STR_IMPRESSION', 'STR_NAME', 'STR_FILE_CODE'], 'safe'],
        ];
    }
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    public function search($params, $mixDate = false)
    {
        $query = SiteDownload::find()
        	->joinWith('siteFile')
        	->joinWith('siteUser');
    	if($mixDate)
    	{
    		$query->where(['like', SiteDownload::tableName().'.TST_CREATION_DATE',  $mixDate]); 
    	}
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['STR_NAME'] = [
        		'asc' => [SiteUser::tableName().'.STR_NAME' => SORT_ASC],
        		'desc' => [SiteUser::tableName().'.STR_NAME' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['STR_FILE_CODE'] = [
        		'asc' => [SiteFile::tableName().'.STR_FILE_CODE' => SORT_ASC],
        		'desc' => [SiteFile::tableName().'.STR_FILE_CODE' => SORT_DESC],
        ];
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'INT_PK_ID_SITE_DOWNLOAD' => $this->INT_PK_ID_SITE_DOWNLOAD,
            'INT_FK_ID_SITE_USER' => $this->INT_FK_ID_SITE_USER,
            'INT_FK_ID_SITE_FILE' => $this->INT_FK_ID_SITE_FILE,
            //SiteDownload::tableName().'.TST_CREATION_DATE' => $this->TST_CREATION_DATE,
            'BOO_INVOICE' => $this->BOO_INVOICE,
            'INT_FK_ERP_PRICE_ID' => $this->INT_FK_ERP_PRICE_ID,
            'BOO_DOWNLOAD_SITE' => $this->BOO_DOWNLOAD_SITE,
        	SiteFile::tableName().'.STR_FILE_CODE' => $this->STR_FILE_CODE,
        	SiteUser::tableName().'.STR_NAME' => $this->STR_NAME,
        ]);
        $query->orderBy(SiteUser::tableName().'.STR_NAME ASC');
        $query->andFilterWhere(['like', 'STR_IP', $this->STR_IP])
            ->andFilterWhere(['like', 'STR_NOTE', $this->STR_NOTE])
            ->andFilterWhere(['like', 'STR_PROJECT_NAME', $this->STR_PROJECT_NAME])
            ->andFilterWhere(['like', 'STR_FORMAT', $this->STR_FORMAT])
            ->andFilterWhere(['like', 'STR_CIRCULATION', $this->STR_CIRCULATION])
            ->andFilterWhere(['like', 'STR_IMPRESSION', $this->STR_IMPRESSION])
            ->andFilterWhere(['like', SiteFile::tableName().'.STR_FILE_CODE', $this->STR_FILE_CODE])
            ->andFilterWhere(['like', SiteUser::tableName().'.STR_NAME', $this->STR_NAME]);
        return $dataProvider;
    }
}
