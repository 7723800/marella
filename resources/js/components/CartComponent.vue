<template>
    <div class="cart">
        <div class="container">
            <div v-if="items.length" class="cart-wrapper">
                <div class="cart-header">
                    <h4>Список покупки</h4>
                </div>
                <div class="cart-content">
                    <items-edit></items-edit>
                    <div class="widescreen-row">
                        <div class="widescreen-column widescreen-column__left">
                            <div class="user-section">
                                <h4>Способ доставки</h4>
                                <ul class="radio-list">
                                    <li class="radio-control">
                                        <input id="pickup" type="radio" value="pickup" v-model="deliveryMethod">
                                        <div class="checkmark"></div>
                                        <label for="pickup">Самовывоз</label>
                                        <span>{{ data.delivery.pickup }} ₸</span>
                                    </li>
                                    <li class="radio-control">
                                        <input id="courier" type="radio" value="courier" v-model="deliveryMethod" >
                                        <div class="checkmark"></div>
                                        <label for="courier">Доставка курьером по г.Астана</label>
                                        <span>{{ deliveryCourier.toLocaleString('ru-RU') }} ₸</span>
                                    </li>
                                    <!-- <li class="radio-control">
                                        <input id="tryon" type="radio" value="tryon" v-model="deliveryMethod" >
                                        <div class="checkmark"></div>
                                        <label for="tryon">Доставка по г. Астана с примеркой</label>
                                        <span>{{ data.delivery.tryon.toLocaleString('ru-RU') }} ₸</span>
                                    </li> -->
                                     <!-- <li class="radio-control">
                                        <input id="express" type="radio" value="express" v-model="deliveryMethod">
                                        <div class="checkmark"></div>
                                        <label for="express">Экспресс доставка по Казахстану (1-3 дня)</label>
                                        <span> {{ data.delivery.express.toLocaleString('ru-RU') }} ₸</span>
                                    </li> -->
                                    <li class="radio-control">
                                        <input id="qazaqstan" type="radio" value="qazaqstan" v-model="deliveryMethod">
                                        <div class="checkmark"></div>
                                        <label for="qazaqstan">Доставка по Казахстану</label>
                                        <span> {{ data.delivery.qazaqstan.toLocaleString('ru-RU') }} ₸</span>
                                    </li>
                                    <li class="radio-control">
                                        <input id="russia" type="radio" value="russia" v-model="deliveryMethod">
                                        <div class="checkmark"></div>
                                        <label for="russia">Доставка по России</label>
                                        <span> {{ data.delivery.russia.toLocaleString('ru-RU') }} ₸</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="user-section">
                                <h4>Способ оплаты</h4>
                                <ul class="radio-list">
                                    <li class="radio-control">
                                        <input id="kaspiQr-payment" type="radio" value="kaspiQr" v-model="paymentMethod" >
                                        <div class="checkmark"></div>
                                        <label for="kaspiQr-payment">Оплата Kaspi QR</label>
                                    </li>
                                    <li class="radio-control">
                                        <input id="online-payment" type="radio" value="online" v-model="paymentMethod">
                                        <div class="checkmark"></div>
                                        <label for="online-payment">Online оплата Visa/Mastercard</label>
                                    </li>
                                    <!-- <li v-if="totalSum <= 150000" class="radio-control">
                                        <input id="kaspiRed-payment" type="radio" value="kaspiRed" v-model="paymentMethod" >
                                        <div class="checkmark"></div>
                                        <label for="kaspiRed-payment">Оплата Kaspi Red</label>
                                    </li> -->
                                    <!-- <li class="radio-control">
                                        <input id="cash-payment" type="radio" value="cash" v-model="paymentMethod" >
                                        <div class="checkmark"></div>
                                        <label for="cash-payment">Оплата наличными курьеру.<br/>Доступна только по г.Астана</label>
                                    </li> -->
                                </ul>
                            </div>
                            <div class="user-section">
                                <h4>Ваши данные</h4>
                                <div class="form-group">
                                    <label>Имя<span class="form-control-required">*</span></label>
                                    <input ref="uFirstname" name="firstname" type="text" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label>Фамилия<span class="form-control-required">*</span></label>
                                    <input ref="uLastname" name="lastname" type="text" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label>Эл. адрес<span class="form-control-required">*</span></label>
                                    <input ref="uEmail" name="email" type="email" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label>Номер телефона<span class="form-control-required">*</span></label>
                                    <input type="tel" name="phone" ref="uPhone" :value="userPhone" v-imask="phoneMask" @accept="onAccept" @complete="onComplete" placeholder="+7 (777) 777-77-77" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label>Улица, номер дома и квартиры<span class="form-control-required">*</span></label>
                                    <input ref="uAddress" name="address" type="text" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label>Город<span class="form-control-required">*</span></label>
                                    <input ref="uCity" name="city" type="text" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label>Регион/Область<span class="form-control-required">*</span></label>
                                    <input ref="uArea" name="area" type="text" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label>Комментарий</label>
                                    <textarea ref="uComments" name="comments" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="widescreen-column widescreen-column__right">
                            <div id="sticky-sidebar" class="user-section">
                                <h4>Промокод</h4>
                                <div class="form-group gift-card">
                                    <input name="u_cert" type="text" class="form-control" v-model="promocode"/>
                                    <button @click="getPromocode($event)" class="btn">Применить</button>
                                </div>
                                <br/>
                                <div class="order-data">
                                    <div class="name">Сумма заказа</div>
                                    <div class="value">
                                        <span>{{ total.toLocaleString('ru-RU') }} ₸</span>
                                    </div>
                                </div>
                                <div class="order-data">
                                    <div class="name">Скидка</div>
                                    <div class="value">
                                        <span>{{ (totalWithDiscount == 0 ? 0 : total - totalWithDiscount).toLocaleString('ru-RU') }} ₸</span>
                                    </div>
                                </div>
                                <div class="order-data">
                                    <div class="name">Extra cкидка 1+1</div>
                                    <div class="value">
                                        <span>{{ extraDiscount.toLocaleString('ru-RU') }} ₸</span>
                                    </div>
                                </div>
                                <div class="order-data">
                                    <div class="name">Промокод</div>
                                    <div class="value">
                                        <span>{{ discount.toLocaleString('ru-RU') }} ₸</span>
                                    </div>
                                </div>
                                <div class="order-data">
                                    <div class="name">Доставка</div>
                                    <div class="value">
                                        <span>{{ delivery.toLocaleString('ru-RU') }} ₸</span>
                                    </div>
                                </div>
                                <div class="order-data">
                                    <div class="name">Итого к оплате</div>
                                    <div class="value">
                                        <span>{{ totalSum.toLocaleString('ru-RU') }} ₸</span>
                                    </div>
                                </div>
                                <div class="order-data__actions">
                                    <button class="kaspiQr-btn " v-if="paymentMethod == 'kaspiQr'" :class="{ inprogress: isOrderInProgress }" @click="processAnOrder">
                                        <div :class="{inProgress: isOrderInProgress}">
                                            <img class="" src="/images/pay_with_kaspi_gold.svg" alt="Kaspi QR">
                                        </div>
                                    </button>
                                    <button v-else @click="processAnOrder" :class="{ inprogress: isOrderInProgress }" class="btn">{{ paymentMethod === 'online' ? 'Оплатить' : 'Оформить'  }} заказ</button>
                                    <p class="info">Нажимая на кнопку "Оплатить заказ", я принимаю условия <a href="/info/oferta">публичной оферты</a> и <a href="/checkout">политики конфиденциальности</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="text-empty">Ваша корзина пока пуста</div>
            <p v-if="visited.length" class="cart-watched">Вы недавно смотрели</p>
            <swiper-component v-if="visited.length" @wishlistHandler="wishlistHandler" :items="visited"></swiper-component>
        </div>
    </div>
