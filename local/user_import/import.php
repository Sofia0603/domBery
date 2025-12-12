<?
$_SERVER['DOCUMENT_ROOT'] = '/home/z/zembery/zembery.beget.tech/public_html';

define('LANG', 's1');
define('BX_UTF', true);
define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_BUFFER_USED', true);

require('vendor/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
header("Cache-Control: no-cache, must-revalidate");
header('Content-type: text/html; charset=utf-8' );
header('X-Accel-Buffering: no');
ini_set('output_buffering', 0);
ini_set('zlib.output_compression',0);
ini_set('implicit_flush',1);
ini_set('mbstring.func_overload',2);
ini_set('auto_detect_line_endings',TRUE);
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time',0);
ini_set("log_errors", TRUE);  
ini_set('error_log', 'log_errors.log'); 
//error_reporting(E_ALL | E_PARSE);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

@ob_end_flush();
@flush();

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

function e($mess){
	echo $mess.PHP_EOL;
}

function addUser($name, $phone, $email, $birthday, $strUch, $village){
	$user = new CUser;
	$password = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10);
	$arFields = Array(
		"NAME"              => $name,
		"EMAIL"             => $email,
		"PERSONAL_MOBILE"	=> $phone,
		"LOGIN"             => $email,
		"LID"               => "ru",
		"ACTIVE"            => "Y",
		'PERSONAL_BIRTHDAY' => $birthday,
		"GROUP_ID"          => array(3,4,5,$village),
		"PASSWORD"          => $password,
		"CONFIRM_PASSWORD"  => $password,
		"UF_UCH" 			=> $strUch,
	);
	$ID = $user->Add($arFields);
	if (intval($ID) > 0)
		e('Пользователь '.$name.' '.$lastname.' добавлен');
	else
		e($user->LAST_ERROR);
	unset($user);
}

function updateUser($ID, $name, $phone, $email, $birthday,$strUch, $village){
	$user = new CUser;
	$password = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10);
	$arFields = Array(
		"NAME"              => $name,
		"EMAIL"             => $email,
		"PERSONAL_MOBILE"	=> $phone,
		"LOGIN"             => $email,
		"LID"               => "ru",
		"ACTIVE"            => "Y",
		'PERSONAL_BIRTHDAY' => $birthday,
		"GROUP_ID"          => array(3,4,5,$village),
		"PASSWORD"          => $password,
		"CONFIRM_PASSWORD"  => $password,
		"UF_UCH" 			=> $strUch,
	);
	if ($user->Update($ID,$arFields)) 
		e('Пользователь '.$ID.' '.$name.' '.$lastname.' обновлен');
	else 
		e($user->LAST_ERROR);
	unset($user);
}

function addGroup($name){
	$group = new CGroup;
	$arFields = Array(
		"ACTIVE"       => "Y",
		"NAME"         => $name,	
	);
		if ($group->Add($arFields)) 
			e('Группа '.$name.' добавлена');
		else 
			e($group->LAST_ERROR);
		unset($group);
}

function findUserByEmail($email){
	$rsUsers = CUser::GetList($by="c_sort", $order="asc", Array('EMAIL' => $email)); 
	if ($userfound = $rsUsers->Fetch()){
		return $userfound['ID'];
	} else {
		return false;
	}
}

function findUserByName($name){
	$rsUsers = CUser::GetList($by="c_sort", $order="asc", Array('NAME' => $name)); 
	if ($userfound = $rsUsers->Fetch()){
		return $userfound['ID'];
	} else {
		return false;
	}
}

function getUserUch($uid) //возвращает номера участков, купленных клиентом
{
		$rsUsers = CUser::GetList($by = "c_sort", $order = "asc", Array('ID' => $uid), Array('SELECT' => Array('UF_UCH')));
		$user = $rsUsers->Fetch();
		$arrUch = explode(',',$user['UF_UCH']);
		return $arrUch; 
}

function findGroupByName ($name)
{
	$rsGroups = CGroup::GetList ($by = "c_sort", $order = "asc", Array ("NAME" => $name));
	if ($groupfound = $rsGroups->Fetch()){
		return $groupfound['ID'];
	} else {
		return false;
	}
} 

$data = array();
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('data.xlsx');

foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
    $data[$worksheet->getTitle()] = $worksheet->toArray(null, true, false);
}
// save memory
$spreadsheet->__destruct();
$spreadsheet = NULL;
unset($spreadsheet);



foreach ($data as $wTitle => $wData){
 	if (!findGroupByName($wTitle)) $gid = addGroup($wTitle); else $gid = findGroupByName($wTitle);
 	
 	foreach ($wData as $key => $userRow) {
 		if ($key == 0) continue;
 		if ($userRow[1] == NULL) continue;
 		
 		$uch = $userRow[0];
 		$name = trim($userRow[1]);
 		$phone = $userRow[2];
 		$birthday = NumberFormat::toFormattedString($userRow[3], 'DD.MM.YYYY'); //birthday
 		$email = $userRow[4];
 		
 		if ($email && $uid = findUserByEmail($email))
 		{
 			$arrUch = getUserUch($uid);
 			$arrUch[] = $uch;
 			$strUch = implode(',', $arrUch);
 			updateUser($uid, $name, $phone, $email, $birthday, $strUch,$gid);
 		} elseif($email) {
			addUser($name, $phone, $email, $birthday, $uch, $gid);
 		} else {
 			if ($uid = findUserByName($name)){
 				$email = 'no-email-'.substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5).'@zembery.ru';
 				$arrUch = getUserUch($uid);
	 			$arrUch[] = $uch;
	 			$strUch = implode(',', $arrUch);
	 			updateUser($uid, $name, $phone, $email, $birthday, $strUch,$gid);
 			} else {
 				$email = 'no-email-'.substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5).'@zembery.ru';
 				addUser($name, $phone, $email, $birthday, $uch, $gid);
 			}
 			//e('Отсутствует email: '.$name);
 		}
 		
 		//if ($key > 10) exit();
 	
 	}

}






