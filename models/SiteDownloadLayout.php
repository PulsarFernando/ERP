<?php
namespace app\models;
use Yii;
class SiteDownloadLayout extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_DOWNLOAD_LAYOUT';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_FILE_ID', 'INT_FK_SITE_USER_ID', 'STR_PROJECT_NAME'], 'required'],
            [['INT_FK_SITE_FILE_ID', 'INT_FK_SITE_USER_ID'], 'integer'],
            [['TST_CREATION_DATE'], 'safe'],
            [['STR_NOTE', 'STR_PROJECT_NAME'], 'string', 'max' => 250],
            [['STR_NAME'], 'string', 'max' => 150],
            [['STR_IP'], 'string', 'max' => 16],
            [['INT_FK_SITE_FILE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteFile::className(), 'targetAttribute' => ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']],
            [['INT_FK_SITE_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUser::className(), 'targetAttribute' => ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_DOWNLOAD_LAYOUT' => Yii::t('erpModel', 'ANTIGO: log_download_layout'),
            'INT_FK_SITE_FILE_ID' => Yii::t('erpModel', 'Int  Fk  Site  File  ID'),
            'INT_FK_SITE_USER_ID' => Yii::t('erpModel', 'Int  Fk  Site  User  ID'),
            'STR_NOTE' => Yii::t('erpModel', 'Str  Note'),
            'STR_NAME' => Yii::t('erpModel', 'Str  Name'),
            'STR_IP' => Yii::t('erpModel', 'Str  Ip'),
            'TST_CREATION_DATE' => Yii::t('erpModel', 'Tst  Creation  Date'),
            'STR_PROJECT_NAME' => Yii::t('erpModel', 'Str  Project  Name'),
        ];
    }
    public function getIntFkSiteFile()
    {
        return $this->hasOne(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_FK_SITE_FILE_ID']);
    }
    public function getIntFkSiteUser()
    {
        return $this->hasOne(SiteUser::className(), ['INT_PK_ID_SITE_USER' => 'INT_FK_SITE_USER_ID']);
    }
}