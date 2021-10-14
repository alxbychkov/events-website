<?php
#
# Описываем обработчики!
#

use
	\Bitrix\Main,
	\Bitrix\Main\Loader,
	\Bitrix\Main\Mail\Event as MailEvent;

	AddEventHandler("main", "OnBeforeUserRegister", "OnBeforeUserRegisterHandler");
	AddEventHandler("main", "OnBeforeUserUpdate", "OnBeforeUserUpdateHandler");
	function OnBeforeUserRegisterHandler(&$arFields) {
		$arFields['EMAIL'] = strtolower($arFields['EMAIL']);
		$arFields["LOGIN"] = $arFields["EMAIL"];
		$arFields["NAME"] = ucfirst(strtolower($arFields["NAME"]));
		$arFields["LAST_NAME"] = ucfirst(strtolower($arFields["LAST_NAME"]));
		$arFields["SECOND_NAME"] = ucfirst(strtolower($arFields["SECOND_NAME"]));
		$arFields["WORK_POSITION"] = ucfirst(strtolower($arFields["WORK_POSITION"]));
		$arFields["WORK_COMPANY"] = ucfirst(strtolower($arFields["WORK_COMPANY"]));
		return $arFields;
	}

	AddEventHandler("main", "OnAfterUserRegister", Array("classHandler", "OnAfterUserRegisterHandler"));
	class classHandler
	{
		function OnAfterUserRegisterHandler(&$arFields) {
			if ($arFields["UF_SUBSCRIPTION"] && $arFields["UF_SUBSCRIPTION"] == 'on') {
				$name = htmlspecialchars(stripslashes(trim($arFields["NAME"])));
				$company = htmlspecialchars(stripslashes(trim($arFields["WORK_COMPANY"])));
				$email = htmlspecialchars(stripslashes(trim($arFields["EMAIL"])));

				$url = $_SERVER["HTTP_HOST"] . '/local/ajax/subscribe.php';
				
				$params = array(
					"name" => $name,
					'company' => $company,
					'email' => $email
				);
				$json = json_encode($params);

				// создаем подключение
				$ch = curl_init($url);
				// устанавлваем даные для отправки
				curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
				// флаг о том, что нужно получить результат
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POST, true);
				// отправляем запрос
				$result = curl_exec($ch);
				// закрываем соединение
				curl_close($ch);
			}

			global $APPLICATION;
			$APPLICATION->set_cookie("USER_REG", 'true');
		}
	}

	AddEventHandler("main", "OnEndBufferContent", "adminPanelEnter");
	function adminPanelEnter(&$content) {
		global $USER, $APPLICATION;
		if (($APPLICATION->GetCurDir() == '/bitrix/' || $APPLICATION->GetCurDir() == '/bitrix/admin/') &&  !$USER->IsAdmin()) { LocalRedirect("/404.php"); }
	}

?>