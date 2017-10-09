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
}
