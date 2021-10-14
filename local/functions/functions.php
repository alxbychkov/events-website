<?php
use \Bitrix\Main\Web\Json;

#
# Убираем из телефона все лишнее, кроме цифр
#
function ParsePhone($str)
{
	if (strlen($str) <= 0):
		return false;
	endif;
	$string = preg_replace('~\D~', '', $str);

	return $string;
}

/**
 * Дебагер
 * @param string $message
 * @param bool   $title
 * @param string $color
 */
function DebugMessage($message = "", $title = false, $color = "#008B8B")
{
	Global $USER;
	if (!is_object($USER))
	{
		$USER = new CUser;
	}
	if ($USER->IsAdmin())
	{
		echo '<table border="0" cellpadding="5" cellspacing="0" style="border:1px solid ' . $color .
				';margin:2px;"><tr><td>';
		if (strlen($title) > 0)
		{
			echo '<p style="color: ' . $color . ';font-size:11px;font-family:Verdana;">[' . $title . ']</p>';
		}
		if (is_array($message) || is_object($message))
		{
			echo '<pre style="color:' . $color . ';font-size:11px;font-family:Verdana;">';
			print_r($message);
			echo '</pre>';
		}
		else
		{
			echo '<p style="color:' . $color . ';font-size:11px;font-family:Verdana;">' . $message . '</p>';
		}
		echo '</td></tr></table>';
	}
}

/**
 * @param      $var - массив или объект
 * @param bool $stop - прекратить выполнение скрипта
 * @param bool $inconsole - вывод в консоль
 * @param bool $UID - ID пользователя
 */
function pre($var, $stop = false, $inconsole = false, $UID = false)
{
	$bt = debug_backtrace();
	$bt = $bt[0];
	$dRoot = $_SERVER["DOCUMENT_ROOT"];
	$dRoot = str_replace("/", "\\", $dRoot);
	$bt["file"] = str_replace($dRoot, "", $bt["file"]);
	$dRoot = str_replace("\\", "/", $dRoot);
	$bt["file"] = str_replace($dRoot, "", $bt["file"]);
	if ($GLOBALS['USER']->IsAdmin())
	{
		if ($UID && intval($UID) !== $GLOBALS['USER']->GetID()) return;
		if ($inconsole)
		{
			echo "<script>console.log('File: " . $bt['file'] . " [" . $bt['line'] . "]');console.debug(" . json_encode($var) . ");</script>";
		}
		else
		{
			echo '<div style="padding:3px 5px; background:#99CCFF; font-weight:bold;">File: ' . $bt["file"] . ' [' . $bt["line"] . ']</div>';
			echo '<pre style="text-align: left">';
			((is_array($var) || is_object($var)) ? print_r($var) : var_dump($var));
			echo '</pre>';
		}
		if ($stop) exit(0);
	}
}

/**
 * @param        $var - переменная
 * @param string $module - модуль
 */
function log2file($var, $module = '')
{
	if (!defined('LOG_FILENAME'))
	{
		if (!file_exists($_SERVER["DOCUMENT_ROOT"] . "/log/")) mkdir($_SERVER["DOCUMENT_ROOT"] . "/log/");
		define('LOG_FILENAME', $_SERVER["DOCUMENT_ROOT"] . "/local/log/log_" . date("dmY") . ".txt");
	}
	else
	{
		if (!file_exists(dirname(LOG_FILENAME))) mkdir(dirname(LOG_FILENAME));
	}

	$bt = debug_backtrace();
	$bt = $bt[0];
	$dRoot = $_SERVER["DOCUMENT_ROOT"];
	$dRoot = str_replace("/", "\\", $dRoot);
	$bt["file"] = str_replace($dRoot, "", $bt["file"]);
	$dRoot = str_replace("\\", "/", $dRoot);
	$bt["file"] = str_replace($dRoot, "", $bt["file"]);

	ob_start();
	echo PHP_EOL . date('d.m.Y H:i:s') . ' ----------======= File: ' . $bt["file"] . ' [' . $bt["line"] . ']=======----------' . PHP_EOL;
	if (strlen($module) > 0) echo '+++' . strtoupper($module) . '+++' . PHP_EOL;
	((is_array($var) || is_object($var)) ? print_r($var) : var_dump($var)) . PHP_EOL;
	echo str_repeat('=', 100) . PHP_EOL;
	$out1 = ob_get_contents();
	ob_end_clean();

	file_put_contents(LOG_FILENAME, $out1 . PHP_EOL, FILE_APPEND | LOCK_EX);
}

/**
 * Проверяем, является ли $password текущим паролем пользователя.
 * @param int    $userId
 * @param string $password
 * @return bool
 */
