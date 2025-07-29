<template>
<div class="items-edit">
    <transition name="fade">
        <div v-if="isRemoveDialog" @click.self="isRemoveDialog = false" class="dialog-is-remove">
            <div class="container">
                <div class="dialog-content">
                    <div @click="isRemoveDialog = false" class="dialog-content__close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 20"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg>
                    </div>
                    <div class="dialog-content__text">
                        <p>Вы действительно хотите удалить данный товар?</p>
                    </div>
                    <div class="dialog-content__action">
                        <button @click="deleteItem" class="btn continue">Да</button>
                        <button @click="isRemoveDialog = false" class="btn">Отмена</button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    <transition-group name="fade-left" tag="ul" class="items-edit__list">
        <li v-for="item in items" :key="item.key" class="items-edit__item">
            <div :ref="`info${item.key}`" class="item-info">
                <a :href="item.url" class="item-image">
                    <img :src="item.images[0].url">
                </a>
                <div class="item-content">
                    <div class="item-content__title">{{ item.name }}</div>
                    <div class="item-content__wrapper">
                        <div class="item-content__size"><span class="item-content__label">{{ item.perfume ? 'Объем' : 'Размер' }}:</span>{{ selectedSize(item.sizes) }}</div>
                        <div class="item-content__color">
                            <span>Цвет:</span>
                            <img v-if="item.color" :src="item.color.imageUrl">
                            <span v-else>&nbsp;&mdash;</span>
                        </div>
                        <div class="item-content__price">
                            <div class="item-content__label">Цена:</div>
                            <div v-if="item.price != item.finalPrice" class="item-content__price-main">{{ item.price.toLocaleString('ru-RU') }} ₸</div>
                            <div v-if="item.price == item.finalPrice">{{ item.price.toLocaleString('ru-RU') }} ₸</div>
                            <div v-if="item.price != item.finalPrice" class="item-content__price-final">{{ item.finalPrice.toLocaleString('ru-RU') }} ₸</div>
                        </div>
                        <div class="item-content__in-cart">
                            <vue-numeric-input v-model="item.inCart" :align="'center'" :size="'70%'" :min="1" :max="10" :step="1" @change="updateItemInCart({ value: $event, key: item.key })"></vue-numeric-input>
                            <span class="qty">шт.</span>
                        </div>
                    </div>
                </div>
                <div class="item-actions">
                    <div @click="deleteDialog(item.key)" class="item-edit__delete">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 42"><path fill-rule="evenodd" d="M0 4h34v10H0V4zm2 2h30v6H2V6zm1 6h28v30H3V12zm2 2h24v26H5V14zm5-14h13v6H10V0zm2 2h9v2h-9V2zM9 18h2v18H9V18zm7 0h2v18h-2V18zm7 0h2v18h-2V18z"/><path d="M0 12h34v2H0zM0 4h34v2H0z"/></svg>
                    </div>
                </div>
            </div>
        </li>
    </transition-group>
</div>
</template>

<script>
import VueNumericInput from 'vue-numeric-input';
import Vue2TouchEvents from 'vue2-touch-events';
import { mapState, mapMutations } from 'vuex';
    export default {
        data() {
            return {
                isRemoveDialog: false,
                itemKeyToDelete: null
            }
        },
        components: {
            VueNumericInput,
            Vue2TouchEvents
        },
        mounted() {
            const inputNumeric = document.querySelector('.numeric-input')
            if (inputNumeric) inputNumeric.setAttribute('readonly', true);
        },
        methods: {
            ...mapMutations(['updateItemInCart', 'removeFromCart']),
            selectedSize(sizes) {
                let selectedSize = ''
                sizes.map(size => {
                    size.isSelected ? selectedSize = size.value : ''
                })
                return selectedSize
            },
            // updateItemQty(value, key) {
            //     this.updateItemInCart({ value, key })
            // },
            deleteDialog(key) {
                this.isRemoveDialog = true;
                this.itemKeyToDelete = key;
            },
            deleteItem() {
                this.removeFromCart(this.itemKeyToDelete);
                this.isRemoveDialog = false;
            }
        },
        computed: {
            ...mapState(['items']),
        }
    }
</script>

