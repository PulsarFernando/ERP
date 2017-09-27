<?php
namespace app\models;
use Yii;
class SiteQuoteSent extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_QUOTE_SENT';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_USER_ID', 'INT_FK_ERP_USER_ID'], 'required'],
            [['INT_FK_SITE_USER_ID', 'INT_FK_ERP_USER_ID', 'BOO_ATTENDED'], 'integer'],
            [['TST_LAST_ACESS', 'STR_SERVICE_DATE'], 'safe'],
            [['STR_CUSTOMER_MESSAGE', 'STR_PULSAR_MESSAGE'], 'string'],
            [['INT_FK_ERP_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpUser::className(), 'targetAttribute' => ['INT_FK_ERP_USER_ID' => 'INT_PK_ID_ERP_USER']],
            [['INT_FK_SITE_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUser::className(), 'targetAttribute' => ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_QUOTE_SENT' => 'Código da cotação',
            'INT_FK_SITE_USER_ID' =>'Código do cliente',
            'INT_FK_ERP_USER_ID' => 'Código do colaborador',
            'TST_LAST_ACESS' => 'Data de atendimento',
            'STR_CUSTOMER_MESSAGE' => 'Menssagem do cliente',
            'BOO_ATTENDED' => 'Atendimento',
            'STR_SERVICE_DATE' => 'Data do registro',
            'STR_PULSAR_MESSAGE' => 'Mensagem do colaborador',
        ];
    }
    public function getErpUser()
    {
        return $this->hasOne(ErpUser::className(), ['INT_PK_ID_ERP_USER' => 'INT_FK_ERP_USER_ID']);
    }
    public function getSiteUser()
    {
        return $this->hasOne(SiteUser::className(), ['INT_PK_ID_SITE_USER' => 'INT_FK_SITE_USER_ID']);
    }
}