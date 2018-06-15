<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<h3><?=$arResult["arForm"]["NAME"]?></h3>
<form data-parsley-validate="" id="<?=$arResult["arForm"]["SID"]?>" name="<?=$arResult["arForm"]["SID"]?>" action="<?=POST_FORM_ACTION_URI?>" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">

            <?if($arResult["SUCCESS"] == "Y"):?>
                <p style="color: green;"><?=$arParams["SUCCESS_URL"]?></p>
            <?endif;?>

            <?foreach ($arResult["QUESTIONS"] as $arQuestion):?>

                <?
                $comments = "";
                if(strlen($arQuestion["COMMENTS"]) > 0) {
                    try {
                        $comments = (array)json_decode($arQuestion["COMMENTS"]);
                        if(json_last_error_msg() != "No error"){
                            ?>
                            <script>
                                console.log('<?=json_last_error_msg()?>');
                                console.log('ID question: <?=json_decode($arQuestion["ID"])?>');
                            </script>
                            <?
                        }
                    }
                    catch (Exception $e){}
                }
                ?>

                <?$input_id = $arQuestion["FIELD_TYPE"] . "_" . $arQuestion["ID"];?>

                <?if($arQuestion["ADDITIONAL"] != "Y"):?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">

                            <?if($arQuestion["ERROR"] == "Y"):?>
                                <small style="color: red;"><?=$arQuestion["ERROR_MESSAGE"]?></small>
                                <div class="clearfix"></div>
                            <?endif;?>

                            <label for="<?=$input_id?>"><?=$arQuestion["TITLE"]?></label>

                            <?if($arQuestion["REQUIRED"] == "Y"):?>
                                <span style="color: red;">*</span>
                            <?endif;?>
<<<<<<< HEAD
                            
                            <small id="<?=$arQuestion["ERROR_INPUT_ID"]?>"></small>
=======

                            <div id="<?=$arQuestion["FIELD_TYPE"]?>_errors_<?=$arQuestion["ID"]?>"></div>
