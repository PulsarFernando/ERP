<?php
namespace app\models;
use Yii;
use yii\helpers\ArrayHelper;
class SiteSpecialUserPrefix extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_SPECIAL_USER_PREFIX';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_SPECIAL_USER_PREFIX'], 'required'],
            [['STR_SPECIAL_USER_PREFIX'], 'string', 'max' => 50],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_SPECIAL_USER_PREFIX' => 'Código do prefixo',
            'STR_SPECIAL_USER_PREFIX' => 'Prefixo',
        ];
    }
    public function getIntFkSiteUser()
    {
    	return $this->hasOne(SiteUser::className(), ['INT_PK_ID_SITE_USER' => 'INT_PK_ID_SITE_SPECIAL_USER_PREFIX']);
    }
    public function getSiteSpecialUserPrefix()
    {
    	return ArrayHelper::map(
    		SiteSpecialUserPrefix::find()->asArray()->all(),
    		'INT_PK_ID_SITE_SPECIAL_USER_PREFIX',
    		'STR_SPECIAL_USER_PREFIX'
    	);
    }
}