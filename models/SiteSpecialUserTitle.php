<?php
namespace app\models;
use Yii;
class SiteSpecialUserTitle extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_SPECIAL_USER_TITLE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_USER_ID', 'STR_TITTLE'], 'required'],
            [['INT_FK_SITE_USER_ID', 'BOO_STATUS'], 'integer'],
            [['TST_CREATION_DATE', 'TST_UPDATE_DATE'], 'safe'],
            [['STR_TITTLE'], 'string', 'max' => 200],
            [['INT_FK_SITE_USER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUser::className(), 'targetAttribute' => ['INT_FK_SITE_USER_ID' => 'INT_PK_ID_SITE_USER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_SPECIAL_USER_TITLE' => Yii::t('erpModel', 'ANTIGO: site_cliente_especial_titulo'),
            'INT_FK_SITE_USER_ID' => Yii::t('erpModel', 'Int  Fk  Site  User  ID'),
            'STR_TITTLE' => Yii::t('erpModel', 'Str  Tittle'),
            'TST_CREATION_DATE' => Yii::t('erpModel', 'Tst  Creation  Date'),
            'TST_UPDATE_DATE' => Yii::t('erpModel', 'Tst  Update  Date'),
            'BOO_STATUS' => Yii::t('erpModel', 'Boo  Status'),
        ];
    }
    public function getIntFkSiteUser()
    {
        return $this->hasOne(SiteUser::className(), ['INT_PK_ID_SITE_USER' => 'INT_FK_SITE_USER_ID']);
    }
}