function isUserPassword($userId, $password)
{
	$userData = CUser::GetByID($userId)->Fetch();

	$salt = substr($userData['PASSWORD'], 0, (strlen($userData['PASSWORD']) - 32));

	$realPassword = substr($userData['PASSWORD'], -32);
	$password = md5($salt . $password);

	return ($password == $realPassword);
}

/**
 * finishScript: Вспомогательная функция для завершения ajax скриптов -
 *               чтобы возвращать статус и сообщение
 * @param $bStatus
 * @param $strMessage
 * @param $arData
 */
function finishScript($bStatus, $strMessage, $arData = null)
{
	global $APPLICATION;
	$result = array();
	$result["status"] = $bStatus;
	$message = is_array($strMessage) ? implode("<br/>", $strMessage) : $strMessage;
	$result["message"] = $strMessage;
	if (!empty($arData))
	{
		$result["data"] = $arData;
	}
	$APPLICATION->RestartBuffer();
	header("Content-Type: application/json; charset=" . SITE_CHARSET);
	echo Json::encode($result);
	\CMain::FinalActions();
	die();
}

/**
 * getNumEnding: Функция возвращает окончание для множественного числа слова на основании числа и массива окончаний
 * param  $number Integer Число на основе которого нужно сформировать окончание
 * param  $endingsArray  Array Массив слов или окончаний для чисел (1, 4, 5),
 *         например array('яблоко', 'яблока', 'яблок')
 * return String
 */
function getNumEnding($number, $endingArray)
{
	if ($number >= 11 && $number <= 19)
	{
		$ending = $endingArray[2];
	}
	else
	{
		$i = $number % 10;
		switch ($i)
		{
			case (1):
				$ending = $endingArray[0];
				break;
			case (2):
			case (3):
			case (4):
				$ending = $endingArray[1];
				break;
			default:
				$ending = $endingArray[2];
		}
	}

	return $ending;
}

/**
 * NumberWordEndingsEx: Определение окончания множественного числа
 * @param      $num
 * @param bool $arEnds
 * @return string
 */
function NumberWordEndingsEx($num, $arEnds = false)
{
	$lang = LANGUAGE_ID;
	if ($arEnds === false)
	{
		$arEnds = array('ов', 'ов', '', 'а');
	}
	if ($lang == 'ru')
	{
		if (strlen($num) > 1 && substr($num, strlen($num) - 2, 1) == '1')
		{
			return $arEnds[0];
		}
		else
		{
			$c = IntVal(substr($num, strlen($num) - 1, 1));
			if ($c == 0 || ($c >= 5 && $c <= 9))
			{
				return $arEnds[1];
			}
			elseif ($c == 1)
			{
				return $arEnds[2];
			}
			else
			{
				return $arEnds[3];
			}
		}
	}
	elseif ($lang == 'en')
	{
		if (IntVal($num) > 1)
		{
			return 's';
		}

		return '';
	}
	else
	{
		return '';
	}
}

/**
 * GetThumb: Создает миниатюры картинок. Внимание, при изменении
 * параметров размера, фото с предыдущими размерами автоматически НЕ
 * удаляются - может быть переполнение диска
 * @param $Image
 * @param $width
 * @param $height
 * @param $resizeType
 * @param $arWaterMark
 * @return bool|string
 */
