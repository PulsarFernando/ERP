<?php
namespace app\models;
use Yii;
use yii\db\ActiveRecord;
class ErpProjectType extends ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_PROJECT_TYPE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_PROJECT_TYPE_PT', 'STR_PROJECT_TYPE_EN'], 'required'],
            [['STR_PROJECT_TYPE_PT', 'STR_PROJECT_TYPE_EN'], 'string', 'max' => 255],
        	[['BOO_STATUS','BOO_FOR_PICTURE','BOO_FOR_VIDEO'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_PROJECT_TYPE' => Yii::t('erpModel', 'ANTIGA USO_TIPO'),
            'STR_PROJECT_TYPE_PT' => Yii::t('erpModel', 'Str  Project  Type  Pt'),
            'STR_PROJECT_TYPE_EN' => Yii::t('erpModel', 'Str  Project  Type  Pt'),
        	'BOO_STATUS' => Yii::t('erpModel', 'Str  Project  Type  Pt'),
        	'BOO_FOR_PICTURE' => Yii::t('erpModel', 'boo for picture'),
        	'BOO_FOR_VIDEO' => Yii::t('erpModel', 'boo for video'),
        ];
    }
    public function getErpPrice()
    {
        return $this->hasMany(ErpPrice::className(), ['INT_FK_ERP_PROJECT_TYPE_ID' => 'INT_PK_ID_PROJECT_TYPE']);
    }
}