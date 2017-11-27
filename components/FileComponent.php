<?php
namespace app\components;
use Imagine\Gd\Image;
class FileComponent extends ErpGlobal
{
	private $strPictureS3 = 's3://pulsar-media/fotos/orig/';
	private $strCopyLocation = '/var/www/php7/erpHomolog/images/copyS3/';
	public function setCopyLocation($strCopyLocation)
	{
		$this->strCopyLocation = $strCopyLocation;
	}
	public function getCopyLocation()
	{
		return $this->strCopyLocation;
	}
	public function copyS3($strFile)
	{
 		shell_exec('aws --profile pulsar s3 cp '.$this->strPictureS3.$strFile.$this->strExtensionJpg.' '.$this->strCopyLocation.$strFile.$this->strExtensionJpg); 
 		if(file_exists($this->strCopyLocation.$strFile.$this->strExtensionJpg))
 		{
 			chmod($this->strCopyLocation.$strFile.$this->strExtensionJpg, 0777);
			return true;
 		}
 		else
 			return false;
	}
	public function createThumbnail($arrThumb = ['strPathImage' => '', 'intHorizontaSize' => 0, 'intVerticalSize' => 0, 'strPathSave' => '', 'strPrefix' => 'thumb_'])
	{
		try 
		{
			Image::thumbnail($this->strCopyLocation.$arrThumb['strPathImage'].$this->strExtensionJpg,  $arrThumb['intHorizontaSize'], $arrThumb['intVerticalSize'])->save($this->strCopyLocation.$arrThumb['strPathSave'].$this->strExtensionJpg);
			return true;
		}
		catch (Exception $e)
		{
			return false;	
		}
	}
	public function cropImage($arrCrop = ['strPathImage' => '', 'intHorizontaSize' => 0, 'intVerticalSize' => 0, 'intHorizontaCropSize' => 0, 'intVerticalCropSize' => 0, 'strPathSave' => ''])
	{
		try
		{
			Image::crop(
					$arrCrop['strPathImage'],
					$arrCrop['intHorizontaSize'],
					$arrCrop['intVerticalSize'],
				[
					$arrCrop['intHorizontaCropSize'],
					$arrCrop['intVerticalCropSize']
				]
			)->save($arrCrop['strPathSave']);
			return true;
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	public function changeFileFolder($strOriginPath, $strDestionationPath)
	{
		
	}
}