function GetThumb($Image, $width, $height, $resizeType = BX_RESIZE_IMAGE_PROPORTIONAL, $arWaterMark)
{
	$result = false;
	if (!is_array($Image) && strpos($Image, 'http') !== false)
	{
		$sourceFileName = basename($Image);
		if (!file_exists($_SERVER["DOCUMENT_ROOT"] . '/upload/thumbs/tmp/'))
		{
			mkdir($_SERVER["DOCUMENT_ROOT"] . '/upload/thumbs/');
			mkdir($_SERVER["DOCUMENT_ROOT"] . '/upload/thumbs/tmp/');
		}
		$local_destination_File = '/upload/thumbs/tmp/' . $sourceFileName;
		$destination_File = $_SERVER["DOCUMENT_ROOT"] . $local_destination_File;
		$sourceFileHeaders = @get_headers($Image);
		if (!file_exists($destination_File) && (preg_match("|200|", $sourceFileHeaders[0])))
		{
			$arSourceFile = CFile::MakeFileArray($Image);
			#file_put_contents($destination_File, file_get_contents($Image));
			file_put_contents($destination_File, file_get_contents($arSourceFile));
		}

		$arFile = CFile::MakeFileArray($Image);
		if (is_array($arFile))
		{
			$arFile['MODULE_ID'] = 'iblock';
			$Image = $local_destination_File;
		}
		// $Image = CFile::SaveFile($arFile);
	}

	if ((is_array($Image) && isset($Image['SRC'])) || (intval($Image) > 0))
	{
		// work with ResizeImageGet
		$file = CFile::ResizeImageGet(
				$Image,
				array('width' => $width, 'height' => $height),
				$resizeType,
				true,
				$arWaterMark
		);
		if (isset($file['src']) && strlen($file['src']) > 0)
			$result = $file['src'];
		elseif (!is_array($Image) && intval($Image) > 0)
		{
			$result = CFile::GetPath(intval($Image));
		}
		else
			$result = $Image['SRC'];
	}
	else
	{
		// work with ResizeImageFile
		$arSource = explode('.', $Image);
		$arSource[count($arSource) - 2] .= '-' . $width . 'x' . $height;
		$localdestinationFile = implode('.', $arSource);

		$destinationFile = $_SERVER["DOCUMENT_ROOT"] . $localdestinationFile;
		$sourceFile = $_SERVER["DOCUMENT_ROOT"] . $Image;

		if (strlen($destinationFile) > 0)
		{
			if (!file_exists($destinationFile))
			{
				if (count($arWaterMark) > 0):
					#/bitrix/templates/ukrsemena/img/znak4.png
					#$arWaterMark
				endif;
				$rif = CFile::ResizeImageFile(
						$sourceFile,
						$destinationFile,
						$arSize = array('width' => $width, 'height' => $height),
						$resizeType = $resizeType,
						$arWaterMark
				);

			}
			if (file_exists($destinationFile))
			{
				$result = $localdestinationFile;
			}
			else
			{
				$result = $sourceFile;
			}
		}

	}

	return $result;
}

if( !function_exists('PhoneToHref') ) {
	function PhoneToHref($strPhone)
	{
		$ret = $strPhone;
		$ret = str_replace(",", '.', $ret);
		$ret = preg_replace("/[^x\d|*\.]/", "", $ret);	
		return '+' . $ret;
	}
}

