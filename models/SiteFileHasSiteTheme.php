<?php
namespace app\models;
use Yii;
class SiteFileHasSiteTheme extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_FILE_HAS_SITE_THEME';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_PK_SITE_FILE_ID', 'INT_PK_SITE_THEME_ID'], 'required'],
            [['INT_PK_SITE_FILE_ID', 'INT_PK_SITE_THEME_ID'], 'integer'],
            [['INT_PK_SITE_FILE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteFile::className(), 'targetAttribute' => ['INT_PK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']],
            [['INT_PK_SITE_THEME_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteTheme::className(), 'targetAttribute' => ['INT_PK_SITE_THEME_ID' => 'INT_PK_ID_SITE_THEME']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_SITE_FILE_ID' => Yii::t('erpModel', 'Antiga: rel_fotos_temas'),
            'INT_PK_SITE_THEME_ID' => Yii::t('erpModel', 'Int  Pk  Site  Theme  ID'),
        ];
    }
    public function getIntFkSiteFile()
    {
        return $this->hasOne(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_PK_SITE_FILE_ID']);
    }
    public function getIntFkSiteTheme()
    {
        return $this->hasOne(SiteTheme::className(), ['INT_PK_ID_SITE_THEME' => 'INT_PK_SITE_THEME_ID']);
    }
}