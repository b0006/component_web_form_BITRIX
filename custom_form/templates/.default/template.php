<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<script>
    var requiredFields = [];
</script>

<h3><?=$arResult["arForm"]["NAME"]?></h3>
<form id="<?=$arResult["arForm"]["SID"]?>" name="<?=$arResult["arForm"]["SID"]?>" action="<?=POST_FORM_ACTION_URI?>" method="POST" enctype="multipart/form-data">
    <input name="sessid" id="sessid" value="<?=$_SESSION["fixed_session_id"]?>" type="hidden">

    <div class="row">
        <div class="col-md-6">

            <?if($arResult["SUCCESS"] == "Y"):?>
                <p style="color: green;"><?=$arParams["SUCCESS_URL"]?></p>
            <?endif;?>

            <?foreach ($arResult["QUESTIONS"] as $arQuestion):?>
                <?$input_id = $arQuestion["FIELD_TYPE"] . "_" . $arQuestion["ID"];?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">

                            <?if($arQuestion["ERROR"] == "Y"):?>
                                <small style="color: red;"><?=$arQuestion["ERROR_MESSAGE"]?></small>
                                <div class="clearfix"></div>
                            <?endif;?>

                            <small id="error_<?=$arQuestion["ID"]?>" style="color: #FF0000;"></small>
                            <div class="clearfix"></div>

                            <label for="<?=$input_id?>"><?=$arQuestion["TITLE"]?></label>

                            <?if($arQuestion["REQUIRED"] == "Y"):?>
                                <span style="color: red;">*</span>
                                <script>
                                    requiredFields.push({
                                        error_field_id : 'error_<?=$arQuestion["ID"]?>',
                                        field_name : '<?=$arQuestion["INPUT_NAME"]?>',
                                        type : '<?=$arQuestion["FIELD_TYPE"]?>'
                                    });
                                </script>
                            <?endif;?>

                            <?if($arQuestion["FIELD_TYPE"] == "text"):?>

                                <input class="form-control" type="text" id="text_<?=$arQuestion["ID"]?>" name="<?=$arQuestion["INPUT_NAME"]?>" value="<?=$arQuestion["REQUEST_VALUE"]?>">

                            <?elseif($arQuestion["FIELD_TYPE"] == "textarea"):?>

                                <textarea class="form-control" id="textarea_<?=$arQuestion["ID"]?>" name="<?=$arQuestion["INPUT_NAME"]?>"><?=$arQuestion["REQUEST_VALUE"]?></textarea>

                            <?elseif($arQuestion["FIELD_TYPE"] == "radio"):?>

                                <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="<?=$arQuestion["INPUT_NAME"]?>"
                                               id="radio_<?=$answer["ID"]?>"
                                               value="<?=$answer["ID"]?>"
                                               <?if($arQuestion["REQUEST_VALUE"] == $answer["ID"]):?>checked<?endif;?>
                                        >
                                        <label class="form-check-label" for="radio_<?=$answer["ID"]?>">
                                            <?=$answer["MESSAGE"]?>
                                        </label>
                                    </div>
                                <?endforeach;?>

                            <?elseif($arQuestion["FIELD_TYPE"] == "checkbox"):?>

                                <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               value="<?=$answer["ID"]?>"
                                               name="<?=$arQuestion["INPUT_NAME"]?>"
                                               id="checkbox_<?=$answer["ID"]?>"
                                               <?foreach ($arQuestion["REQUEST_VALUE"] as $req):?>
                                               <?if($req == $answer["ID"]):?>checked<?endif;?>
                                               <?endforeach;?>
                                        >
                                        <label class="form-check-label" for="checkbox_<?=$answer["ID"]?>">
                                            <?=$answer["MESSAGE"]?>
                                        </label>
                                    </div>
                                <?endforeach;?>

                            <?elseif($arQuestion["FIELD_TYPE"] == "dropdown"):?>

                                <select class="form-control" id="dropdown_<?=$arQuestion["ID"]?>" name="<?=$arQuestion["INPUT_NAME"]?>">
                                    <option></option>
                                    <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                        <option value="<?=$answer["ID"]?>" <?if($arQuestion["REQUEST_VALUE"] == $answer["ID"]):?>selected<?endif;?>><?=$answer["MESSAGE"]?></option>
                                    <?endforeach;?>
                                </select>

                            <?elseif($arQuestion["FIELD_TYPE"] == "email"):?>
                                <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                    <input type="text" class="form-control" id="email_<?=$arQuestion["ID"]?>" name="<?=$arQuestion["INPUT_NAME"]?>" value="<?=$arQuestion["REQUEST_VALUE"]?>">
                                <?endforeach;?>
                            <?elseif($arQuestion["FIELD_TYPE"] == "multiselect"):?>
                                <select multiple="" class="form-control" id="multiselect_<?=$arQuestion["ID"]?>" name="<?=$arQuestion["INPUT_NAME"]?>">
                                    <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                        <option value="<?=$answer["ID"]?>"
                                            <?foreach ($arQuestion["REQUEST_VALUE"] as $req):?>
                                                <?if($req == $answer["ID"]):?>selected<?endif;?>
                                            <?endforeach;?>
                                        >
                                            <?=$answer["MESSAGE"]?>
                                        </option>
                                    <?endforeach;?>
                                </select>
                            <?elseif($arQuestion["FIELD_TYPE"] == "date"):?>
                                <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="/bitrix/js/main/core/images/calendar-icon.gif" alt="Выбрать дату в календаре" class="calendar-icon" onclick="BX.calendar({node:this, field:'date_<?=$arQuestion["ID"]?>', form: '<?=$arResult["arForm"]["SID"]?>', bTime: false, currentTime: '<?echo time();?>', bHideTime: false});" onmouseover="BX.addClass(this, 'calendar-icon-hover');" onmouseout="BX.removeClass(this, 'calendar-icon-hover');" border="0">
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="date_<?=$arQuestion["ID"]?>" name="<?=$arQuestion["INPUT_NAME"]?>" value="<?=$arQuestion["REQUEST_VALUE"]?>">
                                        </div>
                                    </div>

                                    <script>
                                        $('#date_<?=$arQuestion["ID"]?>').mask("99.99.9999");
                                    </script>

                                    <?endforeach;?>
                            <?elseif($arQuestion["FIELD_TYPE"] == "image"):?>
                                <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                    <input type="file" class="form-control-file" id="image_<?=$arQuestion["ID"]?>" name="<?=$arQuestion["INPUT_NAME"]?>" value="">
                                <?endforeach;?>
                            <?elseif($arQuestion["FIELD_TYPE"] == "file"):?>
                                <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                    <input type="file" class="form-control-file" id="file_<?=$arQuestion["ID"]?>" name="<?=$arQuestion["INPUT_NAME"]?>" value="">
                                <?endforeach;?>
                            <?elseif($arQuestion["FIELD_TYPE"] == "url"):?>
                                <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                    <input type="text" class="form-control" id="url_<?=$arQuestion["ID"]?>" name="<?=$arQuestion["INPUT_NAME"]?>" value="<?=$arQuestion["REQUEST_VALUE"]?>">
                                <?endforeach;?>
                            <?elseif($arQuestion["FIELD_TYPE"] == "password"):?>
                                <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                    <input type="password" class="form-control" id="url_<?=$arQuestion["ID"]?>" name="<?=$arQuestion["INPUT_NAME"]?>" value="<?=$arQuestion["REQUEST_VALUE"]?>">
                                <?endforeach;?>
                            <?endif;?>
                        </div>
                    </div>
                </div>
            <?endforeach;?>

            <?if($arParams["USE_RECAPTCHA"] == "Y"):?>

                <?if(isset($arResult["ERROR_MESSAGE_RECAPTCHA"])):?>
                    <?=$arResult["ERROR_MESSAGE_RECAPTCHA"]?>
                <?endif;?>

                <small id="g-recaptcha-error"></small>
                <div class="g-recaptcha" data-sitekey="<?=RE_SITE_KEY?>"></div>
            <?endif;?>

            <input type="hidden" name="isAjax" value="<?if($arParams["AJAX"] == "Y"):?>Y<?else:?>N<?endif;?>">
            <input class="btn btn-primary" name="<?=$arResult["SUBMIT_NAME"]?>" type="submit" value="<?=$arResult["arForm"]["BUTTON"]?>">
        </div>
    </div>
