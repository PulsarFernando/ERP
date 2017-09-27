<?php
namespace app\models;
use Yii;
class SIteSuperTheme extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_SUPER_THEME';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['STR_UNITED_THEME_PT', 'STR_UNITED_THEME_EN'], 'required'],
            [['STR_UNITED_THEME_PT', 'STR_UNITED_THEME_EN'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_SUPER_THEME' => Yii::t('erpModel', 'Antigo: super_temas'),
            'STR_UNITED_THEME_PT' => Yii::t('erpModel', 'Str  United  Theme  Pt'),
            'STR_UNITED_THEME_EN' => Yii::t('erpModel', 'Str  United  Theme  En'),
        ];
    }
}