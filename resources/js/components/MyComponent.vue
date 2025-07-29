<template>
<div class="container">
    <div class="my-account">
     <div class="my-account__breadcrumbs">
        <div class="title">Учетная запись</div>
    </div>
    <div class="my-account__content">
        <tabs :options="{ useUrlFragment: false }">
            <tab name="Мои данные">
                <form method="POST">
                    <fieldset>
                        <h4>Профиль</h4>
                        <div class="form-group">
                            <label for="user_login">Логин</label>
                            <input id="user_login" type="text" class="form-control" autocomplete="false" name="user_login" :value="login" disabled="disabled">
                        </div>
                        <div class="form-group">
                            <label for="user_name">Имя<span class="form-control-required">*</span></label>
                            <input ref="userName" id="user_name" type="text" name="name" class="form-control" :value="name">
                        </div>
                        <div class="form-group">
                            <label for="user_lastname">Фамилия<span class="form-control-required">*</span></label>
                            <input ref="userLastname" id="user_lastname" type="text" name="lastname" class="form-control" :value="lastname">
                        </div>
                        <div class="form-group">
                            <label for="user_phone">Номер телефона<span class="form-control-required">*</span></label>
                            <input ref="userPhone" id="user_phone" type="tel" name="phone" class="form-control" :value="phone" v-imask="phoneMask" @accept="onAccept" @complete="onComplete">
                            </div>
                        <div class="form-group">
                            <label for="user_email">Эл. адрес<span class="form-control-required">*</span></label>
                            <input ref="userEmail" id="user_email" type="email" name="email" class="form-control" :value="email">
                        </div>
                        <div class="form-group">
                            <label for="user_city">Город<span class="form-control-required">*</span></label>
                            <input ref="userCity" id="user_city" type="text" name="city" class="form-control" :value="city">
                        </div>
                        <div class="form-group">
                            <label for="user_address">Адрес<span class="form-control-required">*</span></label>
                            <input style="display:none" type="text" name="fakeaddress" autocomplete="false">
                            <input id="user_address" ref="userAddress" type="text" name="address" class="form-control" :value="address">
                        </div>
                        <div class="form-group">
                            <label for="user_area">Регион/Область<span class="form-control-required">*</span></label>
                            <input id="user_area" ref="userArea" type="text" name="area" class="form-control" :value="area">
                        </div>
                        <div class="form-group">
                            <label for="user_password">Пароль<span class="form-control-required">*</span></label>
                            <input style="display:none" type="password" name="fakepassword" autocomplete="false">
                            <input ref="userPassword" id="user_password" type="password" class="form-control" autocomplete="false" name="password" placeholder="Введите текущий пароль">
                        </div>
                        <button :class="{inprogress: isUpdateInProgress}" @click="setUserData($event)" class="btn save">Сохранить</button>
                    </fieldset>
                    <fieldset>
                        <div class="password-reset">
                            <h4>Смена пароля</h4>
                            <!-- <div class="form-group">
                                <label for="login">Логин</label>
                                <input id="login" type="text" class="form-control" autocomplete="false" name="login" :value="login" disabled="disabled">
                            </div> -->
                            <div class="form-group">
                                <label for="current_password">Текущий пароль<span class="form-control-required">*</span></label>
                                <input style="display:none" type="password" name="fakepassword" autocomplete="false">
                                <input ref="currentPassword" id="current_password" type="password" class="form-control" autocomplete="false" name="current_password">
                            </div>
                            <div class="form-group">
                                <label for="new_password">Новый пароль<span class="form-control-required">*</span></label>
                                <input style="display:none" type="password" name="fakepassword" autocomplete="false">
                                <input ref="newPassword" id="new_password" type="password" class="form-control" autocomplete="false" name="new_password">
                            </div>
                            <button :class="{ inprogress: isPassInProgress }" @click="setUserPassword($event)" class="btn save">Изменить</button>
                        </div>
                    </fieldset>
                </form>
                <div class="my-account__action">
            <div class="logout">
                <form action="/my/logout" method="POST">
                    <input type="hidden" name="_token" :value="csrf">
                    <button type="submit" class="btn">Выйти</button>
                </form>
            </div>
        </div>
            </tab>
            <tab name="Мои заказы">
                <div v-if="orders.length" class="orders">
                    <div v-for="order in orders" :key="order.id" class="slidedown">
                        <div class="slidedown-toggle">
                            <div @click="showOrderItems(order.id, $event)" class="accordion">№ {{ order.order_number }} от {{ getOrderDate(order.created_at) }}</div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/><path fill="none" d="M0 0h24v24H0V0z"/></svg>
                        </div>
                        <ul :ref="'order' + order.id" class="orders-list">
                            <li v-for="item in order.items" :key="item.item_data.key" class="items-edit__item">
                                <div class="item-info">
                                    <a :href="item.item_data.path" class="item-image">
                                        <img :src="item.item_data.images[0].url">
                                    </a>
                                    <div class="item-content">
                                        <div class="item-content__title">{{ item.item_data.name }}</div>
                                        <div class="item-content__wrapper">
                                            <div class="item-content__size"><span class="item-content__label">Размер:</span>{{ selectedSize(item.item_data.sizes) }}</div>
                                            <div v-if="item.item_data.color" class="item-content__color">
                                                <span>Цвет:</span>
                                                <img :src="item.item_data.color.data">
                                            </div>
                                            <div class="item-content__price"><span class="item-content__label">Цена:</span>{{ item.item_data.finalPrice.toLocaleString('ru-RU') }} ₸</div>
                                            <div class="item-content__in-cart">Количество: {{ item.item_data.inCart }} шт.</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <div class="container">
                                <div class="orders-total">
                                    <p>Заказ на сумму: {{ order.total.toLocaleString('ru-RU') }} ₸</p>
                                    <p>Доставка: {{ order.delivery_price.toLocaleString('ru-RU') }} ₸</p>
                                    <p>Итого: {{ (order.total + order.delivery_price).toLocaleString('ru-RU') }} ₸</p>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
                <div v-else class="orders">
                    <p v-if="!isAjax">Загружаю...</p>
                    <p v-else> Заказов пока нет :(</p>
                </div>
            </tab>
        </tabs>
    </div>
    </div>
    </div>
</template>

<script>
import axios from 'axios';
import { Tabs, Tab } from 'vue-tabs-component';
import { IMaskDirective } from 'vue-imask';
import { showMessage } from '../plugins';
import validator from "email-validator";
    export default {
        components: {
            'tabs': Tabs,
            'tab': Tab
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                email: null,
                phone: null,
                name: null,
                lastname: null,
                city: null,
                address: null,
                area: null,
                login: null,
                orders: [],
                phoneMask: {
                    mask: '{+7} (000) 000-00-00',
                    lazy: false,
                    placeholderChar: '•',
                },
                password: null,
                confirmPassword: null,
                isUpdateInProgress: false,
                isPassInProgress: false,
                unmaskedPhone: null,
                isAjax: true,
                errorMsg: {
                    name: 'Введите имя.',
                    lastname: 'Введите фамилию.',
                    address: 'Введите адрес.',
                    city: 'Введите город.',
                    area: 'Введите регион/область.',
                    password: 'Введите пароль.'
                }
            }
        },
        directives: {
            imask: IMaskDirective
        },
        props: ['data'],
        mounted() {
            this.getUserData()
            // console.log(this.data);
        },
        methods: {
            getUserData() {
                const path = '/api/user/index';
                this.isAjax = false;
                axios.post(path, {
                    id: this.data
                })
                .then(response => {
                    this.email = response.data.email;
                    this.phone = response.data.phone;
                    this.unmaskedPhone = response.data.phone
                    this.name = response.data.name;
                    this.lastname = response.data.lastname;
                    this.city = response.data.city;
                    this.address = response.data.address;
                    this.area = response.data.area;
                    this.login = response.data.email;
                    this.orders = response.data.order;
                    IMaskDirective.update(this.$refs.userPhone, this.phoneMask);
                    this.isAjax = true;
                })
            },
            setUserData(e) {
                e.preventDefault()
                let isEmail, password, email, name, lastname, phone, address, city, area
                const path = '/api/user/update';
                name = this.$refs.userName;
                lastname = this.$refs.userLastname
                phone = this.phone !== this.unmaskedPhone ? this.unmaskedPhone : null;
                email = this.email !== this.$refs.userEmail.value ? this.$refs.userEmail.value : null;
                password = this.$refs.userPassword;
                city = this.$refs.userCity;
                address = this.$refs.userAddress;
                area = this.$refs.userArea;
                isEmail = validator.validate(this.$refs.userEmail.value);
                const userInputs = [name, lastname, city, address, area, password]
                if (!this.unmaskedPhone) return showMessage('Номер телефона не верный.', false);
                if (!isEmail) return showMessage('E-mail не верный.', false);
                for (const input of userInputs) {
                    if (input.value === '') return showMessage(this.errorMsg[input.name], false);
                }
                if (this.isAjax) {
                    const body = this.getQueryBody({
                        name: name.value,
                        lastname: lastname.value,
                        phone,
                        email,
                        password: password.value,
                        login: this.email,
                        address: address.value,
                        city: city.value,
                        area: area.value
                        })
                    this.isAjax = false;
                    this.isUpdateInProgress = true;
                    axios.post(path, body)
                    .then(response => {
                        this.unmaskedPhone = this.phone;
                        IMaskDirective.update(this.$refs.userPhone, this.phoneMask);
                        if(response.data.success){
                            showMessage(response.data.success)
                            this.$refs.userPassword.value = ''
                            this.getUserData()
                        } else showMessage(response.data[Object.keys(response.data)[0]][0], false)
                        this.isUpdateInProgress = false
                        this.isAjax = true
                    })
                }
            },
            setUserPassword(e) {
                e.preventDefault();
                const path = '/api/user/password';
                const password = this.$refs.currentPassword.value;
                const newPassword = this.$refs.newPassword.value;
                if (!password.length) return showMessage('Введите текущий пароль.', false);
                if (!newPassword.length) return showMessage('Введите новый пароль.', false);
                this.isAjax = true;
                if(this.isAjax) {
                    this.isAjax = false;
                    this.isPassInProgress = true;
                    axios.post(path, {
                        login: this.login,
                        password,
                        newPassword
                    })
                    .then(response => {
                        this.unmaskedPhone = this.phone;
                        if(response.data.success) {
                            showMessage(response.data.success)
                            this.$refs.currentPassword.value = '';
                            this.$refs.newPassword.value = '';
                            IMaskDirective.update(this.$refs.userPhone, this.phoneMask);
                        } else showMessage(response.data[Object.keys(response.data)[0]][0], false)
                        this.isPassInProgress = false
                        this.isAjax = true
                    })
                }
            },
            checkPasswordMatch() {
                this.password !== this.confirmPassword ? this.$refs.confirmPassword.classList.add('incorrect') : this.$refs.confirmPassword.classList.remove('incorrect')
                if(this.confirmPassword === '') this.$refs.confirmPassword.classList.remove('incorrect')
            },
            onComplete(e) {
                const maskRef = e.detail;
                this.unmaskedPhone = maskRef.unmaskedValue.replace('+', '');
                // console.log('complete', this.unmaskedPhone);
            },
            onAccept(e) {
                const maskRef = e.detail;
                this.unmaskedPhone = false
                // console.log('accept', maskRef.value);
            },
            getQueryBody(body) {
                Object.keys(body).forEach((key) => (body[key] == null) && delete body[key]);
                return body;
            },
            showOrderItems(id, e) {
                const [panel] = this.$refs['order' + id];
                const arrow =  e.target.nextElementSibling
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null
                    arrow.classList.remove('open');
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                    arrow.classList.add('open');
                }
            },
            getOrderDate(date) {
                const monthNames = ["января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря"];
                let newDate = new Date(date.replace(/\s/, 'T'));
                return `${newDate.getDate()} ${monthNames[newDate.getMonth()]} ${newDate.getFullYear()}`
            },
            selectedSize(sizes) {
                let selectedSize = ''
                sizes.map(size => {
                    size.isSelected ? selectedSize = size.value : ''
                })
                return selectedSize
            },
        }
    }
