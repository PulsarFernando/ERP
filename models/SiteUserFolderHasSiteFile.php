<?php
namespace app\models;
use Yii;
class SiteUserFolderHasSiteFile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_USER_FOLDER_HAS_SITE_FILE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_USER_FOLDER_ID', 'INT_FK_SITE_FILE_ID'], 'required'],
            [['INT_FK_SITE_USER_FOLDER_ID', 'INT_FK_SITE_FILE_ID'], 'integer'],
            [['INT_FK_SITE_USER_FOLDER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUserFolder::className(), 'targetAttribute' => ['INT_FK_SITE_USER_FOLDER_ID' => 'INT_PK_ID_SITE_USER_FOLDER']],
            [['INT_FK_SITE_FILE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteFile::className(), 'targetAttribute' => ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_FK_SITE_USER_FOLDER_ID' => Yii::t('erpModel', 'ANTIGA: pasta_fotos'),
            'INT_FK_SITE_FILE_ID' => Yii::t('erpModel', 'Int  Fk  Site  File  ID'),
        ];
    }
    public function getIntFkSiteUserFolder()
    {
        return $this->hasOne(SiteUserFolder::className(), ['INT_PK_ID_SITE_USER_FOLDER' => 'INT_FK_SITE_USER_FOLDER_ID']);
    }
    public function getIntFkSiteFile()
    {
        return $this->hasOne(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_FK_SITE_FILE_ID']);
    }
}