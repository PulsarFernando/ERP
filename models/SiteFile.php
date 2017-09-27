<?php
namespace app\models;
use Yii;
use yii\db\ActiveRecord;
class SiteFile extends ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_FILE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_PK_ID_SITE_FILE', 'INT_FK_ERP_TYPE_FILE_ID', 'INT_FK_ERP_AUTHOR_ID', 'INT_FK_SITE_ORIENTATION_FILE_ID', 'INT_FK_SITE_IMAGE_RIGHT_ID', 'STR_FILE_CODE', 'STR_MAIN_SUBJECT_PT', 'STR_EXTRA_SUBJECT_PT', 'INT_FILE_DATE'], 'required'],
            [['INT_PK_ID_SITE_FILE', 'INT_FK_ERP_TYPE_FILE_ID', 'INT_FK_ERP_AUTHOR_ID', 'INT_FK_ERP_CITY_ID', 'INT_FK_SITE_ORIENTATION_FILE_ID', 'INT_FK_SITE_IMAGE_RIGHT_ID', 'INT_FILE_DATE', 'INT_HORIZANTAL_SIZE', 'INT_VERTICAL_SIZE'], 'integer'],
            [['STR_EXTRA_SUBJECT_PT', 'STR_EXTRA_SUBJECT_EN'], 'string'],
            [['TST_CREATION_DATE'], 'safe'],
            [['STR_FILE_CODE'], 'string', 'max' => 10],
            [['STR_MAIN_SUBJECT_PT', 'STR_MAIN_SUBJECT_EN'], 'string', 'max' => 150],
            [['INT_PK_ID_SITE_FILE'], 'unique'],
            [['INT_FK_ERP_AUTHOR_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpAuthor::className(), 'targetAttribute' => ['INT_FK_ERP_AUTHOR_ID' => 'INT_PK_ID_SITE_AUTHOR']],
            [['INT_FK_ERP_CITY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpCity::className(), 'targetAttribute' => ['INT_FK_ERP_CITY_ID' => 'INT_PK_ID_ERP_CITY']],
            [['INT_FK_ERP_TYPE_FILE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpTypeFile::className(), 'targetAttribute' => ['INT_FK_ERP_TYPE_FILE_ID' => 'INT_PK_ID_ERP_TYPE_FILE']],
            [['INT_FK_SITE_IMAGE_RIGHT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteImageRight::className(), 'targetAttribute' => ['INT_FK_SITE_IMAGE_RIGHT_ID' => 'INT_PK_ID_SITE_IMAGE_RIGHT']],
            [['INT_FK_SITE_ORIENTATION_FILE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteOrientationFile::className(), 'targetAttribute' => ['INT_FK_SITE_ORIENTATION_FILE_ID' => 'INT_PK_ID_ SITE_ORIENTATION_FILE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_FILE' => 'Código identificador',
            'INT_FK_ERP_TYPE_FILE_ID' => 'Código do tipo do arquivo',
            'INT_FK_ERP_AUTHOR_ID' => 'Código do autor',
            'INT_FK_ERP_CITY_ID' => 'Código da cidade',
            'INT_FK_SITE_ORIENTATION_FILE_ID' => 'Código da orintação do arquivo',
            'INT_FK_SITE_IMAGE_RIGHT_ID' => 'Código do direito de imagem',
            'STR_FILE_CODE' => 'Código do arquivo',
            'STR_MAIN_SUBJECT_PT' => 'Assunto em Português',
            'STR_MAIN_SUBJECT_EN' => 'Assunto em Inglês',
            'STR_EXTRA_SUBJECT_PT' => 'Assunto extra em Português',
            'STR_EXTRA_SUBJECT_EN' => 'Assunto extra em Inglês',
            'INT_FILE_DATE' => 'Data do arquivo',
            'TST_CREATION_DATE' => 'Data do registro',
            'INT_HORIZANTAL_SIZE' => 'Tamnoho horizontal',
            'INT_VERTICAL_SIZE' => 'Tamanho vertical',
        ];
    }
    public function getErpLogIndexer()
    {
        return $this->hasMany(ErpLoginIndexer::className(), ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getErpLuiHasSiteFile()
    {
        return $this->hasMany(ErpLuiHasSiteFile::className(), ['INT_FK_ID_SITE_FILE' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getSiteCountShowFile()
    {
        return $this->hasOne(SiteCountShowFile::className(), ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getSiteDownloadLayout()
    {
        return $this->hasMany(SiteDownloadLayout::className(), ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getSiteExtraVideoInformation()
    {
        return $this->hasOne(SiteExtraVideoInformation::className(), ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getIntFkErpAuthor()
    {
        return $this->hasOne(ErpAuthor::className(), ['INT_PK_ID_SITE_AUTHOR' => 'INT_FK_ERP_AUTHOR_ID']);
    }
    public function getIntFkErpCity()
    {
        return $this->hasOne(ErpCity::className(), ['INT_PK_ID_ERP_CITY' => 'INT_FK_ERP_CITY_ID']);
    }
    public function getIntFkErpTypeFile()
    {
        return $this->hasOne(ErpTypeFile::className(), ['INT_PK_ID_ERP_TYPE_FILE' => 'INT_FK_ERP_TYPE_FILE_ID']);
    }
    public function getIntFkSiteImageRight()
    {
        return $this->hasOne(SiteImageRight::className(), ['INT_PK_ID_SITE_IMAGE_RIGHT' => 'INT_FK_SITE_IMAGE_RIGHT_ID']);
    }
    public function getIntFkSiteOrientationFile()
    {
        return $this->hasOne(SiteOrientationFile::className(), ['INT_PK_ID_ SITE_ORIENTATION_FILE' => 'INT_FK_SITE_ORIENTATION_FILE_ID']);
    }
    public function getSiteFileHasSiteTheme()
    {
        return $this->hasMany(SiteFileHasSiteTheme::className(), ['INT_PK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getIntPkSiteTheme()
    {
        return $this->hasMany(SiteTheme::className(), ['INT_PK_ID_SITE_THEME' => 'INT_PK_SITE_THEME_ID'])->viaTable('SITE_FILE_HAS_SITE_THEME', ['INT_PK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getSiteFilePromotion()
    {
        return $this->hasOne(SiteFilePromotion::className(), ['INT_PK_ID_SITE_FILE' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getSiteFtpFile()
    {
        return $this->hasMany(SiteFtpFile::className(), ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getSiteHomePageFile()
    {
        return $this->hasMany(SiteHomePageFile::className(), ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getSiteKeywordHasSiteFile()
    {
        return $this->hasMany(SiteKeywordHasSiteFile::className(), ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getIntFkSiteKeyword()
    {
        return $this->hasMany(SiteKeyword::className(), ['INT_PK_ID_SITE_KEYWORD' => 'INT_FK_SITE_KEYWORD_ID'])->viaTable('SITE_KEYWORD_HAS_SITE_FILE', ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getSiteLogShowFile()
    {
        return $this->hasMany(SiteLogShowFile::className(), ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getSiteQuotationCollection()
    {
        return $this->hasMany(SiteQuotationCollection::className(), ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getSiteSendMailFileHasSiteFile()
    {
        return $this->hasMany(SiteSendMailFileHasSiteFile::className(), ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getIntFkSiteSendMailFile()
    {
        return $this->hasMany(SiteSendMailFile::className(), ['INT_PK_ID_SITE_SEND_EMAIL_FILE' => 'INT_FK_SITE_SEND_EMAIL_FILE_ID'])->viaTable('SITE_SEND_EMAIL_FILE_HAS_SITE_FILE', ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getSiteUserFolderHasSiteFile()
    {
        return $this->hasMany(SiteUserFolderHasSiteFile::className(), ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getIntFkSiteUserFolder()
    {
        return $this->hasMany(SiteUserFolder::className(), ['INT_PK_ID_SITE_USER_FOLDER' => 'INT_FK_SITE_USER_FOLDER_ID'])->viaTable('SITE_USER_FOLDER_HAS_SITE_FILE', ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getSiteDownload()
    {
    	return $this->hasMany(SiteDownload::className(), ['INT_FK_ID_SITE_FILE' => 'INT_PK_ID_SITE_FILE']);
    }
    public function getByIdFtpFileWithSiteFile($intIdSiteFile, $intIdTypeFile, $intIdSiteUser)
    {
    	return $this->find()
    		->select([
    			SiteFile::tableName().'.*',	
    			SiteFTPFile::tableName().'.*',
    		])
    		->innerJoinWith('siteFtpFile')
    		->where(
    			[
    				'INT_PK_ID_SITE_FILE' => $intIdSiteFile,
    				'INT_FK_SITE_USER_ID' => $intIdSiteUser,
    				'INT_FK_ERP_TYPE_FILE_ID' => $intIdTypeFile, 
    				
    			])
    		->one();
    }
}