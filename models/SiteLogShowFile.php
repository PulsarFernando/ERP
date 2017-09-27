<?php
namespace app\models;
use Yii;
class SiteLogShowFile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_LOG_SHOW_FILE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_PK_ID_SITE_LOG_SHOW_FILE', 'INT_FK_SITE_FILE_ID'], 'required'],
            [['INT_PK_ID_SITE_LOG_SHOW_FILE', 'INT_FK_SITE_FILE_ID'], 'integer'],
            [['TST_CREATION_DATE'], 'safe'],
            [['STR_IP'], 'string', 'max' => 15],
            [['INT_PK_ID_SITE_LOG_SHOW_FILE'], 'unique'],
            [['INT_FK_SITE_FILE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteFile::className(), 'targetAttribute' => ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_LOG_SHOW_FILE' => Yii::t('erpModel', 'Int  Pk  Id  Site  Log  Show  File'),
            'INT_FK_SITE_FILE_ID' => Yii::t('erpModel', 'ANTIGA: log_pop'),
            'TST_CREATION_DATE' => Yii::t('erpModel', 'Tst  Creation  Date'),
            'STR_IP' => Yii::t('erpModel', 'Str  Ip'),
        ];
    }
    public function getIntFkSiteFile()
    {
        return $this->hasOne(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_FK_SITE_FILE_ID']);
    }
}