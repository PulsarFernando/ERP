<?php
namespace app\models;
use Yii;
class SiteHomePageFile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SITE_HOMEPAGE_FILE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_FILE_ID', 'INT_FK_SITE_AUTHOR_ID'], 'required'],
            [['INT_FK_SITE_FILE_ID', 'INT_FK_SITE_AUTHOR_ID'], 'integer'],
            [['INT_FK_SITE_AUTHOR_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpAuthor::className(), 'targetAttribute' => ['INT_FK_SITE_AUTHOR_ID' => 'INT_PK_ID_SITE_AUTHOR']],
            [['INT_FK_SITE_FILE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteFile::className(), 'targetAttribute' => ['INT_FK_SITE_FILE_ID' => 'INT_PK_ID_SITE_FILE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_HOMEPAGE_FILE' => Yii::t('erpModel', 'ANTIGA: fotos_homepage'),
            'INT_FK_SITE_FILE_ID' => Yii::t('erpModel', 'Int  Fk  Site  File  ID'),
            'INT_FK_SITE_AUTHOR_ID' => Yii::t('erpModel', 'Int  Fk  Site  Author  ID'),
        ];
    }
    public function getErpAuthorHasHomepageFile()
    {
        return $this->hasMany(ErpAuthorHasHomepageFile::className(), ['INT_FK_SITE_HOMEPAGE_FILE_ID' => 'INT_PK_ID_SITE_HOMEPAGE_FILE']);
    }
    public function getIntFkSiteAuthorViaTable()
    {
        return $this->hasMany(ErpAuthor::className(), ['INT_PK_ID_SITE_AUTHOR' => 'INT_FK_SITE_AUTHOR_ID'])->viaTable('ERP_AUTHOR_HAS_HOMEPAGE_FILE', ['INT_FK_SITE_HOMEPAGE_FILE_ID' => 'INT_PK_ID_SITE_HOMEPAGE_FILE']);
    }
    public function getIntFkSiteAuthor()
    {
        return $this->hasOne(ErpAuthor::className(), ['INT_PK_ID_SITE_AUTHOR' => 'INT_FK_SITE_AUTHOR_ID']);
    }
    public function getIntFkSiteFile()
    {
        return $this->hasOne(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_FK_SITE_FILE_ID']);
    }
}