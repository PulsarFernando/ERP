<?php
namespace app\models;
use Yii;
class SiteExtraVideoInformation extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_EXTRA_VIDEO_INFORMATION';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_FILE_ID'], 'required'],
            [['INT_FK_SITE_FILE_ID', 'BOO_AUDIO', 'BOO_STATUS'], 'integer'],
            [['FLO_FPS'], 'number'],
            [['TIM_TIME'], 'safe'],
            [['STR_RESOLUTION'], 'string', 'max' => 20],
            [['STR_CODEC'], 'string', 'max' => 40],
            [['STR_ASPECT'], 'string', 'max' => 10],
            [['INT_FK_SITE_FILE_ID'], 'unique'],
            [['INT_FK_SITE_FILE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteFile::className(), 'targetAttribute' => ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_FK_SITE_FILE_ID' => Yii::t('erpModel', 'Int  Fk  Site  File  ID'),
            'FLO_FPS' => Yii::t('erpModel', 'Flo  Fps'),
            'STR_RESOLUTION' => Yii::t('erpModel', 'Str  Resolution'),
            'STR_CODEC' => Yii::t('erpModel', 'Str  Codec'),
            'BOO_AUDIO' => Yii::t('erpModel', 'Boo  Audio'),
            'TIM_TIME' => Yii::t('erpModel', 'Tim  Time'),
            'STR_ASPECT' => Yii::t('erpModel', 'Str  Aspect'),
            'BOO_STATUS' => Yii::t('erpModel', 'Boo  Status'),
        ];
    }
    public function getIntFkSiteFile()
    {
        return $this->hasOne(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_FK_SITE_FILE_ID']);
    }
}