<style lang="scss">
@mixin slideTransition {
    transition: left 0.3s cubic-bezier(0.645, 0.045, 0.355, 1);
}
@mixin itemIcon {
    display: block;
    width: 15px;
    height: 1px;
    margin: 0 auto;
    background: $grey;
    position: absolute;
    left: 30%;
    top: 50%;
    &::before {
        content: '';
        position: absolute;
        width: 15px;
        height: 1px;
        background: $grey;
        top: -4px
    }
    &::after{
        content: '';
        position: absolute;
        width: 15px;
        height: 1px;
        background: $grey;
        bottom: -4px
    }
}
.items {
    &-edit {
        &__list {
            overflow-x: hidden;
        }
        &__item {
            display: flex;
            border-bottom: 1px solid $line-color;
            justify-content: space-between;
            position: relative;
            flex-wrap: wrap;
            .is {
                &-info {
                    left: -88% !important;
                }
                &-edit {
                    left: 12% !important;

                }
            }
            .item {
                &-image {
                    display: flex;
                    align-items: center;
                    margin: 1px 0;
                    img {
                        @include get-media($mobile) {
                            width: 30vw;
                        }
                    }
                }
                &-info {
                    display: flex;
                    position: relative;
                    width: 100%;
                    left: 0;
                    @include slideTransition;
                }
                &-content {
                    display: flex;
                    flex-direction: column;
                    justify-content: space-around;
                    font-size: 90%;
                    margin-left: 3%;
                    width: 55%;
                    padding: 5px 0;
                    &__title {
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        margin-bottom: 11px;
                    }
                    &__label {
                        margin-right: 10px;
                    }
                    &__price {
                        display: flex;
                        &-main {
                            color: $grey;
                            position: relative;
                            &::after {
                                position: absolute;
                                left: 0;
                                top: 40%;
                                content: "";
                                height: 1px;
                                width: 100%;
                                background: $grey;
                            }
                        }
                        &-final {
                            color: $red;
                            margin-left: 8px;
                        }
                    }
                    &__wrapper {
                        display: flex;
                        flex-direction: column;
                        height: 100%;
                        justify-content: space-between;
                        @include get-media($laptop, $desktop) {
                            .item-content__size {
                                min-width: 180px;
                            }
                            .item-content__color{
                                width: 80px;
                            }
                        }
                    }
                    &__in-cart {
                        display: flex;
                        font-size: 110%;
                        align-items: center;
                        input {
                            cursor: default;
                            border-radius: 5px;
                            color: $grey;
                            caret-color: transparent;
                        }
                        .vue-numeric-input {
                            .numeric-input {
                                border-color: $line-color;
                            }
                            .btn {
                                background: none;
                                box-shadow: none;
                                border: none;
                                &-icon {
                                    cursor: pointer;
                                    &:before, &::after{
                                        background-color: $grey;
                                    }
                                }
                                &-increment {
                                    right: 10px;
                                    .btn-icon {
                                        &::after {
                                            height: 37%;
                                             @include get-media($laptop, $desktop) {
                                                height: 27%;
                                            }
                                        }
                                    }
                                }
                                &-decrement {
                                    left: 10px;
                                }
                                &-increment, &-decrement {
                                    top: 5px;
                                    bottom: 5px;
                                }
                            }
                        }
                        .qty {
                            margin-left: 15px;
                        }
                    }
                    &__color {
                        display: flex;
                        align-items: center;
                        height: 1.5rem;
                        img {
                            width: 21px;
                            margin: 0 10px;
                        }
                    }
                    &__title {
                        margin-right: 5px;
                    }
                }
                &-actions {
                    width: 40px;
                }
                &-edit {
                    &__delete {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        cursor: pointer;
                        svg {
                            width: 18px;
                            height: 18px;
                            fill: $grey;
                        }
                        height: 100%;
                    }
                }
            }
        }
        .dialog {
            &-is-remove {
                @include dialog;
            }
            &-content {
                @include dialogContent;
                &__action {
                    text-align: center;
                    .btn {
                        width: 40%;
                    }
                }
            }
        }
    }
}
.fade-left-enter-active, .fade-left-leave-active {
	transition: all .5s ease;
}
.fade-left-enter, .fade-left-leave-to {
	transform: translateX(-15px);
	opacity: 0;
}
</style>
