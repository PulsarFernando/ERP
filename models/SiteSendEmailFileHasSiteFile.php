<?php
namespace app\models;
use Yii;
class SiteSendEmailFileHasSiteFile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_SEND_EMAIL_FILE_HAS_SITE_FILE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_SEND_EMAIL_FILE_ID', 'INT_FK_SITE_FILE_ID'], 'required'],
            [['INT_FK_SITE_SEND_EMAIL_FILE_ID', 'INT_FK_SITE_FILE_ID'], 'integer'],
            [['INT_FK_SITE_SEND_EMAIL_FILE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteSendEmailFile::className(), 'targetAttribute' => ['INT_FK_SITE_SEND_EMAIL_FILE_ID' => 'INT_PK_ID_SITE_SEND_EMAIL_FILE']],
            [['INT_FK_SITE_FILE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteFile::className(), 'targetAttribute' => ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_FK_SITE_SEND_EMAIL_FILE_ID' => Yii::t('erpModel', 'Int  Fk  Site  Send  Email  File  ID'),
            'INT_FK_SITE_FILE_ID' => Yii::t('erpModel', 'Int  Fk  Site  File  ID'),
        ];
    }
    public function getIntFkSiteSendEmailFile()
    {
        return $this->hasOne(SiteSendEmailFile::className(), ['INT_PK_ID_SITE_SEND_EMAIL_FILE' => 'INT_FK_SITE_SEND_EMAIL_FILE_ID']);
    }
    public function getIntFkSiteFile()
    {
        return $this->hasOne(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_FK_SITE_FILE_ID']);
    }
}