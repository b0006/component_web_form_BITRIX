<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("form")) return;

$arrForms = array();
$rsForm = CForm::GetList($by='s_sort', $order='asc', array("SITE" => $_REQUEST["site"]), $v3);
while ($arForm = $rsForm->Fetch())
{
	$arrForms[$arForm["ID"]] = "[".$arForm["ID"]."] ".$arForm["NAME"];
}

$arComponentParameters = array(
	"GROUPS" => array(
		"FORM_PARAMS" => array(
			"NAME" => GetMessage("COMP_FORM_GROUP_PARAMS")
		),
	),

	"PARAMETERS" => array(

		"WEB_FORM_ID" => array(
			"NAME" => GetMessage("COMP_FORM_PARAMS_WEB_FORM_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arrForms,
			"ADDITIONAL_VALUES"	=> "Y",
			"DEFAULT" => "={\$_REQUEST[WEB_FORM_ID]}",
			"PARENT" => "DATA_SOURCE",
		),

		"SUCCESS_URL" => array(
			"NAME" => GetMessage("COMP_FORM_PARAMS_SUCCESS"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
			"PARENT" => "FORM_PARAMS",
		),

        "AJAX" => array(
            "NAME" => "Использовать AJAX",
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
            "PARENT" => "FORM_PARAMS",
        ),

        "USE_RECAPTCHA" => array(
            "NAME" => "Использовать Recaptcha v2",
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "PARENT" => "FORM_PARAMS",
        ),


		"CACHE_TIME" => array("DEFAULT" => "3600"),
	),
);
?>