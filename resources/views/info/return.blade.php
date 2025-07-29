@extends('layouts.app')

@section('content')

<div class="info">
    <div class="container">
        <div class="info-inner">
            <h3>Возврат и обмен</h3>
            <p>Вы можете вернуть или обменять товар, не подошедший Вам по каким-либо причинам (фасон, размер, цвет) в течение <b>7 календарных дней с момента получения заказа</b> (не более 14 дней с момента оформления покупки).</p>
            <p>Возврат товара возможен только в случае, если указанный товар не был в употреблении, сохранен его первоначальный товарный вид, потребительские свойства, оригинальные этикетки, пломбы и документы, подтверждающие покупку.</p>
            <p>Если у вас нет возможности приехать для возврата в наши точки продаж, доставка  курьером осуществляется за ваш счет (мы вычитаем сумму, потраченную нами за пересылку)</p>
            <p>После получения Вашей возвратной посылки мы проверим, в каком состоянии находятся товар с целью определения его качества и сохранности потребительских свойств. При обнаружении нарушений условий сохранения товарного вида, наша компания имеет право отказать в возврате или обмене.</p>
            <p>Для того, чтобы оформить возврат или обмен, пожалуйста, заполните форму заявки на возврат.</p>
            <p>При необходимости замены товара, укажите цвет и размер, на который Вы бы хотели произвести обмен.</p>
            <p>Мы вернем полную стоимость товара (или разницу стоимости — в случае обмена) путем перевода денежных средств на ваш банковский счет в течение 10 рабочих дней с момента получения возврата.</p>
            <p>Напоминаем, что возврату и обмену не подлежат некоторые группы товаров:
                <ul>
                    <li>- нижнее белье, чулочно-носочные изделия</li>
                    <li>- бижутерия</li>
                    <li>- парфюмерно-косметические продукты</li>
                </ul>
            </p>
            <p>Возврат вышеперечисленных товаров осуществляется только в случае производственного брака.</p>
            <p>Нашей компанией предусмотрен возврат товара ненадлежащего качества в том случае, если вам доставили товар с заводским браком или в ходе эксплуатации был обнаружен скрытый дефект. Под товаром ненадлежащего качества подразумевается товар, который неисправен, не соответствует использованию по целевому назначению или имеет неустранимые недостатки. При отсутствии брака - возвратная посылка на наш склад осуществляется за счет клиента.</p>
            <p>Если у Вас возникли дополнительные вопросы свяжитесь с нами: по телефону <a href="tel:+77770015373">+7 (777) 001 53 73</a>, по электронной почте donato.kz@mail.ru </p>
            <p>Мы дорожим своей репутацией и трепетно относимся к каждому заказу!</p>
            <div class="info_return-form form-group">
                <h3>Форма заявки на возврат</h3>
                <form id="form-return">
                    <div class="ui_from-group">
                        <label for="r_name">Имя<span class="form-control-required">*</span></label>
                        <input id="r_name" name="name" type="text" class="form-control">
                    </div>
                    <div class="ui_from-group">
                        <label for="r_lastname">Фамилия<span class="form-control-required">*</span></label>
                        <input id="r_lastname" name="lastname" type="text" class="form-control">
                    </div>
                    <div class="ui_from-group">
                        <label for="r_email">Эл. адрес<span class="form-control-required">*</span></label>
                        <input id="r_email" name="email" type="email" class="form-control">
                    </div>
                    <div class="ui_from-group">
                        <label for="r_phone">Мобильный номер<span class="form-control-required">*</span></label>
                        <input id="r_phone" name="phone" type="tel" class="form-control">
                    </div>
                    <div class="ui_from-group">
                        <label for="r_order">Номер заказа<span class="form-control-required">*</span></label>
                        <input id="r_order" name="order" type="text" class="form-control">
                    </div>
                    <div class="ui_from-group">
                        <label for="r_vendor_id">Артикул товара<span class="form-control-required">*</span></label>
                        <input id="r_vendor_id" name="vendor_id" type="text" class="form-control">
                    </div>
                    <div class="ui_from-group">
                        <label for="r_vendor_id">Причина возврата<span class="form-control-required">*</span></label>
                        <textarea name="comment" name="info" rows="5" class="form-control"></textarea>
                    </div>
                    <button id="return-btn" class="btn">Отправить запрос</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