</form>

<?if($arParams["AJAX"] == "Y"):?>
    <script>
        $( document ).ready(function() {
            var id_form = "<?=$arResult["arForm"]["SID"]?>";

            function validation_web_form(required_fields, form_data, captcha = "none") {
                var isSuccess = true;

                if(captcha !== "none"){
                    if(!captcha.length){
                        isSuccess = false;
                        $("#g-recaptcha-error").text("Ошибка проверки безопасности");
                    }
                    else {
                        $("#g-recaptcha-error").text("");
                        grecaptcha.reset();
                    }
                }

                required_fields.forEach(function (req_value, req_index) {
                    var error_field = $("#" + req_value.error_field_id);
                    error_field.text("");

                    var arValue = form_data.getAll(req_value.field_name);

                    if(arValue.length === 0){
                        error_field.text("Заполните поле");
                        isSuccess = false;
                    }
                    else if(arValue.length > 0) {
                        if(req_value.type === "image") {

                            arValue.forEach(function (image, index) {
                                var mime_type = image.type;
                                if(mime_type !== undefined) {
                                    var isImage = mime_type.indexOf("image");
                                    if (isImage === -1) {
                                        error_field.text("Заполните поле");
                                        isSuccess = false;
                                    }
                                }
                                else if((mime_type === "") || (mime_type === undefined)) {
                                    error_field.text("Заполните поле");
                                    isSuccess = false;
                                }
                            });
                        }
                        else {
                            arValue.forEach(function (value, index) {
                                if (value === "") {
                                    error_field.text("Заполните поле");
                                    isSuccess = false;
                                }
                            });
                        }

                    }
                });
                return isSuccess;
            }

            $("#"+ id_form).submit(function(e) {
                var captcha = grecaptcha.getResponse();

                e.preventDefault();
                var that = this;

                var formData = new FormData(this);
                var isSuccess = validation_web_form(requiredFields, formData, captcha);

                if(isSuccess) {
                    $.ajax({
                        url: that.action,
                        type: that.method,
                        data: formData,
                        success: function (data) {
                            grecaptcha.reset();
                            that.reset();
                            alert("<?=$arParams["SUCCESS_URL"]?>");
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
            });
        });

    </script>
<?endif;?>