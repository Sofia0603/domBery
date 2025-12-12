<?
namespace DigitalPlans;
use Bitrix\Main\Diag\Debug;
require( $_SERVER[ "DOCUMENT_ROOT" ]."/bitrix/modules/main/include/prolog_before.php" );
require_once $_SERVER['DOCUMENT_ROOT'].'/local/classes/General.php';
General::autoload();
B24::eventHandler();
General::autoload(1);
?>