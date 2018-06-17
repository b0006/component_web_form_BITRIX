<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach ($arResult["QUESTIONS"] as &$arQuestion) {
    if(strlen($arQuestion["COMMENTS"]) > 0) {
        try {
            $arQuestion["COMMENTS"] = (array)json_decode($arQuestion["COMMENTS"]);
            if(json_last_error_msg() != "No error"){
                $arQuestion["ERROR_COMMENTS"] =  json_last_error_msg();
            }
        }
        catch (Exception $e){}
    }
}

?>
