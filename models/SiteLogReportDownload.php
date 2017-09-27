<?php
namespace app\models;
use Yii;
class SiteLogReportDownload extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_LOG_REPORT_DOWNLOAD';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_USER_ID'], 'required'],
            [['INT_FK_SITE_USER_ID'], 'integer'],
            [['TST_CREATION_DATE'], 'safe'],
            [['INT_FK_SITE_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUser::className(), 'targetAttribute' => ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_LOG_REPORT_DOWNLOAD' => Yii::t('erpModel', 'log_view_relatorio_download'),
            'INT_FK_SITE_USER_ID' => Yii::t('erpModel', 'Int  Fk  Site  User  ID'),
            'TST_CREATION_DATE' => Yii::t('erpModel', 'Tst  Creation  Date'),
        ];
    }
    public function getIntFkSiteFile()
    {
        return $this->hasOne(SiteUser::className(), ['INT_PK_ID_SITE_USER' => 'INT_FK_SITE_USER_ID']);
    }
}