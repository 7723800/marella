<template>
    <div class="sets-content">
        <div class="control-section"></div>
        <!-- desktop categories catalog start -->
        <catalog-component :catalog="data.catalog"></catalog-component>
        <!-- desktop categories catalog end -->
        <!-- items start -->
        <items-grid-component :items="data.items"></items-grid-component>
        <!-- items end-->

        <!-- subscribe start -->
        <subscribe-component></subscribe-component>
        <!-- subscribe end -->

    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';

    export default {
        components: {
            'items-grid-component': () => import('./containers/_itemsGridComponent'),
            'subscribe-component': () => import('./SubscribeComponent')
        },
        data() {
            return {
                gridItems: Array,
            }
        },
        props: ['data'],
        mounted() {
            const dummyProducts = document.getElementById('dummy-products')
            dummyProducts.remove();
        },
        methods: {
            ...mapActions(['setToWishlist']),
            setWishlist(item) {
                item.isWishlist = !item.isWishlist
                this.setToWishlist(item)
            },
        }
    }
</script>

<style lang="scss">
.perfume {
    display: flow-root;
    &-breadcrumbs {
        @include breadCrumbs;
    }
    &-icon-nav {
        svg {
            width: 20px;
            height: 20px;
        }
    }
   .product-card__wishes {
        @include get-media($laptop, $desktop) {
            width: 17%;
            height: 12%;;
        }
    }
}
</style>
