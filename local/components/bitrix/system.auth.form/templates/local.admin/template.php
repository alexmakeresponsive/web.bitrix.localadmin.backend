<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CJSCore::Init();

$APPLICATION->SetAdditionalCss("/local/templates/local_admin/styles/vendor/twitter/bootstrap.slate.min.css");


$arResult["AUTH_SERVICES"] = null;
$arResult["NEW_USER_REGISTRATION"] = "N";
?>

<style>
    html, body, body > div, .bx-system-auth-form {
        height: 100%;
    }
    .form-control {

    }
</style>
<div class="bx-system-auth-form">

    <?
    if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
        ShowMessage($arResult['ERROR_MESSAGE']);
    ?>

    <? if ($arResult["FORM_TYPE"] == "login"): ?>


        <div class="container">
            <div class="row">
                <div class="col-4 offset-4">
                    <div class="card text-white bg-secondary border-light mt-3">
                        <div class="card-header text-center">Sign in</div>
                        <div class="card-body">
                            <form name="system_auth_form<?= $arResult["RND"] ?>" method="post" target="_top"
                                  action="<?= $arResult["AUTH_URL"] ?>">
                                <? if ($arResult["BACKURL"] <> ''): ?>
                                    <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
                                <?endif ?>
                                <? foreach ($arResult["POST"] as $key => $value): ?>
                                    <input type="hidden" name="<?= $key ?>" value="<?= $value ?>"/>
                                <?endforeach ?>
                                <input type="hidden" name="AUTH_FORM" value="Y"/>
                                <input type="hidden" name="TYPE" value="AUTH"/>
                                <table >
                                    <tr>
                                        <td colspan="2">
                                            <label for="user-login"><?= GetMessage("AUTH_LOGIN") ?>:</label>
                                            <input class="form-control form-control form-control-sm mb-3" type="text" name="USER_LOGIN" id="user-login" maxlength="50" value="" size="17"/>
                                            <script>
                                                BX.ready(function () {
                                                    var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult["~LOGIN_COOKIE_NAME"])?>");
                                                    if (loginCookie) {
                                                        var form = document.forms["system_auth_form<?=$arResult["RND"]?>"];
                                                        var loginInput = form.elements["USER_LOGIN"];
                                                        loginInput.value = loginCookie;
                                                    }
                                                });
                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label for="user-password"><?= GetMessage("AUTH_PASSWORD") ?>:</label>
                                            <input class="form-control form-control form-control-sm mb-3" type="password" name="USER_PASSWORD" id="user-password" maxlength="255" size="17" autocomplete="off"/>
                                            <? if ($arResult["SECURE_AUTH"]): ?>
                                                <span class="bx-auth-secure" id="bx_auth_secure<?= $arResult["RND"] ?>"
                                                      title="<? echo GetMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
                                                <noscript>
				<span class="bx-auth-secure" title="<? echo GetMessage("AUTH_NONSECURE_NOTE") ?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
                                                </noscript>
                                                <script type="text/javascript">
                                                    document.getElementById('bx_auth_secure<?=$arResult["RND"]?>').style.display = 'inline-block';
                                                </script>
                                            <?endif ?>
                                        </td>
                                    </tr>
                                    <? if ($arResult["STORE_PASSWORD"] == "Y"): ?>
                                        <tr>
                                            <td width="100%">
                                                <div class="d-flex justify-content-center">
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input class="custom-control-input" type="checkbox" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y"/>
                                                        <label class="custom-control-label"
                                                               for="USER_REMEMBER_frm"
                                                               title="<?= GetMessage("AUTH_REMEMBER_ME") ?>"><? echo GetMessage("AUTH_REMEMBER_SHORT") ?></label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td width="100%">
                                            </td>
                                        </tr>
                                    <?endif ?>
                                    <? if ($arResult["CAPTCHA_CODE"]): ?>
                                        <tr>
                                            <td colspan="2">
                                                <? echo GetMessage("AUTH_CAPTCHA_PROMT") ?>:<br/>
                                                <input type="hidden" name="captcha_sid" value="<? echo $arResult["CAPTCHA_CODE"] ?>"/>
                                                <img src="/bitrix/tools/captcha.php?captcha_sid=<? echo $arResult["CAPTCHA_CODE"] ?>"
                                                     width="180" height="40" alt="CAPTCHA"/><br/><br/>
                                                <input type="text" name="captcha_word" maxlength="50" value=""/></td>
                                        </tr>
                                    <?endif ?>
                                    <tr>
                                        <td colspan="2">
                                            <div class="d-flex justify-content-center">
                                                <input class="btn btn-primary" type="submit" name="Login" value="<?= GetMessage("AUTH_LOGIN_BUTTON") ?>"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <? if ($arResult["NEW_USER_REGISTRATION"] == "Y"): ?>
                                        <tr>
                                            <td colspan="2">
                                                <noindex><a href="<?= $arResult["AUTH_REGISTER_URL"] ?>"
                                                            rel="nofollow"><?= GetMessage("AUTH_REGISTER") ?></a></noindex>
                                                <br/></td>
                                        </tr>
                                    <?endif ?>


                                    <? if ($arResult["AUTH_SERVICES"]): ?>
                                        <tr>
                                            <td colspan="2">
                                                <div class="bx-auth-lbl"><?= GetMessage("socserv_as_user_form") ?></div>


                                                <?
                                                $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "icons",
                                                    array(
                                                        "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
                                                        "SUFFIX" => "form",
                                                    ),
                                                    $component,
                                                    array("HIDE_ICONS" => "Y")
                                                );
                                                ?>
                                            </td>
                                        </tr>
                                    <?endif ?>
                                </table>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <? if ($arResult["AUTH_SERVICES"]): ?>
            <?
            $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
                array(
                    "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
                    "AUTH_URL" => $arResult["AUTH_URL"],
                    "POST" => $arResult["POST"],
                    "POPUP" => "Y",
                    "SUFFIX" => "form",
                ),
                $component,
                array("HIDE_ICONS" => "Y")
            );
            ?>
        <?endif ?>

        <?
