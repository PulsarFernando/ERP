<?php
namespace app\models;
use Yii;
class SiteFtpFile extends \yii\db\ActiveRecord
{	
    public static function tableName()
    {
        return 'SITE_FTP_FILE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_PK_ID_SITE_FTP_FILE', 'INT_FK_SITE_FILE_ID', 'INT_FK_SITE_USER_ID', 'INT_FK_ERP_USER_ID'], 'required'],
            [['INT_PK_ID_SITE_FTP_FILE', 'INT_FK_SITE_FILE_ID', 'INT_SHELF_LIFE', 'INT_FK_SITE_USER_ID', 'INT_FK_ERP_USER_ID'], 'integer'],
            [['TST_CREATION_DATE'], 'safe'],
            [['STR_NOTE'], 'string', 'max' => 250],
            [['INT_PK_ID_SITE_FTP_FILE'], 'unique'],
            [['INT_FK_ERP_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpUser::className(), 'targetAttribute' => ['INT_FK_ERP_USER_ID' => 'INT_PK_ID_ERP_USER']],
            [['INT_FK_SITE_FILE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteFile::className(), 'targetAttribute' => ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']],
            [['INT_FK_SITE_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUser::className(), 'targetAttribute' => ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_FTP_FILE' => 'Código do ftp',
            'INT_FK_SITE_FILE_ID' => 'Código do arquivo',
            'TST_CREATION_DATE' => 'Data',
            'INT_SHELF_LIFE' => 'Validade',
            'STR_NOTE' => 'Observação',
            'INT_FK_SITE_USER_ID' => 'Código do cliente',
            'INT_FK_ERP_USER_ID' => 'Código do colaborador',
        ];
    }
    public function getErpUser()
    {
        return $this->hasOne(ErpUser::className(), ['INT_PK_ID_ERP_USER' => 'INT_FK_ERP_USER_ID']);
    }
    public function getSiteFile()
    {
        return $this->hasOne(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_FK_SITE_FILE_ID']);
    }
    public function getSiteUser()
    {
        return $this->hasOne(SiteUser::className(), ['INT_PK_ID_SITE_USER' => 'INT_FK_SITE_USER_ID']);
    }
    public function updateAllAttributes($arrUpdate)
    {
    	Yii::$app->dbPulsar->createCommand()->update($this->tableName(),$arrUpdate,'INT_PK_ID_SITE_FTP_FILE = '.$arrUpdate['INT_PK_ID_SITE_FTP_FILE'])->execute();
    	return true;
    }
}