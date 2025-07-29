<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="{{ Carbon\Carbon::now()->format('Y-m-d H:i') }}">
    <shop>
        <name>Donato</name>
        <company>БРЕНДЫ ПРЕМИУМ</company>
        <categories>
            <category id="1">Одежда/Обувь/Marella</category>
        </categories>
        <offers>
        @foreach ($items as $item)
        <offer id="{{ $item->id }}" available="true">
            <categoryId>1</categoryId>
            <name>{{ $item->name }}</name>
            <vendor>{{ $item->brand->name }}</vendor>
            <price>{{ $item->final_price }}</price>
            <picture>{{ $item->images[0]['url'] }}</picture>
            </offer>
        @endforeach
        </offers>
    </shop>
</yml_catalog>
