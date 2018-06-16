<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

if (CModule::IncludeModule("form"))
{
    $web_form_id = $arParams["WEB_FORM_ID"];

    $arResult = array();

    if($web_form_id != "") {
        $is_filtered = true;
        $rsForm = CForm::GetByID($web_form_id);

        if ($form = $rsForm->Fetch()) {
            $arResult["arForm"] = $form;
        }

        $rsQuestions = CFormField::GetList(
            $web_form_id,
            "ALL",
            $by = "s_sort",
            $order = "asc",
            array("ACTIVE" => "Y"),
            $is_filtered
        );
        while ($arQuestion = $rsQuestions->Fetch()) {

            $arResult["QUESTIONS"][$arQuestion["ID"]] = $arQuestion;

            // получим список всех ответов
            $rsAnswers = CFormAnswer::GetList(
                $arQuestion["ID"],
                $by = "s_sort",
                $order = "asc",
                array(),
                $is_filtered
            );

            while ($arAnswer = $rsAnswers->Fetch()) {
                $arResult["QUESTIONS"][$arAnswer["QUESTION_ID"]]["ANSWERS"][] = $arAnswer;
                $arResult["QUESTIONS"][$arAnswer["QUESTION_ID"]]["FIELD_TYPE"] = $arAnswer["FIELD_TYPE"];
            }
        }

        foreach ($arResult["QUESTIONS"] as &$arItem){

            $arItem["ERROR_INPUT_ID"] = "error_" . $arItem["ID"];

            if(
                ($arItem["FIELD_TYPE"] == "text") ||
                ($arItem["FIELD_TYPE"] == "textarea") ||
                ($arItem["FIELD_TYPE"] == "email") ||
                ($arItem["FIELD_TYPE"] == "date") ||
                ($arItem["FIELD_TYPE"] == "image") ||
                ($arItem["FIELD_TYPE"] == "file") ||
                ($arItem["FIELD_TYPE"] == "url") ||
                ($arItem["FIELD_TYPE"] == "password")
            ) {
                foreach ($arItem["ANSWERS"] as &$answer){
                    $answer["INPUT_ID"] = $answer["FIELD_TYPE"] . "_" . $answer["ID"];
                    $answer["INPUT_NAME"] = "form_" . $answer["FIELD_TYPE"] . "_" . $answer["ID"];
                }
            }
            elseif(($arItem["FIELD_TYPE"] == "radio") || ($arItem["FIELD_TYPE"] == "dropdown")) {
                foreach ($arItem["ANSWERS"] as &$answer){
                    $answer["INPUT_ID"] = $answer["FIELD_TYPE"] . "_" . $answer["ID"];
                    $answer["INPUT_NAME"] = "form_" . $answer["FIELD_TYPE"] . "_" . $arItem["VARNAME"];
                }
            }
            elseif(($arItem["FIELD_TYPE"] == "checkbox") || ($arItem["FIELD_TYPE"] == "multiselect")) {
                foreach ($arItem["ANSWERS"] as &$answer){
                    $answer["INPUT_ID"] = $answer["FIELD_TYPE"] . "_" . $answer["ID"];
                    $answer["INPUT_NAME"] = "form_" . $answer["FIELD_TYPE"] . "_" . $arItem["VARNAME"] . "[]";
                }
            }
        }

        $arResult["SUBMIT_NAME"] = "submit_" . $arResult["arForm"]["SID"];

        if($arParams["USE_CAPTCHA"] == "bitrix") {
            include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
            $code = $APPLICATION->CaptchaGetCode();
            $arResult["CAPTCHA_CODE"] = $code;
        }

        if(isset($_REQUEST[$arResult["SUBMIT_NAME"]])){

            $arRequest = $_REQUEST;
            $arRequest = array_merge($_REQUEST, $_FILES);

            foreach ($arRequest as $req_pid => $request) {
                foreach ($arResult["QUESTIONS"] as &$arItem) {
                    $input_name = "";

                    foreach ($arItem["ANSWERS"] as &$answer){
                        $input_name = str_replace("[]", "", $answer["INPUT_NAME"]);
                    }

                    if ($input_name == $req_pid) {
                        $arItem["REQUEST_VALUE"] = $request;
                    }
                }
            }

            $isSuccess = true;

            foreach ($arResult["QUESTIONS"] as &$arItem) {
                if($arItem["FIELD_TYPE"] == "image"){
                    if($arItem["REQUIRED"] == "Y") {
                        $isImage = CFile::IsImage($arItem["REQUEST_VALUE"]["name"]);
                        if (!$isImage) {
                            $arItem["ERROR"] = "Y";
                            $arItem["ERROR_MESSAGE"] = GetMessage("FORM_ERROR_FIELD_IMG");
                            $isSuccess = false;
                        }
                    }
                    elseif(($arItem["REQUIRED"] == "N") && ($arItem["REQUEST_VALUE"]["name"] != "")) {
                        $isImage = CFile::IsImage($arItem["REQUEST_VALUE"]["name"]);
                        if (!$isImage) {
                            $arItem["ERROR"] = "Y";
                            $arItem["ERROR_MESSAGE"] = GetMessage("FORM_ERROR_FIELD_IMG");
                            $isSuccess = false;
                        }
                    }
                }
                elseif($arItem["FIELD_TYPE"] == "file"){
                    if (($arItem["REQUIRED"] == "Y") && ($arItem["REQUEST_VALUE"]["name"] == "")) {
                        $arItem["ERROR"] = "Y";
                        $arItem["ERROR_MESSAGE"] = GetMessage("FORM_ERROR_FIELD_FILE");
                        $isSuccess = false;
                    }
                }
                elseif($arItem["FIELD_TYPE"] == "url"){
                    if(($arItem["REQUIRED"] == "Y") && (strlen($arItem["REQUEST_VALUE"]) <= 0)) {
                        $arItem["ERROR"] = "Y";
                        $arItem["ERROR_MESSAGE"] = GetMessage("FORM_ERROR_FIELD_URL");
                        $isSuccess = false;
//                        if (!preg_match("/^(http|https|ftp):\/\//i", $arItem["REQUEST_VALUE"])) {
//                            $arItem["ERROR"] = "Y";
//                            $arItem["ERROR_MESSAGE"] = GetMessage("FORM_ERROR_FIELD_URL");
//                            $isSuccess = false;
//                        }
                    }
                }
                elseif($arItem["FIELD_TYPE"] == "email") {

                    if($arItem["REQUIRED"] == "Y") {
                        if (!filter_var($arItem["REQUEST_VALUE"], FILTER_VALIDATE_EMAIL)) {
                            $arItem["ERROR"] = "Y";
                            $arItem["ERROR_MESSAGE"] = GetMessage("FORM_ERROR_FIELD_EMAIL");
                            $isSuccess = false;
                        }
                    }
                    elseif(($arItem["REQUIRED"] == "N") && ($arItem["REQUEST_VALUE"] != "")) {
                        if (!filter_var($arItem["REQUEST_VALUE"], FILTER_VALIDATE_EMAIL)) {
                            $arItem["ERROR"] = "Y";
                            $arItem["ERROR_MESSAGE"] = GetMessage("FORM_ERROR_FIELD_EMAIL");
                            $isSuccess = false;
                        }
                    }
                }
                elseif(($arItem["FIELD_TYPE"] == "multiselect") || ($arItem["FIELD_TYPE"] == "checkbox")) {
                    if($arItem["REQUIRED"] == "Y") {
                        if (count($arItem["FIELD_TYPE"]) == 0) {
                            $arItem["ERROR"] = "Y";
                            $arItem["ERROR_MESSAGE"] = GetMessage("FORM_ERROR_FIELD_EMAIL");
                            $isSuccess = false;
                        }
                    }
                }
                elseif (($arItem["REQUIRED"] == "Y") && (strlen($arItem["REQUEST_VALUE"]) <= 0)) {
                    $arItem["ERROR"] = "Y";
                    $arItem["ERROR_MESSAGE"] =  GetMessage("FORM_ERROR_FIELD_TEXT");
                    $isSuccess = false;
                }
            }

            if($arParams["USE_CAPTCHA"] == "google") {

                $recaptcha = new \ReCaptcha\ReCaptcha(RE_SEC_KEY);
                $resp = $recaptcha->verify($_REQUEST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

                if (!$resp->isSuccess()) {
                    foreach ($resp->getErrorCodes() as $code) {
                        $isSuccess = false;
                        $arResult["ERROR_MESSAGE_RECAPTCHA"] = "Не пройдена проверка безопасности";
                    }
                }
            }
            elseif($arParams["USE_CAPTCHA"] == "bitrix") {
                // проверяется в ajax/reload_captcha.php.
            }

            if($isSuccess) {
                if ($RESULT_ID = CFormResult::Add($web_form_id, $arRequest)) {
                    CFormCRM::onResultAdded($web_form_id, $RESULT_ID);
                    CFormResult::SetEvent($RESULT_ID);
                    CFormResult::Mail($RESULT_ID);

                    $arResult["SUCCESS"] = "Y";
                }
            }
        }
    }

    $this->IncludeComponentTemplate($arResult);
}
else
{
	echo ShowError(GetMessage("FORM_MODULE_NOT_INSTALLED"));
}
?>