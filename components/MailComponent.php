<?php
namespace app\components;
use Yii;
use yii\base\Component;
class MailComponent extends Component
{
	public function ftpSendMail($strPulsarUser, $intValidity, $strSendTo, $strLogin, $strPassword, $strErpUser = 'Equipe Pulsar Imagens')
	{
		$mixEmail = $this->explodeEmailsByCommaOrSemicolon($strSendTo);
		Yii::$app->mailer->compose(
			'layouts/ftpMail',
			[
				'strName'	=>	$strPulsarUser,	
				'intValidity' => $intValidity,
				'strLogin' => $strLogin,
				'strPassword' => $strPassword,
				'strErpUser' => $strErpUser,
			]
		)
		->setFrom('pulsar@pulsarimagens.com.br')
		->setTo($mixEmail)
		->setBcc([
			//'pulsar@pulsarimagens.com.br',
			//'pulsarimagensltda@gmail.com',
			'fernandomdib@gmail.com',
		])
		->setSubject('Seus arquivos já estão disponíveis em nosso FTP')
		->send();
	}
	public function customerQuotationAnswerSendMail($strCustomerName, $strSendFrom, $strSendTo, $strMessage, $strErpUser = 'Equipe Pulsar Imagens')
	{
		Yii::$app->mailer->compose(
				'layouts/quotationAnswerSendMail',
				[
						'strErpUser' =>	$strErpUser,
						'strMessage' => $strMessage,
						'strCustomerName' => $strCustomerName,
				]
				)
				->setFrom('pulsar@pulsarimagens.com.br')
				->setTo($strSendTo)
				->setBcc([
						//'pulsar@pulsarimagens.com.br',
						//'pulsarimagensltda@gmail.com',
						'fernandomdib@gmail.com',
				])
				->setReplyTo($strSendFrom)
				->setSubject('Seus arquivos já estão disponíveis em nosso FTP')
				->send();
	}
	private function explodeEmailsByCommaOrSemicolon($strEmail)
	{
		
		if(substr_count($strEmail,','))
			$strEmail = str_replace(',', ';', $strEmail);
		if(substr_count($strEmail,';'))
			$mixReturn = explode(';', $strEmail);
		if(count($mixReturn) > 0)
		{
			foreach ($mixReturn as $intKey => $strRow)
				$mixReturn[$intKey] =  trim($strRow);
		}
		else 
			$mixReturn[0] =  trim($strEmail);
		if(!isset($mixReturn))
			$mixReturn[0] = trim($strEmail);	
		return $mixReturn;
	}
}