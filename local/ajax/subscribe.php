<?php
/**
 * возвращает json с результатами
 * 1 - Подписан
 * 2 - Уже был подписан
 * 3 - 
 * 0 - Ошибка
 */
define("NO_KEEP_STATISTIC", true); // Не собираем стату по действиям AJAX
define("STOP_STATISTICS", true);
define('NO_AGENT_CHECK', true);
define("NO_AGENT_STATISTIC", true);
define("BX_SECURITY_SHOW_MESSAGE", true);
define("PUBLIC_AJAX_MODE", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$GLOBALS['APPLICATION']->RestartBuffer();
use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;
CModule::IncludeModule('subscribe');
CModule::IncludeModule('sender');
$application = Application::getInstance();
$context = $application->getContext();
$request = $context->getRequest();
$request->addFilter(new \Bitrix\Main\Web\PostDecodeFilter);
$result = 0;
$delete = 0;

if($request->isPost())  {
    if (file_get_contents("php://input")) {
        $json = file_get_contents("php://input");
        $json = json_decode($json);
        $post_email = clean($json->email);
        $post_name = clean($json->name);
        $post_company = clean($json->company);
        $token = $json->token;
        
        $return = getCaptcha($token, SECRET_KEY);

        if ($return && $return->success && $return->score > 0.5) {
            if (!empty($post_email) && empty($json->text)) {
                $post_email = filter_var($post_email, FILTER_VALIDATE_EMAIL);
    
                // проверяем email на наличие в подписках
                $subscr = CSubscription::GetList(
                    array(),
                    array()
                );
                while(($subscr_arr = $subscr->Fetch())) {
                    $aEmail[] = $subscr_arr["EMAIL"];
                }
                
                if(!in_array($post_email, $aEmail)) {
                    global $USER;
                    // Есть ли пользователь
                    $filter = Array("EMAIL" => $post_email);
                    $rsUser = CUser::GetList(($by="id"), ($order="desc"), $filter);
                    $arUser = $rsUser->Fetch();
    
                    if (!$arUser["ID"]) {
                        // Добавляем пользователя
                        $user = new CUser;
                        $password = randString(6);
                        $arFields = Array(
                            "NAME"              => $post_name,
                            "EMAIL"             => $post_email,
                            "LOGIN"             => $post_email,
                            "LID"               => "ru",
                            "ACTIVE"            => "Y",
                            "GROUP_ID"          => array(5),
                            "PASSWORD"          => $password,
                            "CONFIRM_PASSWORD"  => $password,
                            "WORK_COMPANY"      => $post_company
                        );
    
                        $idUser = $user->Add($arFields);
    
                        if (intval($idUser) > 0) {
                            $arEventFields= array(
                                "LOGIN" => $arFields["LOGIN"],
                                "PASSWORD" => $arFields["PASSWORD"],
                                "EMAIL" => $arFields["EMAIL"]
                            );
                            CEvent::Send("NEW_USER_AUTO", SITE_ID, $arEventFields, "N", 51);
                        } else {
                            AddMessage2Log($user->LAST_ERROR);
                            $idUser = $post_email;
                        }
                            
                    } else {
                        $idUser = $arUser["ID"];
                    }
    
                    // если отсутствует, то добавляем
                    // запрос всех рубрик
                    $rub = CRubric::GetList(
                        array("LID"=>"ASC","SORT"=>"ASC","NAME"=>"ASC"),
                        array("ACTIVE"=>"Y", "LID"=>LANG)
                    );
    
                    $arRubIDS = array();
                    while ($arRub = $rub->Fetch()) {
                        $arRubIDS[] = $arRub['ID'];
                    }
                    
                    // формируем массив с полями для создания подписки
                    $arFields = Array(
                        "USER_ID" => $idUser,
                        "FORMAT" => "html",
                        "EMAIL" => $post_email,
                        "ACTIVE" => "Y",
                        "RUB_ID" => $arRubIDS,
                        "SEND_CONFIRM" => 'Y',
                        "USER_NAME" => $post_name
                    );
    
                    $subscr = new CSubscription;
                    // создаем подписку
                    $ID = $subscr->Add($arFields);
    
                    if ($ID > 0) {
                        $result = 1;
                    }
                
                    // $subscr->Update($ID, array("ACTIVE" => "Y", "USER_NAME" => $post_name));
    
                } else {
                    $result = 2;
                }
            }

            // elseif(in_array($post_email, $aEmail) && $delete = 1) {    
            //     // удаляем из подписок
            //     if (($res = CSubscription::Delete($_POST['subid'])) && $res->AffectedRowsCount() < 1 || $res == false) {
            //         echo "Error deleting subscription.";
            //     } else {
            //         echo "Subscription deleted.";
            //     }
            // }
        }
    }
}
echo json_encode($result);
die();
?>