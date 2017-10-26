<?php
namespace app\components;
use yii\base\Component;
class SystemComponent extends Component
{
	private $arrReturn = [];
	private $strToExplode = '';
	public function getExplodeStringInArray($stringToExplode, $arrCharactersToExplode)
	{
		$this->strToExplode = $stringToExplode;
		if($this->setStringToExplodeReplecedByComma($arrCharactersToExplode))
		{
			$arrTemp = explode(',',$this->strToExplode);
			foreach ($arrTemp as $intKey => $strlineValue)
			{
				if($strlineValue != '' && $strlineValue != NULL)
					$this->arrReturn[$intKey] = $strlineValue;
			}
			return true;
		}
		return false;
	}
	private function setStringToExplodeReplecedByComma($arrDelimite)
	{
		if(is_array($arrDelimite))
		{
			foreach ($arrDelimite as $strValue)
				$this->strToExplode = str_replace($strValue, ',', $this->strToExplode);
			return true;
		}
		else 
			return false;
	}
	public function getArrReturn($strBackField = null)
	{
		if($strBackField == null)
			return $this->arrReturn;
		else 
			return $this->arrReturn[$strBackField];
	}
	public function getArrWhenDefaultValue($arrReturn, $arrValueForReturn, $mixDefaultValue = '0')
	{
		if(is_array($arrReturn))
		{
			foreach ($arrReturn as $key => $value)
			{
				if($arrValueForReturn[$key] !== null)
				{
					if($arrValueForReturn[$key] !== '')
						$this->arrReturn[$key] = $arrValueForReturn[$key];
					else 
						$this->arrReturn[$key] = $mixDefaultValue;
				}
				else 
					$this->arrReturn[$key] = $mixDefaultValue;
			}
		}
	}
	public function getDateForDb($strDate)
	{
		$arrDate = explode('/',$strDate);
		Return $arrDate[2].'-'.$arrDate[1].'-'.$arrDate[0];
	}
	public function getDataSiteFile($strString)
	{
		if($strString != '')
		{
			return substr($strString, 4,6).'/'.substr($strString, 0,4);
		}
		else 
			return 'N/A';
	}
	public function getDropdownValue($arrDropdown, $strKeyValue, $strTextValue)
	{
		try 
		{
			foreach ($arrDropdown as $arrValue)
				$arrReturn[trim($arrValue[$strTextValue])] = trim($arrValue[$strTextValue]);
			return $arrReturn;
		}
		catch (\Exception $e)
		{
			return [];
		}
	}
}