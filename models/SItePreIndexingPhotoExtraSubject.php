<?php
namespace app\models;
use Yii;
class SItePreIndexingPhotoExtraSubject extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_PRE_INDEXING_PHOTO_EXTRA_SUBJECT';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_FILE_CODE', 'STR_EXTRA_SUBJECT_PT'], 'required'],
            [['STR_FILE_CODE'], 'string', 'max' => 10],
            [['STR_EXTRA_SUBJECT_PT', 'STR_EXTRA_SUBJECT_EN'], 'string', 'max' => 150],
            [['STR_FILE_CODE'], 'unique'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_PRE_INDEXING_VIDEO_EXTRA_SUBJECT' => Yii::t('erpModel', 'ANTIGO: Fotos_extra'),
            'STR_FILE_CODE' => Yii::t('erpModel', 'Str  File  Code'),
            'STR_EXTRA_SUBJECT_PT' => Yii::t('erpModel', 'Str  Extra  Subject  Pt'),
            'STR_EXTRA_SUBJECT_EN' => Yii::t('erpModel', 'Str  Extra  Subject  En'),
        ];
    }
}