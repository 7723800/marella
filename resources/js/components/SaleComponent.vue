<template>
    <div v-if="items.length" class="sale">
        <div class="container">
            <div class="card-head">
                <div class="card-title">Sale</div>
            </div>
        </div>
        <swiper-component v-if="items.length" @wishlistHandler="wishlistHandler" :items="items"></swiper-component>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
    export default {
        components: {
            'swiper-component': () => import('./containers/_swiperComponent')
        },
        props: ['items'],
        methods: {
            ...mapActions(['setToWishlist']),
            wishlistHandler(item) {
                this.setToWishlist(item)
            }
        },
    }
</script>

<style lang="scss">
.sale {
    .swiper-button {
        top: -35px;
    }
}
</style>
