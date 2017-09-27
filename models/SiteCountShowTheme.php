<?php
namespace app\models;
use Yii;
class SiteCountShowTheme extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_COUNT_SHOW_THEME';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_THEME_ID'], 'required'],
            [['INT_FK_SITE_THEME_ID', 'INT_COUNT_SHOW_THEME'], 'integer'],
            [['INT_FK_SITE_THEME_ID'], 'unique'],
            [['INT_FK_SITE_THEME_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteTheme::className(), 'targetAttribute' => ['INT_FK_SITE_THEME_ID' => 'INT_PK_ID_SITE_THEME']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_FK_SITE_THEME_ID' => Yii::t('erpModel', 'Int  Fk  Site  Theme  ID'),
            'INT_COUNT_SHOW_THEME' => Yii::t('erpModel', 'Int  Count  Show  Theme'),
        ];
    }
    public function getIntFkSiteTheme()
    {
        return $this->hasOne(SiteTheme::className(), ['INT_PK_ID_SITE_THEME' => 'INT_FK_SITE_THEME_ID']);
    }
}