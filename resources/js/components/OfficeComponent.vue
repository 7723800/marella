<template>
    <div class="office-content">
        <div class="control-section"></div>
        <!-- desktop categories catalog start -->
        <catalog-component :catalog="data.catalog"></catalog-component>
        <!-- desktop categories catalog end -->

        <!--items start -->
            <items-grid-component :preloader="preloader" :items="office"></items-grid-component>
        <!-- items end-->
        <!-- desktop categories catalog end -->


        <!-- pagination start-->
        <paginate
            v-model="currentPage"
            :page-count="totalPages"
            :click-handler="paginateItems"
            :prev-text="'❮'"
            :next-text="'❯'"
            :page-class="'pagination-item'"
            :prev-class="'pagination-link'"
            :next-class="'pagination-link'"
            :container-class="'pagination'"
            v-if="totalPages > 1">
        </paginate>
        <!-- pagination end-->

        <!-- subscribe start -->
        <subscribe-component></subscribe-component>
        <!-- subscribe end -->

    </div>
</template>

<script>
import NProgress from 'nprogress'
import Paginate from 'vuejs-paginate'
import SmoothScroll from 'smooth-scroll';
import { mapState, mapActions } from 'vuex';

    export default {
        components: {
            Paginate,
            'items-grid-component': () => import('./containers/_itemsGridComponent'),
            'subscribe-component': () => import('./SubscribeComponent')
        },
        data() {
            return {
                office: Array,
                preloader: false,
                gridItems: Array,
                currentPage: 1,
                totalPages: 0,
                totalItems: 1,
            }
        },
        props: ['data'],
        created() {
            this.office = this.data.items;
        },
        mounted() {
            const dummyProducts = document.getElementById('dummy-products')
            dummyProducts.remove();
            this.countPages(this.data.paginate)
            this.currentPage = parseInt(this.$route.query.page);
            },
        methods: {
            ...mapActions(['setToWishlist']),
            setWishlist(item) {
                item.isWishlist = !item.isWishlist
                this.setToWishlist(item)
            },
            countPages(paginate) {
                this.totalPages = Math.ceil(paginate.total / paginate.perPage)
                this.totalItems = paginate.total
            },
            paginateItems() {
                let url, page
                page = this.currentPage > 1 ? `?page=${this.currentPage}` : ''
                url = this.$route.path + page
                NProgress.start()
                this.preloader = true
                this.scrollToTop()
                axios.get(`/api${url}`)
                    .then(response => {
                        this.sets = response.data.items
                        this.$router.replace(url)
                    }).then(() => {
                        this.preloader = false
                        NProgress.done()
                    })
            },
            scrollToTop() {
                const scroll = new SmoothScroll();
			    scroll.animateScroll(0, null, {
                    speed: 200
                });
            },
        }
    }
</script>

<style lang="scss">
.office {
    display: flow-root;
   &-content {
       .catalog {
            margin-top: 0;
        }
   }
}
</style>
