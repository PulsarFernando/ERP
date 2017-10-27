<?php
namespace app\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SiteUser;
use app\models\SiteDownload;
use app\models\SiteUserType;
use app\models\SiteSpecialUserPrefix;
use yii\helpers\ArrayHelper;
class SiteUserSearch extends SiteUser
{
	public $STR_SPECIAL_USER_PREFIX;
	public $STR_SOCIAL_REASON;
	public $INT_TOTAL_INVOICED;
	public $INT_TOTAL_DOWNLOAD;
	public $STR_USER_TYPE_NAME_PT;
    public function rules()
    {
        return [
            [['INT_PK_ID_SITE_USER', 'INT_FK_ERP_CUSTOMER_ID', 'INT_FK_ERP_COMPANY_ID', 'INT_FK_ERP_CITY_ID', 'INT_FK_SITE_TYPE_USER_ID', 'INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID', 'INT_FK_SITE_USER_LANGUAGE_ID', 'INT_FK_SITE_USER_TYPE_NEWSLETTER_ID', 'INT_FK_SITE_SPECIAL_USER_PREFIX_ID', 'BOO_TEMPORARY_USER', 'INT_DOWNLOAD_LIMIT', 'BOO_NEWSLETTER', 'BOO_ACCEPT_TERM', 'INT_PAGINATION', 'BOO_SPECIAL_USER', 'BOO_STATUS', 'INT_TOTAL_INVOICED','INT_TOTAL_DOWNLOAD'],'integer'],
            [['STR_LOGIN','STR_PASSWORD', 'BOO_SPECIAL_USER_ADMINISTRATOR', 'TST_CREATION_DATE', 'TST_LAST_ACESS', 'STR_ADDRESS', 'STR_ZIP_CODE', 'STR_NUMBER', 'STR_ADDRESS_COMPLEMENT', 'STR_CPF', 'STR_NAME', 'STR_EMAIL', 'STR_SPECIAL_USER_PREFIX', 'STR_SOCIAL_REASON','INT_TOTAL_INVOICED','INT_TOTAL_DOWNLOAD', 'STR_USER_TYPE_NAME_PT'], 'safe']
        ];	
    }
    public function scenarios()
    {
        return Model::scenarios();
    }
    public function search($params, $intTypeStatus = 1)
    {
    	if($intTypeStatus == 1)
       		$query = SiteUser::find()->joinWith(['siteSpecialUserPrefix','erpCompany'])->where('BOO_STATUS = 1');
    	elseif($intTypeStatus == 0)
    		$query = SiteUser::find()->joinWith(['siteSpecialUserPrefix','erpCompany'])->where('BOO_STATUS = 0');
    	else 
    		$query = SiteUser::find()->joinWith(['siteSpecialUserPrefix','erpCompany']);
    	$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['STR_SPECIAL_USER_PREFIX'] = [
        		'asc' => [SiteSpecialUserPrefix::tableName().'.STR_SPECIAL_USER_PREFIX' => SORT_ASC],
        		'desc' => [SiteSpecialUserPrefix::tableName().'.STR_SPECIAL_USER_PREFIX' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['STR_SOCIAL_REASON'] = [
        		'asc' => [ErpCompany::tableName().'.STR_SOCIAL_REASON' => SORT_ASC],
        		'desc' => [ErpCompany::tableName().'.STR_SOCIAL_REASON' => SORT_DESC],
        ];
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'INT_PK_ID_SITE_USER' => $this->INT_PK_ID_SITE_USER,
            'INT_FK_ERP_CUSTOMER_ID' => $this->INT_FK_ERP_CUSTOMER_ID,
            'INT_FK_ERP_COMPANY_ID' => $this->INT_FK_ERP_COMPANY_ID,
            'INT_FK_ERP_CITY_ID' => $this->INT_FK_ERP_CITY_ID,
            'INT_FK_SITE_TYPE_USER_ID' => $this->INT_FK_SITE_TYPE_USER_ID,
            'INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID' => $this->INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID,
            'INT_FK_SITE_USER_LANGUAGE_ID' => $this->INT_FK_SITE_USER_LANGUAGE_ID,
            'INT_FK_SITE_USER_TYPE_NEWSLETTER_ID' => $this->INT_FK_SITE_USER_TYPE_NEWSLETTER_ID,
            'INT_FK_SITE_SPECIAL_USER_PREFIX_ID' => $this->INT_FK_SITE_SPECIAL_USER_PREFIX_ID,
            'BOO_TEMPORARY_USER' => $this->BOO_TEMPORARY_USER,
            'INT_DOWNLOAD_LIMIT' => $this->INT_DOWNLOAD_LIMIT,
            'BOO_NEWSLETTER' => $this->BOO_NEWSLETTER,
            'BOO_ACCEPT_TERM' => $this->BOO_ACCEPT_TERM,
            'INT_PAGINATION' => $this->INT_PAGINATION,
            'BOO_SPECIAL_USER' => $this->BOO_SPECIAL_USER,
            'BOO_STATUS' => $this->BOO_STATUS,
            'TST_CREATION_DATE' => $this->TST_CREATION_DATE,
            'TST_LAST_ACESS' => $this->TST_LAST_ACESS,
        	'STR_SPECIAL_USER_PREFIX' => $this->STR_SPECIAL_USER_PREFIX,
        	'STR_NAME' => $this->STR_NAME, 
        	'STR_EMAIL' => $this->STR_EMAIL,
        	'STR_SOCIAL_REASON' => $this->STR_SOCIAL_REASON,	
        	
        ]);
        $query->andFilterWhere(['like', 'STR_LOGIN', $this->STR_LOGIN])
            ->andFilterWhere(['like', 'STR_PASSWORD', $this->STR_PASSWORD])
            ->andFilterWhere(['like', 'BOO_SPECIAL_USER_ADMINISTRATOR', $this->BOO_SPECIAL_USER_ADMINISTRATOR])
            ->andFilterWhere(['like', 'STR_ADDRESS', $this->STR_ADDRESS])
            ->andFilterWhere(['like', 'STR_ZIP_CODE', $this->STR_ZIP_CODE])
            ->andFilterWhere(['like', 'STR_NUMBER', $this->STR_NUMBER])
            ->andFilterWhere(['like', 'STR_ADDRESS_COMPLEMENT', $this->STR_ADDRESS_COMPLEMENT])
            ->andFilterWhere(['like', 'STR_NAME', $this->STR_NAME])
            ->andFilterWhere(['like', 'STR_EMAIL', $this->STR_EMAIL])
            ->andFilterWhere(['like', 'STR_CPF', $this->STR_CPF])
            ->andFilterWhere(['like', SiteSpecialUserPrefix::tableName().'.STR_SPECIAL_USER_PREFIX',  $this->STR_SPECIAL_USER_PREFIX])
            ->andFilterWhere(['like', ErpCompany::tableName().'.STR_SOCIAL_REASON',  $this->STR_SOCIAL_REASON]);
        return $dataProvider;
    }
    public function searchDownloadReport($arrParam, $datDateStart, $datDateFinish)
    {
    	$query = SiteUser::find()
    		->joinWith(['siteDownload', 'siteUserType'], 'inner')
    		->joinWith(['erpCompany', 'siteSpecialUserPrefix'], 'left')
    		->where(['between', SiteDownload::tableName().'.TST_CREATION_DATE',  $datDateStart, $datDateFinish])
    		->groupBy('INT_PK_ID_SITE_USER');	
    	if($arrParam['intUserId'])
    	{
    		$query->andWhere(['INT_PK_ID_SITE_USER' => $arrParam['intUserId']]);
    	}
   		if($arrParam['intIdErpTypeFile'])
   		{
    		$query->join('INNER JOIN', 
    			SiteFile::tableName(), SiteFile::tableName().'.INT_PK_ID_SITE_FILE = '.SiteDownload::tableName().'.INT_FK_ID_SITE_FILE AND '.SiteFile::tableName().'.INT_FK_ERP_TYPE_FILE_ID = '.$arrParam['intIdErpTypeFile']);
    		$query->andWhere(['INT_FK_ERP_TYPE_FILE_ID' => $arrParam['intIdErpTypeFile']]);
   		}
    	$dataProvider = new ActiveDataProvider([
    		'query' => $query,
    		'sort'=> ['defaultOrder' => ['STR_SOCIAL_REASON'=>SORT_DESC, 'STR_NAME' => SORT_ASC]],
    	]);
    	$dataProvider->sort->attributes['STR_SOCIAL_REASON'] = [
    			'asc' => [ErpCompany::tableName().'.STR_SOCIAL_REASON' => SORT_ASC],
    			'desc' => [ErpCompany::tableName().'.STR_SOCIAL_REASON' => SORT_DESC],
    	];
    	$dataProvider->sort->attributes['STR_USER_TYPE_NAME_PT'] = [
    			'asc' => [SiteUserType::tableName().'.STR_USER_TYPE_NAME_PT' => SORT_ASC],
    			'desc' => [SiteUserType::tableName().'.STR_USER_TYPE_NAME_PT' => SORT_DESC],
    	];
    	$dataProvider->sort->attributes['STR_SPECIAL_USER_PREFIX'] = [
    			'asc' => [SiteSpecialUserPrefix::tableName().'.STR_SPECIAL_USER_PREFIX' => SORT_ASC],
    			'desc' => [SiteSpecialUserPrefix::tableName().'.STR_SPECIAL_USER_PREFIX' => SORT_DESC],
    	];
    	$this->load($arrParam);
    	if (!$this->validate()) 
    		return $dataProvider;
    	$query->andFilterWhere([
    			'INT_PK_ID_SITE_USER' => $this->INT_PK_ID_SITE_USER,
    			'INT_FK_ERP_CUSTOMER_ID' => $this->INT_FK_ERP_CUSTOMER_ID,
    			'INT_FK_ERP_COMPANY_ID' => $this->INT_FK_ERP_COMPANY_ID,
    			'INT_FK_ERP_CITY_ID' => $this->INT_FK_ERP_CITY_ID,
    			'INT_FK_SITE_TYPE_USER_ID' => $this->INT_FK_SITE_TYPE_USER_ID,
    			'INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID' => $this->INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID,
    			'INT_FK_SITE_USER_LANGUAGE_ID' => $this->INT_FK_SITE_USER_LANGUAGE_ID,
    			'INT_FK_SITE_USER_TYPE_NEWSLETTER_ID' => $this->INT_FK_SITE_USER_TYPE_NEWSLETTER_ID,
    			'INT_FK_SITE_SPECIAL_USER_PREFIX_ID' => $this->INT_FK_SITE_SPECIAL_USER_PREFIX_ID,
    			'BOO_TEMPORARY_USER' => $this->BOO_TEMPORARY_USER,
    			'INT_DOWNLOAD_LIMIT' => $this->INT_DOWNLOAD_LIMIT,
    			'BOO_NEWSLETTER' => $this->BOO_NEWSLETTER,
    			'BOO_ACCEPT_TERM' => $this->BOO_ACCEPT_TERM,
    			'INT_PAGINATION' => $this->INT_PAGINATION,
    			'BOO_SPECIAL_USER' => $this->BOO_SPECIAL_USER,
    			'BOO_STATUS' => $this->BOO_STATUS,
    			'TST_CREATION_DATE' => $this->TST_CREATION_DATE,
    			'TST_LAST_ACESS' => $this->TST_LAST_ACESS,
    			'STR_SPECIAL_USER_PREFIX' => $this->STR_SPECIAL_USER_PREFIX,
    			'STR_NAME' => $this->STR_NAME,
    			'STR_EMAIL' => $this->STR_EMAIL,
    			'STR_SOCIAL_REASON' => $this->STR_SOCIAL_REASON,
    			'STR_USER_TYPE_NAME_PT' => $this->STR_USER_TYPE_NAME_PT,
    			'INT_TOTAL_INVOICED' => $this->INT_TOTAL_INVOICED,
    			'INT_TOTAL_DOWNLOAD' => $this->INT_TOTAL_DOWNLOAD,
    	]);
    	$query->andFilterWhere(['like', 'STR_LOGIN', $this->STR_LOGIN])
    	->andFilterWhere(['like', 'STR_PASSWORD', $this->STR_PASSWORD])
    	->andFilterWhere(['like', 'BOO_SPECIAL_USER_ADMINISTRATOR', $this->BOO_SPECIAL_USER_ADMINISTRATOR])
    	->andFilterWhere(['like', 'STR_ADDRESS', $this->STR_ADDRESS])
    	->andFilterWhere(['like', 'STR_ZIP_CODE', $this->STR_ZIP_CODE])
    	->andFilterWhere(['like', 'STR_NUMBER', $this->STR_NUMBER])
    	->andFilterWhere(['like', 'STR_ADDRESS_COMPLEMENT', $this->STR_ADDRESS_COMPLEMENT])
    	->andFilterWhere(['like', 'STR_NAME', $this->STR_NAME])
    	->andFilterWhere(['like', 'STR_EMAIL', $this->STR_EMAIL])
    	->andFilterWhere(['like', 'STR_CPF', $this->STR_CPF])
    	->andFilterWhere(['like', ErpCompany::tableName().'.STR_SOCIAL_REASON',  $this->STR_SOCIAL_REASON])
    	->andFilterWhere(['like', SiteUserType::tableName().'.STR_USER_TYPE_NAME_PT',  $this->STR_USER_TYPE_NAME_PT])
    	->andFilterWhere(['like', SiteSpecialUserPrefix::tableName().'.STR_SPECIAL_USER_PREFIX',  $this->STR_SPECIAL_USER_PREFIX]);
    	return $dataProvider;	
    }
    public function searchDownloadReportForSpecialCustomer($arrParam, $datDateStart, $datDateFinish, $arrIdsSpecialCustomer)
    {
    	$query = SiteUser::find()
    	->joinWith(['siteDownload', 'siteUserType'], 'inner')
    	->joinWith(['erpCompany', 'siteSpecialUserPrefix'], 'left')
    	->where(['between', SiteDownload::tableName().'.TST_CREATION_DATE',  $datDateStart, $datDateFinish])
    	->groupBy('INT_PK_ID_SITE_USER');
    	if(count($arrIdsSpecialCustomer))
    		$query->andWhere(['INT_PK_ID_SITE_USER' => $arrIdsSpecialCustomer]);
    	else
    		$query->andWhere(['INT_PK_ID_SITE_USER' => $arrParam['intUserId']]);
    	if($arrParam['intIdErpTypeFile'])
    		$query->join('INNER JOIN', SiteFile::tableName(), SiteFile::tableName().'.INT_PK_ID_SITE_FILE = '.SiteDownload::tableName().'.INT_FK_ID_SITE_FILE AND '.SiteFile::tableName().'.INT_FK_ERP_TYPE_FILE_ID = '.$arrParam['intIdErpTypeFile']);
    		$dataProvider = new ActiveDataProvider([
    				'query' => $query,
    				'sort'=> ['defaultOrder' => ['STR_SOCIAL_REASON'=>SORT_DESC, 'STR_NAME' => SORT_DESC]],
    		]);
    		$dataProvider->sort->attributes['STR_SOCIAL_REASON'] = [
    				'asc' => [ErpCompany::tableName().'.STR_SOCIAL_REASON' => SORT_ASC],
    				'desc' => [ErpCompany::tableName().'.STR_SOCIAL_REASON' => SORT_DESC],
    		];
    		$dataProvider->sort->attributes['STR_USER_TYPE_NAME_PT'] = [
    				'asc' => [SiteUserType::tableName().'.STR_USER_TYPE_NAME_PT' => SORT_ASC],
    				'desc' => [SiteUserType::tableName().'.STR_USER_TYPE_NAME_PT' => SORT_DESC],
    		];
    		$dataProvider->sort->attributes['STR_SPECIAL_USER_PREFIX'] = [
    				'asc' => [SiteSpecialUserPrefix::tableName().'.STR_SPECIAL_USER_PREFIX' => SORT_ASC],
    				'desc' => [SiteSpecialUserPrefix::tableName().'.STR_SPECIAL_USER_PREFIX' => SORT_DESC],
    		];
    		$this->load($arrParam);
    		if (!$this->validate())
    			return $dataProvider;
    			$query->andFilterWhere([
    					'INT_PK_ID_SITE_USER' => $this->INT_PK_ID_SITE_USER,
    					'INT_FK_ERP_CUSTOMER_ID' => $this->INT_FK_ERP_CUSTOMER_ID,
    					'INT_FK_ERP_COMPANY_ID' => $this->INT_FK_ERP_COMPANY_ID,
    					'INT_FK_ERP_CITY_ID' => $this->INT_FK_ERP_CITY_ID,
    					'INT_FK_SITE_TYPE_USER_ID' => $this->INT_FK_SITE_TYPE_USER_ID,
    					'INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID' => $this->INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID,
    					'INT_FK_SITE_USER_LANGUAGE_ID' => $this->INT_FK_SITE_USER_LANGUAGE_ID,
    					'INT_FK_SITE_USER_TYPE_NEWSLETTER_ID' => $this->INT_FK_SITE_USER_TYPE_NEWSLETTER_ID,
    					'INT_FK_SITE_SPECIAL_USER_PREFIX_ID' => $this->INT_FK_SITE_SPECIAL_USER_PREFIX_ID,
    					'BOO_TEMPORARY_USER' => $this->BOO_TEMPORARY_USER,
    					'INT_DOWNLOAD_LIMIT' => $this->INT_DOWNLOAD_LIMIT,
    					'BOO_NEWSLETTER' => $this->BOO_NEWSLETTER,
    					'BOO_ACCEPT_TERM' => $this->BOO_ACCEPT_TERM,
    					'INT_PAGINATION' => $this->INT_PAGINATION,
    					'BOO_SPECIAL_USER' => $this->BOO_SPECIAL_USER,
    					'BOO_STATUS' => $this->BOO_STATUS,
    					'TST_CREATION_DATE' => $this->TST_CREATION_DATE,
    					'TST_LAST_ACESS' => $this->TST_LAST_ACESS,
    					'STR_SPECIAL_USER_PREFIX' => $this->STR_SPECIAL_USER_PREFIX,
    					'STR_NAME' => $this->STR_NAME,
    					'STR_EMAIL' => $this->STR_EMAIL,
    					'STR_SOCIAL_REASON' => $this->STR_SOCIAL_REASON,
    					'STR_USER_TYPE_NAME_PT' => $this->STR_USER_TYPE_NAME_PT,
    					'INT_TOTAL_INVOICED' => $this->INT_TOTAL_INVOICED,
    					'INT_TOTAL_DOWNLOAD' => $this->INT_TOTAL_DOWNLOAD,
    			]);
    			$query->andFilterWhere(['like', 'STR_LOGIN', $this->STR_LOGIN])
    			->andFilterWhere(['like', 'STR_PASSWORD', $this->STR_PASSWORD])
    			->andFilterWhere(['like', 'BOO_SPECIAL_USER_ADMINISTRATOR', $this->BOO_SPECIAL_USER_ADMINISTRATOR])
    			->andFilterWhere(['like', 'STR_ADDRESS', $this->STR_ADDRESS])
    			->andFilterWhere(['like', 'STR_ZIP_CODE', $this->STR_ZIP_CODE])
    			->andFilterWhere(['like', 'STR_NUMBER', $this->STR_NUMBER])
    			->andFilterWhere(['like', 'STR_ADDRESS_COMPLEMENT', $this->STR_ADDRESS_COMPLEMENT])
    			->andFilterWhere(['like', 'STR_NAME', $this->STR_NAME])
    			->andFilterWhere(['like', 'STR_EMAIL', $this->STR_EMAIL])
    			->andFilterWhere(['like', 'STR_CPF', $this->STR_CPF])
    			->andFilterWhere(['like', ErpCompany::tableName().'.STR_SOCIAL_REASON',  $this->STR_SOCIAL_REASON])
    			->andFilterWhere(['like', SiteUserType::tableName().'.STR_USER_TYPE_NAME_PT',  $this->STR_USER_TYPE_NAME_PT])
    			->andFilterWhere(['like', SiteSpecialUserPrefix::tableName().'.STR_SPECIAL_USER_PREFIX',  $this->STR_SPECIAL_USER_PREFIX]);
    			return $dataProvider;
    }
    public function getUserArrayByParam($strParam)
    {
    	if($strParam != 'STR_SPECIAL_USER_PREFIX')
    		return SiteUser::find()->joinWith(['siteSpecialUserPrefix'])->where('BOO_STATUS = 1')->orderBy($strParam)->asArray()->all();
  		else 
  			return SiteUser::find()->joinWith(['siteSpecialUserPrefix'])->where('BOO_STATUS = 1')->asArray()->all();
  			
    }
    public function getUserById($intPkIdSiteUser)
    {
    	return SiteUser::find()
    		->where(
    			[
    				'INT_PK_ID_SITE_USER' => $intPkIdSiteUser ,
    				'BOO_STATUS' => 1
    			]
    		)
    		->one();
    }
    public function getAllSiteUser()
    {
    	return ArrayHelper::map(
    			SiteUser::find()->where(['BOO_STATUS' => 1])->orderBy(['STR_NAME' => SORT_ASC])->asArray()->all(),
    			'INT_PK_ID_SITE_USER',
    			'STR_NAME'
    			);
    }
    public function getIdSpecialUserPrefix($intIdUser)
    {
    	$objCustormer = SiteUser::find()->where(['INT_PK_ID_SITE_USER' => $intIdUser])->one();
    	return $objCustormer->INT_FK_SITE_SPECIAL_USER_PREFIX_ID; 
    }
    public function getAllIdsBySameIdPrefix($intIdPrefix)
    {
    	return SiteUser::find()->where(['INT_FK_SITE_SPECIAL_USER_PREFIX_ID' => $intIdPrefix])->All();
    }
}