</template>

<script>
import { IMaskDirective } from 'vue-imask';
import { mapState, mapActions, mapMutations } from 'vuex';
import { showMessage } from '../plugins';
import validator from 'email-validator';
import _ from 'lodash/core';
import ScrollMagic from 'scrollmagic';
import 'imports-loader?define=>false!scrollmagic/scrollmagic/uncompressed/plugins/debug.addIndicators';
import md5 from 'js-md5';
    export default {
        components: {
            'items-edit': () => import('./containers/_itemsEditComponent'),
            'swiper-component': () => import('./containers/_swiperComponent')
        },
        data() {
            return {
                userPhone: '',
                phoneMask: {
                    mask: '{+0} (000) 000-00-00',
                    lazy: false,
                    placeholderChar: '•'
                },
                unmaskedPhone: null,
                isOrderInProgress: false,
                isAjax: true,
                deliveryMethod: 'courier',
                paymentMethod: 'kaspiQr',
                errorMsg: {
                    firstname: 'Введите имя.',
                    lastname: 'Введите фамилию.',
                    address: 'Введите адрес.',
                    city: 'Введите город.',
                    area: 'Введите регион/область.'
                },
                discount: 0,
                promocode: '',
                isValuePromocode: false,
                validPromocode: null,
                scripts: [
                    "https://auth.robokassa.ru/Merchant/bundle/robokassa_iframe.js" //robokassa
                ],
                order: null,
                roboData: {}
            }
        },
        directives: {
            imask: IMaskDirective
        },
        props: ['data'],
        created() {
            this.getRoboData()
        },
        mounted() {
            this.getCustomerData(this.data.id)
            this.initScrollMagic();
            console.log(this.data);
        },
        methods: {
            ...mapActions(['setToWishlist']),
            ...mapMutations(['setCustomerData', 'clearCart']),
            onAccept(e) {
                const maskRef = e.detail;
                this.unmaskedPhone = null
                this.$refs.uPhone.classList.add('incorrect')
            },
	        onComplete(e) {
                const maskRef = e.detail;
                this.unmaskedPhone = maskRef.unmaskedValue.replace(/[^0-9\\.]+/g, '');
                this.$refs.uPhone.classList.remove('incorrect')
                // this.isCorrectPhone = true
            },
            wishlistHandler(item) {
                this.setToWishlist(item)
            },
            initScrollMagic() {
                const controller = new ScrollMagic.Controller();
                const scene = new ScrollMagic.Scene({
                    triggerHook: 0.05,
                    triggerElement: '.widescreen-row',
                    duration: 780,
                })
                // .addIndicators()
                .setPin('#sticky-sidebar')
                .addTo(controller)
                if (window.innerWidth < 1025) scene.destroy(true)
            },
            getCustomerData(id) {
                if (id) {
                    const path = '/api/user/index';
                    axios.post(path, {
                        id
                    })
                    .then(response => {
                        this.$refs.uFirstname.value = response.data.name;
                        this.$refs.uLastname.value = response.data.lastname;
                        this.userPhone = response.data.phone;
                        this.unmaskedPhone = response.data.phone;
                        this.$refs.uEmail.value = response.data.email;
                        this.$refs.uAddress.value = response.data.address;
                        this.$refs.uCity.value = response.data.city
                        this.$refs.uArea.value = response.data.area
                        IMaskDirective.update(this.$refs.uPhone, this.phoneMask);
                    })
                } else {
                    const isCustomerData = _.isEmpty(this.customer);
                    if (!isCustomerData && this.items.length) {
                        this.$refs.uFirstname.value = this.customer.name
                        this.$refs.uLastname.value = this.customer.lastname
                        this.userPhone = this.customer.phone
                        this.unmaskedPhone = this.customer.phone
                        this.$refs.uEmail.value = this.customer.email
                        this.$refs.uAddress.value = this.customer.address
                        this.$refs.uCity.value = this.customer.city
                        this.$refs.uArea.value = this.customer.area
                        IMaskDirective.update(this.$refs.uPhone, this.phoneMask);
                    }
                }
            },
            getPromocode(e) {
                if (this.promocode === '') return showMessage('Введите промокод.', false);
                if (this.totalWithDiscount < this.data.delivery.promocode) return showMessage(`Промокод действует при заказе от ${(this.data.delivery.promocode).toLocaleString('ru-RU')} ₸`, false);
                if (this.isAjax) {
                    this.isAjax = false
                    e.target.classList.add('inprogress');
                    axios.post('/api/promocode', {
                        promocode: this.promocode,
                    })
                    .then(response => {
                        e.target.classList.remove('inprogress');
                        this.isAjax = true;
                        if (response.data.error) return showMessage(response.data.error, false);
                        if (response.data.success) {
                            if (response.data.promocode.value != 0) {
                                this.isValuePromocode = true
                                this.discount = response.data.promocode.value
                                this.validPromocode = response.data.promocode.number
                                showMessage(response.data.success);
                            } else if (response.data.promocode.percentage != 0) {
                                const discountPrice = this.items.reduce((total, item) => {
                                    if (item.discount <= response.data.promocode.percentage) {
                                        total += item.price * item.inCart / 100 * response.data.promocode.percentage
                                    }
                                    return total
                                }, 0);
                                this.discount = Math.round(discountPrice)
                                this.validPromocode = response.data.promocode.number
                                showMessage(response.data.success);
                            }
                        }
                    })
                }
            },
            storeCustomerData() {
                const customerData = {
                    name: this.$refs.uFirstname.value,
                    lastname: this.$refs.uLastname.value,
                    phone: this.unmaskedPhone,
                    email: this.$refs.uEmail.value,
                    address: this.$refs.uAddress.value,
                    city: this.$refs.uCity.value,
                    area: this.$refs.uArea.value,
                }
                this.userPhone = this.unmaskedPhone
                this.setCustomerData(customerData)
            },
            processAnOrder() {
                const isEmail = validator.validate(this.$refs.uEmail.value);
                const userInputs = [this.$refs.uFirstname, this.$refs.uLastname, this.$refs.uAddress, this.$refs.uCity, this.$refs.uArea]
                if (!this.unmaskedPhone) return showMessage('Номер телефона не верный.', false);
                if (!isEmail) return showMessage('E-mail не верный.', false);
                for (const input of userInputs) {
                    if (input.value === '') return showMessage(this.errorMsg[input.name], false);
                }
                this.storeCustomerData()
                if (this.paymentMethod === 'online') {
                    return this.startRobokassa(this.totalWithDiscount + this.delivery - this.discount)
                } else if (this.paymentMethod === 'kaspiQr') {
                    this.sendOrderQuery(false)
                } else {
                    this.sendOrderQuery(true)
                }

                //create order
            },
            sendOrderQuery(isNotification) {
                if (this.isAjax) {
                    this.isOrderInProgress = true;
                    const path = '/api/order'
                    this.isAjax = false;
                    return axios.post(path, {
                        user_id: this.data.id,
                        name: this.customer.name,
                        lastname: this.customer.lastname,
                        email: this.customer.email,
                        phone: this.customer.phone,
                        address: this.customer.address,
                        city: this.customer.city,
                        area: this.customer.area,
                        comment: this.$refs.uComments.value,
                        discount: this.discount,
                        promocode: this.validPromocode,
                        delivery_price: this.delivery,
                        total: this.totalSum,
                        total_with_discount: this.totalWithDiscount,
                        items: this.items,
                        delivery_method: document.getElementById(this.deliveryMethod).labels[0].innerText,
                        payment_method: this.paymentMethod,
                        isNotification: isNotification
                    })
                    .then(response => {
                        this.isAjax = true;
                        this.isOrderInProgress = false;
                        if (response.data.kaspi) {
                            window.location.href = response.data.kaspi.formUrl
                        } else if (response.data.error) {
                            console.log(response.data.error);
                            return showMessage(response.data.error, false);
                        } else if (!isNotification) {
                            return response;
                        } else {
                            window.location.href = `/checkout/confirm?order=${response.data.order}`
                        }
                        // this.clearCart();
                    })
                }
            },
            importScripts(scripts) {
                scripts.forEach(script => {
                    let tag = document.createElement("script");
                    tag.setAttribute("src", script);
                    document.head.appendChild(tag);
                });
            },
            startRobokassa(sum) {
                const startPayment = sum => {
                    const orderNumber = this.order.replace(/\D/g, '')
                    const signature = md5(`DONATOKZ:${sum}:${orderNumber}:${this.roboData.pass}`)
                        const url = `https://auth.robokassa.kz/Merchant/Index.aspx?MerchantLogin=DONATOKZ&Culture=ru&Description=Оплата заказа № ${this.order} в интернет магазине Donato.kz&Encoding=utf-8&OutSum=${sum}&InvId=${orderNumber}&SignatureValue=${signature}&IsTest=${this.roboData.isTest}`
                        window.location.href = url
                }
                if (this.order) return startPayment(sum)
                this.sendOrderQuery(false).then(response => {
                    this.order = response.data.order
                    startPayment(sum)
                })
            },
            getRoboData() {
                axios.post('/payment/robokassa').then(response => {
                    this.roboData = response.data;
                })
            }
        },
        computed: {
            ...mapState(['items', 'visited', 'customer']),
            extraDiscount() {
                let extraDiscount = 0
                let extraDiscountItemsAmount = 0
                this.items.forEach(item => {
                    if (item.extra_discount > 0) {
                        extraDiscountItemsAmount += item.inCart
                    }
                });

                if (extraDiscountItemsAmount > 1) {
                    extraDiscount = this.items.reduce((total, item) => {
                    return total + item.price * item.inCart / 100 * item.extra_discount
                }, 0);
                }
                return extraDiscount
            },
            total() {
                return this.items.reduce((total, item) => {
                    return total + (item.price * item.inCart);
                }, 0);
            },
            totalWithDiscount() {
                return this.items.reduce((total, item) => {
                    if (this.discount > 0 && !this.isValuePromocode) {
                        return 0
                    } else {
                        return total + (item.finalPrice * item.inCart);
                    }
                }, 0);
            },
            deliveryCourier() {
                return this.totalWithDiscount > this.data.delivery.max ? 0 : this.data.delivery.courier
            },
            delivery() {
                if (this.deliveryMethod === 'courier' && !this.deliveryCourier) return this.deliveryCourier
                return this.data.delivery[this.deliveryMethod]
            },
            totalSum() {
                if (this.discount > 0 && !this.isValuePromocode) {
                    return this.total + this.delivery - this.discount - this.extraDiscount
                } else {
                    return this.totalWithDiscount + this.delivery - this.discount - this.extraDiscount
                }
            }
        },
        watch: {
            totalSum(newValue) {
                if (newValue > 150000 && this.paymentMethod == 'kaspiRed') this.paymentMethod = 'cash'
            }
        }
    }
