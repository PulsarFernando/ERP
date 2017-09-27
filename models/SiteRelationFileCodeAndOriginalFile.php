<?php
namespace app\models;
use Yii;
class SiteRelationFileCodeAndOriginalFile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_RELATION_FILE_CODE_AND_ORIGINAL_FILE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_YEAR', 'INT_COUNT_FILE_AUTHOR', 'INT_FK_SITE_AUTHOR_ID', 'STR_FILE_CODE', 'STR_ORIGINAL_FILE'], 'required'],
            [['INT_YEAR', 'INT_COUNT_FILE_AUTHOR', 'INT_FK_SITE_AUTHOR_ID', 'INT_STATUS'], 'integer'],
            [['TST_DATE_CREATION_DATE'], 'safe'],
            [['STR_FILE_CODE'], 'string', 'max' => 10],
            [['STR_ORIGINAL_FILE'], 'string', 'max' => 100],
            [['INT_FK_SITE_AUTHOR_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpAuthor::className(), 'targetAttribute' => ['INT_FK_SITE_AUTHOR_ID' => 'INT_PK_ID_SITE_AUTHOR']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_RELATION_FILE_CODE_AND_ORIGINAL_FILE' => Yii::t('erpModel', 'ANTIGA: codigo_video'),
            'INT_YEAR' => Yii::t('erpModel', 'Int  Year'),
            'INT_COUNT_FILE_AUTHOR' => Yii::t('erpModel', 'Int  Count  File  Author'),
            'INT_FK_SITE_AUTHOR_ID' => Yii::t('erpModel', 'Int  Fk  Site  Author  ID'),
            'STR_FILE_CODE' => Yii::t('erpModel', 'Str  File  Code'),
            'STR_ORIGINAL_FILE' => Yii::t('erpModel', 'Str  Original  File'),
            'TST_DATE_CREATION_DATE' => Yii::t('erpModel', 'Tst  Date  Creation  Date'),
            'INT_STATUS' => Yii::t('erpModel', 'Antigo:

Status 2 = Finalizado
Status 1 = Liberar indexação
Status -1 = Rejeitado

Novo:

Status 3 = Finalizado
Status 2 = Liberar indexação
Status 1 = Avaliando
Status 0 = Finalizado e Rejeitado'),
        ];
    }
    public function getIntFkSiteAuthor()
    {
        return $this->hasOne(ErpAuthor::className(), ['INT_PK_ID_SITE_AUTHOR' => 'INT_FK_SITE_AUTHOR_ID']);
    }
}