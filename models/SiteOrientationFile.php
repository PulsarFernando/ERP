<?php
namespace app\models;
use Yii;
class SiteOrientationFile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_ORIENTATION_FILE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_ORIENTATION_PT', 'STR_ORIENTATION_EN'], 'required'],
            [['STR_ORIENTATION_PT', 'STR_ORIENTATION_EN'], 'string', 'max' => 20],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ SITE_ORIENTATION_FILE' => Yii::t('erpModel', 'Int  Pk  Id   Site  Orientation  File'),
            'STR_ORIENTATION_PT' => Yii::t('erpModel', 'Str  Orientation  Pt'),
            'STR_ORIENTATION_EN' => Yii::t('erpModel', 'Str  Orientation  En'),
        ];
    }
    public function getSiteFile()
    {
        return $this->hasMany(SiteFile::className(), ['INT_FK_SITE_ORIENTATION_FILE_ID' => 'INT_PK_ID_ SITE_ORIENTATION_FILE']);
    }
}