</script>

<style lang="scss">
.cart {
    &-header {
        position: relative;
        display: flow-root;
        &::before {
            @include pseudoLine(auto, 0);
            @include get-media($laptop, $desktop) {
                content: none;
            }
        }
    }
    &-content {
        .order-data {
            display: flex;
            justify-content: space-between;
            padding: 2px 0;
            margin: 5px 0;
            position: relative;
            &::before {
                content: '';
                position: absolute;
                left: 0;
                width: 100%;
                height: 1px;
                border-bottom: 1px dotted #444;
                bottom: 4px;
            }
            .name {
                font-weight: bold;
            }
            &__actions {
                @include button(100%);
                margin: 50px 0;
                .info {
                    font-size: 12px;
                    a {
                        text-decoration: underline
                    }
                }
                .kaspiQr-btn {
                    display: flex;
                    width: 100%;
                    justify-content: center;
                    img {
                        cursor: pointer;
                        padding: 0;
                    }
                    .btn {
                        background-color: transparent;
                    }
                    .inProgress {
                        position: relative;
                        &::before {
                            content: "";
                            width: 100%;
                            height: 100%;
                            position: absolute;
                            background-image: linear-gradient(-45deg,rgba(255,255,255,.2) 0,rgba(255,255,255,.2) 25%,rgba(255,255,255,0) 26%,rgba(0,0,0,0) 50%,rgba(255,255,255,.2) 51%,rgba(255,255,255,.2) 75%,rgba(255,255,255,0) 76%);
                            background-size: 20px 20px;
                            animation: background-move 1s linear infinite;
                        }
                    }
                }
            }
        }
        .gift-card {
            display: flex;
            input {
                margin-right: 1em;
            }
            @include button(65%);
            .btn {
                margin: 5px 0;
            }
        }
        .items-edit {
            margin: 0 -1em;
            @include get-media($laptop, $desktop) {
                margin: 0;
            }
            &__list {
                .item {
                    @include get-media($laptop, $desktop) {
                        &-image {
                            img {
                                width: 105px;
                            }
                        }
                        &-content {
                            width: 100%;
                            flex-direction: row;
                            &__title {
                                align-items: center;
                                display: flex;
                                margin: 0;
                                width: 155px;
                                white-space: normal;
                            }
                            &__wrapper {
                                flex-direction: row;
                                align-items: center;
                                flex: 1;
                                justify-content: space-around;
                            }
                        }
                    }
                }
            }
            &__item {
                @include get-media($laptop, $desktop) {
                    margin-bottom: 2em;
                    border-bottom: none;
                }
            }
        }
        .form {
            &-group {
                margin-top: 1em;
                @include get-media($laptop, $desktop) {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }
            }
            &-control {
                @include get-media($laptop, $desktop) {
                    width: 65%;
                }
            }
        }
        .widescreen {
            @include get-media($laptop, $desktop) {
                &-row {
                    display: flex;
                    justify-content: space-between;
                    padding-bottom: 5em;
                }
                &-column {
                    &__left {
                        width: 55%;
                        .form-group {
                            label {
                                width: 32%;
                            }
                        }

                    }
                    &__right {
                        width: 35%;
                    }
                }
            }
        }
        .radio {
            &-control {
                display: flex;
                position: relative;
                margin: 1em 0;
                align-items: center;
                @include customInputPicker;
                input {
                    left: 0;
                    right: auto;
                    top: auto;
                    margin: 0;
                    width: 24px;
                    height: 24px;
                    &:checked ~ .checkmark {
                        background-color: transparent;
                        border-color: $line-color;
                    }
                }
                span {
                    text-align: right;
                    margin-left: 4em;
                }
                .checkmark {
                    display: flex;
                    margin-right: .8em;
                    align-items: center;
                    justify-content: center;
                    @include get-media($laptop, $desktop) {
                        border-radius: 50%;
                        height: 23px;
                        width: 23px;
                    }
                    &::after {
                        background-color: $donato-color;
                        border: none;
                        transform: none;
                        width: 7px;
                        height: 7px;
                        border-radius: 50%;
                        left: auto;
                        top: auto;
                    }
                }
            }
        }
        .user-section {
            // @include get-media($laptop, $desktop) {
                padding-top: 3em;
            // }
        }
    }
    .swiper {
        margin: 0 -1em;
        @include get-media($laptop, $desktop) {
            margin: 0;
        }
        &-slide {
            @include get-media($mobile) {
                width: calc(100vw / 2 - 1rem);
            }
        }
    }
    .swiper-button {
        top: -40px;
    }
    .text-empty {
        min-height: 10vh;
        font-size: 100%;
    }
}
</style>
