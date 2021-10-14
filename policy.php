<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Политика в отношении обработки персональных данных");
?>
<main class="main">
    <div class="container">
        <h1 class="section__title page__title"><?$APPLICATION->ShowTitle(false)?></h1>
		<section class="section policy">
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.include",
				".default",
				Array(
					"AREA_FILE_SHOW" => "file",
					"AREA_FILE_SUFFIX" => "inc",
					"COMPONENT_TEMPLATE" => ".default",
					"EDIT_TEMPLATE" => "",
					"PATH" => "/local/include/policy_text.php"
				)
			);?>
		</section>
    </div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>