</script>

<style lang="scss">
.my-account {
    @include button(100%);
    &__action {
        text-align: center;
        .logout, .login {
            margin: 60px 0;
            .btn {
                margin: 0 auto;
            }
        }
    }
    &__content {
        // @include get-media($laptop, $desktop) {
        //     margin: 2rem 0;
        // }
        .tabs-component {
            &-tabs {
                display: flex;
                justify-content: center;
                li:first-child {
                    border-top-left-radius: $btn-radius;
                    border-bottom-left-radius: $btn-radius;
                }
                li:last-child {
                    border-top-right-radius: $btn-radius;
                    border-bottom-right-radius: $btn-radius;
                }
            }
            &-tab {
                padding: 6px 8px;
                font-family: SegoeUI;
                border: 1px solid $line-color;
                font-size: 85%;
                width: 85px;
                text-align: center;
                transition: $transition;
                &.is-active {
                    background: $donato-color;
                    color: white;
                    border-color: $donato-color
                }
            }
            &-panels {
                margin: 1.5em 0;
                fieldset {
                    @include get-media($laptop, $desktop) {
                        float: left;
                        width: 47%;
                    }
                }
                form {
                    @include get-media($laptop, $desktop) {
                        display: flex;
                        justify-content: space-between;
                    }
                }
            }
        }
        .password-reset {
            width: 100%;
            display: inline-block;
            margin: 25px 0;
            @include get-media($laptop, $desktop) {
                margin: 0;
            }
        }
        .orders {
            min-height: 35vh;
            @include get-media($laptop, $desktop) {
                width: 60%;
                margin: 0 auto;
            }
            .slidedown {
                border-bottom: 1px solid white;
                margin: 0 -15px;
                &-toggle {
                    position: relative;
                    display: flex;
                    align-items: center;
                    svg {
                        position: absolute;
                        width: 28px;
                        height: 28px;
                        right: 3%;
                        fill: #ffffff;
                        transform: rotate(90deg);
                        transition: $transition
                    }
                    .open {
                        transform: rotate(-90deg);
                    }
                    .accordion {
                        background: $main-color;
                        color: #fff;
                        cursor: pointer;
                        padding: 10px 15px;
                        text-align: left;
                        border: none;
                        outline: none;
                        transition: $transition;
                        font-size: 90%;
                        width: 100%;
                    }
                }
            }
            &-list {
                max-height: 0;
                overflow: hidden;
                transition: $transition;
                border-bottom: 1px solid $main-color;
            }
            &-total {
                margin: 14px 0;
            }
            .item-image {
                img {
                    width: 150px;
                }
            }
        }
        .save {
            margin-top: 20px;
        }
    }
    @include get-media($laptop, $desktop) {
        max-width: 100%;
        margin: 0 auto;
    }
}
</style>
