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
		<section class="section registration">
			<h1 class="section__title"><?$APPLICATION->ShowTitle(false)?></h1>
				<?
					if(!empty($arParams["~AUTH_RESULT"])): 
						$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
						$bundleText = str_replace(array("<br>", "<br />"), "", $arParams["~AUTH_RESULT"]["MESSAGE"]);
						$type = 'error';
						if ($arParams["~AUTH_RESULT"]["TYPE"] == 'OK') {
							$bundleText = 'Данные были высланы на email.';
							$type = '';
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
						<label class="checkbox-label">
							<span class="checkbox-label__text"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></span>
						</label>
						<input type="hidden" name="AUTH_FORM" value="Y">
						<input type="hidden" name="TYPE" value="SEND_PWD">
						<?if($arResult["BACKURL"] <> ''):?>
							<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
						<?endif?>
						<?foreach ($arResult["POST"] as $key => $value):?>
								<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
						<?endforeach?>
						<input type="email" autofocus class="form__input" name="USER_LOGIN" placeholder="E-MAIL">
						<input type="submit" name="send_account_info" class="form__btn" value="<?=GetMessage("AUTH_SEND")?>">
						<label class="checkbox-label">
							<span class="checkbox-label__text"><?= GetMessage("forgot_pass_email_note");?></span>
						</label>
						<a href="<?=$arResult["AUTH_AUTH_URL"]?>" class="policy__link"><?=GetMessage("AUTH_AUTH")?></a>
					</div>
				</form>
			</div>
		</section>
	</div>
</main>
