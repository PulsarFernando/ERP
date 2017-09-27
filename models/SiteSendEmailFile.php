<?php
namespace app\models;
use Yii;
class SiteSendEmailFile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_SEND_EMAIL_FILE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_EMAIL', 'STR_SUBJECT'], 'required'],
            [['TST_CREATION_DATE'], 'safe'],
            [['STR_MESSAGE'], 'string'],
            [['INT_FK_SITE_USER_ID'], 'integer'],
            [['STR_EMAIL'], 'string', 'max' => 150],
            [['STR_SUBJECT'], 'string', 'max' => 50],
            [['INT_FK_SITE_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUser::className(), 'targetAttribute' => ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_SEND_EMAIL_FILE' => Yii::t('erpModel', 'foto_envio_email'),
            'STR_EMAIL' => Yii::t('erpModel', 'Antiga: foto_envio_email'),
            'TST_CREATION_DATE' => Yii::t('erpModel', 'Tst  Creation  Date'),
            'STR_SUBJECT' => Yii::t('erpModel', 'Str  Subject'),
            'STR_MESSAGE' => Yii::t('erpModel', 'Str  Message'),
            'INT_FK_SITE_USER_ID' => Yii::t('erpModel', 'Int  Fk  Site  User  ID'),
        ];
    }
    public function getIntFkSiteUser()
    {
        return $this->hasOne(SiteUser::className(), ['INT_PK_ID_SITE_USER' => 'INT_FK_SITE_USER_ID']);
    }
    public function getSiteSendEmailFileHasSiteFile()
    {
        return $this->hasMany(SiteSendEmailFileHasSiteFile::className(), ['INT_FK_SITE_SEND_EMAIL_FILE_ID' => 'INT_PK_ID_SITE_SEND_EMAIL_FILE']);
    }
    public function getIntFkSiteFile()
    {
        return $this->hasMany(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_FK_SITE_FILE_ID'])->viaTable('SITE_SEND_EMAIL_FILE_HAS_SITE_FILE', ['INT_FK_SITE_SEND_EMAIL_FILE_ID' => 'INT_PK_ID_SITE_SEND_EMAIL_FILE']);
    }
}