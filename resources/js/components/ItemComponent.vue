<template>
    <div class="container">
        <div id="item" class="item">
            <div class="item-breadcrumbs">
                <div class="backward">
                    <div @click="goBack" class="arrow back">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 7.4 12" style="enable-background:new 0 0 7.4 12;" xml:space="preserve"><path d="M0,10.6L4.6,6L0,1.4L1.4,0l6,6l-6,6L0,10.6z"/></svg>
                    </div>
                    <div v-if="item.brand && item.brand.imageUrl" class="logo">
                        <img :src="item.brand.imageUrl" />
                    </div>
                </div>
            </div>
            <div class="card-wrapper">
                <div class="item-gallery">
                    <div class="swiper-wrapper">
                        <div v-for="img in item.images" :key="img.id" class="swiper-slide">
                            <div class="item-card">
                                <div :data-background="img.url" class="item-card__image swiper-lazy">
                                     <div class="lazy-preloader-image" style="background-image: url('/images/image-loader.svg')"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="data.isActive" @click="itemToWishlist(item)" class="item-gallery__wishes">
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
                    <div class="swiper-pagination"></div>

                    <scrollactive
                        :scrollContainerSelector="'.v-scroll-media'"
                        :highlightFirstItem="true"
                        :modifyUrl="false"
                        :offset="scrollingOffset"
                        class="v-scroll-thumbs">
                        <a v-for="img in item.images" :key="img.id" :href="`#media${img.id}`" class="item-card__image scrollactive-item" v-lazy:background-image="img.url"></a>
                    </scrollactive>

                    <div class="v-scroll-media">
                        <div v-for="img in item.images" :key="img.id" :data-image-section="img.id" class="item-card">
                            <div class="item-card__image" :data-image-section="img.id" :id="`media${img.id}`" v-lazy:background-image="img.url">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item-properties">
                    <div class="item-title">
                        <p>{{ item.name }}</p>
                    </div>
                    <div class="item-prices">
                        <div v-if="!item.discount" class="current">{{ item.price.toLocaleString('ru-RU') }} ₸</div>
                        <div v-if="item.discount" class="old">{{ item.price.toLocaleString('ru-RU') }} ₸</div>
                        <div v-if="item.discount" class="new">{{ item.finalPrice.toLocaleString('ru-RU') }} ₸<span>-{{ item.discount }}%</span> </div>
                    </div>
                    <a v-if="item.discount == 0 || item.discount <= 40" href="/info/kaspi-red" class="item-kaspiRed">
                        <div class="kaspiRed-schedule">4 x {{ (Math.round(item.finalPrice / 4)).toLocaleString('ru-RU') }} ₸</div>
                        <div class="kaspiRed-about">Что такое Kaspi Red?</div>
                    </a>
                    <a v-if="item.extra_discount > 0" href="/info/extra-sale" class="item-extra-price">Данный товар участвует в акции «<span style="color:red">1+1=EXTRA -{{ item.extra_discount }}%</span>»</a>
                    <div v-if="data.isActive" class="item-sizes">
                        <div class="item-sizes__label">{{ item.perfume ? 'Объем' : 'Выберите размер' }}</div>
                        <div class="item-sizes__values">
                            <div v-for="size in item.sizes" :key="size.id" @click="setSize(size.id)" class="size-value" :class="{ 'is-size': size.isSelected }">{{ size.value }}</div>
                            <div>&nbsp;</div>
                        </div>
                    </div>
                    <div v-if="item.isKaspi" class="ks-widget"
                        data-template="flatButton"
                        :data-merchant-sku="item.vendor"
                        data-merchant-code="Donato"
                        data-city="710000000"
                        data-style="mobile"
                    ></div>
                    <div id="sticky-button" class="item-action">
                        <button v-if="data.isActive" class="btn" @click="pushToCart(item)">Добавить в корзину</button>
                        <button v-else class="btn notAvailable">Нет в наличии</button>
                    </div>
                    <div v-if="item.extraColors && item.extraColors.length > 0" class="item-colors">
                        <div class="item-colors__label">Другой цвет</div>
                        <div class="item-colors__variations">
                            <div class="color-variation" v-for="color in item.extraColors" :key="color.id">
                                <a :href="color.url" class="color-item is-color" :class="{ 'is-color': color.id == item.id}" v-lazy:background-image="color.images[0].url">
                                    <!-- <img :src="color.images[0].url"> -->
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="item-description">
                        <p v-if="item.branch"><span class="label">Магазин</span>{{ item.branch.address }}</p>
                        <p><span class="label">Артикул</span> {{ item.vendor }}</p>
                        <p v-if="item.brand"><span class="label">Бренд</span> {{ item.brand.name }}</p>
                        <p v-if="item.perfume"><span class="label">Тип</span> {{ item.type.name }}</p>
                        <p v-if="item.perfume"><span class="label">Пол</span> {{ item.sex.name }}</p>
                        <p v-if="item.color"><span class="label">Цвет</span> {{ item.color.name }}</p>
                        <p v-if="item.seasons"><span class="label">Сезон</span> {{ getSeasonsString }}</p>
                        <p v-if="item.sourceState"><span class="label">Страна бренда</span> {{ item.sourceState.name }}</p>
                        <p v-if="item.manufactureState"><span class="label">Страна производитель</span> {{ item.manufactureState.name }}</p>
                    </div>
                    <div class="itemHaveQuestions">
                        <p>Есть вопросы?</p>
                        <div class="social">
                            <a href="https://t.me/donatokz" class="telegram" target="_blank">
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="telegram-plane" class="svg-inline--fa fa-telegram-plane fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M446.7 98.6l-67.6 318.8c-5.1 22.5-18.4 28.1-37.3 17.5l-103-75.9-49.7 47.8c-5.5 5.5-10.1 10.1-20.7 10.1l7.4-104.9 190.9-172.5c8.3-7.4-1.8-11.5-12.9-4.1L117.8 284 16.2 252.2c-22.1-6.9-22.5-22.1 4.6-32.7L418.2 66.4c18.4-6.9 34.5 4.1 28.5 32.2z"></path></svg>
                                <span>Telegram</span>
                            </a>
                            <a href="https://api.whatsapp.com/send?phone=77770015373" class="whattsapp" target="_blank">
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="whatsapp" class="svg-inline--fa fa-whatsapp fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path></svg>
                                <span>WhatsApp</span>
                            </a>
                            <a href="https://www.facebook.com/donatokz/" class="facebook" target="_blank">
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f" class="svg-inline--fa fa-facebook-f fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg>
                                <span>Facebook</span>
                            </a>
                            <a href="https://www.instagram.com/donato.kz/" class="instagram" target="_blank">
                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="instagram" class="svg-inline--fa fa-instagram fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg>
                                <span>Instagram</span>
                            </a>
                        </div>
                    </div>
                    <div class="item-features">
                        <p>Подробнее о товаре</p>
                        <div class="features-accordion">
                            <div v-if="item.composition" class="accordion-item">
                                <div @click="revealAccordion" class="accordion-label">
                                    <span>Состав</span>
                                    <i class="accordion-icon"></i>
                                </div>
                                <div data-panel="composition" class="accordion-content">
                                    <p>{{ item.composition }}</p>
                                </div>
                            </div>
                            <div v-if="item.description" class="accordion-item">
                                <div @click="revealAccordion" class="accordion-label">
                                    <span>Описание</span>
                                    <i class="accordion-icon"></i>
                                </div>
                                <div data-panel="description" class="accordion-content">
                                    <p>{{ item.description }}</p>
                                </div>
                            </div>
                            <div v-if="item.features" class="accordion-item">
                                <div @click="revealAccordion" class="accordion-label">
                                    <span>Особенности</span>
                                    <i class="accordion-icon"></i>
                                </div>
                                <div data-panel="features" class="accordion-content">
                                    <p>{{ item.features }}</p>
                                </div>
                            </div>
                            <div v-if="item.care" class="accordion-item">
                                <div @click="revealAccordion" class="accordion-label">
                                    <span>Уход</span>
                                    <i class="accordion-icon"></i>
                                </div>
                                <div data-panel="care" class="accordion-content">
                                    <p v-html="item.care "></p>
                                </div>
                            </div>
                            <div v-if="measurements" class="accordion-item">
                                <div @click="revealAccordion" class="accordion-label">
                                    <span>Обмеры</span>
                                    <i class="accordion-icon"></i>
                                </div>
                                <div data-panel="sizes-guide" class="accordion-content sizes-guide">
                                    <p>
                                    <table v-if="measurements[0].title" class="lingerie">
                                        <tbody>
                                            <tr>
                                                <td colspan="3">{{ measurements[0].title[0] }}</td>
                                                <td colspan="4">{{ measurements[0].title[1] }}</td>
                                            </tr>
                                            <tr v-for="item in measurements" :key="item.id">
                                                <td v-for="(size, index) in item.sizes" :key="index" v-html="size"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table v-else>
                                        <tbody >
                                            <tr v-for="item in measurements" :key="item.id">
                                                <td v-for="(size, index) in item.sizes" :key="index">{{ size }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <div v-if="data.item.alsoBoughtProducts && data.item.alsoBoughtProducts.length" class="related-products">
            <p>С этим товаром покупают</p>
            <swiper-component :items="data.item.alsoBoughtProducts" :wishes="false"></swiper-component>
        </div>
        <div v-if="data.mightLikeItems" class="might-like">
            <p>Возможно, вам понравится</p>
            <swiper-component :items="data.mightLikeItems" @wishlistHandler="wishlistHandler"></swiper-component>
        </div>

        <!-- subscribe start -->
        <subscribe-component></subscribe-component>
        <!-- subscribe end -->

        <transition name="fade">
            <div v-show="isDialogSize" @click.self="isDialogSize = false" ref="dialogSize" class="dialog-size">
                <div class="dialog-content">
                    <div @click="isDialogSize = false" class="dialog-content__close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 20"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg>
                    </div>
                    <div class="dialog-content__text">
                        <p>Пожалуйста выберите размер!</p>
                    </div>
                    <div class="dialog-content__action">
                        <button @click="isDialogSize = !isDialogSize" class="btn">ОК</button>
                    </div>
                </div>
            </div>
        </transition>
        <transition name="fade">
            <div v-show="isDialogBasketAdded" @click.self="isDialogBasketAdded = !isDialogBasketAdded" ref="dialogAdded" class="dialog-added">
                    <div class="dialog-content">
                        <div @click="isDialogBasketAdded = !isDialogBasketAdded" class="dialog-content__close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 20"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                        </div>
                        <div class="dialog-content__text">
                            <p class="tnx">СПАСИБО!</p>
                            <p>Товар успешно добавлен в корзину.</p>
                        </div>
                        <div class="dialog-content__action">
                            <button @click="byOneClick" class="btn">Купить в 1 клик</button>
                            <button @click="goBack" class="btn continue">Продолжить покупки</button>
                            <button @click="isDialogBasketAdded = false" class="btn continue">Добавить ещё размер</button>
                            <a ref="linkHref" style="display:none"></a>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
import Swiper from 'swiper';
import 'swiper/css/swiper.css'
import { disableBodyScroll, enableBodyScroll, clearAllBodyScrollLocks } from 'body-scroll-lock'
import { mapState, mapActions } from 'vuex';
    export default {
        components: {
            'swiper-component': () => import('./containers/_swiperComponent'),
            'subscribe-component': () => import('./SubscribeComponent')
        },
        data() {
            return {
                item: Object,
                isSizeSelected: false,
                isDialogSize: false,
                isDialogBasketAdded: false,
                scrollingOffset: 0,
                bodyScrollOptions: {
                    reserveScrollBarGap: true
                },
            }
        },
        props: ['data'],
        created() {
            this.item = this.data.item
        },
        beforeMount() {
            this.isItemWishlist()
        },
        mounted() {
            this.initSwiper()
            this.$store.watch(state => state.wishlist, wishlist => {
                const item = wishlist.find(item => item.id === this.item.id)
                if (!item) this.item.isWishlist = false;
            })
            this.itemToVisited()
            if (document.referrer) this.setReturnPath(document.referrer)

            if (this.item.isKaspi) this.loadKaspiScript()

            this.initVScroll()
            this.stickyToBottom()

            console.log(this.item)
        },
        methods: {
            ...mapActions(['setToWishlist', 'addToVisited', 'setReturnPath', 'addToCart']),
            wishlistHandler(item) {
                this.setToWishlist(item)
            },
            initSwiper() {
                const mySwiper = new Swiper ('.item-gallery', {
                    loop: true,
                    width: 80 / 100 * window.innerWidth,
                    loopedSlides: 2,
                    lazy: {
                        loadPrevNext: true,
                        loadOnTransitionStart: true,
                        preloaderClass: 'lazy-preloader-image'
                    },
                    watchSlidesVisibility: true,
                    pagination: {
                        el: '.swiper-pagination',
                        type: 'bullets',
                    },
                    breakpoints: {
                        1200: {
                            slidesPerView: 3,
                            spaceBetween: 4,
                        }
                    }
                })

                let bullets = document.querySelectorAll('.swiper-pagination-bullet');
                for (let bullet of bullets) {
                    bullet.style.width = window.innerWidth / bullets.length - 10 + 'px';
                }
            },
            initVScroll() {
                const vScrollMedia = document.querySelector('.v-scroll-media')
                const medias = vScrollMedia.querySelectorAll('.item-card__image')
                vScrollMedia.style.height = medias[0].scrollHeight  + 'px';
                this.scrollingOffset = vScrollMedia.getBoundingClientRect().top;
            },
            setSize(id) {
                this.item.sizes.map(size => {
                    size.id == id ? size.isSelected = true : size.isSelected = false
                });
            },
            itemToWishlist(item) {
                item.isWishlist = !item.isWishlist;
                this.setToWishlist(item)
            },
            pushToCart(item) {
                const isSize = Object.values(item.sizes).find(size => size.isSelected === true);
                if (!isSize) return this.isDialogSize = !this.isDialogSize
                item.key = parseInt(String(item.id) + String(isSize.id))
                this.addToCart(item);
                this.isDialogBasketAdded = true
            },
            isItemWishlist() {
                const isWishlist = this.wishlist.find(wishes => wishes.id == this.item.id);
                if (isWishlist) this.item.isWishlist = true
            },
            itemToVisited() {
                this.addToVisited(this.item)
            },
            goBack() {
                this.returnPath ? window.location.href = this.returnPath : window.location.href = document.referrer
            },
            byOneClick() {
                this.isDialogBasketAdded = !this.isDialogBasketAdded
                this.$refs.linkHref.href = '/checkout';
                this.$refs.linkHref.click();
            },
            revealAccordion(e) {
                const boards = document.querySelectorAll('.accordion-content');
                const panel = e.target.parentElement.querySelector('.accordion-content');
                const icon = e.target.parentElement.querySelector('.accordion-icon');
                for (const board of boards) {
                    if (panel.dataset !== board.dataset) {
                        board.style.maxHeight = null;
                        board.parentElement.querySelector('.accordion-icon').classList.remove('accordion-icon__is-reveal')
                    }
                }
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null
                    icon.classList.remove('accordion-icon__is-reveal')
                } else {
                    panel.style.maxHeight = 1 + panel.scrollHeight + "px";
                    icon.classList.add('accordion-icon__is-reveal')
                }
            },
            stickyToBottom() {
                let windowHeight, windowY, stickyPosition, btnPosition
                const panel = document.querySelector("#sticky-button")
                const panelHeight = panel.getBoundingClientRect().top + 20
                const panelY = panel.scrollHeight

                window.addEventListener('scroll', () => {
                    windowHeight = window.innerHeight;
                    windowY = window.scrollY
                    stickyPosition = Math.round(panelHeight + panelY);
                    btnPosition = Math.round(windowY + windowHeight)
                    btnPosition > stickyPosition ? panel.classList.add('stick') : panel.classList.remove('stick');
                })
            },
            loadKaspiScript() {
                (function(d, s, id) {
                    var js, kjs;
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = 'https://kaspi.kz/kaspibutton/widget/ks-wi_ext.js';
                    kjs = document.getElementsByTagName(s)[0]
                    kjs.parentNode.insertBefore(js, kjs);
                }(document, 'script', 'KS-Widget'));
            }
        },
        computed: {
            ...mapState(['wishlist', 'visited', 'returnPath']),
            getSeasonsString() {
                let seasons = []
                this.item.seasons.map(season => {
                    seasons.push(season.name);
                });
                return seasons.join(' / ')
            },
            measurements() {
                return this.item.guideSizes ? JSON.parse(this.item.guideSizes.data) : null
            }
        },
        watch: {
            isDialogSize() {
                this.isDialogSize ? disableBodyScroll(this.$refs.dialogSize, this.bodyScrollOptions) : enableBodyScroll(this.$refs.dialogSize, this.bodyScrollOptions)
            },
            isDialogBasketAdded() {
                this.isDialogBasketAdded ? disableBodyScroll(this.$refs.dialogAdded, this.bodyScrollOptions) : enableBodyScroll(this.$refs.dialogAdded, this.bodyScrollOptions)
            }
        }
    }
