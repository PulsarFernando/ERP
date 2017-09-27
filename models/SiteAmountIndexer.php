<?php
namespace app\models;
use Yii;
class SiteAmountIndexer extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_AMOUNT_INDEXER';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_ERP_USER_ID'], 'required'],
            [['INT_FK_ERP_USER_ID'], 'integer'],
            [['FLO_AMOUNT_NEW_INDEXING', 'FLO_AMOUNT_EDIT_INDEXED'], 'number'],
            [['INT_FK_ERP_USER_ID'], 'unique'],
            [['INT_FK_ERP_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpUser::className(), 'targetAttribute' => ['INT_FK_ERP_USER_ID' => 'INT_PK_ID_ERP_USER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_FK_ERP_USER_ID' => Yii::t('erpModel', 'Int  Fk  Erp  User  ID'),
            'FLO_AMOUNT_NEW_INDEXING' => Yii::t('erpModel', 'Flo  Amount  New  Indexing'),
            'FLO_AMOUNT_EDIT_INDEXED' => Yii::t('erpModel', 'Flo  Amount  Edit  Indexed'),
        ];
    }
    public function getIntFkErpUser()
    {
        return $this->hasOne(ErpUser::className(), ['INT_PK_ID_ERP_USER' => 'INT_FK_ERP_USER_ID']);
    }
}
