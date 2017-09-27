<?php
namespace app\models;
use Yii;
class SiteUserPromotion extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_USER_PROMOTION';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_ID_SITE_USER'], 'required'],
            [['INT_FK_ID_SITE_USER', 'BOO_SITE_PROMOTION'], 'integer'],
            [['INT_FK_ID_SITE_USER'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUser::className(), 'targetAttribute' => ['INT_FK_ID_SITE_USER' => 'INT_PK_ID_SITE_USER']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_FK_ID_SITE_USER' => Yii::t('erpModel', 'ANTIGA: site_cadastro_promocao'),
            'BOO_SITE_PROMOTION' => Yii::t('erpModel', 'Boo  Site  Promotion'),
        ];
    }
    public function getIntFkSiteUser()
    {
        return $this->hasOne(SiteUser::className(), ['INT_PK_ID_SITE_USER' => 'INT_FK_ID_SITE_USER']);
    }
}