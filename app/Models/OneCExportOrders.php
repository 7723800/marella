<?php

namespace App\Models;

use App\Models\Products\Item;
use App\Models\Products\ItemSize;
use Illuminate\Support\Facades\DB;
use CommerceML\Constructors\Address;
use CommerceML\Constructors\Contact;
use CommerceML\Constructors\Feature;
use CommerceML\Constructors\Product;
use CommerceML\Constructors\BaseUnit;
use CommerceML\Constructors\Contacts;
use CommerceML\Constructors\Document;
use CommerceML\Constructors\Features;
use CommerceML\Constructors\Products;
use Illuminate\Database\Eloquent\Model;
use CommerceML\Constructors\AddressField;
use CommerceML\Constructors\Counterparty;
use CommerceML\Constructors\Counterparties;
use CommerceML\Constructors\RequisiteValue;
use CommerceML\Constructors\Representatives;
use CommerceML\Constructors\RequisiteValues;
use Mavsan\LaProtocol\Interfaces\ExportOrders;
use CommerceML\Implementation\CommercialInformation;
use CommerceML\Constructors\CommercialInformation as CommercialInfo;

class OneCExportOrders extends Model implements ExportOrders
{
    /**
     * Метод, вызываемый контроллером после того, как данные были выгружены на
     * сервер
     * @return string|null
     */
    public function stepSuccess(): ?string
    {
        return null;
    }

    /**
     * @return \CommerceML\Implementation\CommercialInformation Данные о
     * заказах, соответствувющие тегу "Коммерческая информация"
     */
    public function exportAllOrders(): CommercialInformation
    {
        $orders = Order::with('items')->orderBy('id')->get();
        $documents = array();

        foreach ($orders as $order) {
            $products = array();

            if ($order->delivery_price > 0) {
                $products[] = new Product(
                    'ORDER_DELIVERY',
                    'Доставка заказа',
                    '7dd8f7a3-3745-42c8-acdb-47ac6a74174f',
                    new BaseUnit('796', 'Штука', 'PCE', 'шт'),
                    $order->delivery_price,
                    '1',
                    $order->delivery_price,
                    new RequisiteValues([
                        new RequisiteValue('ВидНоменклатуры', 'Услуга'),
                        new RequisiteValue('ТипНоменклатуры', 'Услуга')
                    ])
                );
            }

            foreach ($order->items as $item) {
                $onecId = "";
                $sizeKey = array_search(true, array_column($item->item_data['sizes'], 'isSelected'));
                $size = $item->item_data['sizes'][$sizeKey]['value'];
                $sizeData = ItemSize::where('value', $size)->first();
                $sizePivotTable = DB::table('item_size_pivot')->where([['item_id', $item->item_data['id']], ['size_id', $sizeData->id]])->first();
                if ($sizePivotTable && !is_null($sizePivotTable->onec_id)) {
                    $onecId = $sizePivotTable->onec_id;
                } else {
                    $product = Item::withoutGlobalScopes()->where('id', $item->item_data['id'])->first();
                    $onecId = $product->onec_id ?? "";
                }

                $products[] = new Product(
                    $onecId,
                    $item->item_data['name'] . ' (' . $item->item_data['vendor'] . ', ' . $size . ', ' . $item->item_data['color']['name'] . ')',
                    '',
                    new BaseUnit('796', 'Штука', 'PCE', 'шт'),
                    $item->item_data['finalPrice'],
                    $item->item_data['quantity'],
                    $item->item_data['finalPrice'] * $item->item_data['quantity'],
                    new RequisiteValues([
                        new RequisiteValue('ВидНоменклатуры', 'Товар'),
                        new RequisiteValue('ТипНоменклатуры', 'Товар')
                    ]),
                );
            }

            $documents[] = new Document(
                $order->id,
                $order->order_number,
                $order->created_at->format('Y-m-d'),
                'Заказ товара',
                'Продавец',
                'тенге',
                $order->items->count(),
                $order->total,
                new Counterparties([
                    new Counterparty(
                        '10d5b325-4240-11e3-b8e5-1cbdb9e585e4',
                        'ИП Котлобаев МС',
                        'Контактное лицо',
                        'Покупатель',
                        $order->customer_name . ' ' . $order->customer_lastname,
                        $order->customer_lastname,
                        $order->customer_name,
                        new Address([
                            new AddressField('Область', $order->customer_area),
                            new AddressField('Город', $order->customer_city),
                            new AddressField('Адрес', $order->customer_address),
                        ], $order->created_at->format('Y')),
                        new Contacts([
                            new Contact('Номер телефона', "+{$order->customer_phone}")
                        ]),
                        new Representatives([])
                    )
                ]),
                $order->created_at->format('H:i:s'),
                $order->customer_comment ?? "",
                new Products($products),
                new RequisiteValues([
                    new RequisiteValue('Метод оплаты', $order->payment_method),
                    new RequisiteValue('Заказ оплачен', $order->is_paid != 0 ? 'true' : 'false'),
                    new RequisiteValue('Способ доставки', $order->delivery_method),
                    // new RequisiteValue('Доставка разрешена', 'false'),
                    // new RequisiteValue('Отменен', 'false'),
                    // new RequisiteValue('Финальный статус', 'false'),
                    // new RequisiteValue('Статус заказа', '[N] Принят'),
                    new RequisiteValue('Дата изменения статуса', $order->updated_at),
                ])
            );
        }
        $commercialInformation = new CommercialInfo($documents);
        return $commercialInformation;
    }
}
