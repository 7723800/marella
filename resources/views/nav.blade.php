<ul class="menu-list">
    <li class="menu-link menu-link__info">ДОСТАВКА ПО КАЗАХСТАНУ 1-3 ДНЯ</li>
    <div class="menu-column">
        <li class="menu-link">
            <div class="link-title link-title__head">
                <span>Каталог</span>
                <i class="link-icon"></i>
            </div>
            <ul class="link-items">
                @if ($catalog->is_women_new)
                    <li class="link-sub-item link-sub-item__head">
                        <a
                            href="{{ route('category', ['c' => $catalog->women_category_id, 'items' => 'all', 'is_new' => 1]) }}">New</a>
                    </li>
                @endif
                @if ($catalog->is_women_discount)
                    <li class="link-sub-item link-sub-item__head">
                        <a href="#" class="link-sub-item second-level red">Sale<i class="link-icon"></i></a>
                        <ul class="link-second-level">
                            {{-- @foreach ($subcategory['second_subcategories'] as $key => $secondSubcategory) --}}
                            <li class="link-sub-item">
                                <a class="second-level-a"
                                    href="{{ route('category', ['c' => $catalog->women_category_id, 'items' => 'all', 'sale' => 30]) }}">Sale
                                    - 30%</a>
                            </li>
                            <li class="link-sub-item">
                                <a class="second-level-a"
                                    href="{{ route('category', ['c' => $catalog->women_category_id, 'items' => 'all', 'sale' => 40]) }}">Sale
                                    - 40%</a>
                            </li>
                            <li class="link-sub-item">
                                <a class="second-level-a"
                                    href="{{ route('category', ['c' => $catalog->women_category_id, 'items' => 'all', 'sale' => 50]) }}">Sale
                                    - 50%</a>
                            </li>
                            <li class="link-sub-item">
                                <a class="second-level-a"
                                    href="{{ route('category', ['c' => $catalog->women_category_id, 'items' => 'all', 'sale' => 70]) }}">Sale
                                    - 70%</a>
                            </li>
                            {{-- @endforeach --}}
                        </ul>
                    </li>
                @endif
                {{-- @if ($catalog->is_women_outlet)
                    <li class="link-sub-item link-sub-item__head">
                        <a href="{{ route('category', ['c' => $catalog->women_category_id, 'items' => 'all', 'is_outlet' => 1]) }}"
                            class="red">Outlet</a>
                    </li>
                @endif --}}
                @foreach ($catalog->women as $key => $subcategory)
                    <li class="link-sub-item">
                        @if (count($subcategory['second_subcategories']))
                            <a href="#" class="link-sub-item second-level">{{ $subcategory['name'] }}<i
                                    class="link-icon"></i></a>
                            <ul class="link-second-level">
                                @if ($subcategory['id'] == 16)
                                    <li class="link-sub-item">
                                        <a class="second-level-a"
                                            href="{{ route('category', ['c' => $subcategory['category_id'], 'items' => $subcategory['slug']]) }}">Вся
                                            обувь</a>
                                    </li>
                                @endif
                                @foreach ($subcategory['second_subcategories'] as $key => $secondSubcategory)
                                    <li class="link-sub-item">
                                        <a class="second-level-a"
                                            href="{{ route('category', ['c' => $secondSubcategory['category_id'], 'items' => $secondSubcategory['slug']]) }}">{{ $secondSubcategory['name'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <a
                                href="{{ route('category', ['c' => $subcategory['category_id'], 'items' => $subcategory['slug']]) }}">{{ $subcategory['name'] }}</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </li>
    </div>

    <div class="menu-column">
        <li class="menu-link">
            <div class="link-title link-title__head">
                <span>{{ $catalog->sets_title }}</span>
                <i class="link-icon"></i>
            </div>
            <ul class="link-items">
                @foreach ($catalog->sets as $set)
                    <li class="link-sub-item">
                        <a href="{{ route('sets', ['slug' => $set->slug]) }}">{{ $set->name }}</a>
                    </li>
                @endforeach
            </ul>
        </li>
    </div>
    <div class="menu-column">
        <li class="menu-link"><a href="{{ route('office') }}">ОФИС</a></li>
        {{-- <li class="menu-link"><a href="{{ route('perfume') }}"
                style="text-transform: uppercase">{{ $catalog->perfumes }}</a></li> --}}
        <li class="menu-link"><a href="{{ route('giftcard') }}"
                style="text-transform: uppercase">{{ $catalog->giftcards }}</a></li>
        <li class="menu-link"><a href="{{ route('blog') }}">БЛОГ</a></li>
        @if ($catalog->is_kaspi)
            <li class="menu-link">
                <a href="{{ route('category', ['c' => $catalog->women_category_id, 'items' => 'all', 'is_kaspi' => 1]) }}"
                    style="text-transform: uppercase">Товары в рассрочку
                    <img class="kaspiLogo" src="/images/kaspi-logo.svg" alt="">
                </a>
            </li>
        @endif
        <li class="menu-link">
            <div class="link-title link-title__hero">
                <span>Клиентам</span>
                <i class="link-icon"></i>
            </div>
            <ul class="link-items">
                <li class="link-sub-item">
                    <a href="{{ route('payment') }}">Оплата</a>
                </li>
                <li class="link-sub-item">
                    <a href="{{ route('info-delivery') }}">Доставка</a>
                </li>
                <li class="link-sub-item">
                    <a href="{{ route('info-return') }}">Возврат и обмен</a>
                </li>
                <li class="link-sub-item">
                    <a href="{{ route('payment-guide') }}">Руководство по покупке</a>
                </li>
            </ul>
        </li>
        <li class="menu-link user-link"><a href="{{ route('info-oferta') }}">Публичная оферта</a></li>
        <li class="menu-link user-link"><a href="{{ route('address') }}">Контакты</a></li>
        <li class="menu-link user-link"><a href="{{ route('about') }}">О компании</a></li>
    </div>
</ul>
