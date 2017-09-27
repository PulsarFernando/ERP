<?php
namespace app\models;
use Yii;
class SiteTheme extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_THEME';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_THEME_ID', 'BOO_STATUS'], 'integer'],
            [['STR_THEME_PT', 'STR_THEME_EN'], 'required'],
            [['STR_THEME_PT', 'STR_THEME_EN'], 'string', 'max' => 200],
            [['INT_FK_SITE_THEME_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteTheme::className(), 'targetAttribute' => ['INT_FK_SITE_THEME_ID' => 'INT_PK_ID_SITE_THEME']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_THEME' => Yii::t('erpModel', 'ANTIGA: temas'),
            'INT_FK_SITE_THEME_ID' => Yii::t('erpModel', 'Int  Fk  Site  Theme  ID'),
            'STR_THEME_PT' => Yii::t('erpModel', 'Str  Theme  Pt'),
            'STR_THEME_EN' => Yii::t('erpModel', 'Str  Theme  En'),
            'BOO_STATUS' => Yii::t('erpModel', 'Boo  Status'),
        ];
    }
    public function getSiteCountShowTheme()
    {
        return $this->hasOne(SiteCountShowTheme::className(), ['INT_FK_SITE_THEME_ID' => 'INT_PK_ID_SITE_THEME']);
    }
    public function getSiteFileHasSiteTheme()
    {
        return $this->hasMany(SiteFileHasSiteTheme::className(), ['INT_PK_SITE_THEME_ID' => 'INT_PK_ID_SITE_THEME']);
    }
    public function getIntFkSiteFile()
    {
        return $this->hasMany(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_PK_SITE_FILE_ID'])->viaTable('SITE_FILE_HAS_SITE_THEME', ['INT_PK_SITE_THEME_ID' => 'INT_PK_ID_SITE_THEME']);
    }
    public function getIntFkSiteTheme()
    {
        return $this->hasOne(SiteTheme::className(), ['INT_PK_ID_SITE_THEME' => 'INT_FK_SITE_THEME_ID']);
    }
    public function getSiteTheme()
    {
        return $this->hasMany(SiteTheme::className(), ['INT_FK_SITE_THEME_ID' => 'INT_PK_ID_SITE_THEME']);
    }
}