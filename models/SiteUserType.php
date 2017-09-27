<?php
namespace app\models;
use Yii;
use yii\helpers\ArrayHelper;
class SiteUserType extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_USER_TYPE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_USER_TYPE_NAME_PT', 'STR_USER_TYPE_NAME_EN'], 'required'],
            [['STR_USER_TYPE_NAME_PT', 'STR_USER_TYPE_NAME_EN'], 'string', 'max' => 45],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_TYPE_USER' => Yii::t('erpModel', 'AQUI seria pessoa física ou jurídica
e super user ou não
'),
            'STR_USER_TYPE_NAME_PT' => Yii::t('erpModel', 'Str  User  Type  Name  Pt'),
            'STR_USER_TYPE_NAME_EN' => Yii::t('erpModel', 'Str  User  Type  Name  En'),
        ];
    }
    public function getSiteUser()
    {
        return $this->hasMany(SiteUser::className(), ['INT_FK_SITE_TYPE_USER_ID' => 'INT_PK_ID_TYPE_USER']);
    }
    public function getSiteUserType($strOrder = 'INT_PK_ID_TYPE_USER desc')
    {
    	return ArrayHelper::map(
    			SiteUserType::find()->orderBy($strOrder)->asArray()->all(),
    			'INT_PK_ID_TYPE_USER',
    			'STR_USER_TYPE_NAME_PT'
    	);
    }
}