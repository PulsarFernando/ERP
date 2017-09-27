<?php
namespace app\models;
use Yii;
class SiteKeywordHasSiteFile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_KEYWORD_HAS_SITE_FILE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_KEYWORD_ID', 'INT_FK_SITE_FILE_ID'], 'required'],
            [['INT_FK_SITE_KEYWORD_ID', 'INT_FK_SITE_FILE_ID'], 'integer'],
            [['INT_FK_SITE_FILE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteFile::className(), 'targetAttribute' => ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']],
            [['INT_FK_SITE_KEYWORD_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteKeyword::className(), 'targetAttribute' => ['INT_FK_SITE_KEYWORD_ID' => 'INT_PK_ID_SITE_KEYWORD']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_FK_SITE_KEYWORD_ID' => Yii::t('erpModel', 'Antiga: rel_fotos_pal_ch'),
            'INT_FK_SITE_FILE_ID' => Yii::t('erpModel', 'Int  Fk  Site  File  ID'),
        ];
    }
    public function getIntFkSiteFile()
    {
        return $this->hasOne(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_FK_SITE_FILE_ID']);
    }
    public function getIntFkSiteKeyword()
    {
        return $this->hasOne(SiteKeyword::className(), ['INT_PK_ID_SITE_KEYWORD' => 'INT_FK_SITE_KEYWORD_ID']);
    }
}