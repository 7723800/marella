<template>
     <transition-group name="fade" tag="div" mode="out-in" class="product-card__grid">
            <div v-show="preloader" key="0" class="preloader__mask-layer"></div>
            <div v-for="(item, index) in items" :key="`${item.id}${index}`" class="product-card">
                <div class="product-card__image">
                    <div v-if="item.discount" class="product-card__sale">-{{ item.discount }}%</div>
                    <div v-if="item.extra_discount" class="product-card__extra-discount">EXTRA -{{ item.extra_discount }}%</div>
                    <div v-if="item.new" class="product-card__new" :class="{'is-discount': item.discount}">NEW</div>
                    <div v-if="item.isKaspi" class="product-card__kaspi"></div>
                    <a :href="item.url" class="product-card__images-wrapper">
                        <div class="main-image" v-lazy:background-image="item.images[0].url"></div>
                        <div v-if="item.images[1]" class="extra-image" v-lazy:background-image="item.images[1].url"></div>
                    </a>
                    <div @click="setWishlist(item)" class="product-card__wishes">
                        <div class="fav-in-active">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/></svg>
                        </div>
                        <div class="fav-back-layer">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </div>
                        <transition name="fade">
                        <div v-if="item.isWishlist" class="fav-is-active">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </div>
                        </transition>
                    </div>
                </div>
                <a :href="item.url" class="product-card__info">
                    <div class="product-card__prices">
                        <div v-if="!item.discount" class="current">{{ item.price.toLocaleString('ru-RU') }} ₸</div>
                        <div v-if="item.discount" class="old">{{ item.price.toLocaleString('ru-RU') }} ₸</div>
                        <div v-if="item.discount" class="new">{{ item.finalPrice.toLocaleString('ru-RU') }} ₸</div>
                    </div>
                    <div v-if="item.brand" class="product-card__brand">
                        <span>{{ item.brand.name }}</span>
                    </div>
                    <div class="product-card__title">
                        <span>{{ item.name }}</span>
                    </div>
                    <div v-if="item.sizes" class="product-card__sizes">
                        <div v-for="(size, index) in item.sizes" :key="`${item.id}${index}`" class="product-card__size">{{ size.value }}</div>
                    </div>
                    <div v-if="item.branch" class="product-card__branch">
                        <span>{{ item.branch.address }}</span>
                    </div>
                    <div v-if="item.volume" class="product-card__sizes">{{ item.volume.name }}</div>
                </a>
            </div>
        </transition-group>
</template>

<script>
import { mapState, mapActions } from 'vuex';
    export default {
        props: ['items', 'preloader'],
        beforeMount() {
            this.isItemsWishlist()
        },
        mounted() {
        // watch wishlist changes outside component
            this.$store.watch(() => {
                this.items.map(item => {
                    const isWishes = this.wishlist.find(goods => goods.id === item.id);
                    if (!isWishes) item.isWishlist = false;
                })
            })
        },
        methods: {
            ...mapActions(['setToWishlist']),
            setWishlist(item) {
                item.isWishlist = !item.isWishlist
                this.setToWishlist(item)
            },
            isItemsWishlist() {
                this.items.map(item => {
                    const isWishes = this.wishlist.find(goods => goods.id === item.id);
                    if (isWishes) item.isWishlist = true;
                })
            },
        },
        computed: {
            ...mapState(['wishlist']),
        },
        watch: {
            items() {
                this.isItemsWishlist()
            }
        }
    }
</script>
