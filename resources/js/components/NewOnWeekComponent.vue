<template>
    <div v-if="items.length" class="new-on-week">
        <div class="container">
            <div class="card-head">
                <div class="card-title">Новое на этой неделе</div>
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
.new-on-week{
    .swiper-button {
        top: -35px;
    }
}
</style>
