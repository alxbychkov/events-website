<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>

<section class="section subscription-form">
	<h2 class="section__title">Будь в курсе</h2>
	<div class="sub-form-wrapper">
		<form action="" class="form">
			<p class="sub-form__text">
				<?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					Array(
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "inc",
						"COMPONENT_TEMPLATE" => "",
						"EDIT_TEMPLATE" => "",
						"PATH" => SITE_DIR . "local/include/subscribe_form_text.php"
					)
				);?>
				<span class="form__error__message hidden" data-type="error">*не все поля заполнены</span>
			</p>
			<div class="form-inputs">
 <input type="text" class="form__input" name="name" placeholder="ИМЯ"> <input type="text" class="form__input" name="company" placeholder="КОМПАНИЯ"> <input type="email" class="form__input" name="email" placeholder="E-MAIL">
			</div>
			<div class="form-inputs">
			<input type="text" name="text" class="form__input __vh" value="">
			<input type="hidden" name="recaptcha_token" value="">
 <button type="submit" class="form__btn disabled" disabled>подписаться</button> <label class="checkbox-label" for="policy__check"> <input type="checkbox" name="check" class="hidden__checkbox" id="policy__check"> <span class="custom__check"></span> <span class="checkbox-label__text">Я согласен на обработку персональных данных, а также с условиями подписки</span> </label> <a href="<?='/policy.php';?>" class="policy__link">Политика конфиденциальности</a>
			</div>
		</form>
	</div>
</section>
