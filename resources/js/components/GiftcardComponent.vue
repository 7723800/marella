<template>
    <div class="giftcard-content">
        <div class="control-section"></div>
        <!-- desktop categories catalog start -->
        <catalog-component :catalog="data.catalog"></catalog-component>
        <!-- desktop categories catalog end -->
        <!-- items start -->
        <items-grid-component :items="gridItems"></items-grid-component>
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
        created() {
            this.gridItems = this.data.items;
        },
        mounted() {
            const dummyProducts = document.getElementById('dummy-products')
            dummyProducts.remove();
            // console.log(this.data);
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
.giftcard {
    &-content {
        display: flow-root;
    }
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
