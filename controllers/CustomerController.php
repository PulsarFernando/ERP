<?php
namespace app\controllers;
use Yii;
use app\models\SiteUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\SiteUserLanguage;
use yii\helpers\ArrayHelper;
use app\models\SiteUserTypeNewsletter;
class CustomerController extends Controller
{
    public function actionAddTemporaryCustomer()
    {
        $objSiteUser = new SiteUser(
        	['scenario'=>SiteUser::SCENARIO_TEMPORARY_CUSTOMER]
        );
        $objSiteUserLanguage = new SiteUserLanguage();
        $objSiteUserTypeNewsletter = new SiteUserTypeNewsletter();
        
        if ($objSiteUser->load(Yii::$app->request->post()) && $objSiteUser->save()) 
        {
            return $this->redirect(
	            [
	            	'/site/ftp', 
	            	'SiteUserSearch[STR_LOGIN]' => $objSiteUser->STR_LOGIN,
	            	'SiteUserSearch[STR_NAME]' => '',
	            	'SiteUserSearch[STR_EMAIL]' => '',
	            	'SiteUserSearch[STR_SPECIAL_USER_PREFIX]' => '',
	            ]
            );
        } 
        else 
        {
            return $this->render('addTemporaryCustomer', [
                'objSiteUser' => $objSiteUser,
            	'arrItemsLanguage' => ArrayHelper::map($objSiteUserLanguage->find()->all(),'INT_PK_ID_SITE_USER_LANGUAGE','STR_NAME_LANGUAGE_PT'),
            	'arrItemsTypeNewsletter' => ArrayHelper::map($objSiteUserTypeNewsletter->find()->all(),'INT_PK_ID_SITE_USER_TYPE_NEWSLETTER','STR_TYPE_NEWLETTER_NAME_PT'),
            ]);
        }
    }
    protected function findModel($id)
    {
        if (($model = SiteUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}