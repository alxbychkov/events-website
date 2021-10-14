<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>

<section class="section registration">
	<h1 class="section__title page__title">Редактирование профиля</h1>
	<?ShowError($arResult["strProfileError"]);?>
	<?
	if ($arResult['DATA_SAVED'] == 'Y')
		ShowNote(GetMessage('PROFILE_DATA_SAVED'));
	?>
	<div class="registration__wrapper">
		<form class="registration__form" method="post" action="<?=$arResult["FORM_TARGET"]?>" name="form1" enctype="multipart/form-data">
			<div class="form-inputs">
				<?=$arResult["BX_SESSION_CHECK"]?>
				<input type="hidden" name="lang" value="<?=LANG?>" />
				<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
				<input type="text" class="form__input" name="NAME" value="<?=$arResult["arUser"]["NAME"]?>" placeholder="ИМЯ">
				<input type="text" class="form__input" name="LAST_NAME" value="<?=$arResult["arUser"]["LAST_NAME"]?>" placeholder="ФАМИЛИЯ">
				<input type="text" class="form__input" name="SECOND_NAME" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" placeholder="ОТЧЕСТВО">
				<input type="text" class="form__input" name="WORK_POSITION" value="<?=$arResult["arUser"]["WORK_POSITION"]?>" placeholder="ДОЛЖНОСТЬ">
				<input type="text" class="form__input" name="WORK_COMPANY" value="<?=$arResult["arUser"]["WORK_COMPANY"]?>" placeholder="ОРГАНИЗАЦИЯ">
				<input type="email" class="form__input" name="EMAIL" value="<?=$arResult["arUser"]["EMAIL"]?>" placeholder="E-MAIL">
				<div class="password-wrapper">
					<input type="password" class="form__input" name="NEW_PASSWORD" autocomplete="off" placeholder="ПАРОЛЬ">
					<span class="eye__pwd" data-type="show-pwd"></span>
				</div>
				<div class="password-wrapper">
					<input type="password" class="form__input" name="NEW_PASSWORD_CONFIRM" autocomplete="off" placeholder="ПОДТВЕРЖДЕНИЕ ПАРОЛЯ">
					<span class="eye__pwd" data-type="show-pwd"></span>
				</div>
				<input type="submit" name="save" class="form__btn" value="Сохранить">
			</div>
			<div class="form-inputs">
				<?
					$photoID = $arResult["arUser"]['PERSONAL_PHOTO']; //Получаем ID Фотографии по ID пользователя.
					if ($photoID) {
						$avatar = CFile::GetPath($photoID); //Получаем путь к файлу.
					}
				?>
				<input type="file" class="form__file" name="PERSONAL_PHOTO">
				<?if($avatar):?>
					<div class="photo__container" style="background-image: url(<?=$avatar;?>)" data-type="files"></div>
				<?else:?>
					<div class="photo__container no__avatar" data-type="files"></div>
				<?endif;?>
				
				<button class="form__btn" data-type="files">загрузить фото</button>
				<span class="format__photo">JPEG, gif, png не более 5 мб</span>
			</div>
		</form>
	</div>    
</section>