</script>

<style lang="scss">
.item {
    position: relative;
    &-breadcrumbs {
        padding-bottom: 1em;
        min-height: 1.1875em;
        @include breadCrumbs;
        .arrow {
            width: 18vw;
        }
        .logo {
            text-align: right;
            img {
                height: 10px;
            }
        }
    }
    .card-wrapper {
        @include get-media($laptop, $desktop) {
            display: flex;
            justify-content: space-between;
        }
    }
    &-gallery {
        position: relative;
        margin: 0 -1em;
        overflow: hidden;
        @include get-media($laptop, $desktop) {
            flex: 0 0 60%;
            margin: 0;
        }
        .swiper {
            &-pagination {
                &-bullets {
                    bottom: 5px;
                }
                &-bullet {
                    border-radius: 2px;
                    height: 4px;
                    &-active {
                        background: $main-color;
                    }
                    transition: all .2s ease-in-out;
                }
                @include get-media($laptop, $desktop) {
                    display: none;
                }
            }
            &-wrapper {
                @include get-media($laptop, $desktop) {
                    display: none;
                }
            }
        }
        &__wishes {
            @include wishes;
            width: 15%;
            height: 15%;
            cursor: pointer;
            @include get-media($laptop, $desktop) {
                right: 2%;
                width: 8%;
                height: 8%;
            }
        }
        .v-scroll {
            &-media {
                display: none;
                @include get-media($laptop, $desktop) {
                    display: block;
                    overflow-y: scroll;
                    scrollbar-width: none;
                    &::-webkit-scrollbar {
                        display: none;
                    }
                }
            }
            &-thumbs {
                display: none;
                @include get-media($laptop, $desktop) {
                    display: grid;
                    width: 11%;
                    float: left;
                    margin-right: 8%;
                    a {
                        margin-bottom: .5em;
                    }
                }
            }
        }
    }
    &-card {
        display: flex;
        .lazy-preloader-image {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: absolute;
            top: 0;
            left: 0;
        }
        &__image {
            width: 100%;
            padding-top: calc(100% * 1.3333);
            background-size: cover;
            background-position: top center;
            background-repeat: no-repeat;
            @include get-media($laptop, $desktop) {
                position: relative;
                display: inline-flex;
                border: 1px solid transparent;
                transition: border-color .3s;
                align-items: flex-start;
                &.scrollactive-item {
                    &:before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: 0;
                        bottom: 0;
                        right: 0;
                        background-color: rgba(255, 255, 255, 0.35);
                        transition: 300ms linear;
                    }
                    &.is-active {
                        border-color: $brown-color;
                        &:before {
                            content: none;
                        }
                    }
                }
            }
        }
    }
    &-properties {
        @include get-media($laptop, $desktop) {
            width: 70%;
            margin-left: 5%;
        }
        .ks-widget {
            @include get-media($mobile) {
                margin: 1rem 0 2rem;
            }
        }
    }
    &-prices {
        position: relative;
        font-weight: bold;
        font-size: 100% !important;
        padding: 15px 0;
        @include prices;
        &::before {
            @include pseudoLine(0);
        }
        &::after {
            @include pseudoLine(auto, 0);
        }
        span {
            position: absolute;
            color: white;
            background: $red;
            border-radius: 2px;
            font-size: 70%;
            font-weight: normal;
            padding: 3px 8px 0;
            right: 0;
        }
    }
    &-sizes {
        position: relative;
        padding: 15px 0;
        &__label {
            margin-bottom: 20px;
            font-family: 'SegoeUI'
        }
        &__values {
            display: flex;
            overflow-x: scroll;
            -webkit-overflow-scrolling: touch;
            margin: 0 -1em;
            padding: 0 1em .5em;
            @include get-media($laptop, $desktop) {
                overflow-x: auto;
                cursor: pointer;
            }
            .size-value {
                border: 1px solid $line-color;
                padding: 5px 16px 5px;
                margin-right: 15px;
                border-radius: 3px;
                transition: all .2s ease-in-out;
            }
            .is-size {
                background: $donato-color;
                color: white;
                border: 1px solid $donato-color;
            }
        }

    }
    &-extra-price {
        font-size:90%;
        padding: 12px 0;
        position: relative;
        &::after {
            content: "";
            position: absolute;
            height: 1px;
            top: auto;
            bottom: 0;
            left: -20px;
            right: -20px;
            background: #e5e5e5;
            @include get-media($laptop, $desktop) {
                left: 0;
                right: 0;
            }
        }
    }
    &-colors {
        position: relative;
        padding: 18px 0;
        &__label {
            margin-bottom: 20px;
            font-family: 'SegoeUI'
        }
        &__variations {
            display: flex;
            overflow-x: scroll;
            padding: 2px 0 10px 15px;
            margin: 0 -1em;
            -webkit-overflow-scrolling: touch;
             @include get-media($laptop, $desktop) {
                    overflow-x: auto;
                }
            .color {
                &-item {
                    display: flex;
                    align-items: flex-start;
                    position: relative;
                    width: 30vw;
                    margin-right: 1em;
                    border-radius: $btn-radius;
                    padding-top: 112%;
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    @include get-media($laptop, $desktop) {
                        width: auto;
                    }
                    &::after {
                        content: "";
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        border: 1px solid white;
                        transition: all .2s ease-in-out;
                    }
                    &.is-color {
                        &::after {
                            border: 1px solid $main-color;
                            box-shadow: 0 3px 7px 0 rgba(0,0,0,.1);
                        }
                    }
                }
                &::after {
                    @include pseudoLine(auto, 0);
                }
                &-variation {
                    @include get-media($laptop, $desktop) {
                        width: 23%;
                    }
                }
            }
        }
    }
    &-action {
        position: relative;
        padding: 1em 0;
        z-index: 100;
        text-align: center;
        @include button(100%);
        &.stick {
            @include get-media($mobile) {
                position: fixed;
                bottom: 20px;
                width: calc(100% - 2em);
            }
        }
        .btn.notAvailable {
            background-color: $main-color;
        }
    }
    &-description {
        .label {
            color: $grey;
            margin-right: 8px;
            font-family: 'SegoeUI'
        }
    }
    &-features {
        margin-top: 3rem;
        .features-accordion {
            .accordion {
                &-item {
                    border-bottom: 1px solid $line-color;
                    padding: 1em 0;
                    cursor: pointer;
                    &:first-child {
                        padding-top: .5em;
                    }
                }
                &-label {
                    display: flex;
                    justify-content: space-between;
                    span {
                        pointer-events: none;
                    }
                }
                &-icon {
                    @include plusIcon;
                    pointer-events: none;
                    &__is-reveal {
                        &::before {
                            transform: scale(0);
                        }
                    }
                }
                &-content {
                    max-height: 0;
                    overflow: hidden;
                    transition: all .2s linear;
                    p {
                        margin-bottom: 0;
                    }
                    &.sizes-guide {
                        font-size: 90%;
                        overflow-x: auto;
                        table, td {
                            border: 1px solid $line-color;
                            border-collapse: collapse;
                            text-align: center;
                        }
                        td {
                            padding: 0.3em .25em;
                        }
                        tr:first-child {
                            background: #f5f5f5;
                        }
                        .lingerie {
                            tbody {
                                tr:nth-child(1) {
                                    background: $brown-color;
                                    color: white;
                                    td {
                                        background: $brown-color;
                                    }
                                }
                                tr:nth-child(3) {
                                    background: #f5f5f5;
                                }
                            }
                            tr {
                                td {
                                    white-space: nowrap;
                                    &:nth-child(1), &:nth-child(4), &:nth-child(5)  {
                                        background: #f5f5f5;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    .related-products {
        position: relative;
        margin-top: 4rem;
        .swiper {
         margin: 0 -1em;
           &-slide {
                width: 49%;
            }
        }
    }
    .dialog {
        &-size {
            @include dialog;
            flex-direction: column;
            width: 100%;
            &__text {
                margin-bottom: 50px;
                text-align: center;
            }
            &__action {
                width: 25%;
                @include button(100%);
            }
        }
        &-added {
            @include dialog;
            padding: 0 1em;

        }
        &-content {
           @include dialogContent;
        }
    }
    .might-like {
        margin: 4rem 0;
        .swiper {
            margin: 0 -1em;
            &-slide {
                width: 46%;
            }
        }
    }
    &-kaspiRed {
        background: url('/images/icon-kaspi-red.svg') no-repeat center left;
        display: flex;
        padding: 1rem 2rem;
        flex-direction: column;
        align-items: flex-start;
        .kaspiRed {
            &-schedule {
                color: $red;
                font-weight: bold;
            }
            &-about {
                font-size: 70%;
            }
        }
    }
    &HaveQuestions {
        margin: 2rem 0;
        .social {
            margin-top: 0;
            a {
                color: inherit;
            }
        }
        @include get-media($laptop, $desktop) {
            display: none;
        }
    }
}
</style>
