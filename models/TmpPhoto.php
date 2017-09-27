<?php
namespace app\models;
use Yii;
class TmpPhoto extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'Fotos_tmp';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['Id_Foto', 'tombo'], 'required'],
            [['Id_Foto', 'id_autor', 'id_estado', 'dim_a', 'dim_b', 'status'], 'integer'],
            [['extra', 'pal_chave'], 'string'],
            [['tombo'], 'string', 'max' => 15],
            [['data_foto'], 'string', 'max' => 10],
            [['cidade'], 'string', 'max' => 50],
            [['id_pais'], 'string', 'max' => 3],
            [['orientacao'], 'string', 'max' => 1],
            [['assunto_principal'], 'string', 'max' => 100],
            [['Id_Foto'], 'unique'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'Id_Foto' => Yii::t('erpModel', 'Id  Foto'),
            'tombo' => Yii::t('erpModel', 'Tombo'),
            'id_autor' => Yii::t('erpModel', 'Id Autor'),
            'data_foto' => Yii::t('erpModel', 'Data Foto'),
            'cidade' => Yii::t('erpModel', 'Cidade'),
            'id_estado' => Yii::t('erpModel', 'Id Estado'),
            'id_pais' => Yii::t('erpModel', 'Id Pais'),
            'orientacao' => Yii::t('erpModel', 'Orientacao'),
            'assunto_principal' => Yii::t('erpModel', 'Assunto Principal'),
            'dim_a' => Yii::t('erpModel', 'Dim A'),
            'dim_b' => Yii::t('erpModel', 'Dim B'),
            'extra' => Yii::t('erpModel', 'Extra'),
            'pal_chave' => Yii::t('erpModel', 'Pal Chave'),
            'status' => Yii::t('erpModel', 'Status'),
        ];
    }
}