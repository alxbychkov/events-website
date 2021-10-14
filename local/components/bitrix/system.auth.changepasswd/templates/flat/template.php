<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */

//one css for all system.auth.* forms
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");
?>

<main class="main">
	<div class="container">
	<?if($arResult["SHOW_FORM"]):?>
		<section class="section registration">
			<h1 class="section__title"><?=GetMessage("AUTH_CHANGE_PASSWORD")?></h1>
				<?
				if(!empty($arParams["~AUTH_RESULT"])):
					$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
					$bundleText = str_replace(array("<br>", "<br />"), "", $arParams["~AUTH_RESULT"]["MESSAGE"]);
					$type = '';
					if($arParams["~AUTH_RESULT"]["TYPE"] == 'ERROR') {
						$type = 'error';
					}
				?>
					<noscript>
						<div class="alert <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"alert-danger")?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
					</noscript>
					<script>
						showBundle('<?=$bundleText;?>','<?=$type;?>');
					</script>
				<?endif?>
			<div class="registration__wrapper">		
				<form action="<?=$arResult["AUTH_URL"]?>" method="post" class="registration__form" name="form_auth">
					<div class="form-inputs">
						<?if ($arResult["BACKURL"] <> ''): ?>
							<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
						<?endif;?>
						<input type="hidden" name="AUTH_FORM" value="Y">
						<input type="hidden" name="TYPE" value="CHANGE_PWD">
						<?foreach ($arResult["POST"] as $key => $value):?>
								<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
						<?endforeach?>
						<input type="text" class="form__input" name="USER_LOGIN" placeholder="E-MAIL" value="<?=$arResult["LAST_LOGIN"]?>">
						<?if($arResult["USE_PASSWORD"]):?>
							<div class="password-wrapper">
								<input type="password" class="form__input" name="USER_CURRENT_PASSWORD" placeholder="<?=GetMessage("system_change_pass_current_pass")?>" value="<?=$arResult["USER_CURRENT_PASSWORD"];?>" autocomplete="new-password" />
								<span class="eye__pwd" data-type="show-pwd"></span>
							</div>
						<?else:?>
							<input type="text" class="form__input" name="USER_CHECKWORD" placeholder="<?=GetMessage("change_pass_code");?>" value="<?=$arResult["USER_CHECKWORD"];?>" autocomplete="off" />
						<?endif;?>
						<div class="password-wrapper">
							<input type="password" class="form__input" name="USER_PASSWORD" placeholder="<?=GetMessage("AUTH_NEW_PASSWORD_REQ");?>" value="<?=$arResult["USER_PASSWORD"];?>" autocomplete="new-password" />
							<span class="eye__pwd" data-type="show-pwd"></span>
						</div>
						<div class="password-wrapper">
							<input type="password" class="form__input" name="USER_CONFIRM_PASSWORD" placeholder="<?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM");?>" value="<?=$arResult["USER_CONFIRM_PASSWORD"];?>" autocomplete="new-password" />
							<span class="eye__pwd" data-type="show-pwd"></span>
						</div>
						<input type="submit" name="change_pwd" class="form__btn" value="<?=GetMessage("AUTH_CHANGE")?>">
						<label class="checkbox-label">
							<span class="checkbox-label__text"><?=$arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></span>
						</label>
						<a href="<?=$arResult["AUTH_AUTH_URL"]?>" class="policy__link"><?=GetMessage("AUTH_AUTH")?></a>
					</div>
				</form>
			</div>
		</section>
	<?endif;?>
	</div>
</main>




