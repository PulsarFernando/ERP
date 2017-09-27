<?php
namespace app\models;
use Yii;
class SiteQuotationCollection extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_QUOTATION_COLLECTION';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['TST_CREATION_DATE'], 'safe'],
            [['INT_FK_SITE_USER_ID', 'INT_FK_SITE_FILE_ID'], 'required'],
            [['INT_FK_SITE_USER_ID', 'INT_FK_SITE_FILE_ID', 'INT_FK_SITE_USER_FOLDER_ID'], 'integer'],
            [['INT_FK_SITE_FILE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteFile::className(), 'targetAttribute' => ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']],
            [['INT_FK_SITE_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUser::className(), 'targetAttribute' => ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']],
            [['INT_FK_SITE_USER_FOLDER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUserFolder::className(), 'targetAttribute' => ['INT_FK_SITE_USER_FOLDER_ID' => 'INT_PK_ID_SITE_USER_FOLDER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_QUOTATION_COLLECTION' => Yii::t('erpModel', 'ANTIGA: cotacao e cotacao_cromos'),
            'TST_CREATION_DATE' => Yii::t('erpModel', 'Tst  Creation  Date'),
            'INT_FK_SITE_USER_ID' => Yii::t('erpModel', 'Int  Fk  Site  User  ID'),
            'INT_FK_SITE_FILE_ID' => Yii::t('erpModel', 'Int  Fk  Site  File  ID'),
            'INT_FK_SITE_USER_FOLDER_ID' => Yii::t('erpModel', 'Int  Fk  Site  User  Folder  ID'),
        ];
    }
    public function getIntFkSiteFile()
    {
        return $this->hasOne(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_FK_SITE_FILE_ID']);
    }
    public function getIntFkSiteUser()
    {
        return $this->hasOne(SiteUser::className(), ['INT_PK_ID_SITE_USER' => 'INT_FK_SITE_USER_ID']);
    }
    public function getIntFkSiteUserFolder()
    {
        return $this->hasOne(SiteUserFolder::className(), ['INT_PK_ID_SITE_USER_FOLDER' => 'INT_FK_SITE_USER_FOLDER_ID']);
    }
}