#
# Вывод массива
#
function debug($array) {
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

#
# Получение пользовательского поля
#
function GetUserField($entity_id, $value_id, $property_id) 
{ 
   $arUF = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields ($entity_id, $value_id); 
   return $arUF[$property_id]["VALUE"]; 
} 

#
# Установка пользовательского поля
#
function SetUserField($entity_id, $value_id, $uf_id, $uf_value) 
{ 
   return $GLOBALS["USER_FIELD_MANAGER"]->Update ($entity_id, $value_id, 
   Array ($uf_id => $uf_value)); 
}

#
# Определение страницы
#
function is_current_page($pages = '/') {
	
	global $APPLICATION;
	
	$url = $APPLICATION->GetCurPage();
	return strpos($url, $pages) ? true : false;
}

#
# Получаем пользоватльское поле пользователя
#
function userCustomFields($idUser, $name) {
	$rsUser = CUser::GetByID($idUser);
	$arUser = $rsUser->Fetch();
	return $arUser[$name];
}

#
# Получаем все мероприятия за год
#
function getEventsDates($blockId, $year = '') {
	if (CModule::IncludeModule("iblock")) {
		if ($year == '') $year = (new DateTime())->format('Y');
		$events = array();
		$blockEvents = CIBlockElement::GetList (
		  Array("ID" => "ASC"),
		  Array("IBLOCK_ID" => $blockId, ">=DATE_ACTIVE_FROM" => "01.01.".$year, "<=DATE_ACTIVE_FROM" => "31.12.".$year),
		  false,
		  false,
		  Array('*')
		);
	   
		while($arItem = $blockEvents->GetNext())
		{
			$month = strtolower(FormatDate("n", MakeTimeStamp($arItem['DATE_ACTIVE_FROM'])));
			$day = (int)strtolower(FormatDate("d", MakeTimeStamp($arItem['DATE_ACTIVE_FROM'])));
			$days = [];

			if ($arItem['DATE_ACTIVE_TO']) {
				$currentDay = (new DateTime($arItem['DATE_ACTIVE_FROM']))->format('d.m.Y');
				$lastDay = (new DateTime($arItem['DATE_ACTIVE_TO']))->format('d.m.Y');

				while (strtotime($currentDay) <= strtotime($lastDay)) {
					$days[] = $currentDay;
					$nextDay = (new DateTime($currentDay . '+1 day'))->format('d.m.Y');
					$currentDay = $nextDay;	
				}

				foreach($days as $item) {
					$month = strtolower(FormatDate("n", MakeTimeStamp($item)));
					$day = (int)strtolower(FormatDate("d", MakeTimeStamp($item)));

					if (!$events[$month]) {
						$events[$month] = array($day);
					} else {
						array_push($events[$month], $day);
					}					
				}
			} else {
				if (!$events[$month]) {
					$events[$month] = array($day);
				} else {
					array_push($events[$month], $day);
				}
			}
			
		}
		return $events;
	}

	return false;
}


#
# Получаем незаконченные мероприятия
#
function getFutureEvents($blockId) {
	$today = (new DateTime())->format('d.m.Y');
	if (CModule::IncludeModule("iblock")) {
		$events = array();
		$blockEvents = CIBlockElement::GetList (
		  Array("ID" => "ASC"),
		  Array("IBLOCK_ID" => $blockId, ">=DATE_ACTIVE_FROM" => $today),
		  false,
		  false,
		  Array('ID')
		);

		while($arItem = $blockEvents->GetNext())
		{
			$events[] = $arItem["ID"];
		}
		return $events;
	}
	return false;
}

#
# Проверка полей с форм
#
function clean($value = "") {
	$value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    
    return $value;
}

#
# Image conver to Webp
#
function makeWebp($src) {
	$newImgPath = false;
	$folderPath = $_SERVER["DOCUMENT_ROOT"];
	if ($src && function_exists('imagewebp')) {
		$newImgPath = str_replace(array('.jpg', '.jpeg', '.gif', '.png'), '.webp', $src);
		if (!file_exists($folderPath.$newImgPath)) {
			$info = getimagesize($folderPath.$src);
			if ($info !== false && ($type = $info[2])) {
				switch ($type) {
					case IMAGETYPE_JPEG:
						$newImg = imagecreatefromjpeg($folderPath.$src);
						break;
					case IMAGETYPE_GIF:
						$newImg = imagecreatefromgif($folderPath.$src);
						break;
					case IMAGETYPE_PNG:
						$newImg = imagecreatefrompng($folderPath.$src);
						break;
				}
				if ($newImg) {
					imagewebp($newImg, $folderPath.$newImgPath, 90);
					imagedestroy($newImg);
				}
			}
		}
	}
	return $newImgPath;
}

#
#Создаем превью изображение для pdf
#Нужно установленное расширение для php ImageMagick
#
function createrPdfPreviewImage($pdf) {
	if (!$pdf) return false;
	if (!extension_loaded('imagick')) return false;
	
	$file = pathinfo($pdf);
	if ($file['extension'] != 'pdf') return false; 
	$pdfPath = $_SERVER['DOCUMENT_ROOT'] . $pdf . '[0]';
	$imagePath = $file['dirname'] . '/' . $file['filename'] . '.jpg';
	$imageName = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
	
	if (!file_exists($imageName)) {
		$image = new imagick($pdfPath);
		$image->writeImage($imageName);
	}
	return $imagePath;
}

#
# Месяц с английского на русский
#
function RU_month($name) {
	$months = array('January' => 'Январь', 'February' => 'Февраль', 'March' => 'Март', 'April' => 'Апрель', 'May' => 'Май', 'June' => 'Июнь', 'July' => 'Июль', 'August' => 'Август', 'September' => 'Сентябрь', 'October' => 'Октябрь', 'November' => 'Ноябрь', 'December' => 'Декабрь');
	return $months[$name];
}

#
# Получаем годы мероприятий
#
function get_events_years($blockId) {
	$query = new \Bitrix\Main\Entity\Query(Bitrix\Iblock\ElementTable::getEntity());
	$query->registerRuntimeField(
		"YEAR", 
		array(
			"data_type" => "Datetime",
			"expression" => array("LEFT(ACTIVE_FROM,4)", "ACTIVE_FROM")
	))
	->setSelect(array('YEAR'))
	->setFilter(array("IBLOCK_ID" => $blockId,'ACTIVE'=>'Y','!ACTIVE_FROM'=>''))
	->setOrder(array("YEAR" => "ASC"))
	->setGroup(array("YEAR"));
	// ->setLimit(5);
	$db = $query->exec();
	$arrYears = $db->fetchAll();
	return $arrYears;
}

#
#ФУНКЦИЯ КОТОРАЯ ДЕЛАЕТ ЗАПРОС НА GOOGLE СЕРВИС
#
function getCaptcha($SecretKey, $key) {
	$url = 'https://www.google.com/recaptcha/api/siteverify?secret='.$key.'&response='.$SecretKey;
	$return = false;

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);

	if (!empty($response)) {
		$return = json_decode($response);
	}
		
	return $return;
}

?>