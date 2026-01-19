<template>
    <div class="catalog">
        <div class="catalog-label">Каталог</div>
        <div class="catalog-title">{{ catalog.women_title }}</div>
        <ul class="catalog-list">
            <li v-if="catalog.is_women_new" class="catalog-item catalog-item__head">
                <a href="/catalog?c=1&items=all&is_new=1" :class="{'is-active': $route.query.c === '1' && $route.query.items === 'all' && $route.query.is_new === '1'}">New</a>
            </li>
            <!-- <li v-if="catalog.is_women_discount" class="catalog-item catalog-item__head red">
                <a href="/catalog?c=1&items=all&is_discount=1" :class="{'is-active': $route.query.c === '1' && $route.query.items === 'all' && $route.query.is_discount === '1'}">Sale</a>
            </li> -->
            <li class="catalog-item">
                <a href="/catalog?c=1&items=all&is_discount=1" :class="{'is-active': $route.query.c === '1' && $route.query.items === 'all' && $route.query.is_discount === '1'}" class="catalog-item__head red">Sale</a>
                <ul class="catalog-second-list">
                    <li class="catalog-item">
                        <a href="/catalog?c=1&items=all&sale=20" :class="{'is-active': $route.query.c === '1' && $route.query.items === 'all' && $route.query.sale === '20'}">SALE - 20%</a>
                    </li>
                    <li class="catalog-item">
                        <a href="/catalog?c=1&items=all&sale=30" :class="{'is-active': $route.query.c === '1' && $route.query.items === 'all' && $route.query.sale === '30'}">SALE - 30%</a>
                    </li>
                    <li class="catalog-item">
                        <a href="/catalog?c=1&items=all&sale=40" :class="{'is-active': $route.query.c === '1' && $route.query.items === 'all' && $route.query.sale === '40'}">SALE - 40%</a>
                    </li>
                    <li class="catalog-item">
                        <a href="/catalog?c=1&items=all&sale=50" :class="{'is-active': $route.query.c === '1' && $route.query.items === 'all' && $route.query.sale === '50'}">SALE - 50%</a>
                    </li>
                    <li class="catalog-item">
                        <a href="/catalog?c=1&items=all&sale=60" :class="{'is-active': $route.query.c === '1' && $route.query.items === 'all' && $route.query.sale === '60'}">SALE - 60%</a>
                    </li>
                    <li class="catalog-item">
                        <a href="/catalog?c=1&items=all&sale=70" :class="{'is-active': $route.query.c === '1' && $route.query.items === 'all' && $route.query.sale === '70'}">SALE - 70%</a>
                    </li>
                    <li class="catalog-item">
                        <a href="/catalog?c=1&items=all&sale=80" :class="{'is-active': $route.query.c === '1' && $route.query.items === 'all' && $route.query.sale === '80'}">SALE - 80%</a>
                    </li>
                </ul>
            </li>
            <!-- <li v-if="catalog.is_women_outlet" class="catalog-item catalog-item__head red">
                <a href="/catalog?c=1&items=all&is_outlet=1" :class="{'is-active': $route.query.c === '1' && $route.query.items === 'all' && $route.query.is_outlet === '1'}">Outlet</a>
            </li> -->
            <li v-for="item in catalog.women" :key="item.id" class="catalog-item">
                <a :href="`/catalog?c=1&items=${item.slug}`" :class="{'is-active': $route.query.c === '1' && $route.query.items === item.slug && !$route.query.is_new && !$route.query.is_discount && !$route.query.is_outlet && !$route.query.sale}">{{ item.name }}</a>
                <ul v-if="item.second_subcategories.length" class="catalog-second-list">
                    <li v-for="secondSubcategory in item.second_subcategories" :key="secondSubcategory.id" class="catalog-item">
                        <a :href="`/catalog?c=1&items=${secondSubcategory.slug}`" :class="{'is-active': $route.query.c === '1' && $route.query.items === secondSubcategory.slug && !$route.query.is_new && !$route.query.is_discount && !$route.query.is_outlet}">{{ secondSubcategory.name }}</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- <div class="catalog-title">{{ catalog.men_title }}</div> -->
        <!-- <ul class="catalog-list">
            <li v-if="catalog.is_men_new" class="catalog-item catalog-item__head">
                <a href="/catalog?c=2&items=all&is_new=1" :class="{'is-active': $route.query.c === '2' && $route.query.items === 'all' && $route.query.is_new === '1'}">New</a>
            </li> -->
            <!-- <li v-if="catalog.is_men_discount" class="catalog-item catalog-item__head red">
                <a href="/catalog?c=2&items=all&is_discount=1" :class="{'is-active': $route.query.c === '2' && $route.query.items === 'all' && $route.query.is_discount === '1'}">Sale</a>
            </li> -->
            <!-- <li class="catalog-item">
                <a href="/catalog?c=2&items=all&is_discount=1" :class="{'is-active': $route.query.c === '2' && $route.query.items === 'all' && $route.query.is_discount === '1'}" class="catalog-item__head red">Sale</a>
                <ul class="catalog-second-list">
                    <li class="catalog-item">
                        <a href="/catalog?c=2&items=all&sale=30" :class="{'is-active': $route.query.c === '2' && $route.query.items === 'all' && $route.query.sale === '30'}">SALE - 30%</a>
                    </li>
                    <li class="catalog-item">
                        <a href="/catalog?c=2&items=all&sale=40" :class="{'is-active': $route.query.c === '2' && $route.query.items === 'all' && $route.query.sale === '40'}">SALE - 40%</a>
                    </li>
                    <li class="catalog-item">
                        <a href="/catalog?c=2&items=all&sale=50" :class="{'is-active': $route.query.c === '2' && $route.query.items === 'all' && $route.query.sale === '50'}">SALE - 50%</a>
                    </li>
                    <li class="catalog-item">
                        <a href="/catalog?c=2&items=all&sale=70" :class="{'is-active': $route.query.c === '2' && $route.query.items === 'all' && $route.query.sale === '70'}">SALE - 70%</a>
                    </li>
                </ul>
            </li> -->
            <!-- <li v-if="catalog.is_men_outlet" class="catalog-item catalog-item__head red">
                <a href="/catalog?c=2&items=all&is_outlet=1" :class="{'is-active': $route.query.c === '2' && $route.query.items === 'all' && $route.query.is_outlet === '1'}">Outlet</a>
            </li> -->
            <!-- <li v-for="item in catalog.men" :key="item.id" class="catalog-item">
                <a :href="`/catalog?c=2&items=${item.slug}`" :class="{'is-active': $route.query.c === '2' && $route.query.items === item.slug && !$route.query.is_new && !$route.query.is_discount && !$route.query.is_outlet && !$route.query.sale}">{{ item.name }}</a>
            </li>
        </ul> -->
        <div class="catalog-title">{{ catalog.sets_title }}</div>
        <ul class="catalog-list">
            <li v-for="set in catalog.sets" :key="set.id" class="catalog-item">
                <a :href="`/catalog/sets/${set.slug}`" :class="{'is-active': $route.path === `/catalog/sets/${set.slug}`}">{{ set.name }}</a>
            </li>
        </ul>
        <!-- <ul class="catalog-list">
            <li class="catalog-item__head">
                <a href="/catalog/perfume" :class="{'is-active': $route.path === '/catalog/perfume'}">{{ catalog.perfumes }}</a>
            </li>
        </ul> -->
        <ul class="catalog-list">
            <li class="catalog-item__head">
                <a href="/catalog/giftcard" :class="{'is-active': $route.path === '/catalog/giftcard'}">{{ catalog.giftcards }}</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['catalog'],
        mounted() {
            console.log(this.catalog);
        }
    }
</script>

<style lang="scss">
.catalog {
    @include get-media($mobile) {
            display: none;
        }
    @include get-media($laptop, $desktop) {
        width: 25%;
        float: left;
        margin-top: -46px;
    }
    &-label {
        @include get-media($mobile) {
            display: none;
        }
        position: relative;
        text-transform: uppercase;
        letter-spacing: .3em;
        font-size: 1.2em;
        margin-bottom: 1em;
        height: 30px;
        cursor: default;
        &::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 90%;
            height: 1px;
            background: $line-color;
        }
    }
    &-title {
        text-transform: uppercase;
        cursor: default;
    }
    &-list {
        margin-bottom: 1.5em;
    }
    &-item {
        padding: .4em 1em;
        font-family: SegoeUI;
        &__head {
            text-transform: uppercase;
            display: flex;
            // padding: 0;
            font-family: inherit
        }
        @at-root .catalog .is-active {
            position: relative;
            &::before {
                content: '';
                position: absolute;
                left: -15px;
                top: 40%;
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background-color: $main-color;
            }
        }
    }
    &-second-list {
        padding-top: 0.5rem;
    }
}
</style>
