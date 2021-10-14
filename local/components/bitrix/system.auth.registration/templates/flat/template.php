<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>

<main class="main">
	<div class="container">
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.register",
		"registration_form",
		Array(
			"AUTH" => "Y",
			"REQUIRED_FIELDS" => array("EMAIL","NAME"),
			"SET_TITLE" => "N",
			"SHOW_FIELDS" => array("EMAIL","NAME","LAST_NAME","PERSONAL_PHOTO","WORK_COMPANY","WORK_POSITION"),
			"SUCCESS_PAGE" => "/login/",
			"USER_PROPERTY" => array("UF_SUBSCRIPTION"),
			"USER_PROPERTY_NAME" => "subscription",
			"USE_BACKURL" => "Y"
		)
	);?>
	</div>
</main>