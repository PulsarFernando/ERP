<?php
namespace app\models;
use Yii;
class SiteUserFolder extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_USER_FOLDER';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_USER_ID', 'STR_FOLDER_NAME'], 'required'],
            [['INT_FK_SITE_USER_ID'], 'integer'],
            [['TST_CREATION_DATE', 'TST_UPDATE_DATE'], 'safe'],
            [['STR_FOLDER_NAME'], 'string', 'max' => 45],
            [['INT_FK_SITE_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUser::className(), 'targetAttribute' => ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_USER_FOLDER' => Yii::t('erpModel', 'Antiga: pastas'),
            'INT_FK_SITE_USER_ID' => Yii::t('erpModel', 'Int  Fk  Site  User  ID'),
            'STR_FOLDER_NAME' => Yii::t('erpModel', 'Str  Folder  Name'),
            'TST_CREATION_DATE' => Yii::t('erpModel', 'Tst  Creation  Date'),
            'TST_UPDATE_DATE' => Yii::t('erpModel', 'Tst  Update  Date'),
        ];
    }
    public function getSiteQuotationCollection()
    {
        return $this->hasMany(SiteQuotationCollection::className(), ['INT_FK_SITE_USER_FOLDER_ID' => 'INT_PK_ID_SITE_USER_FOLDER']);
    }
    public function getIntFkSiteUser()
    {
        return $this->hasOne(SiteUser::className(), ['INT_PK_ID_SITE_USER' => 'INT_FK_SITE_USER_ID']);
    }
    public function getSiteUserFolderHasSiteFile()
    {
        return $this->hasMany(SiteUserFolderHasSiteFile::className(), ['INT_FK_SITE_USER_FOLDER_ID' => 'INT_PK_ID_SITE_USER_FOLDER']);
    }
    public function getIntFkSiteFile()
    {
        return $this->hasMany(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_FK_SITE_FILE_ID'])->viaTable('SITE_USER_FOLDER_HAS_SITE_FILE', ['INT_FK_SITE_USER_FOLDER_ID' => 'INT_PK_ID_SITE_USER_FOLDER']);
    }
}