>>>>>>> 826ce3bbdf1edb5df9a392a62869e01b3b2b9cc4
                            <?if($arQuestion["FIELD_TYPE"] == "text"):?>

                                <?foreach ($arQuestion["ANSWERS"] as $answer):?>

                                    <input type="text"
                                           class="form-control"
                                           id="<?=$answer["INPUT_ID"]?>"
                                           name="<?=$answer["INPUT_NAME"]?>"
                                           value="<?=$arQuestion["REQUEST_VALUE"]?>"
                                           data-parsley-errors-container="#<?=$arQuestion["ERROR_INPUT_ID"]?>"
                                           <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>
                                           <?if(isset($comments["error_message"])):?>
                                               data-parsley-required-message="<?=$comments["error_message"]?>"
                                           <?else:?>
                                               data-parsley-required-message="Заполните поле"
                                           <?endif;?>
                                           <?if(isset($comments["min_message"])):?>data-parsley-minlength-message="<?=$comments["min_message"]?>"<?endif;?>
                                           <?if(isset($comments["max_message"])):?>data-parsley-maxlength-message="<?=$comments["max_message"]?>"<?endif;?>
                                           <?if(isset($comments["min_length"])):?>data-parsley-minlength="<?=$comments["min_length"]?>"<?endif;?>
                                           <?if(isset($comments["max_length"])):?>data-parsley-maxlength="<?=$comments["max_length"]?>"<?endif;?>
                                    >

                                    <?if($comments["type"] == "phone"):?>
                                        <script>
                                            //$('#<?//=$answer["INPUT_ID"]?>').inputmask("+8(999) 999 9999");
                                            $('#<?=$answer["INPUT_ID"]?>').mask("+7(999) 999 9999");
                                        </script>
                                    <?endif;?>

                                <?endforeach;?>


                            <?elseif($arQuestion["FIELD_TYPE"] == "textarea"):?>

                                <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                    <textarea class="form-control"
                                              id="<?=$answer["INPUT_ID"]?>"
                                              name="<?=$answer["INPUT_NAME"]?>"
                                              <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>
                                              data-parsley-errors-container="#<?=$arQuestion["ERROR_INPUT_ID"]?>"
                                              <?if(isset($comments["error_message"])):?>
                                                  data-parsley-required-message="<?=$comments["error_message"]?>"
                                              <?else:?>
                                                  data-parsley-required-message="Напишите сообщение"
                                              <?endif;?>
                                              <?if(isset($comments["min_message"])):?>data-parsley-minlength-message="<?=$comments["min_message"]?>"<?endif;?>
                                              <?if(isset($comments["max_message"])):?>data-parsley-maxlength-message="<?=$comments["max_message"]?>"<?endif;?>
                                              <?if(isset($comments["min_length"])):?>data-parsley-minlength="<?=$comments["min_length"]?>"<?endif;?>
                                              <?if(isset($comments["max_length"])):?>data-parsley-maxlength="<?=$comments["max_length"]?>"<?endif;?>
                                    ><?=$arQuestion["REQUEST_VALUE"]?></textarea>
                                <?endforeach;?>

                            <?elseif($arQuestion["FIELD_TYPE"] == "radio"):?>

                                <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="radio"
                                               id="<?=$answer["INPUT_ID"]?>"
                                               name="<?=$answer["INPUT_NAME"]?>"
                                               value="<?=$answer["ID"]?>"
                                               data-parsley-errors-container="#<?=$arQuestion["ERROR_INPUT_ID"]?>"
                                               <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>
                                               <?if($arQuestion["REQUEST_VALUE"] == $answer["ID"]):?>checked<?endif;?>
                                               <?if(isset($comments["error_message"])):?>
                                                   data-parsley-required-message="<?=$comments["error_message"]?>"
                                               <?else:?>
                                                   data-parsley-required-message="Выберите вариант ответа"
                                               <?endif;?>
                                        >
                                        <label class="form-check-label" for="<?=$answer["INPUT_ID"]?>">
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
                                               name="<?=$answer["INPUT_NAME"]?>"
                                               id="<?=$answer["INPUT_ID"]?>"
                                               data-parsley-trigger="click"
                                               data-parsley-errors-container="#<?=$arQuestion["ERROR_INPUT_ID"]?>"
                                               <?foreach ($arQuestion["REQUEST_VALUE"] as $req):?>
                                               <?if($req == $answer["ID"]):?>checked<?endif;?>
                                               <?endforeach;?>
                                               <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>
                                               <?if(isset($comments["min_message"])):?>data-parsley-mincheck-message="<?=$comments["min_message"]?>"<?endif;?>
                                               <?if(isset($comments["max_message"])):?>data-parsley-maxcheck-message="<?=$comments["max_message"]?>"<?endif;?>
                                               <?if(isset($comments["mincheck"])):?>data-parsley-mincheck="<?=$comments["mincheck"]?>"<?endif;?>
                                               <?if(isset($comments["maxcheck"])):?>data-parsley-maxcheck="<?=$comments["maxcheck"]?>"<?endif;?>
                                               <?if(isset($comments["error_message"])):?>
                                                   data-parsley-required-message="<?=$comments["error_message"]?>"
                                               <?else:?>
                                                   data-parsley-required-message="Выберите вариант(ы) ответа(ов)"
                                               <?endif;?>
                                        >
                                        <label class="form-check-label" for="<?=$answer["INPUT_ID"]?>">
                                            <?=$answer["MESSAGE"]?>
                                        </label>
                                    </div>
                                <?endforeach;?>

                            <?elseif($arQuestion["FIELD_TYPE"] == "dropdown"):?>
                                    <?foreach ($arQuestion["ANSWERS"] as $a_pid => $answer):?>

                                        <?if($a_pid == 0):?>
                                            <select class="form-control"
                                                    id="<?=$answer["INPUT_ID"]?>"
                                                    name="<?=$answer["INPUT_NAME"]?>"
                                                    data-parsley-errors-container="#<?=$arQuestion["ERROR_INPUT_ID"]?>"
                                                    <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>
                                                    <?if(isset($comments["error_message"])):?>
                                                        data-parsley-required-message="<?=$comments["error_message"]?>"
                                                    <?else:?>
                                                        data-parsley-required-message="Выберите"
                                                    <?endif;?>
                                            >
                                            <option label="Выберите вариант ответа"></option>
                                        <?endif;?>

                                        <option value="<?=$answer["ID"]?>" <?if($arQuestion["REQUEST_VALUE"] == $answer["ID"]):?>selected<?endif;?>>
                                            <?=$answer["MESSAGE"]?>
                                        </option>

                                    <?endforeach;?>
                                </select>

                            <?elseif($arQuestion["FIELD_TYPE"] == "email"):?>
                                <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                    <input type="email"
                                           class="form-control"
                                           id="<?=$answer["INPUT_ID"]?>"
                                           name="<?=$answer["INPUT_NAME"]?>"
                                           value="<?=$arQuestion["REQUEST_VALUE"]?>"
                                           data-parsley-errors-container="#<?=$arQuestion["ERROR_INPUT_ID"]?>"
                                           <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>
                                           data-parsley-trigger="change"
                                           data-parsley-type-message="Неккоректный email"
                                           <?if(isset($comments["error_message"])):?>
                                               data-parsley-required-message="<?=$comments["error_message"]?>"
                                           <?endif;?>
                                    >
                                <?endforeach;?>
                            <?elseif($arQuestion["FIELD_TYPE"] == "multiselect"):?>
                                    <?foreach ($arQuestion["ANSWERS"] as $a_pid => $answer):?>

                                        <?if($a_pid == 0):?>
                                            <select multiple=""
                                                    class="form-control"
                                                    id="<?=$answer["INPUT_ID"]?>"
                                                    name="<?=$answer["INPUT_NAME"]?>"
                                                    data-parsley-trigger="click"
                                                    data-parsley-errors-container="#<?=$arQuestion["ERROR_INPUT_ID"]?>"
                                                    <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>
                                                    <?if(isset($comments["min_message"])):?>data-parsley-mincheck-message="<?=$comments["min_message"]?>"<?endif;?>
                                                    <?if(isset($comments["max_message"])):?>data-parsley-maxcheck-message="<?=$comments["max_message"]?>"<?endif;?>
                                                    <?if(isset($comments["mincheck"])):?>data-parsley-mincheck="<?=$comments["mincheck"]?>"<?endif;?>
                                                    <?if(isset($comments["maxcheck"])):?>data-parsley-maxcheck="<?=$comments["maxcheck"]?>"<?endif;?>
                                                    <?if(isset($comments["error_message"])):?>
                                                        data-parsley-required-message="<?=$comments["error_message"]?>"
                                                    <?else:?>
                                                        data-parsley-required-message="Выберите"
                                                    <?endif;?>
                                            >
                                        <?endif;?>

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
                                            <img src="/bitrix/js/main/core/images/calendar-icon.gif"
                                                 alt="Выбрать дату в календаре"
                                                 class="calendar-icon"
                                                 onclick="BX.calendar({node:this, field:'<?=$answer["INPUT_ID"]?>', form: '<?=$arResult["arForm"]["SID"]?>', bTime: false, currentTime: '<?echo time();?>', bHideTime: false});"
                                                 onmouseover="BX.addClass(this, 'calendar-icon-hover');"
                                                 onmouseout="BX.removeClass(this, 'calendar-icon-hover');"
                                                 border="0"
                                            >
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text"
                                                   class="form-control"
                                                   id="<?=$answer["INPUT_ID"]?>"
                                                   name="<?=$answer["INPUT_NAME"]?>"
                                                   value="<?=$arQuestion["REQUEST_VALUE"]?>"
                                                   data-parsley-errors-container="#<?=$arQuestion["ERROR_INPUT_ID"]?>"
                                                   <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>
                                                   <?if(isset($comments["error_message"])):?>
                                                       data-parsley-required-message="<?=$comments["error_message"]?>"
                                                   <?else:?>
                                                       data-parsley-required-message="Выберите дату"
                                                   <?endif;?>
                                            >
                                        </div>
                                    </div>

                                    <script>
                                        $('#<?=$answer["INPUT_ID"]?>').mask("99.99.9999");
                                    </script>

                                    <?endforeach;?>
                            <?elseif($arQuestion["FIELD_TYPE"] == "image"):?>
                                <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                    <input type="file"
                                           class="form-control-file"
                                           id="<?=$answer["INPUT_ID"]?>"
                                           name="<?=$answer["INPUT_NAME"]?>"
                                           data-parsley-errors-container="#<?=$arQuestion["ERROR_INPUT_ID"]?>"
                                           <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>
                                           <?if(isset($comments["error_message"])):?>
                                               data-parsley-required-message="<?=$comments["error_message"]?>"
                                           <?else:?>
                                               data-parsley-required-message="Выберите изображение"
                                           <?endif;?>
                                    >
                                <?endforeach;?>
                            <?elseif($arQuestion["FIELD_TYPE"] == "file"):?>
                                <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                    <input type="file"
                                           class="form-control-file"
                                           id="<?=$answer["INPUT_ID"]?>"
                                           name="<?=$answer["INPUT_NAME"]?>"
                                           data-parsley-errors-container="#<?=$arQuestion["ERROR_INPUT_ID"]?>"
                                           <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>
                                           <?if(isset($comments["error_message"])):?>
                                               data-parsley-required-message="<?=$comments["error_message"]?>"
                                           <?else:?>
                                               data-parsley-required-message="Выберите файл"
                                           <?endif;?>
                                    >
                                <?endforeach;?>
                            <?elseif($arQuestion["FIELD_TYPE"] == "url"):?>
                                <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                    <input type="text"
                                           class="form-control"
                                           id="<?=$answer["INPUT_ID"]?>"
                                           name="<?=$answer["INPUT_NAME"]?>"
                                           data-parsley-errors-container="#<?=$arQuestion["ERROR_INPUT_ID"]?>"
                                           value="<?=$arQuestion["REQUEST_VALUE"]?>"
                                           <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>
                                           data-parsley-type="url"
                                           <?if(isset($comments["error_message"])):?>
                                               data-parsley-required-message="<?=$comments["error_message"]?>"
                                           <?else:?>
                                               data-parsley-required-message="Введите URL"
                                           <?endif;?>
                                    >
                                <?endforeach;?>
                            <?elseif($arQuestion["FIELD_TYPE"] == "password"):?>
                                <?foreach ($arQuestion["ANSWERS"] as $answer):?>
                                    <input type="password"
                                           class="form-control"
                                           id="<?=$answer["INPUT_ID"]?>"
                                           name="<?=$answer["INPUT_NAME"]?>"
                                           data-parsley-errors-container="#<?=$arQuestion["ERROR_INPUT_ID"]?>"
                                           value="<?=$arQuestion["REQUEST_VALUE"]?>"
                                           <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>
                                           <?if(isset($comments["min_message"])):?>data-parsley-mincheck-message="<?=$comments["min_message"]?>"<?endif;?>
                                           <?if(isset($comments["max_message"])):?>data-parsley-maxcheck-message="<?=$comments["max_message"]?>"<?endif;?>
                                           <?if(isset($comments["mincheck"])):?>data-parsley-mincheck="<?=$comments["mincheck"]?>"<?endif;?>
                                           <?if(isset($comments["maxcheck"])):?>data-parsley-maxcheck="<?=$comments["maxcheck"]?>"<?endif;?>
                                           <?if(isset($comments["error_message"])):?>
                                               data-parsley-required-message="<?=$comments["error_message"]?>"
                                           <?else:?>
                                               data-parsley-required-message="Введите пароль"
                                           <?endif;?>
                                    >
                                <?endforeach;?>
                            <?endif;?>
                        </div>
                    </div>
                </div>
                <?endif;?>
            <?endforeach;?>

            <?if($arParams["USE_CAPTCHA"] == "google"):?>

                <?if(isset($arResult["ERROR_MESSAGE_RECAPTCHA"])):?>
                    <?=$arResult["ERROR_MESSAGE_RECAPTCHA"]?>
                <?endif;?>

                <small style="color: red;" id="g-recaptcha-error"></small>
                <div class="g-recaptcha" data-sitekey="<?=RE_SITE_KEY?>"></div>
            <?elseif($arParams["USE_CAPTCHA"] == "bitrix"):?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="captcha-block">
                                        <small style="color: red;" id="captcha-error">
                                            <?if(isset($arResult["ERROR_MESSAGE_CAPTCHA"])):?>
                                                <?=$arResult["ERROR_MESSAGE_CAPTCHA"]?>
                                            <?endif;?>
                                        </small>
                                        <div class="clearfix"></div>

                                        <input class="captchaSid" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" type="hidden">
                                        <img class="captchaImg" src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40">
                                        <div class="clearfix"></div>
                                        <a class="captcha-link reloadCaptcha" href="#">Обновить картинку</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input name="captcha_word" value="" class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?endif;?>

            <input type="hidden" name="isAjax" value="<?if($arParams["AJAX"] == "Y"):?>Y<?else:?>N<?endif;?>">
            <input class="btn btn-primary" name="<?=$arResult["SUBMIT_NAME"]?>" type="submit" value="<?=$arResult["arForm"]["BUTTON"]?>">
        </div>
    </div>
