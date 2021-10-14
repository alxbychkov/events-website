<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?

foreach($arResult["MESSAGE"] as $itemID=>$itemValue)
	echo ShowMessage(array("MESSAGE"=>$itemValue, "TYPE"=>"OK"));
foreach($arResult["ERROR"] as $itemID=>$itemValue)
	echo ShowMessage(array("MESSAGE"=>$itemValue, "TYPE"=>"ERROR"));

//whether to show the forms
if($arResult["ID"] || CSubscription::IsAuthorized($arResult["ID"]))
{
	//show confirmation form
	if($arResult["ID"]>0 && $arResult["SUBSCRIPTION"]["CONFIRMED"] <> "Y")
	{
		include("confirmation.php");
	}

	//status and unsubscription/activation section
	if($arResult["ID"]>0 && $arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y")
	{
		include("status.php");
	}
} else {
	
	//subscribe form
	$APPLICATION->IncludeComponent(
		"bitrix:subscribe.form",
		"subscribe_form",
		Array(
			"CACHE_TIME" => "3600",
			"CACHE_TYPE" => "A",
			"PAGE" => "",
			"SHOW_HIDDEN" => "N",
			"USE_PERSONALIZATION" => "Y"
		)
	);
}
?>