<?php
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Редактировать пользователя");
?><main class="main">
<div class="container">
<?$APPLICATION->IncludeComponent("bitrix:main.profile", "profile_edit", Array(
	"CHECK_RIGHTS" => "Y",	// Проверять права доступа
		"SEND_INFO" => "N",	// Генерировать почтовое событие
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"USER_PROPERTY" => "",	// Показывать доп. свойства
		"USER_PROPERTY_NAME" => "",	// Название закладки с доп. свойствами
	),
	false
);?>
</div>
 </main><?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>