</form>


<script>
    $( document ).ready(function() {

        $('.captcha-block').on('click', '.reloadCaptcha', function(){
            var $parent = $(this).closest('.captcha-block');

            $.getJSON('/ajax/reload_captcha.php', function(data) {
                console.log(data);
                $parent.find('.captchaImg').attr('src','/bitrix/tools/captcha.php?captcha_sid=' + data.code);
                $parent.find('.captchaSid').val(data.code);
            });
            return false;
        });

        var id_form = "<?=$arResult["arForm"]["SID"]?>";

        $('#' + id_form).parsley().on('field:validated', function(formInstance) {

        });

        $("#" + id_form).on("submit", function (e) {

            var isSuccess = true;

            <?if($arParams["USE_CAPTCHA"] == "google"):?>
                var captcha = grecaptcha.getResponse();
                if (grecaptcha.getResponse() === ""){
                    $("#g-recaptcha-error").text("Подтвердите, что Вы не являетесь роботом!");
                    isSuccess = false;
                    return false;
                }
                else {
                    $("#g-recaptcha-error").text("");
                }
            <?elseif(($arParams["USE_CAPTCHA"] == "bitrix") && ($arParams["AJAX"] == "Y")):?>
                var cap_sid = $('#' + id_form + " input[name=captcha_sid]").attr("value");
                var cap_word = $('#' + id_form + " input[name=captcha_word]").val();

                var $parent = $('.captcha-block').closest('.captcha-block');

                $.getJSON( '/ajax/reload_captcha.php', { cap_sid: cap_sid, cap_word: cap_word } )
                    .done(function( json ) {

                        console.log(json);

                        if(json.status === "failed"){
                            $parent.find('.captchaImg').attr('src','/bitrix/tools/captcha.php?captcha_sid=' + json.code);
                            $parent.find('.captchaSid').val(json.code);
                            $("#captcha-error").text(json.message);
                        }

                        if(json.status === "ok") {
                            $("#captcha-error").text("");

                            var that = $('#' + id_form)[0];
                            var formData = new FormData(that);

                            $.ajax({
                                url: that.action,
                                type: that.method,
                                data: formData,
                                success: function (data) {
                                    <?if($arParams["USE_CAPTCHA"] == "google"):?>
                                    grecaptcha.reset();
                                    <?endif;?>
                                    that.reset();

                                    // var $parent = $('.captcha-block').closest('.captcha-block');
                                    $.getJSON('/ajax/reload_captcha.php', function (data) {
                                        $parent.find('.captchaImg').attr('src', '/bitrix/tools/captcha.php?captcha_sid=' + data.code);
                                        $parent.find('.captchaSid').val(data.code);
                                    });

                                    alert("<?=$arParams["SUCCESS_URL"]?>");
                                },
                                cache: false,
                                contentType: false,
                                processData: false
                            });
                        }
                    })
                    .fail(function( jqxhr, textStatus, error ) {
                        console.log( "Request Failed: " + error );
                    });

                return false;

            <?endif;?>

            if(isSuccess) {
                <?if($arParams["AJAX"] == "Y"):?>

                var that = $('#' + id_form)[0];
                var formData = new FormData(that);

                $.ajax({
                    url: that.action,
                    type: that.method,
                    data: formData,
                    success: function (data) {
                        <?if($arParams["USE_CAPTCHA"] == "google"):?>
                        grecaptcha.reset();
                        <?endif;?>
                        that.reset();

                        var $parent = $('.captcha-block').closest('.captcha-block');
                        $.getJSON('/ajax/reload_captcha.php', function (data) {
                            $parent.find('.captchaImg').attr('src', '/bitrix/tools/captcha.php?captcha_sid=' + data.code);
                            $parent.find('.captchaSid').val(data.code);
                        });

                        alert("<?=$arParams["SUCCESS_URL"]?>");
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

                return false;
                <?endif;?>
            }

        });
    });

</script>

