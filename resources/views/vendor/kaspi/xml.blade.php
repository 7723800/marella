<kaspi_catalog date="string" xmlns="kaspiShopping" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="kaspiShopping http://kaspi.kz/kaspishopping.xsd">
    <company>DONATO</company>
    <merchantid>Donato</merchantid>
    <offers>
    @foreach ($items as $item)
    <offer sku="{{ $item->vendor_id }}">
            <model>{{ $item->name }}</model>
            <brand>{{ $item->brand->name }}</brand>
            <availabilities>
                <availability available="yes" storeId="DNT2"/>
            </availabilities>
            <price>{{ $item->final_price }}</price>
        </offer>
    @endforeach
    </offers>
</kaspi_catalog>
