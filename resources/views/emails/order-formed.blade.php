@include('sections')
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <style>
    </style>
</head>

<body>
    <table border="0" cellpadding="0" cellspacing="0"
        style="margin:0 auto;padding:0; font-family: Verdana, Geneva, sans-serif;" width="600">
        <tbody>
            <tr align="center" height="100">
                <td colspan="2">
                    <a href="https://donato.kz"
                        style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;"
                        target="_blank">
                        <img src="https://donato.kz/images/donato-logo.png"
                            style="max-width: 230px; width:30%; display:block;" alt="" border="0"
                            width="100">
                    </a>
                </td>
            </tr>
            <tr align="center" height="30">
                <td colspan="2">
                    <center style="max-width: 600px; width: 100%;">
                        <table border="0" cellpadding="0" cellspacing="0"
                            style="margin:0 auto;padding:0; font-family: Verdana, Geneva, sans-serif;" width="600"
                            bgcolor="#009c68" width="100%" height="100%">
                            <tbody>
                                <tr align="center" style="color:#ffffff;letter-spacing:0.2em;" height="40">
                                    <td>
                                        <p>Сформирован новый заказ</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </center>
                </td>
            </tr>
            <tr height="80">
                <td colspan="2">
                    <span
                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">Заказ
                        <b>№ {{ $order->order_number }}</b></span>
                </td>
            </tr>
            <tr>
                <td style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 20px;">&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0"
                        style="margin:0 auto;padding:10px; font-family:Verdana, Geneva, sans-serif;border: 1px solid #eeeeee;"
                        width="500">
                        <tbody>
                            <tr>
                                <td width="50%">
                                    <span
                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">
                                        <b>Получатель:</b>
                                    </span>
                                </td>
                                <td width="50%">
                                    <span
                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">{{ $order->customer_name }}
                                        {{ $order->customer_lastname }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"
                                    style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 5px;">
                                    &nbsp;</td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <span
                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">
                                    </span>
                                </td>
                                <td width="50%">
                                    <span
                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">+{{ $order->customer_phone }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"
                                    style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 20px;">
                                    &nbsp;</td>
                            </tr>
                            <tr style="vertical-align:top;">
                                <td width="50%">
                                    <span
                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">
                                        <b>E-mail:</b>
                                    </span>
                                </td>
                                <td width="50%">
                                    <span
                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">{{ $order->customer_email }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"
                                    style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 20px;">
                                    &nbsp;</td>
                            </tr>
                            <tr style="vertical-align:top;">
                                <td width="50%">
                                    <span
                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">
                                        <b>Адрес:</b>
                                    </span>
                                </td>
                                <td width="50%">
                                    <span
                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">{{ $order->customer_city }},
                                        {{ $order->customer_address }}, {{ $order->customer_area }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"
                                    style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 20px;">
                                    &nbsp;</td>
                            </tr>
                            <tr style="vertical-align:top;">
                                <td width="50%">
                                    <span
                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">
                                        <b>Способ оплаты:</b>
                                    </span>
                                </td>
                                <td width="50%">
                                    <span
                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">{{ $order->payment_method }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"
                                    style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 20px;">
                                    &nbsp;</td>
                            </tr>

                            <tr style="vertical-align:top;">
                                <td width="50%">
                                    <span
                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">
                                        <b>Статус оплаты:</b>
                                    </span>
                                </td>
                                <td width="50%">
                                    <span
                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">{{ $order->is_paid ? 'Оплачено' : 'Не оплачено' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"
                                    style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 20px;">
                                    &nbsp;</td>
                            </tr>

                            <tr style="vertical-align:top;">
                                <td width="50%">
                                    <span
                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">
                                        <b>Способ доставки:</b>
                                    </span>
                                </td>
                                <td width="50%">
                                    <span
                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">
                                        {{ $order->delivery_method }} </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"
                                    style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 20px;">
                                    &nbsp;</td>
                            </tr>
                            <tr style="vertical-align:top;">
                                <td width="50%">
                                    <span
                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">
                                        <b>Комментарий:</b>
                                    </span>
                                </td>
                                <td width="50%">
                                    <span
                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">{{ $order->customer_comment }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"
                                    style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 20px;">
                                    &nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2"
                                    style="padding: 15px 20px 15px 20px;vertical-align: top;border-top:  1px solid #eeeeee;text-align: left;background-color: #f5f5f5;">
                                    <table border="0" cellpadding="0" cellspacing="0"
                                        style="margin:0 auto;padding:0; font-family:Verdana, Geneva, sans-serif;"
                                        width="500">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    @php($totalItemPrice = 0)
                                                    @foreach ($order->items as $item)
                                                        @php($totalItemPrice += $item->item_data['price'] * $item->item_data['inCart'])
                                                    @endforeach
                                                    <span
                                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">
                                                        Товаров на
                                                        сумму:&nbsp;{{ $totalItemPrice }}&nbsp;₸.
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"
                                                    style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 20px;">
                                                    &nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span
                                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">
                                                        Скидка:&nbsp;{{ ($order->total_with_discount == 0 ? 0 : $totalItemPrice - $order->total_with_discount) + $order->discount }}&nbsp;₸.
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"
                                                    style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 20px;">
                                                    &nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span
                                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">
                                                        Доставка:&nbsp;{{ $order->delivery_price }}&nbsp;₸.
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"
                                                    style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 20px;">
                                                    &nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span
                                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 15px;">
                                                        <b>Итого к
                                                            оплате:&nbsp;{{ $order->total }}&nbsp;₸.</b>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"
                                    style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 20px;">
                                    &nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="vertical-align: top;text-align: left;">
                                    <table border="0" cellpadding="0" cellspacing="0"
                                        style="margin:0 auto;padding:0; font-family:Verdana, Geneva, sans-serif;"
                                        width="500">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    @php($totalAmount = 0)
                                                    @foreach ($order->items as $item)
                                                        @php($totalAmount += $item->item_data['inCart'])
                                                    @endforeach
                                                    <span
                                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 16px;">
                                                        Всего товаров: {{ $totalAmount }}&nbsp;шт.
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 16px;">
                                                        Кол-во.
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        style="font-style:normal;font-weight:normal;line-height:22px;font-family:sans-serif;color:#222222;font-size: 16px;">
                                                        Цена.
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"
                                                    style="padding: 0;vertical-align: top;text-align: left;font-size: 1px;line-height: 1px;height: 1px;">
                                                    <hr size="1" color="222222" style="color:222222;">
                                                </td>
                                            </tr>
                                            @foreach ($order->items as $item)
                                                <tr>
                                                    <td
                                                        style="padding: 21px 0 19px 0;vertical-align: top;text-align: left;font-size: 0;">
                                                        <table cellspacing="0" cellpadding="0" border="0"
                                                            align="center"
                                                            style="border-collapse: collapse;border-spacing: 0;width: 100%;">
                                                            <tbody>
                                                                <tr>
                                                                    <td
                                                                        style="padding: 0;vertical-align: top;text-align: left;width: 92px;">
                                                                        <a href="{{ $item->item_data['url'] }}"
                                                                            target="_blank"
                                                                            style="text-decoration:none;">
                                                                            <img src="{{ $item->item_data['images'][0]['url'] }}"
                                                                                alt="" width="72"
                                                                                height="104" border="0"
                                                                                style="border: 0;outline: none;text-decoration: none;display: block;">
                                                                        </a>
                                                                    </td>
                                                                    <td
                                                                        style="padding: 0;vertical-align: top;text-align: left;">
                                                                        <table cellspacing="0" cellpadding="0"
                                                                            border="0" align="center"
                                                                            style="border-collapse: collapse;border-spacing: 0;width: 100%;">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td
                                                                                        style="padding: 0;vertical-align: top;text-align: left;font-size: 0;">
                                                                                        <div class="row_mailru_css_attribute_postfix"
                                                                                            style="display: inline-block;vertical-align: top;text-align: left;padding: 0;width: 100%;max-width: 303px;">
                                                                                            <table cellspacing="0"
                                                                                                cellpadding="0"
                                                                                                border="0"
                                                                                                align="center"
                                                                                                style="border-collapse: collapse;border-spacing: 0;width: 100%;">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td
                                                                                                            style="padding: 0;vertical-align: top;text-align: left;font-family: sans-serif;font-size: 13px;line-height: 24px;font-weight: normal;color: #222222;">
                                                                                                            <a href="{{ $item->item_data['url'] }}"
                                                                                                                target="_blank"
                                                                                                                style="text-decoration:none;">
                                                                                                                <span
                                                                                                                    style="color:#222222;">{{ $item->item_data['name'] }}</span>
                                                                                                            </a><br>
                                                                                                            <span>
                                                                                                                @if (isset($item->item_data['perfume']))
                                                                                                                    Объем:
                                                                                                                @else
                                                                                                                    Размер:
                                                                                                                @endif
                                                                                                                @foreach ($item->item_data['sizes'] as $size)
                                                                                                                    @if ($size['isSelected'])
                                                                                                                        {{ $size['value'] }}
                                                                                                                    @endif
                                                                                                                @endforeach
                                                                                                            </span><br>
                                                                                                            @if (isset($item->item_data['color']))
                                                                                                                <span>Цвет:
                                                                                                                    {{ $item->item_data['color']['name'] }}</span><br>
                                                                                                            @endif
                                                                                                            <span
                                                                                                                style="color: #aaaaaa;">Арт.&nbsp;{{ $item->item_data['vendor'] }}</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <span
                                                            style="font-family: sans-serif;font-size: 13px;line-height: 24px;font-weight: normal;color: #222222;">&nbsp;{{ $item->item_data['inCart'] }}</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            style="font-family: sans-serif;font-size: 13px;line-height: 24px;font-weight: normal;color: #222222;">&nbsp;{{ $item->item_data['finalPrice'] }}&nbsp;₸.&nbsp;</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 0;font-size: 0;vertical-align: top;text-align: left;height: 20px;">
                    &nbsp;</td>
            </tr>
            <tr>
                <td>
                    @yield('email-footer')
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
