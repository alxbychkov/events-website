<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
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
				?>	
					<noscript>
						<div class="alert alert-danger"><?=nl2br(htmlspecialcharsbx($text))?></div>
					</noscript>
					<script>
						showBundle('<?=$bundleText;?>', 'attention');
					</script>
				<?endif?>
				<?
				if($arResult['ERROR_MESSAGE'] <> ''):
					$text = str_replace(array("<br>", "<br />"), "\n", $arResult['ERROR_MESSAGE']);
					$bundleText = str_replace(array("<br>", "<br />"), "", $arResult['ERROR_MESSAGE']);
				?>
					<noscript>
						<div class="alert alert-danger"><?=nl2br(htmlspecialcharsbx($text))?></div>
					</noscript>
					<script>
						showBundle('<?=$bundleText?>', 'error');
					</script>
				<?endif?>	
			<div class="registration__wrapper">		
				<form action="<?=$arResult["AUTH_URL"]?>" method="post" class="registration__form" name="form_auth">
					<div class="form-inputs">
						<input type="hidden" name="AUTH_FORM" value="Y" />
						<input type="hidden" name="TYPE" value="AUTH" />
						<?if ($arResult["BACKURL"] <> ''):?>
								<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
						<?endif?>
						<?foreach ($arResult["POST"] as $key => $value):?>
								<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
						<?endforeach?>
						<input type="text" class="form__input" name="USER_LOGIN" placeholder="E-MAIL" autofocus>
						<div class="password-wrapper">
							<input type="password" class="form__input" name="USER_PASSWORD" placeholder="ПАРОЛЬ" autocomplete="off">
							<span class="eye__pwd" data-type="show-pwd"></span>
						</div>
						<input type="submit" name="Login" class="form__btn" value="Войти">
						<label class="checkbox-label" for="USER_REMEMBER">
							<input type="checkbox" name="USER_REMEMBER" id="USER_REMEMBER" value="Y" class="hidden__checkbox">
							<span class="custom__check"></span>
							<span class="checkbox-label__text"><?=GetMessage("AUTH_REMEMBER_ME")?></span>
						</label>
						<div class="auth-form__bottom">
							<a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" class="policy__link"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
							<a href="<?=$arResult["AUTH_REGISTER_URL"]?>" class="policy__link"><?=GetMessage("AUTH_REGISTER")?></a>
						</div>
					</div>
				</form>
			</div>
		</section>
	</div>
</main>

