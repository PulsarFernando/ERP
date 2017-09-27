<?php
namespace app\models;
use Yii;
class SiteUserLanguage extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_USER_LANGUAGE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_NAME_LANGUAGE_PT', 'STR_NAME_LANGUAGE_EN'], 'required'],
            [['STR_NAME_LANGUAGE_PT', 'STR_NAME_LANGUAGE_EN'], 'string', 'max' => 50],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_USER_LANGUAGE' => Yii::t('erpModel', 'Int  Pk  Id  Site  User  Language'),
            'STR_NAME_LANGUAGE_PT' => Yii::t('erpModel', 'Str  Name  Language  Pt'),
            'STR_NAME_LANGUAGE_EN' => Yii::t('erpModel', 'Str  Name  Language  En'),
        ];
    }
    public function getSiteUser()
    {
        return $this->hasMany(SiteUser::className(), ['INT_FK_SITE_USER_LANGUAGE_ID' => 'INT_PK_ID_SITE_USER_LANGUAGE']);
    }
}