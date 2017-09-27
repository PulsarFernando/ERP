<?php
namespace app\models;
use Yii;
class ErpLuiHasSiteFile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_LUI_HAS_SITE_FILE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_ID_ERP_LUI', 'INT_FK_ID_SITE_FILE'], 'required'],
            [['INT_FK_ID_ERP_LUI', 'INT_FK_ID_SITE_FILE', 'BOO_STATUS'], 'integer'],
            [['INT_FK_ID_ERP_LUI'], 'exist', 'skipOnError' => true, 'targetClass' => ErpLui::className(), 'targetAttribute' => ['INT_FK_ID_ERP_LUI' => 'INT_PK_ID_ERP_LUI']],
            [['INT_FK_ID_SITE_FILE'], 'exist', 'skipOnError' => true, 'targetClass' => SiteFile::className(), 'targetAttribute' => ['INT_FK_ID_SITE_FILE' => 'INT_PK_ID_SITE_FILE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_FK_ID_ERP_LUI' => Yii::t('erpModel', 'ANTIGO: rel_foto_autorizacao_imagem'),
            'INT_FK_ID_SITE_FILE' => Yii::t('erpModel', 'Int  Fk  Id  Site  File'),
            'BOO_STATUS' => Yii::t('erpModel', 'Boo  Status'),
        ];
    }
    public function getIntFkErpLui()
    {
        return $this->hasOne(ErpLui::className(), ['INT_PK_ID_ERP_LUI' => 'INT_FK_ID_ERP_LUI']);
    }
    public function getIntFkSiteFile()
    {
        return $this->hasOne(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_FK_ID_SITE_FILE']);
    }
}