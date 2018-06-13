<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

if((isset($_REQUEST["cap_sid"])) && (isset($_REQUEST["cap_word"]))) {

    include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");

    $captcha = array(
        "status" => "ok",
    );

    $cpt = new CCaptcha();

    if(!strlen($_REQUEST["cap_word"]) > 0){
        $captcha = array(
            "status" => "failed",
            "message" => "Не введен защитный код",
            "code" => $APPLICATION->CaptchaGetCode(),
        );
    }
    elseif(!$cpt -> CheckCode($_REQUEST["cap_word"],$_REQUEST["cap_sid"])){
        $captcha = array(
            "status" => "failed",
            "message" => "Код с картинки заполнен не правильно",
            "code" => $APPLICATION->CaptchaGetCode()
        );
    }
}
else {
    $captcha = array(
        "code" => $APPLICATION->CaptchaGetCode(),
    );
}
echo json_encode($captcha);
?>