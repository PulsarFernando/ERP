<?php
namespace app\models;
use Yii;
class SiteUserHasSiteUser extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_USER_HAS_SITE_USER';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_USER_ID', 'INT_PK_SITE_USER_ID_ADMINISTRATOR'], 'required'],
            [['INT_FK_SITE_USER_ID', 'INT_PK_SITE_USER_ID_ADMINISTRATOR'], 'integer'],
            [['INT_PK_SITE_USER_ID_ADMINISTRATOR'], 'exist', 'skipOnError' => true, 'targetClass' => SITEUSER::className(), 'targetAttribute' => ['INT_PK_SITE_USER_ID_ADMINISTRATOR' => 'INT_PK_ID_SITE_USER']],
            [['INT_FK_SITE_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SITEUSER::className(), 'targetAttribute' => ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_FK_SITE_USER_ID' => Yii::t('erpModel', 'Int  Fk  Site  User  ID'),
            'INT_PK_SITE_USER_ID_ADMINISTRATOR' => Yii::t('erpModel', 'Int  Pk  Site  User  Id  Administrator'),
        ];
    }
    public function getINTPKSITEUSERIDADMINISTRATOR()
    {
        return $this->hasOne(SITEUSER::className(), ['INT_PK_ID_SITE_USER' => 'INT_PK_SITE_USER_ID_ADMINISTRATOR']);
    }
    public function getINTFKSITEUSER()
    {
        return $this->hasOne(SITEUSER::className(), ['INT_PK_ID_SITE_USER' => 'INT_FK_SITE_USER_ID']);
    }
}