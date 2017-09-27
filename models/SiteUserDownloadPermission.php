<?php
namespace app\models;
use Yii;
use yii\helpers\ArrayHelper;
class SiteUserDownloadPermission extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_USER_DOWNLOAD_PERMISSION';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_NAME_DOWNLOAD_PERMISSION_NAME_PT'], 'required'],
            [['STR_NAME_DOWNLOAD_PERMISSION_NAME_PT', 'STR_NAME_DOWNLOAD_PERMISSION_NAME_EN'], 'string', 'max' => 30],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_USER_DOWNLOAD_PERMISSION' => Yii::t('erpModel', 'Int  Pk  Id  Site  User  Download  Permission'),
            'STR_NAME_DOWNLOAD_PERMISSION_NAME_PT' => Yii::t('erpModel', 'Str  Name  Download  Permission  Name  Pt'),
            'STR_NAME_DOWNLOAD_PERMISSION_NAME_EN' => Yii::t('erpModel', 'Str  Name  Download  Permission  Name  En'),
        ];
    }
    public function getSiteUser()
    {
        return $this->hasMany(SiteUser::className(), ['INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID' => 'INT_PK_ID_SITE_USER_DOWNLOAD_PERMISSION']);
    }
    public function getDownloadPermission($strOrder = 'STR_NAME_DOWNLOAD_PERMISSION_NAME_PT DESC')
    {
    	return ArrayHelper::map(
    		SiteUserDownloadPermission::find()->orderBy($strOrder)->asArray()->all(),
    		'INT_PK_ID_SITE_USER_DOWNLOAD_PERMISSION',
    		'STR_NAME_DOWNLOAD_PERMISSION_NAME_PT'
    	);
    }
}