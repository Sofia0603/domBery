<?
namespace DigitalPlans;
require( $_SERVER[ "DOCUMENT_ROOT" ]."/bitrix/modules/main/include/prolog_before.php" );
require_once $_SERVER['DOCUMENT_ROOT'].'/local/classes/General.php';
General::autoload();
B24::updatePlots();
General::autoload(true);
?>