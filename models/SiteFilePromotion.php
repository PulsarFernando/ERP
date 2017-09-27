<?php
namespace app\models;
use Yii;
class SiteFilePromotion extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_FILE_PROMOTION';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_PK_ID_SITE_FILE'], 'required'],
            [['INT_PK_ID_SITE_FILE', 'BOO_FILE_PROMOTION'], 'integer'],
            [['TST_CREATION_DATE'], 'safe'],
            [['INT_PK_ID_SITE_FILE'], 'exist', 'skipOnError' => true, 'targetClass' => SiteFile::className(), 'targetAttribute' => ['INT_PK_ID_SITE_FILE' => 'INT_PK_ID_SITE_FILE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_FILE' => Yii::t('erpModel', 'ANTIGA: site_foto_promocao'),
            'BOO_FILE_PROMOTION' => Yii::t('erpModel', 'Boo  File  Promotion'),
            'TST_CREATION_DATE' => Yii::t('erpModel', 'Tst  Creation  Date'),
        ];
    }
    public function getIntFkIDSiteFile()
    {
        return $this->hasOne(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_PK_ID_SITE_FILE']);
    }
}