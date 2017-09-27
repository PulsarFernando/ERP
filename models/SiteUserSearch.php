<?php
namespace app\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SiteUser;
use app\models\SiteSpecialUserPrefix;
class SiteUserSearch extends SiteUser
{
	public $STR_SPECIAL_USER_PREFIX;
	public $STR_SOCIAL_REASON;
    public function rules()
    {
        return [
            [['INT_PK_ID_SITE_USER', 'INT_FK_ERP_CUSTOMER_ID', 'INT_FK_ERP_COMPANY_ID', 'INT_FK_ERP_CITY_ID', 'INT_FK_SITE_TYPE_USER_ID', 'INT_FK_SITE_USER_DOWNLOAD_PERMISSION_ID', 'INT_FK_SITE_USER_LANGUAGE_ID', 'INT_FK_SITE_USER_TYPE_NEWSLETTER_ID', 'INT_FK_SITE_SPECIAL_USER_PREFIX_ID', 'BOO_TEMPORARY_USER', 'INT_DOWNLOAD_LIMIT', 'BOO_NEWSLETTER', 'BOO_ACCEPT_TERM', 'INT_PAGINATION', 'BOO_SPECIAL_USER', 'BOO_STATUS'],'integer'],
            [['STR_LOGIN','STR_PASSWORD', 'BOO_SPECIAL_USER_ADMINISTRATOR', 'TST_CREATION_DATE', 'TST_LAST_ACESS', 'STR_ADDRESS', 'STR_ZIP_CODE', 'STR_NUMBER', 'STR_ADDRESS_COMPLEMENT', 'STR_CPF', 'STR_NAME', 'STR_EMAIL', 'STR_SPECIAL_USER_PREFIX', 'STR_SOCIAL_REASON'], 'safe']
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
}