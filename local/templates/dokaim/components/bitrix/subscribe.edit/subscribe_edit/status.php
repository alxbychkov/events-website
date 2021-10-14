<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<section class="section registration">
	<h2 class="section__title"><?echo GetMessage("subscr_title_status")?></h2>
	<div class="registration__wrapper">		
		<form action="<?=$arResult["FORM_ACTION"]?>" method="get" class="registration__form">
			<div class="form-inputs">

				<label style="display: block">
					<span class="checkbox-label__text"><?echo GetMessage("subscr_conf")?></span>
					<span class="<?echo ($arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y"? "notetext":"errortext")?>"><?echo ($arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y"? GetMessage("subscr_yes"):GetMessage("subscr_no"));?></span>
				</label>
				<label style="display: block">
					<span class="checkbox-label__text"><?echo GetMessage("subscr_act")?></span>
					<span class="<?echo ($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"? "notetext":"errortext")?>"><?echo ($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"? GetMessage("subscr_yes"):GetMessage("subscr_no"));?></span>
				</label>

				<input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
				<?echo bitrix_sessid_post();?>
				<?if($arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y"):?>
					<?if($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"):?>
						<input type="submit" class="form__btn" name="unsubscribe" value="<?echo GetMessage("subscr_unsubscr")?>" />
						<input type="hidden" name="action" value="unsubscribe" />
					<?else:?>
						<input type="submit" class="form__btn" name="activate" value="<?echo GetMessage("subscr_activate")?>" />
						<input type="hidden" name="action" value="activate" />
					<?endif;?>
				<?endif;?>
			</div>
		</form>
	</div>
</section>