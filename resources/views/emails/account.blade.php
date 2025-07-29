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
                        <p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';box-sizing: border-box;color: #414042;font-size: 16px;line-height: 1.5em;margin-top: 0;text-align:center;">
                                {{ $message }}</p>
                    </center>
                </td>
            </tr>
            <tr align="center" height="80">
                <td colspan="2">
                <a href="{{ $url }}" style="background:#414042;padding: 10px 28px;border-radius: 3px;" target="_blank">
                        <span style="color: #ffffff; font: 16px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: inline-block;letter-spacing: 0.2em;">{{ $action }}</span>
                    </a>
                </td>
            </tr>
            <tr align="center">
                <td>
                    @yield("email-footer")
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
