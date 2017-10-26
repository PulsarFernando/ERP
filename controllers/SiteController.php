<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use app\components\MailComponent;
use app\models\SiteUserSearch;
use app\models\SiteFtpFileSearch;
use app\models\SiteFtpFile;
use app\models\SiteDownload;
use app\models\SiteUserHasSiteUser;
use app\models\SiteSpecialUserTitle;
use app\models\ErpPriceSearch;
use app\models\SiteFile;
use app\models\SiteUser;
use app\models\ErpState;
use app\models\ErpCity;
use app\models\SiteQuoteSentSearch;
use app\models\SiteQuoteSent;
use app\components\SystemComponent;
use app\models\SiteDownloadSearch;
use app\models\ErpCustomer;
class SiteController extends Controller
{
    public function actionFtp()
    {
    	$objSearchModel = new SiteUserSearch();
    	$objDataProvider = $objSearchModel->search(Yii::$app->request->queryParams);
    	return $this->render('ftpShowSiteUser', [
    			'objSearchModel' => $objSearchModel,
    			'objDataProvider' => $objDataProvider,
    	]);
    }
    public function actionFtpShowCustomerFile()
    {
    	$objSearchModel = new SiteFtpFileSearch();
    	$objDataProvider = $objSearchModel->search(Yii::$app->request->queryParams);
     	$objSiteUser = SiteUserSearch::getUserById(Yii::$app->request->queryParams['SiteFtpFileSearch']['INT_FK_SITE_USER_ID']);
    	return $this->render('ftpShowCustomerFile', [
    			'objSearchModel' => $objSearchModel,
    			'objDataProvider' => $objDataProvider,
    			'objSiteUser' => $objSiteUser,
    	]);
    }
    public function actionFtpAdd()
    {
    	$objSiteDownload = new SiteDownload(['scenario'=>SiteDownload::SCENARIO_FTP]);
    	$objSiteUserHasSiteUser = new SiteUserHasSiteUser();
    	$objSiteSpecialUserTitle = new SiteSpecialUserTitle();
    	$objSiteUserSearch = new SiteUserSearch();
    	$objErpPriceSearch = new ErpPriceSearch();
    	$objSiteFtpFile = new SiteFtpFile();
    	$componentMail = new MailComponent();
    	$objResultSiteUser = $objSiteUserSearch->getUserById(Yii::$app->request->get('intSiteUserId'));
    	$objLastDownload = $objSiteDownload->getDownloadAllById(Yii::$app->request->get('intSiteUserId'), (Yii::$app->request->get('type') == 'picture' ? 1 : 2));
    	$mixLastDownload = false;
    	$booShowLastDownload = false;
    	if($objLastDownload > 0)
    	{
    		$mixLastDownload = $objErpPriceSearch->getPriceByFkIdAndField(['INT_PK_ID_ERP_PRICE' => $objLastDownload->INT_FK_ERP_PRICE_ID],NULL, false);
    		$booShowLastDownload = true;
    	}
    	if($objResultSiteUser->BOO_SPECIAL_USER)
    	{
    		$objResultSiteUserHasSiteUser = $objSiteUserHasSiteUser->find()->where(['INT_FK_SITE_USER_ID' => Yii::$app->request->get('intSiteUserId')])->one();
    		$arrDropdownTitle = ArrayHelper::map($objSiteSpecialUserTitle->find()->where(['INT_FK_SITE_USER_ID' => $objResultSiteUserHasSiteUser->INT_PK_SITE_USER_ID_ADMINISTRATOR, 'BOO_STATUS' => 1])->orderBy('STR_TITTLE')->all(),'STR_TITTLE','STR_TITTLE');
    		if(count($arrDropdownTitle) == 0)
    			$objResultSiteUser->BOO_SPECIAL_USER = 0;
    	}
    	else
    		$arrDropdownTitle = [];
		if($objSiteDownload->load(Yii::$app->request->post())) 
    	{
    		if($objSiteDownload->validate())
    		{
    			$arrPost = Yii::$app->request->post();
    			$arrSiteFtpFile = [
    				'SiteFtpFile' => [
    					'TST_CREATION_DATE' => $arrPost['SiteDownload']['TST_CREATION_DATE'],
    					'INT_SHELF_LIFE' => ($arrPost['SHELF-LIFE'] > 0 ? $arrPost['SHELF-LIFE'] : 7),
    					'STR_NOTE' => $arrPost['SiteDownload']['STR_NOTE'],
    					'INT_FK_SITE_USER_ID' => $arrPost['SiteDownload']['INT_FK_ID_SITE_USER'],
    					'INT_FK_ERP_USER_ID' => Yii::$app->session->get('strIdErpUser'),
    				]
    			];
	    		foreach (explode(',', Yii::$app->request->post('front-file-code')) as $intCodeFile)
	    		{
	    			$objSiteDownload->setAttribute('INT_FK_ID_SITE_FILE', $intCodeFile);
	    			$arrSiteFtpFile['SiteFtpFile']['INT_FK_ID_SITE_FILE'] = $intCodeFile;
    				if($objSiteDownload->save())
	    			{
	    				$objSiteDownload->setAttribute('INT_PK_ID_SITE_DOWNLOAD',$objSiteDownload->getPrimaryKey()+1);
		    			$objSiteDownload->isNewRecord = true;
	    				if($objSiteFtpFile->load($arrSiteFtpFile))
	    				{
	    					$objSiteFtpFile->setAttribute('INT_FK_SITE_FILE_ID', $intCodeFile);
	    					$objSiteFtpFile->setAttribute('TST_CREATION_DATE', $arrSiteFtpFile['SiteFtpFile']['TST_CREATION_DATE']);
	    					$objSiteFtpFile->setAttribute('INT_SHELF_LIFE', $arrSiteFtpFile['SiteFtpFile']['INT_SHELF_LIFE']);
	    					$objSiteFtpFile->setAttribute('STR_NOTE', $arrSiteFtpFile['SiteFtpFile']['STR_NOTE']);
	    					$objSiteFtpFile->setAttribute('INT_FK_SITE_USER_ID', $arrSiteFtpFile['SiteFtpFile']['INT_FK_SITE_USER_ID']);
	    					$objSiteFtpFile->setAttribute('INT_FK_ERP_USER_ID', $arrSiteFtpFile['SiteFtpFile']['INT_FK_ERP_USER_ID']);
		    				if($objSiteFtpFile->save(false))
		    				{
		    					$objSiteFtpFile->setAttribute('INT_PK_ID_SITE_FTP_FILE', $objSiteFtpFile->getPrimaryKey()+1);
		    					$objSiteFtpFile->isNewRecord = true;
		    					$booSendMail = true;			
		    				}
		    				else 
		    					$booSendMail = false;
	    				}
	    			}
	    			else 
	    				$booSendMail = false;
	    			if($booSendMail)
	    			{
	    				$componentMail->ftpSendMail($objResultSiteUser->STR_NAME, $arrSiteFtpFile['SiteFtpFile']['INT_SHELF_LIFE'], $arrPost['STR_EMAIL'], $objResultSiteUser->STR_LOGIN, $objResultSiteUser->STR_PASSWORD, Yii::$app->session->get('strUserName'));
	    				$this->redirect('ftp-show-customer-file?SiteFtpFileSearch[INT_FK_SITE_USER_ID]='.$arrSiteFtpFile['SiteFtpFile']['INT_FK_SITE_USER_ID']);
	    			}
    			}
   			}
    	}
    	return $this->render('ftpAdd', [
    			'objSiteDownload' => $objSiteDownload,
    			'arrDropdownTitle' => $arrDropdownTitle,
    			'booSpecialUser' => $objResultSiteUser->BOO_SPECIAL_USER, 
    			'booShowEmail' => 1,
    			'strEmail' => $objResultSiteUser->STR_EMAIL,
    			'intFkErpPriceId' => $objLastDownload->INT_FK_ERP_PRICE_ID,
    			'booShowLastDownload' => $booShowLastDownload,
    			'strProjectName' => $objLastDownload->STR_PROJECT_NAME,	
    			'mixLastDownload' => $mixLastDownload,
    	]);
    }
    public function actionFtpUpdate($id)
    {
    	$objSiteDownload = new SiteDownload(['scenario'=>SiteDownload::SCENARIO_FTP]);
    	$objSiteUserHasSiteUser = new SiteUserHasSiteUser();
    	$objSiteSpecialUserTitle = new SiteSpecialUserTitle();
    	$objSiteUserSearch = new SiteUserSearch();
    	$objErpPriceSearch = new ErpPriceSearch();
    	$objSiteFtpFile = new SiteFtpFile();
    	$objSiteFile = new SiteFile();
    	$componentMail = new MailComponent();
    	$objResultSiteUser = $objSiteUserSearch->getUserById(Yii::$app->request->get('intSiteUserId'));
    	$objLastDownload = $objSiteDownload->getDownloadAllById(Yii::$app->request->get('intSiteUserId'), (Yii::$app->request->get('type') == 'picture' ? 1 : 2));
    	$mixLastDownload = false;
    	$booShowLastDownload = false;	
    	if($objLastDownload > 0)
    	{
    		$mixLastDownload = $objErpPriceSearch->getPriceByFkIdAndField(['INT_PK_ID_ERP_PRICE' => $objLastDownload->INT_FK_ERP_PRICE_ID],NULL, false);
    		$booShowLastDownload = true;
    	}
    	if($objResultSiteUser->BOO_SPECIAL_USER)
    	{
    		$objResultSiteUserHasSiteUser = $objSiteUserHasSiteUser->find()->where(['INT_FK_SITE_USER_ID' => Yii::$app->request->get('intSiteUserId')])->one();
    		$arrDropdownTitle = ArrayHelper::map($objSiteSpecialUserTitle->find()->where(['INT_FK_SITE_USER_ID' => $objResultSiteUserHasSiteUser->INT_PK_SITE_USER_ID_ADMINISTRATOR, 'BOO_STATUS' => 1])->orderBy('STR_TITTLE')->all(),'STR_TITTLE','STR_TITTLE');
    		if(count($arrDropdownTitle) == 0)
    			$objResultSiteUser->BOO_SPECIAL_USER = 0;
    	}
    	else
    		$arrDropdownTitle = [];
    	if($objSiteDownload->load(Yii::$app->request->post()))
    	{
    		if($objSiteDownload->validate())
    		{
    			$arrPost = Yii::$app->request->post();
    			$intPostIdSiteFile = $arrPost['SiteDownload']['INT_FK_ID_SITE_FILE'];
    			$arrSiteFtpFile = [
    					'SiteFtpFile' => [
	    					'INT_PK_ID_SITE_FTP_FILE' => $id,
	    					'TST_CREATION_DATE' => $arrPost['SiteDownload']['TST_CREATION_DATE'],
	    					'INT_SHELF_LIFE' => $arrPost['SHELF-LIFE'],
	    					'STR_NOTE' => $arrPost['SiteDownload']['STR_NOTE'],
	    					'INT_FK_SITE_USER_ID' => $arrPost['SiteDownload']['INT_FK_ID_SITE_USER'],
	    					'INT_FK_ERP_USER_ID' => Yii::$app->session->get('strIdErpUser'),
    					]
    			];
    			foreach (explode(',', Yii::$app->request->post('front-file-code')) as $intCodeFile)
    			{
    				$arrPost['SiteDownload']['INT_FK_ID_SITE_USER'] = Yii::$app->request->get('intSiteUserId');
    				$arrPost['SiteDownload']['INT_FK_ID_SITE_FILE'] = $arrPost['INT_PK_ID_SITE_DOWNLOAD'];
    				if($objSiteDownload->updateAllAttributes($arrPost['SiteDownload']))
    				{
    					$arrSiteFtpFile['SiteFtpFile']['INT_FK_SITE_FILE_ID'] = $intPostIdSiteFile;
    					if($objSiteFtpFile->updateAllAttributes($arrSiteFtpFile['SiteFtpFile']))
    						$booSendMail = true;
    					else
    						$booSendMail = false;
    				}
    				else
    				{
    					$booSendMail = false;
    				}
    				if($booSendMail)
    					$this->redirect('ftp-show-customer-file?SiteFtpFileSearch[INT_FK_SITE_USER_ID]='.$arrSiteFtpFile['SiteFtpFile']['INT_FK_SITE_USER_ID']);
    			}
    		}
     	}
     	$objValueDownload = $objSiteFile->getByIdFtpFileWithSiteFile(Yii::$app->request->get('intIdSiteFile'), (Yii::$app->request->get('type') == 'picture' ? 1 : 2), Yii::$app->request->get('intSiteUserId'));
     	$objDownloadPrice = $objSiteDownload->getDownloadAllByIdUserAndIdFile(Yii::$app->request->get('intSiteUserId'),(Yii::$app->request->get('type') == 'picture' ? 1 : 2), Yii::$app->request->get('intIdSiteFile'));
     
     	
     	$objLastErpPrice = $objErpPriceSearch->getPriceByFkIdAndField(['INT_PK_ID_ERP_PRICE' => $objDownloadPrice->INT_FK_ERP_PRICE_ID], '', false);
     	return $this->render('ftpUpdate', [
    			'objSiteDownload' =>$objSiteDownload,
    			'arrDropdownTitle' => $arrDropdownTitle,
    			'booSpecialUser' => $objResultSiteUser->BOO_SPECIAL_USER,
    			'booShowEmail' => 1,
    			'strEmail' => $objResultSiteUser->STR_EMAIL,
    			'intFkErpPriceId' => $objLastDownload->INT_FK_ERP_PRICE_ID,
    			'booShowLastDownload' => $booShowLastDownload,
    			'strProjectName' => $objLastDownload->STR_PROJECT_NAME,
    			'mixLastDownload' => $mixLastDownload,
    			'objValueDownload' => $objValueDownload,
    			'objLastErpPrice' => $objLastErpPrice,
    	]);
    }
    public function actionFtpDelete()
    {
    	foreach (explode(',', Yii::$app->request->queryParams['id']) as $strFtpFileId)
    		SiteFtpFile::deleteAll(['INT_PK_ID_SITE_FTP_FILE' => $strFtpFileId]);
    	$this->redirect('ftp-show-customer-file?SiteFtpFileSearch[INT_FK_SITE_USER_ID]='.Yii::$app->request->queryParams['intSiteUserId']);
    }
    public function actionSiteUser()
    {
    	$searchModel = new SiteUserSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams, 2);
    	return $this->render('siteUser', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }
    public function actionSiteUserAdd()
    {
    	$objSiteUser = new SiteUser(
    		['scenario'=>SiteUser::SCENARIO_CUSTOMER]
    	);
    	if ($objSiteUser->load(Yii::$app->request->post()) && $objSiteUser->save())
    		return $this->redirect(['site-user']);
    	else
    	{
    		return $this->render('siteUserAdd', [
    			'objSiteUser' => $objSiteUser,
    		]);
    	}
    }
    public function actionSiteUserUpdate($id)
    {
    	$objErpState = new ErpState();
    	$objErpCity = new ErpCity();
    	$objSiteUser = $this->findModelSiteUser($id);
    	$objErpCityResult = $objErpCity->getErpCityByParam(['INT_PK_ID_ERP_CITY' => $objSiteUser->INT_FK_ERP_CITY_ID]);
    	$objErpStateResult = $objErpState->getErpStateByParam(['INT_PK_ID_ERP_STATE' => $objErpCityResult->INT_FK_ERP_STATE_ID]);
    	$objSiteUser->scenarios(SiteUser::SCENARIO_CUSTOMER);
    	if ($objSiteUser->load(Yii::$app->request->post()) && $objSiteUser->save()) 
    		return $this->redirect(['site-user']);
    	else 
    	{
    		return $this->render('siteUserUpdate', [
    			'objSiteUser' => $objSiteUser,
    			'intPkIdErpState' => $objErpStateResult->INT_PK_ID_ERP_STATE,
    			'intFkErpCountryId' => $objErpStateResult->INT_FK_ERP_COUNTRY_ID,
    		]);
    	}
    }
    public function actionSiteUserDelete($id)
    {
    	$this->findModelSiteUser($id)->delete();
    	return $this->redirect(['site-user']);
    }
    protected function findModelSiteUser($id)
    {
    	if (($objSiteUser = SiteUser::findOne($id)) !== null)
    		return $objSiteUser;
    	else
    		throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionCustomerQuotation()
    {
    	$searchModel = new SiteQuoteSentSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	return $this->render('customerQuotation', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }
    public function actionCustomerQuotationAnswer()
    {
    	$searchModel = new SiteQuoteSentSearch();
    	$componentMail = new MailComponent();
    	$objSiteUserSearch = new SiteUserSearch();
    	
    	$arrParam = Yii::$app->request->get();
    	$objSiteQuoteSent = $this->findModelSiteQuotSent($arrParam['SiteQuoteSentSearch']['INT_PK_ID_SITE_QUOTE_SENT']);
    	if ($objSiteQuoteSent->load(Yii::$app->request->post()) && $objSiteQuoteSent->save()) 
    	{
    		$arrPost = Yii::$app->request->post();
    		$arrSearch = $objSiteUserSearch->getUserById( $arrPost['SiteQuoteSent']['INT_FK_SITE_USER_ID']);
    		$componentMail->customerQuotationAnswerSendMail(
    			$arrSearch->STR_NAME,
    			Yii::$app->session->get('strEmail'),
    			$arrSearch->STR_EMAIL,
    			$arrPost['SiteQuoteSent']['STR_PULSAR_MESSAGE']
    		);
    		return $this->redirect(['customer-quotation']);
    	}	
    	else
    	{
    		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    		return $this->render('customerQuotationAnswer', [
    			'objSiteQuoteSent' => $objSiteQuoteSent,
    			'dataProvider' => $dataProvider,	
    		]);
    	}
    }
    protected function findModelSiteQuotSent($id) 
    {
    	if (($objSiteQuoteSent = SiteQuoteSent::findOne($id)) !== null) 
    		return $objSiteQuoteSent;
    	else 
    		throw new NotFoundHttpException('The requested page does not exist.');
    	
    }
    public function actionDownloadReport()
    {
    	$objSiteUserSearch = new SiteUserSearch();
    	if(Yii::$app->request->get())
    	{
    		$objDataProviderLastMonth = false;
    		$datDateStart = SystemComponent::getDateForDb(Yii::$app->request->get('datFrom'));
     		$datDateFinish = SystemComponent::getDateForDb(Yii::$app->request->get('datTo'));
     	}
    	else 
    	{
    		$objDataProviderLastMonth = true;
    		$datDateStart = date('Y-m').'-01';
    		$datDateFinish = date('Y-m').'-31';
    		$datDateStartLastMonth = date('Y-m', strtotime('-1 months', strtotime(date('Y-m')))).'-01';
    		$datDateFinishLastMonth = date('Y-m', strtotime('-1 months', strtotime(date('Y-m')))).'-31';
    	}
    	Yii::$app->session->set('datDateStart', $datDateStart);
    	Yii::$app->session->set('datDateFinish', $datDateFinish);
    	Yii::$app->session->set('datDateStartLastMonth', $datDateStartLastMonth);
    	Yii::$app->session->set('datDateFinishLastMonth', $datDateFinishLastMonth);
    	$objDataProviderThisMonth = $objSiteUserSearch->searchDownloadReport(Yii::$app->request->queryParams, Yii::$app->session->get('datDateStart'),Yii::$app->session->get('datDateFinish'));
    	if($objDataProviderLastMonth)
    		$objDataProviderLastMonth = $objSiteUserSearch->searchDownloadReport(Yii::$app->request->queryParams, Yii::$app->session->get('datDateStartLastMonth'),Yii::$app->session->get('datDateFinishLastMonth'));
    	return $this->render('downloadReport',
    		[
    			'objSiteUserSearch' => $objSiteUserSearch,
    			'objDataProviderThisMonth' => $objDataProviderThisMonth,
    			'objDataProviderLastMonth' => $objDataProviderLastMonth,
    		]
    	);
    }
    public function actionDownloadReportCustomer()
    {
    	$objSiteUserSearch = new SiteUserSearch();
    	$objSiteDownloadSearch = new SiteDownloadSearch();
    	if(Yii::$app->request->get('booSpecialCustomer') == 1)
    	{	
    		$intIdSpecialUserPrefix = $objSiteUserSearch->getIdSpecialUserPrefix(Yii::$app->request->get('intUserId'));
    		foreach ($objSiteUserSearch->getAllIdsBySameIdPrefix($intIdSpecialUserPrefix) as $objRes)
    			$arrIdsSpecialUser[$objRes->INT_PK_ID_SITE_USER] = $objRes->INT_PK_ID_SITE_USER;
    		$objDataProviderDownloadByCustomer = $objSiteDownloadSearch->search(Yii::$app->request->queryParams, true, $arrIdsSpecialUser);
    		$objDataProviderByCustomer = $objSiteUserSearch->searchDownloadReportForSpecialCustomer(Yii::$app->request->queryParams, Yii::$app->session->get('datDateStart'),Yii::$app->session->get('datDateFinish'), $arrIdsSpecialUser);
    	}
    	else
    	{	
    		$arrIdsSpecialUser = 0;
    		$objDataProviderDownloadByCustomer = $objSiteDownloadSearch->search(Yii::$app->request->queryParams, true);
    		$objDataProviderByCustomer = $objSiteUserSearch->searchDownloadReport(Yii::$app->request->queryParams, Yii::$app->session->get('datDateStart'),Yii::$app->session->get('datDateFinish'));
    	}
    	return $this->render('downloadReportCustomer', [
    			'objSiteUserSearch' => $objSiteUserSearch,
    			'objDataProviderByCustomer' => $objDataProviderByCustomer,
    			'objSiteDownloadSearch' => $objSiteDownloadSearch,
    			'objDataProviderDownloadByCustomer' => $objDataProviderDownloadByCustomer,
    			'arrIdsSpecialUser' => $arrIdsSpecialUser,
    		]
    	);
    }
    public function actionChangeIdCompanyAndIdCustomer()
    {
    	$objSiteUser = new SiteUser();
    	$objErpCustomer = new ErpCustomer();
    	$objErpCustomerResult = $objErpCustomer->getErpCustomerById(Yii::$app->request->post('intIdCustomer'));
    	$objCustomerIdAndCompany = SiteUser::findOne(['INT_PK_ID_SITE_USER' => Yii::$app->request->post('intUserId')]);
    	$objCustomerIdAndCompany->INT_FK_ERP_CUSTOMER_ID = $objErpCustomerResult->INT_PK_ID_ERP_CUSTOMER;
    	$objCustomerIdAndCompany->INT_FK_ERP_COMPANY_ID = $objErpCustomerResult->INT_FK_ERP_COMPANY_ID;
    	if($objCustomerIdAndCompany->update() !== false)
    		return true;
    	else 
    		return false;
    }
    public function actionChangeDownloadTitleByStringIds()
    {
    	try 
    	{
    		$arrIdDownload = explode(',', Yii::$app->request->post('strIdDownload'));
    		foreach ($arrIdDownload as $arrId)
    		{
    			$objEditTitleSiteDownload = SiteDownload::findOne(['INT_PK_ID_SITE_DOWNLOAD' => $arrId]);
    			$objEditTitleSiteDownload->STR_PROJECT_NAME = Yii::$app->request->post('strTitle');  
    			$objEditTitleSiteDownload->update(false);
     		}
     		$this->redirect(Yii::$app->request->post('strRedirect'));
    	}
    	catch (Exception $e)
    	{
    		return 'Não foi possível alterar os titulos selecionados';	
    	}
    	$this->redirect(Yii::$app->request->post('strRedirect'));
    }
    public function actionChangeInvoiceDownload()
    {
    	try
    	{
    		$arrIdDownload = explode(',', Yii::$app->request->post('strIdDownload'));
    		foreach ($arrIdDownload as $arrId)
    		{
    			$objEditTitleSiteDownload = SiteDownload::findOne(['INT_PK_ID_SITE_DOWNLOAD' => $arrId]);
    			$objEditTitleSiteDownload->BOO_INVOICE = 1;
    			$objEditTitleSiteDownload->update(false);
    		}
			$this->redirect('/administrative/license?booSearch=0&strIdDownload='.Yii::$app->request->post('strIdDownload'));
    	}
    	catch (Exception $e)
    	{
    		return 'Não foi possível alterar o status para faturodo dos itens selecionados';
    	}
    }
}