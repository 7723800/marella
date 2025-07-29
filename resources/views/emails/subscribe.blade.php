@include("sections")
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang="ru">
<head>
    <meta charset="UTF-8">
<style>
</style>
</head>
<body>
    <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;padding:0; font-family: Verdana, Geneva, sans-serif;" width="600">
        <tbody>
            <tr align="center" height="100">
                <td colspan="2">
                    <a href="https://donato.kz" style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;" target="_blank">
                        <img src="https://donato.kz/images/donato-logo.png" style="max-width: 230px; width:30%; display:block;" alt="" border="0" width="100">
                    </a>
                </td>
            </tr>
            <tr align="center" height="30">
                <td colspan="2">
                    <center style="max-width: 600px; width: 100%;">
                        <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;padding:0; font-family: Verdana, Geneva, sans-serif;" width="600" bgcolor="#009c68" width="100%" height="100%">
                            <tbody>
                                <tr align="center" style="color:#ffffff;letter-spacing:0.2em;" height="40">
                                    <td>
                                        <p>Подписка оформлена</p>
                                    </td>
                                </tr>
                                </tbody>
                        </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 20px;">&nbsp;</td>
            </tr>
            <tr height="20">
                <td colspan="2" style="text-align: center">
                <span style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">Ваш промокод на <b>{{ $promocode->value }}&nbsp;₸</b> </span>
                </td>
            </tr>
            <tr>
                <td style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 20px;">&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;padding:10px; font-family:Verdana, Geneva, sans-serif;border: 1px solid #eeeeee;" width="500">
                        <tbody>
                            <tr align="center" height="30">
                                <td colspan="2">
                                    <center style="max-width: 600px; width: 100%;">
                                        <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;padding:0; font-family: Verdana, Geneva, sans-serif;" width="600" bgcolor="#f5f5f5" width="100%" height="100%">
                                            <tbody>
                                                <tr align="center" style="color:#222222;font-size: 32px" height="100">
                                                    <td>
                                                    <p><b>{{ $promocode->number }}</b></p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                        </table>
                                    </center>
                                </td>
                            </tr
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 20px;">&nbsp;</td>
            </tr>
            <tr>
                <td>
                    @yield("email-footer")
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
