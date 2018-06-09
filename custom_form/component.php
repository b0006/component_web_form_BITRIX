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

            if(($arItem["FIELD_TYPE"] == "text") || ($arItem["FIELD_TYPE"] == "textarea")) {
                $arItem["INPUT_NAME"] = "form_" . $arItem["FIELD_TYPE"] . "_" . $arItem["ID"];

                foreach ($arItem["ANSWERS"] as &$answer){
                    $answer["INPUT_ID"] = $arItem["FIELD_TYPE"] . "_" . $arItem["ID"];
                    $answer["INPUT_NAME"] = "form_" . $arItem["FIELD_TYPE"] . "_" . $arItem["ID"];
                    $answer["HTML_CODE"] = "<input type='" . $arItem["FIELD_TYPE"] . "' id='" .$answer["INPUT_ID"]. "' name='" . $answer["INPUT_NAME"] ."'>";
                }

            }
            elseif($arItem["FIELD_TYPE"] == "radio") {
                $arItem["INPUT_NAME"] = "form_" . $arItem["FIELD_TYPE"] . "_" . $arItem["VARNAME"];

                foreach ($arItem["ANSWERS"] as &$answer){
                    $answer["INPUT_ID"] = $answer["FIELD_TYPE"] . "_" . $answer["ID"];
                    $answer["INPUT_NAME"] = "form_" . $answer["FIELD_TYPE"] . "_" . $arItem["VARNAME"];
                    $answer["HTML_CODE"] = "<input type='" . $arItem["FIELD_TYPE"] . "' id='" .$answer["INPUT_ID"]. "' name='" . $answer["INPUT_NAME"] ."'>";
                }
            }
            elseif($arItem["FIELD_TYPE"] == "checkbox") {
                $arItem["INPUT_NAME"] = "form_" . $arItem["FIELD_TYPE"] . "_" . $arItem["VARNAME"] . "[]";

                foreach ($arItem["ANSWERS"] as &$answer){
                    $answer["INPUT_ID"] = $answer["FIELD_TYPE"] . "_" . $answer["ID"];
                    $answer["INPUT_NAME"] = "form_" . $answer["FIELD_TYPE"] . "_" . $arItem["VARNAME"] . "[]";
                    $answer["HTML_CODE"] = "<input type='" . $arItem["FIELD_TYPE"] . "' id='" .$answer["INPUT_ID"]. "' name='" . $answer["INPUT_NAME"] ."'>";
                }
            }
            elseif($arItem["FIELD_TYPE"] == "dropdown") {
                $arItem["INPUT_ID"] = $arItem["FIELD_TYPE"] . "_" . $arItem["ID"];
                $arItem["INPUT_NAME"] = "form_" . $arItem["FIELD_TYPE"] . "_" . $arItem["VARNAME"];

                $arItem["HTML_CODE"] = "<select id='" .$arItem["INPUT_ID"]. "' name='" . $arItem["INPUT_NAME"] ."'>";

                foreach ($arItem["ANSWERS"] as &$answer){
                    $arItem["HTML_CODE"] .= "<option value='" . $answer["ID"] ."'>". $answer["MESSAGE"] ."</option>";
                }
                $arItem["HTML_CODE"] .= "</select>";
            }
            elseif($arItem["FIELD_TYPE"] == "email") {

                foreach ($arItem["ANSWERS"] as &$answer){
                    $answer["INPUT_ID"] = $answer["FIELD_TYPE"] . "_" . $arItem["ID"];
                    $answer["INPUT_NAME"] = "form_" . $answer["FIELD_TYPE"] . "_" . $answer["ID"];
                    $answer["HTML_CODE"] = "<input type='" . $answer["FIELD_TYPE"] . "' id='" .$answer["INPUT_ID"]. "' name='" . $answer["INPUT_NAME"] ."'>";

                    $arItem["INPUT_NAME"] = "form_" . $answer["FIELD_TYPE"] . "_" . $answer["ID"];
                }
            }
            elseif($arItem["FIELD_TYPE"] == "multiselect") {
                $arItem["INPUT_ID"] = $arItem["FIELD_TYPE"] . "_" . $arItem["ID"];
                $arItem["INPUT_NAME"] = "form_" . $arItem["FIELD_TYPE"] . "_" . $arItem["VARNAME"] . "[]";

                $arItem["HTML_CODE"] = "<select multiple=\"\" id='" .$arItem["INPUT_ID"]. "' name='" . $arItem["INPUT_NAME"] ."'>";

                foreach ($arItem["ANSWERS"] as &$answer){
                    $arItem["HTML_CODE"] .= "<option value='" . $answer["ID"] ."'>". $answer["MESSAGE"] ."</option>";
                }
                $arItem["HTML_CODE"] .= "</select>";
            }
            elseif($arItem["FIELD_TYPE"] == "date") {

                foreach ($arItem["ANSWERS"] as &$answer){
                    $answer["INPUT_ID"] = $arItem["FIELD_TYPE"] . "_" . $arItem["ID"];

                    $arItem["INPUT_NAME"] = "form_" . $answer["FIELD_TYPE"] . "_" . $answer["ID"];

                    $answer["HTML_CODE"] = "<input type='" . $arItem["FIELD_TYPE"] . "' id='" .$answer["INPUT_ID"]. "' name='" . $answer["INPUT_NAME"] ."'>";
                }
            }
            elseif($arItem["FIELD_TYPE"] == "image") {

                foreach ($arItem["ANSWERS"] as &$answer){
                    $answer["INPUT_ID"] = $arItem["FIELD_TYPE"] . "_" . $arItem["ID"];

                    $arItem["INPUT_NAME"] = "form_" . $answer["FIELD_TYPE"] . "_" . $answer["ID"];

                    $answer["HTML_CODE"] = "<input type='file' id='" .$answer["INPUT_ID"]. "' name='" . $answer["INPUT_NAME"] ."'>";
                }
            }
            elseif($arItem["FIELD_TYPE"] == "file") {

                foreach ($arItem["ANSWERS"] as &$answer){
                    $answer["INPUT_ID"] = $arItem["FIELD_TYPE"] . "_" . $arItem["ID"];

                    $arItem["INPUT_NAME"] = "form_" . $answer["FIELD_TYPE"] . "_" . $answer["ID"];

                    $answer["HTML_CODE"] = "<input type='" . $arItem["FIELD_TYPE"] . "' id='"  .$answer["INPUT_ID"] . "' name='" . $answer["INPUT_NAME"] ."'>";
                }
            }
            elseif($arItem["FIELD_TYPE"] == "url") {

                foreach ($arItem["ANSWERS"] as &$answer){
                    $answer["INPUT_ID"] = $arItem["FIELD_TYPE"] . "_" . $arItem["ID"];

                    $arItem["INPUT_NAME"] = "form_" . $answer["FIELD_TYPE"] . "_" . $answer["ID"];

                    $answer["HTML_CODE"] = "<input type='" . $arItem["FIELD_TYPE"] . "' id='"  .$answer["INPUT_ID"] . "' name='" . $answer["INPUT_NAME"] ."'>";
                }
            }
            elseif($arItem["FIELD_TYPE"] == "password") {

                foreach ($arItem["ANSWERS"] as &$answer){
                    $answer["INPUT_ID"] = $arItem["FIELD_TYPE"] . "_" . $arItem["ID"];

                    $arItem["INPUT_NAME"] = "form_" . $answer["FIELD_TYPE"] . "_" . $answer["ID"];

                    $answer["HTML_CODE"] = "<input type='" . $arItem["FIELD_TYPE"] . "' id='"  .$answer["INPUT_ID"] . "' name='" . $answer["INPUT_NAME"] ."'>";
                }
            }
        }

        $arResult["SUBMIT_NAME"] = "submit";

        if(isset($_REQUEST[$arResult["SUBMIT_NAME"]])){

            $arRequest = $_REQUEST;
            $arRequest = array_merge($_REQUEST, $_FILES);

            foreach ($arRequest as $req_pid => $request) {
                foreach ($arResult["QUESTIONS"] as &$arItem) {
                   $input_name = str_replace("[]", "", $arItem["INPUT_NAME"]);
                    if ($input_name == $req_pid) {
                        $arItem["REQUEST_VALUE"] = $request;
                    }
                }
            }

            $isSuccess = true;

            foreach ($arResult["QUESTIONS"] as &$arItem) {

                if($arItem["FIELD_TYPE"] == "image"){
                    $isImage = CFile::IsImage($arItem["REQUEST_VALUE"]["name"]);
                    if ((($arItem["REQUIRED"] == "Y") && ($arItem["REQUEST_VALUE"]["name"] == "")) || (!$isImage)) {
                        $arItem["ERROR"] = "Y";
                        $arItem["ERROR_MESSAGE"] = "Ошибка выбора картинки";
                        $isSuccess = false;
                    }
                }
                elseif($arItem["FIELD_TYPE"] == "file"){
                    if (($arItem["REQUIRED"] == "Y") && ($arItem["REQUEST_VALUE"]["name"] == "")) {
                        $arItem["ERROR"] = "Y";
                        $arItem["ERROR_MESSAGE"] = "Файл не выбран";
                        $isSuccess = false;
                    }
                }
                elseif($arItem["FIELD_TYPE"] == "url"){
                    if (!preg_match("/^(http|https|ftp):\/\//i", $arItem["REQUEST_VALUE"]))
                    {
                        $arItem["ERROR"] = "Y";
                        $arItem["ERROR_MESSAGE"] = "Неккоректный URL";
                        $isSuccess = false;
                    }
                }
                elseif($arItem["FIELD_TYPE"] == "email") {
                    if (!filter_var($arItem["REQUEST_VALUE"], FILTER_VALIDATE_EMAIL)) {
                        $arItem["ERROR"] = "Y";
                        $arItem["ERROR_MESSAGE"] = "E-mail адрес указан не верно";
                        $isSuccess = false;
                    }
                }
                elseif (($arItem["REQUIRED"] == "Y") && ($arItem["REQUEST_VALUE"] == "")) {
                    $arItem["ERROR"] = "Y";
                    $arItem["ERROR_MESSAGE"] = "Не заполнено поле";
                    $isSuccess = false;
                }


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