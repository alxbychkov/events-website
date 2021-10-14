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
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
?>
	
	<?	
		$errorKeys = '';
		if (count($arResult["ERRORS"]) > 0):
		foreach ($arResult["ERRORS"] as $key => $error) {
			if (intval($key) == 0 && $key !== 0) {
				$errorKeys = $errorKeys . $key . ',';
			} else {
				if ($error == 'Неверно введено слово с картинки')
					$errorKeys = $errorKeys . 'CAPTCHA' . ',';
				if ($error == 'Неверное подтверждение пароля.')
					$errorKeys = $errorKeys . 'DIFFERENT' . ',';
			}
			if (intval($key) == 0 && $key !== 0) 
				$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);
		}?>
		<noscript>	
			<?ShowError(implode("<br />", $arResult["ERRORS"]));?>
		</noscript>		
		<script>if(validate_reg_form('<?=$errorKeys;?>')) showBundle('Для успешной регистрации необходимо<br>заполнить все пункты формы','attention');</script>
	<?endif?>
	<section class="section registration">
		<h1 class="section__title"><?=GetMessage("AUTH_REGISTER")?></h1>
		<div class="registration__wrapper">
			<p class="registration__form__text">Зарегистрируйтесь, чтобы получить полный доступ к мероприятиям, трансляциям или видео-записям, и еще многим функциям<span class="form__error__message hidden" data-type="error">*не все поля заполнены</span></p>
			<form class="registration__form" method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
				<div class="form-inputs">
					<?if($arResult["BACKURL"] <> ''):?>
						<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
					<?endif;?>
					<input type="text" class="form__input" name="REGISTER[NAME]" value="<?=$arResult["VALUES"]["NAME"]?>" placeholder="ИМЯ">
					<input type="text" class="form__input" name="REGISTER[LAST_NAME]" value="<?=$arResult["VALUES"]["LAST_NAME"]?>" placeholder="ФАМИЛИЯ">
					<input type="text" class="form__input" name="REGISTER[SECOND_NAME]" value="<?=$arResult["VALUES"]["SECOND_NAME"]?>" placeholder="ОТЧЕСТВО">
					<input type="text" class="form__input" name="REGISTER[WORK_POSITION]" value="<?=$arResult["VALUES"]["WORK_POSITION"]?>" placeholder="ДОЛЖНОСТЬ">
					<input type="text" class="form__input" name="REGISTER[WORK_COMPANY]" value="<?=$arResult["VALUES"]["WORK_COMPANY"]?>" placeholder="ОРГАНИЗАЦИЯ">
					<input type="email" class="form__input" name="REGISTER[EMAIL]" value="<?=$arResult["VALUES"]["EMAIL"]?>" placeholder="E-MAIL">
					<div class="password-wrapper">
						<input type="password" class="form__input" name="REGISTER[PASSWORD]" autocomplete="off" placeholder="ПАРОЛЬ">
						<span class="eye__pwd" data-type="show-pwd"></span>
					</div>
					<div class="password-wrapper">
						<input type="password" class="form__input" name="REGISTER[CONFIRM_PASSWORD]" autocomplete="off" placeholder="ПОДТВЕРЖДЕНИЕ ПАРОЛЯ">
						<span class="eye__pwd" data-type="show-pwd"></span>
					</div>
						<?
							/* CAPTCHA */
							if ($arResult["USE_CAPTCHA"] == "Y") {?>
								<p><b><?=GetMessage("REGISTER_CAPTCHA_TITLE")?></b></p>
								<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
								<img class="captcha__img" src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
								<input type="text" class="form__input" name="captcha_word" maxlength="50" value="" placeholder="<?=GetMessage("REGISTER_CAPTCHA_PROMT")?>" autocomplete="off" />			
							<?} else {?>
								<input type="hidden" name="recaptcha_token" value="">
							<?}
							/* !CAPTCHA */
							?>
					<input type="submit" name="register_submit_button" disabled class="form__btn disabled" value="<?=GetMessage("AUTH_REGISTER")?>">
					<label class="checkbox-label" for="info__check">
						<input type="checkbox" name="UF_SUBSCRIPTION" class="hidden__checkbox" id="info__check">
						<span class="custom__check"></span>
						<span class="checkbox-label__text">Получать информацию о новых мероприятиях</span>
					</label>
					<label class="checkbox-label" for="policy__check">
						<input type="checkbox" name="check" class="hidden__checkbox" id="policy__check">
						<span class="custom__check"></span>
						<span class="checkbox-label__text">Я согласен на обработку персональных данных, а также с условиями подписки</span>
					</label>
					<a href="/policy.php" class="policy__link">Политика конфиденциальности</a>
				</div>
				<div class="form-inputs">
					<input type="file" class="form__file" name="REGISTER_FILES_PERSONAL_PHOTO">
					<div class="photo__container no__avatar" data-type="files"></div>
					<button class="form__btn" data-type="files">загрузить фото</button>
					<span class="format__photo">JPEG, gif, png не более 5 мб</span>
				</div>
			</form>
		</div>    
	</section>