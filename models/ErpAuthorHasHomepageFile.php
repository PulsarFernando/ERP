<?php
namespace app\models;
use Yii;
class ErpAuthorHasHomepageFile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ERP_AUTHOR_HAS_HOMEPAGE_FILE';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function rules()
    {
        return [
            [['INT_FK_SITE_AUTHOR_ID', 'INT_FK_SITE_HOMEPAGE_FILE_ID'], 'required'],
            [['INT_FK_SITE_AUTHOR_ID', 'INT_FK_SITE_HOMEPAGE_FILE_ID'], 'integer'],
            [['INT_FK_SITE_AUTHOR_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpAuthor::className(), 'targetAttribute' => ['INT_FK_SITE_AUTHOR_ID' => 'INT_PK_ID_SITE_AUTHOR']],
            [['INT_FK_SITE_HOMEPAGE_FILE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => SiteHomePageFile::className(), 'targetAttribute' => ['INT_FK_SITE_HOMEPAGE_FILE_ID' => 'INT_PK_ID_SITE_HOMEPAGE_FILE']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_FK_SITE_AUTHOR_ID' => Yii::t('erpModel', 'ANTIGA: tombo_toindex'),
            'INT_FK_SITE_HOMEPAGE_FILE_ID' => Yii::t('erpModel', 'Int  Fk  Site  Homepage  File  ID'),
        ];
    }
    public function getIntFkSiteAuthor()
    {
        return $this->hasOne(ErpAuthor::className(), ['INT_PK_ID_SITE_AUTHOR' => 'INT_FK_SITE_AUTHOR_ID']);
    }
    public function getIntFkSiteHomePageFile()
    {
        return $this->hasOne(SiteHomePageFile::className(), ['INT_PK_ID_SITE_HOMEPAGE_FILE' => 'INT_FK_SITE_HOMEPAGE_FILE_ID']);
    }
}