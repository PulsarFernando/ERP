<?php
namespace app\models;
use Yii;
use yii\helpers\ArrayHelper;
class SiteUserTypeNewsletter extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_USER_TYPE_NEWSLETTER';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_TYPE_NEWLETTER_NAME_PT', 'STR_TYPE_NEWLETTER_NAME_EN'], 'required'],
            [['STR_TYPE_NEWLETTER_NAME_PT', 'STR_TYPE_NEWLETTER_NAME_EN'], 'string', 'max' => 50],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_USER_TYPE_NEWSLETTER' => Yii::t('erpModel', 'Int  Pk  Id  Site  User  Type  Newsletter'),
            'STR_TYPE_NEWLETTER_NAME_PT' => Yii::t('erpModel', 'Str  Type  Newletter  Name  Pt'),
            'STR_TYPE_NEWLETTER_NAME_EN' => Yii::t('erpModel', 'Str  Type  Newletter  Name  En'),
        ];
    }
    public function getSiteUser()
    {
        return $this->hasMany(SiteUser::className(), ['INT_FK_SITE_USER_TYPE_NEWSLETTER_ID' => 'INT_PK_ID_SITE_USER_TYPE_NEWSLETTER']);
    }
    public function getSiteUserTypeNewsletter()
    {
    	return ArrayHelper::map(
    			SiteUserTypeNewsletter::find()->asArray()->all(),
    		'INT_PK_ID_SITE_USER_TYPE_NEWSLETTER',
    		'STR_TYPE_NEWLETTER_NAME_PT'
    	);
    }
}