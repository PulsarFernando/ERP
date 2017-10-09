<?php
namespace app\models;
use Yii;
use yii\helpers\ArrayHelper;
class ErpTypeFile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_TYPE_FILE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_FILE_TYPE_NAME'], 'required'],
            [['STR_FILE_TYPE_NAME'], 'string', 'max' => 10],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_ERP_TYPE_FILE' => Yii::t('erpModel', 'Int  Pk  Id  Erp  Type  File'),
            'STR_FILE_TYPE_NAME' => Yii::t('erpModel', 'Str  File  Type  Name'),
        ];
    }
    public function getErpContract()
    {
        return $this->hasMany(ErpContract::className(), ['FK_ERP_TYPE_FILE_ID' => 'INT_PK_ID_ERP_TYPE_FILE']);
    }
    public function getSiteFile()
    {
        return $this->hasMany(SiteFile::className(), ['INT_FK_ERP_TYPE_FILE_ID' => 'INT_PK_ID_ERP_TYPE_FILE']);
    }
    public function getAllTypeFile()
    {
    	return ArrayHelper::map(
    			ErpTypeFile::find()->asArray()->all(),
    			'INT_PK_ID_ERP_TYPE_FILE',
    			'STR_FILE_TYPE_NAME'
    			);
    }
}