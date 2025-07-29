<template>
    <div class="subscribe-us">
                <div class="subscribe-us_content">
                    <!-- <img class="banner" src="/images/subscribe-price.jpg" alt="Сидка"> -->
                    <p>Узнайте первым о новинках и скидках</p>
                    <ul class="subscribe-us_list">
                        <li class="subscribe-us_item">промокод на <span style="color: #E83841">3 000 ₸</span> за подписку</li>
                        <li class="subscribe-us_item">быть в курсе новинок и акций</li>
                        <li class="subscribe-us_item">читай статьи о моде и красоте от нашего fashion редактора</li>
                    </ul>
                </div>
                <div class="subscribe-us_actions">
                    <input @input="checkEmail($event)" ref="subscribeEmail" type="email" id="subscribe_email" placeholder="Введите свой e-mail" :class="{ incorrect: isCheckedEmail }">
                    <button @click="subscribe" class="btn" :class="{ inprogress: inProgress }">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z"/></svg>Получить промокод</button>
                </div>
                <div class="subscribe-us_info">
                    <p>Нажимая на кнопку "Подписаться", я соглашаюсь на обработку моих персональных данных и ознакомлен(а) с условиями конфиденциальности.</p>
                </div>
            <!-- </div> -->
    </div>
</template>

<script>
import * as EmailValidator from 'email-validator';
import { showMessage } from '../plugins';
    export default {
        data() {
            return {
                isCheckedEmail: false,
                isAjax: true,
                inProgress: false,
            }
        },
        methods: {
            checkEmail(e) {
                const email = e.target.value
                const isEmail = EmailValidator.validate(email);
                isEmail ? this.isCheckedEmail = false : this.isCheckedEmail = true
                if (email.length === 0) this.isCheckedEmail = false
            },
            subscribe() {
                const email = this.$refs.subscribeEmail.value;
                const isEmail = EmailValidator.validate(email);
                if (!email.length) return showMessage('Пожалуйста, введете e-mail', false)
                if (!isEmail) return showMessage('Введенный e-mail не верный', false)
                if (this.isAjax) {
                    const url = '/api/email-subscription'
                    this.isAjax = false
                    this.inProgress = true
                    axios.post(url, { email }, {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    }).then(response => {
                        this.inProgress = false
                        this.$refs.subscribeEmail.value = ''
                        this.isAjax = true
                        return response.data.error ? showMessage(response.data.error, false) : showMessage(response.data.success)
                    })
                }
            }
        },
    }
</script>

<style lang="scss">
.subscribe-us {
    margin-top: 3rem;
    @include get-media($laptop, $desktop) {
        display: flow-root;
    }
    &_header {
        text-align: right;
        svg {
            height: 1.5rem;
            cursor: pointer;
        }
    }
    &_footer {
        text-align: center;
    }
    &_content {
        @include get-media($laptop, $desktop) {
            text-align: center;
        }
        .banner {
            max-width: 100%;
            padding-top: 0.5rem;
            @include get-media($laptop, $desktop) {
                max-width: 65%;
            }
        }
    }
    &_list {
        text-align: left;
        margin: 1rem 0;
    }
    &_item {
        background: url('/images/list-done.svg') no-repeat left center;
        margin: 1rem 0 ;
        padding-inline-start: 2rem;
    }
    &_actions {
        @include get-media($laptop, $desktop) {
            display: flex;
            align-items: center;
            margin: 0 auto;
            .btn {
                width: 45% !important;
                margin-left: 1em;
                margin-top: 0 !important;
            }
        }
        input {
            width: 100%;
            border: 1px solid $grey;
            border-radius: $btn-radius;
            padding: 10px;
            box-sizing: border-box;
            color: $main-color;
            transition: $transition;
            height: 3rem;
            @include get-media($laptop, $desktop) {
                width: 80%;
            }
        }
        @include button(100%);
        .btn {
            margin-top: 0.5em;
            display: flex;
            align-items: center;
            justify-content: center;
            svg {
                fill: white;
                margin-right: 0.5rem;
            }
        }
    }
    &_info {
        font-size: 0.75rem;
    }
}
</style>