//        echo '<pre>';
//        var_dump($arResult);
//        var_dump($_COOKIE);
//        echo '</pre>';
        ?>

    <?
    elseif ($arResult["FORM_TYPE"] == "otp"):
        ?>

        <form name="system_auth_form<?= $arResult["RND"] ?>" method="post" target="_top"
              action="<?= $arResult["AUTH_URL"] ?>">
            <? if ($arResult["BACKURL"] <> ''):?>
                <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
            <?endif ?>
            <input type="hidden" name="AUTH_FORM" value="Y"/>
            <input type="hidden" name="TYPE" value="OTP"/>
            <table width="95%">
                <tr>
                    <td colspan="2">
                        <? echo GetMessage("auth_form_comp_otp") ?><br/>
                        <input type="text" name="USER_OTP" maxlength="50" value="" size="17" autocomplete="off"/></td>
                </tr>
                <? if ($arResult["CAPTCHA_CODE"]):?>
                    <tr>
                        <td colspan="2">
                            <? echo GetMessage("AUTH_CAPTCHA_PROMT") ?>:<br/>
                            <input type="hidden" name="captcha_sid" value="<? echo $arResult["CAPTCHA_CODE"] ?>"/>
                            <img src="/bitrix/tools/captcha.php?captcha_sid=<? echo $arResult["CAPTCHA_CODE"] ?>"
                                 width="180" height="40" alt="CAPTCHA"/><br/><br/>
                            <input type="text" name="captcha_word" maxlength="50" value=""/></td>
                    </tr>
                <?endif ?>
                <? if ($arResult["REMEMBER_OTP"] == "Y"):?>
                    <tr>
                        <td valign="top"><input type="checkbox" id="OTP_REMEMBER_frm" name="OTP_REMEMBER" value="Y"/>
                        </td>
                        <td width="100%"><label for="OTP_REMEMBER_frm"
                                                title="<? echo GetMessage("auth_form_comp_otp_remember_title") ?>"><? echo GetMessage("auth_form_comp_otp_remember") ?></label>
                        </td>
                    </tr>
                <?endif ?>
                <tr>
                    <td colspan="2"><input type="submit" name="Login" value="<?= GetMessage("AUTH_LOGIN_BUTTON") ?>"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <noindex><a href="<?= $arResult["AUTH_LOGIN_URL"] ?>"
                                    rel="nofollow"><? echo GetMessage("auth_form_comp_auth") ?></a></noindex>
                        <br/></td>
                </tr>
            </table>
        </form>

    <?
    else:
//        echo '<pre>';
//        var_dump($GLOBALS['AUTH_SPA_SECRET']);
//        echo '</pre>';
        ?>
        <!--logout form-->
        <form action="<?= $arResult["AUTH_URL"] ?>">
            <table width="95%">
                <tr>
                    <td align="center">
                        <?= $arResult["USER_NAME"] ?><br/>
                        [<?= $arResult["USER_LOGIN"] ?>]<br/>
                        <a href="<?= $arResult["PROFILE_URL"] ?>"
                           title="<?= GetMessage("AUTH_PROFILE") ?>"><?= GetMessage("AUTH_PROFILE") ?></a><br/>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <? foreach ($arResult["GET"] as $key => $value):?>
                            <input type="hidden" name="<?= $key ?>" value="<?= $value ?>"/>
                        <? endforeach ?>
                        <input type="hidden" name="logout" value="yes"/>
                        <input type="submit" name="logout_butt" value="<?= GetMessage("AUTH_LOGOUT_BUTTON") ?>"/>
                    </td>
                </tr>
            </table>
        </form>
        <!--logout form-->
    <? endif ?>
</div>
