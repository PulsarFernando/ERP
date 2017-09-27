<?php
namespace app\models;
use Yii;
class SiteImageRight extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_IMAGE_RIGHT';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['SITE_IMAGE_RIGHT_PT', 'SITE_IMAGE_RIGHT_EN'], 'required'],
            [['SITE_IMAGE_RIGHT_PT', 'SITE_IMAGE_RIGHT_EN'], 'string', 'max' => 50],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_IMAGE_RIGHT' => Yii::t('erpModel', 'Int  Pk  Id  Site  Image  Right'),
            'SITE_IMAGE_RIGHT_PT' => Yii::t('erpModel', 'Site  Image  Right  Pt'),
            'SITE_IMAGE_RIGHT_EN' => Yii::t('erpModel', 'Site  Image  Right  En'),
        ];
    }
    public function getSiteFile()
    {
        return $this->hasMany(SiteFile::className(), ['INT_FK_SITE_IMAGE_RIGHT_ID' => 'INT_PK_ID_SITE_IMAGE_RIGHT']);
    }
}