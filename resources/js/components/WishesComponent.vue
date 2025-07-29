<template>
    <div @mouseleave="isWishesModal = false" @mouseenter="isWishesModal = true" class="wishes">
        <div class="wishes-heart header-titles" @click="isWishesModal = !isWishesModal">
            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/></svg>
            <transition name="fade-scale">
                <span v-if="wishlist.length" class="in-wishes"></span>
            </transition>
            <span class="icon-title">Избранное</span>
        </div>
        <transition name="fade">
            <div v-show="isWishesModal" class="wishes-modal">
                <div @click="isWishesModal = false" class="wishes-modal__header">
                    <div class="modal-title">Лист желаний</div>
                    <div class="modal-close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 20"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                    </div>
                </div>
                <div ref="wishesContent" class="wishes-modal__content">
                    <div v-if="wishlist.length" class="wishes-modal__wrapper">
                        <div class="container">
                            <transition-group name="fade" tag="div" mode="out-in"  class="product-card__grid">
                                <div v-for="item in wishlist" :key="item.id" class="product-card">
                                    <div class="product-card__image">
                                        <a :href="item.url" style="width: 100%">
                                            <div v-lazy:background-image="item.images[0].url" class="wishes-modalImage"></div>
                                        </a>
                                        <div @click="deleteFromWishlist(item.id)" class="product-card__wishes">
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
                                        <a :href="item.url">
                                            <div class="product-card__brand">
                                                <span>{{ item.brand ? item.brand.name : item.name}}</span>
                                            </div>
                                            <!-- <div v-if="item.giftcard" class="product-card__title">
                                                <span>{{ item.price }}</span>
                                            </div> -->
                                            <div class="product-card__title">
                                                <span>{{ item.giftcard ? item.finalPrice.toLocaleString('ru-RU') + '₸' : item.name }}</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </transition-group>
                        </div>
                    </div>
                    <div v-else class="container">
                        <div class="text-empty">Ваш wishlist пуст</div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import { disableBodyScroll, enableBodyScroll, clearAllBodyScrollLocks } from 'body-scroll-lock';
import { mapState, mapMutations, mapActions } from 'vuex';
    export default {
        data() {
            return {
                isWishesModal: false,
            }
        },
        created() {
            this.updateWishlist()
        },
        mounted() {
            // console.log(this.wishlist);
        },
        methods: {
            ...mapMutations(['removeFromWishlist']),
            ...mapActions(['updateWishlist']),
            deleteFromWishlist(id) {
                const inWishlist = this.wishlist.find(wishes => wishes.id === id)
                const itemIndex = this.wishlist.indexOf(inWishlist)
                this.removeFromWishlist(itemIndex)
            }
        },
        computed: {
            ...mapState(['wishlist']),
        },
        watch: {
            isWishesModal() {
                if (screen.width < 1024) {
                    this.isWishesModal ? disableBodyScroll(this.$refs.wishesContent) : enableBodyScroll(this.$refs.wishesContent);
                }
            }
        }
    }
</script>

<style lang="scss">
.wishes {
    @include wishesBasketAlign;
    @include get-media($laptop, $desktop) {
        position: relative;
    }
    &-modalImage {
        width: 100%;
        padding-top: calc(100% * 1.3333);
        background-size: cover;
        background-position: top center;
        background-repeat: no-repeat;
        margin-bottom: 0.5rem;
    }
    &-heart {
        position: relative;
        .in-wishes {
            position: absolute;
            background: $red;
            top: 0;
            right: 10px;
            padding: 5px;
            border-radius: 5px;
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
            right: -10px;
            left: auto;
            top: $header-height-sm;
            box-shadow: 0px 3px 30px 0px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
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
            .product-card {
                flex-basis: 50%;
                    &__wishes {
                    @include get-media($laptop, $desktop) {
                        width: 26%;
                        height: 18%;
                        &:hover {
                            animation: pulse 0.6s infinite;
                        }
                    }
                }
                &__image {
                    a {
                        @include get-media($laptop, $desktop) {
                            display: grid;
                        }
                    }
                }
                &__info {
                    margin: 5px 0;
                }
                &__grid {
                    margin: 0 0.25em;
                    min-height: auto;
                    margin-bottom: 0 !important;
                }
            }
        }
        &__header {
            @include modalHeader;
        }
        &__content {
            @include modalContent;
            padding-top: 1px;
            .product-card__grid {
                margin-bottom: 80px;
            };
            .text-empty {
                text-align: center;
                margin: 20px 0;
                font-size: 80%;
            }
        }
        &__wrapper {
            @include get-media($laptop, $desktop) {
                overflow-x: hidden;
                overflow-y: auto;
                max-height: 76vh;
            }
        }
    }
}
// heart pulse
@keyframes pulse {
    0% {
        transform: scale(1.0);
    }
    25% {
        transform: scale(0.9);
    }
    50% {
        transform: scale(1.0);
    }
}
</style>
