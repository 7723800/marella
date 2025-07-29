{!! "id,title,description,availability,condition,price,link,image_link,brand,additional_image_link" !!}
@foreach ($items as $item)
    @php
    $description = $item['description'] ?? 'Нет описания';
    $additionalImages = [];
    foreach ($item['images'] as $key => $image) {
        if ($key == 0) {
            continue;
        }
        $additionalImages[] = $image['url'];
    }
    $additionalImagesLink = implode(",", $additionalImages);
    @endphp
    {!! "{$item['vendor']}_{$item['id']},\"{$item['name']}\",\"{$description}\",in stock,new,{$item['finalPrice']} KZT,{$item['url']},{$item['images'][0]['url']},\"{$item['brand']['name']}\",\"{$additionalImagesLink}\"" !!}
@endforeach
