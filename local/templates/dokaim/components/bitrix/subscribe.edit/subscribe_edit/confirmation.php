<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<section class="section registration">
	<h2 class="section__title"><?echo GetMessage("subscr_title_confirm")?></h2>
	<div class="registration__wrapper">		
		<form action="<?=$arResult["FORM_ACTION"]?>" method="get" class="registration__form">
			<div class="form-inputs">
				<?echo bitrix_sessid_post();?>
				<input type="hidden" name="ID" value="<?echo $arResult["ID"];?>" />
				<input type="text" value="<?echo $arResult["REQUEST"]["CONFIRM_CODE"];?>" class="form__input" name="CONFIRM_CODE" placeholder="КОД">
				<input type="submit" name="confirm" class="form__btn" value="<?echo GetMessage("subscr_conf_button")?>">
			</div>
		</form>
	</div>
</section>
