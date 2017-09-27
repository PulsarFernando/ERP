<?php
namespace app\models;
use Yii;
class SiteDownload extends \yii\db\ActiveRecord
{
	const SCENARIO_FTP = 'ftpCustomer';
    public static function tableName()
    {
        return 'SITE_DOWNLOAD';
    }
    public static function getDb()
    {
        return Yii::$app->get('dbPulsar');
    }
    public function scenarios()
    {
    	return [
    		self::SCENARIO_FTP => 
    		[
    			'INT_FK_ERP_PRICE_ID', 'INT_FK_ID_SITE_USER', 'INT_FK_ID_SITE_FILE',  'BOO_INVOICE', 'BOO_DOWNLOAD_SITE', 'TST_CREATION_DATE', 'STR_IP', 'STR_NAME', 'STR_NOTE','STR_PROJECT_NAME',	
    		],	
    	];
    }
    public function rules()
    {
        return [
        	[['INT_FK_ID_SITE_USER', 'INT_FK_ERP_PRICE_ID'], 'required'], // 'INT_FK_ID_SITE_FILE',
        	[['INT_FK_ID_SITE_USER', 'BOO_INVOICE', 'INT_FK_ERP_PRICE_ID', 'BOO_DOWNLOAD_SITE'], 'integer'], // 'INT_FK_ID_SITE_FILE', 
        	[['TST_CREATION_DATE'], 'safe'],
            [['STR_IP'], 'string', 'max' => 15],
            [['STR_NAME'], 'string', 'max' => 150],
            [['STR_NOTE', 'STR_PROJECT_NAME'], 'string', 'max' => 250],
            [['STR_FORMAT', 'STR_IMPRESSION'], 'string', 'max' => 50],
            [['STR_CIRCULATION'], 'string', 'max' => 45],
            [['INT_FK_ERP_PRICE_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ErpPrice::className(), 'targetAttribute' => ['INT_FK_ERP_PRICE_ID' => 'INT_PK_ID_ERP_PRICE']],
            [['INT_FK_ID_SITE_USER'], 'exist', 'skipOnError' => true, 'targetClass' => SiteUser::className(), 'targetAttribute' => ['INT_FK_ID_SITE_USER' => 'INT_PK_ID_SITE_USER']],
        	[['INT_FK_ID_SITE_FILE'], 'required', 'message' => 'Existem códigos que não foram encontrados no sistema.'],	
        	[['INT_FK_ID_SITE_USER', 'INT_FK_ID_SITE_FILE', 'INT_FK_ERP_PRICE_ID', 'BOO_INVOICE', 'BOO_DOWNLOAD_SITE', 'TST_CREATION_DATE', 'STR_IP', 'STR_NAME','STR_PROJECT_NAME', 'STR_FORMAT', 'STR_IMPRESSION', 'STR_CIRCULATION'], 'required', 'on' => self::SCENARIO_FTP],		
        ];
    }
    public function attributeLabels()
    {
        return [
            'INT_PK_ID_SITE_DOWNLOAD' => 'Identificador do Download',
            'INT_FK_ID_SITE_USER' => 'Código do cliente',
            'INT_FK_ID_SITE_FILE' => 'Identificador do arquivo',
            'TST_CREATION_DATE' => 'Data de registro',
            'STR_IP' => 'Ip',
            'STR_NAME' => 'Nome do cliente',
            'STR_NOTE' => 'Observação',
            'BOO_INVOICE' => 'Faturado',
            'INT_FK_ERP_PRICE_ID' => 'Por favor, selecione todos os campos de seleção até o último nível para encontrarmos o preço adequado.',
            'STR_PROJECT_NAME' => 'Título do livro / projeto',
            'STR_FORMAT' => 'Formato',
            'STR_CIRCULATION' => 'Circulacao',
            'STR_IMPRESSION' => 'Tiragem',
            'BOO_DOWNLOAD_SITE' => 'Download pelo site',
        ];
    }
    public function getIntFkErpPrice()
    {
        return $this->hasOne(ErpPrice::className(), ['INT_PK_ID_ERP_PRICE' => 'INT_FK_ERP_PRICE_ID']);
    }
    public function getSiteUser()
    {
        return $this->hasOne(SiteUser::className(), ['INT_PK_ID_SITE_USER' => 'INT_FK_ID_SITE_USER']);
    }
    public function getSiteFile()
    {
    	return $this->hasOne(SiteFile::className(), ['INT_PK_ID_SITE_FILE' => 'INT_FK_ID_SITE_FILE']);
    }
    public function getDownloadAllById($intIdSiteUser, $intIdTypeFile, $booJustLast = true)
    {
    	if($booJustLast)
    		return $this->find()->innerJoin(SiteFile::tableName(), 'INT_PK_ID_SITE_FILE = INT_FK_ID_SITE_FILE')->where(['INT_FK_ID_SITE_USER' => $intIdSiteUser, SiteFile::tableName().'.INT_FK_ERP_TYPE_FILE_ID' => $intIdTypeFile])->orderBy(['INT_PK_ID_SITE_DOWNLOAD' => SORT_DESC])->one();
    	else 
    		return $this->find()->innerJoin(SiteFile::tableName(), 'INT_PK_ID_SITE_FILE = INT_FK_ID_SITE_FILE')->where(['INT_FK_ID_SITE_USER' => $intIdSiteUser, SiteFile::tableName().'.INT_FK_ERP_TYPE_FILE_ID' => $intIdTypeFile])->all();
    }
    public function getDownloadAllByIdUserAndIdFile($intIdSiteUser, $intIdTypeFile, $intIdSiteFile, $booJustLast = true)
    {
    	if($booJustLast)
    		return $this->find()->innerJoin(SiteFile::tableName(), 'INT_PK_ID_SITE_FILE = INT_FK_ID_SITE_FILE')->where(['INT_FK_ID_SITE_USER' => $intIdSiteUser, SiteFile::tableName().'.INT_FK_ERP_TYPE_FILE_ID' => $intIdTypeFile, 'INT_FK_ID_SITE_FILE' => $intIdSiteFile])->orderBy(['INT_PK_ID_SITE_DOWNLOAD' => SORT_DESC])->one();
    	else
    		return $this->find()->innerJoin(SiteFile::tableName(), 'INT_PK_ID_SITE_FILE = INT_FK_ID_SITE_FILE')->where(['INT_FK_ID_SITE_USER' => $intIdSiteUser, SiteFile::tableName().'.INT_FK_ERP_TYPE_FILE_ID' => $intIdTypeFile, 'INT_FK_ID_SITE_FILE' => $intIdSiteFile])->all();
    }
    public function updateAllAttributes($arrUpdate)
    {
    	Yii::$app->db->createCommand()->update($this->tableName(),$arrUpdate,'INT_FK_ID_SITE_FILE = '.$arrUpdate['INT_FK_ID_SITE_FILE'].' AND INT_FK_ID_SITE_USER = '.$arrUpdate['INT_FK_ID_SITE_USER'].' AND BOO_INVOICE = 0')->execute();	
		return true;
    }
}