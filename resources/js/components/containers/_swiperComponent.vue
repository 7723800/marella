<template>
    <div class="swiper">
        <div v-if="reactItems.length > 2" class="swiper-button">
            <div class="prev" :class="`prev-${this.randomClass}`"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/><path fill="none" d="M0 0h24v24H0V0z"/></svg></div>
            <div class="next" :class="`next-${this.randomClass}`"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/><path fill="none" d="M0 0h24v24H0V0z"/></svg></div>
        </div>
        <div class="swiper-container" :class="`swiper-${this.randomClass}`">
            <div class="swiper-wrapper">
                <div v-for="item in reactItems" :key="item.id" class="swiper-slide">
                    <a :href="item.url" class="product-card">
                        <div class="product-card__swiperImageHolder" v-lazy:background-image="item.images[0].url">
                            <div v-if="item.discount" class="product-card__sale">-{{ item.discount }}%</div>
                            <div v-if="item.new" class="product-card__new" :class="{'is-discount': item.discount}">NEW</div>
                            <div v-if="isWishes" @click="setToWishlist(item)" class="product-card__wishes">
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
                        <div class="product-card__info">
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
                            <div class="product-card__sizes">
                                <div v-for="(size, index) in item.sizes" :key="`${item.id}${index}`" class="product-card__size">{{ size.value }}</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swiper from 'swiper';
import { mapState } from 'vuex';
import randomstring from 'randomstring'
    export default {
        data() {
            return {
                isWishes: true,
                reactItems: Array,
                randomClass:''
            }
        },
        props: ['items', 'wishes', 'isUpdate', 'slidesPerView'],
        created() {
            if (this.wishes === false) this.isWishes = false
            this.reactItems = this.items
            this.randomClass = randomstring.generate(7);
        },
        beforeMount() {
            this.isItemWishlist()
        },
        mounted() {
            //initialize swiper when document ready
            this.swiper
        },
        methods: {
            setToWishlist(item) {
                item.isWishlist = !item.isWishlist
                this.$emit('wishlistHandler', item)
            },
            isItemWishlist() {
                this.items.map(item => {
                    const isWishlist = this.wishlist.find(wishes => wishes.id == item.id);
                    if (isWishlist) item.isWishlist = true
                })
            },
        },
        computed: {
            ...mapState(['wishlist']),
            swiper() {
                return new Swiper (`.swiper-${this.randomClass}`, {
                slidesPerView: 'auto',
                spaceBetween: 4,
                // loopedSlides: 3,
                navigation: {
                    nextEl: `.next-${this.randomClass}`,
                    prevEl: `.prev-${this.randomClass}`,
                },
                breakpoints: {
                    // 1281: {
                    //     slidesPerView: slidesPerView || 5,
                    //     spaceBetween: 0,
                    // },
                    1025: {
                        slidesPerView: this.slidesPerView || 5,
                    }
                }
            })
            }
        },
        watch: {
            isUpdate(newValue) {
                if (newValue)  this.swiper.update();
            }
        }
    }
</script>

<style lang="scss">
.swiper {
    position: relative;
    &-container {
        overflow: hidden;
    }
    &-wrapper {
        display: inline-flex;
    }
    &-button {
        display: flex;
        position: absolute;
        top: -38px;
        right: 10px;
        svg {
            fill: $grey;
            width: 28px;
            height: 28px;
        }
        .prev {
            margin-right: 10px;
            svg {
                transform: rotate(180deg);
            }
        }
        .prev, .next {
            cursor: pointer;
        }
    }
    .product-card {
        display: block;
        padding: 0;
        &__title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    }
}
</style>
