<?php
namespace app\models;
use Yii;
class SiteKeyword extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_KEYWORD';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_PK_ID_SITE_KEYWORD', 'STR_KEYWORD_PT'], 'required'],
            [['INT_PK_ID_SITE_KEYWORD'], 'integer'],
            [['STR_KEYWORD_PT', 'STR_KEYWORD_EN'], 'string', 'max' => 255],
            [['INT_PK_ID_SITE_KEYWORD'], 'unique'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_KEYWORD' => Yii::t('erpModel', 'ANTIGO: pulsar.pal_chave'),
            'STR_KEYWORD_PT' => Yii::t('erpModel', 'Str  Keyword  Pt'),
            'STR_KEYWORD_EN' => Yii::t('erpModel', 'Str  Keyword  En'),
        ];
    }
    public function getSiteKeywordHasSiteFile()
    {
        return $this->hasMany(SiteKeywordHasSiteFile::className(), ['INT_FK_SITE_KEYWORD_ID' => 'INT_PK_ID_SITE_KEYWORD']);
    }
    public function getIntFkSiteFile()
    {
        return $this->hasMany(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_FK_SITE_FILE_ID'])->viaTable('SITE_KEYWORD_HAS_SITE_FILE', ['INT_FK_SITE_KEYWORD_ID' => 'INT_PK_ID_SITE_KEYWORD']);
    }
}