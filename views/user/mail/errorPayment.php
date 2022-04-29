<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;

/**
 * @var dektrium\user\models\User $user
 * @var dektrium\user\models\Token $token
 */
$template = \app\models\MailTemplate::find()->where(['tmp_key' => 'errorPayment'])->one();

?>
<?php if(empty($template)): ?>
    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
        <tbody>
        <tr style="border-collapse:collapse">
            <td class="es-m-txt-c" align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:15px">
                <h2 style="Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;font-size:20px;font-style:normal;font-weight:bold;color:#333333">
                    Оплата VPNMAX
                </h2>
            </td>
        </tr>
        <tr style="border-collapse:collapse">
            <td align="left" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px">
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:21px;color:#333333">
                    Здравствуйте,
                </p>
            </td>
        </tr>
        <tr style="border-collapse:collapse">
            <td align="left" style="padding:0;Margin:0;padding-bottom:10px">
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:21px;color:#333333">
                    Не удалось списать оплату
                </p>
            </td>
        </tr>
        <tr style="border-collapse:collapse">
            <td align="left" style="padding:0;Margin:0">
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:21px;color:#333333">
                    <strong>

                    </strong>
                </p>
            </td>
        </tr>
        <tr style="border-collapse:collapse">
            <td align="left" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px">
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;line-height:21px;color:#666666">
                    С Уважением,
                    <br>
                    Команда mpclick.ru
                    <br>
                    тел.:
                    <a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;font-size:14px;text-decoration:underline;color:#0B5394" href="tel:+74954142565">
                        +7(495)414-25-65
                    </a>
                    <br>
                    email:
                    <a target="_blank" href="mailto:hello@mpclick.ru" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;font-size:14px;text-decoration:underline;color:#0B5394">
                        hello@mpclick.ru
                    </a>
                </p>
            </td>
        </tr>
        </tbody>
    </table>
<?php else:
    ?>
    <?= $template->body?>
<?php endif;?>
