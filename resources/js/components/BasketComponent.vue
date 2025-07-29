<template>
    <div @mouseleave="isBasketModal = false" @mouseenter="isBasketModal = true" class="basket">
    <!-- <div @mouseenter="isBasketModal = true" class="basket"> -->
        <div class="basket-bag header-titles" @click="isBasketModal = !isBasketModal">
            <svg class="svg-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 208.955 208.955" style="enable-background:new 0 0 208.955 208.955;" xml:space="preserve"><path d="M190.85,200.227L178.135,58.626c-0.347-3.867-3.588-6.829-7.47-6.829h-26.221V39.971c0-22.04-17.93-39.971-39.969-39.971C82.437,0,64.509,17.931,64.509,39.971v11.826H38.27c-3.882,0-7.123,2.962-7.47,6.829L18.035,200.784c-0.188,2.098,0.514,4.177,1.935,5.731s3.43,2.439,5.535,2.439h157.926c0.006,0,0.014,0,0.02,0c4.143,0,7.5-3.358,7.5-7.5C190.95,201.037,190.916,200.626,190.85,200.227z M79.509,39.971c0-13.769,11.2-24.971,24.967-24.971c13.768,0,24.969,11.202,24.969,24.971v11.826H79.509V39.971z M33.709,193.955L45.127,66.797h19.382v13.412c0,4.142,3.357,7.5,7.5,7.5c4.143,0,7.5-3.358,7.5-7.5V66.797h49.936v13.412c0,4.142,3.357,7.5,7.5,7.5c4.143,0,7.5-3.358,7.5-7.5V66.797h19.364l11.418,127.158H33.709z"/></svg>
            <transition name="fade-scale">
                <span v-show="totalQuantity" class="basket-bag__in">{{ totalQuantity }}</span>
            </transition>
            <span class="icon-title">Корзина</span>
        </div>
        <transition name="fade">
            <div v-show="isBasketModal" class="basket-modal">
                <div @click="isBasketModal = false" class="basket-modal__header">
                    <div class="modal-title">Моя корзина</div>
                    <div class="modal-close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 20"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                    </div>
                </div>
                <div ref="basketContent" class="basket-modal__content">
                    <div class="basket-modal__wrapper" v-if="items.length">
                        <items-edit></items-edit>
                        <div class="basket-modal__total">
                            <div class="total-title">Итого:</div>
                            <div class="total-price">{{ totalPrice.toLocaleString('ru-RU') }} ₸</div>
                        </div>
                        <div class="basket-modal__action">
                            <div class="container">
                                <button @click="orderAction" class="btn">Перейти к оформлению</button>
                            </div>
                        </div>
                    </div>
                    <div v-else class="container">
                        <div class="text-empty">Наполните корзину вещами, о которых давно мечтали...</div>
                    </div>
                    <div class="recently-watched">
                        <p v-if="visited.length" class="label">Вы недавно смотрели</p>
                        <swiper-component v-if="visited.length" @wishlistHandler="setToWishlist" :items="visited" :isUpdate="isBasketModal" :slidesPerView="2"></swiper-component>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import { disableBodyScroll, enableBodyScroll, clearAllBodyScrollLocks } from 'body-scroll-lock';
import { mapState, mapActions } from 'vuex';
    export default {
        components: {
            'items-edit': () => import('./containers/_itemsEditComponent'),
            'swiper-component': () => import('./containers/_swiperComponent')
        },
        data() {
            return {
                isBasketModal: false,
            }
        },
        created() {
            this.updateBasket()
        },
        methods: {
            ...mapActions(['setToWishlist', 'updateBasket']),
            orderAction() {
                const cartPath = '/checkout'
                this.$route.path === cartPath ? this.isBasketModal = !this.isBasketModal : window.location = cartPath
            }
        },
        computed: {
            ...mapState(['items', 'visited']),
            totalQuantity() {
                return this.items.reduce((total, item) => {
                    return total + item.inCart;
                }, 0)
            },
            totalPrice() {
                return this.items.reduce((total, item) => {
                    return total + item.inCart * item.finalPrice;
                }, 0)
            }

        },
        watch: {
            isBasketModal() {
                if (screen.width < 1024) {
                    this.isBasketModal ? disableBodyScroll(this.$refs.basketContent) : enableBodyScroll(this.$refs.basketContent);
                }
            }
        }
    }
</script>

<style lang="scss">
.basket {
    @include wishesBasketAlign;
    @include get-media($laptop, $desktop) {
        position: relative;
    }
    &-bag {
        .icon-title {
            padding-top: 3px
        }
        position: relative;
        &__in {
            display: flex;
            position: absolute;
            background: $red;
            top: -2px;
            right: 0;
            width: 15px;
            height: 15px;
            border-radius: 10px;
            color: #fff;
            justify-content: center;
            font-size: 10px;
            line-height: 1.7;
        }
    }
    &-modal {
        position: absolute;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100vw;
        background: white;
        z-index: 1;
        @include get-media($laptop, $desktop) {
            width: 380px;
            height: auto;
            max-height: 80vh;
            right: -10px;
            left: auto;
            top: $header-height-sm;
            box-shadow: 0px 3px 30px 0px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            overflow: hidden;
            overflow-y: auto;
            &::before {
                content: "";
                display: block;
                position: absolute;
                top: -10px;
                right: 0;
                background: 0 0;
                width: 0;
                height: 0;
                border-bottom: 20px solid #fff;
                border-right: 20px solid transparent;
                border-left: 20px solid transparent;
                margin-left: -20px;
            }
            &::after {
                content: "";
                z-index: -1;
                display: block;
                width: 6px;
                height: 6px;
                position: absolute;
                top: -4px;
                right: 17px;
                margin-left: -3px;
                border-radius: 100%;
                box-shadow: 0 -2px 8px 1px rgba(0, 0, 0, 0.25);
            }
        }
        &__header {
            @include modalHeader;
        }
        &__content {
            @include modalContent;
        }
        &__action {
            margin: 40px 0 80px;
            text-align: center;
            @include button(100%);
            @include get-media($laptop, $desktop) {
                @include button(60%);
            }
        }
        &__total {
            margin: 1.5em 0;
            padding: 0 1em;
            display: flex;
            justify-content: space-between;
        }
        .item-image {
            @include get-media($laptop, $desktop) {
                img {
                    width: 111px;
                }
            }
        }
        .swiper {
            &-slide {
                @include get-media($mobile) {
                    width: calc(100vw / 2 - 1rem) ;
                }
            }
        }
        .recently-watched {
            margin-bottom: 10vh;
            .label {
                margin-left: 1rem;
            }
        }
    }
}
</style>
