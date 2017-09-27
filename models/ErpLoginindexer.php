<?php
namespace app\models;
use Yii;
class ErpLoginindexer extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_LOG_INDEXER';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_FILE_ID', 'INT_FK_ERP_USER_ID'], 'required'],
            [['INT_FK_SITE_FILE_ID', 'INT_FK_ERP_USER_ID', 'BOO_NEW_RECORD'], 'integer'],
            [['TST_CREATION_DATE'], 'safe'],
            [['INT_FK_ERP_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpUser::className(), 'targetAttribute' => ['INT_FK_ERP_USER_ID' => 'INT_PK_ID_ERP_USER']],
            [['INT_FK_SITE_FILE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteFile::className(), 'targetAttribute' => ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_LOG_INDEXER' => Yii::t('erpModel', 'ANTIGA: log_indexacao'),
            'INT_FK_SITE_FILE_ID' => Yii::t('erpModel', 'Int  Fk  Site  File  ID'),
            'INT_FK_ERP_USER_ID' => Yii::t('erpModel', 'Int  Fk  Erp  User  ID'),
            'TST_CREATION_DATE' => Yii::t('erpModel', 'Tst  Creation  Date'),
            'BOO_NEW_RECORD' => Yii::t('erpModel', 'Boo  New  Record'),
        ];
    }
    public function getIntFkErpUser()
    {
        return $this->hasOne(ErpUser::className(), ['INT_PK_ID_ERP_USER' => 'INT_FK_ERP_USER_ID']);
    }
    public function getIntFkSiteFile()
    {
        return $this->hasOne(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_FK_SITE_FILE_ID']);
    }
}
