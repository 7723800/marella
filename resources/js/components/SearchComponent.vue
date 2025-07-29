<template>
    <div class="container">
        <div class="search">
            <a href="/">
                <div class="search-breadcrumbs">
                    <div class="backward">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 7.4 12" style="enable-background:new 0 0 7.4 12;" xml:space="preserve"><path d="M0,10.6L4.6,6L0,1.4L1.4,0l6,6l-6,6L0,10.6z"/></svg>
                    </div>
                    <div class="title">{{ data.page.title }}</div>
                </div>
            </a>
        </div>
        <div class="control-section">
            <div class="navigation">
                <div v-if="$route.query.phrase" class="text">{{ activeSubcategory.name }}</div>
            </div>

             <filter-component ref="filter"
                :colors="colors"
                :sizes="sizes"
                :brands="brands"
                :seasons="seasons"
                :dataPrice="data.price"
                :isGendersItems="data.isGendersItems"
                :totalItems="totalItems"
                :isEmptyItems="isEmptyItems"
                @sortFilterItems="sortFilterItems"
                @toggleFilterGender="toggleFilterGender"
                ></filter-component>

        </div>
        <div class="search-content">
            <search-input-component @keywordClick="getItems"></search-input-component>
            <!-- desktop categories catalog start -->
            <catalog-component :catalog="data.catalog"></catalog-component>
            <!-- desktop categories catalog end -->
            <items-grid-component :preloader="preloader" :items="gridItems"></items-grid-component>

            <!-- pagination start-->
            <paginate v-show="totalItems > data.paginate.perPage && $route.query.phrase"
                v-model="currentPage"
                :page-count="totalPages"
                :click-handler="paginateItems"
                :prev-text="'❮'"
                :next-text="'❯'"
                :page-class="'pagination-item'"
                :prev-class="'pagination-link'"
                :next-class="'pagination-link'"
                :container-class="'pagination'">
            </paginate>
            <!-- pagination end-->
        </div>
    </div>
</template>

<script>
import NProgress from 'nprogress'
import Paginate from 'vuejs-paginate'
import { EventBus } from '../event-bus'
import SmoothScroll from 'smooth-scroll';

    export default {
        components: {
            'items-grid-component': () => import('./containers/_itemsGridComponent'),
            'search-input-component': () => import('./containers/_searchInputComponent'),
            'filter-component': () => import('./containers/_filterComponent'),
             Paginate,
        },
        data() {
            return {
                gridItems: Array,
                colors: Array,
                sizes: Array,
                brands: Array,
                seasons: Array,
                isEmptyItems: false,
                activeSubcategory: Object,
                preloader: false,
                currentPage: 1,
                totalPages: 0,
                totalItems: 0
            }
        },
        props: ['data'],
        created() {
            this.gridItems = this.data.items
            this.colors = this.data.colors
            this.brands = this.data.brands
            this.seasons = this.data.seasons
            this.sizes = this.data.sizes
            this.activeSubcategory = this.data.subcategory
        },
        mounted() {
            this.countPages(this.data.paginate)
            this.currentPage = parseInt(this.$route.query.page);
            },
        methods: {
            getItems(keyword) {
                const currentPath = this.$route.fullPath.replace(/,/g,'%2C')
                const category = this.$route.query.c ? `&c=${this.$route.query.c}` :''
                const fullPath = `${this.$route.path}?phrase=${encodeURIComponent(keyword)}` + category
                NProgress.start()
                this.preloader = true
                axios.get(`/api${fullPath}`)
                    .then(response => {
                        this.gridItems = []
                        this.colors = response.data.colors
                        this.brands = response.data.brands
                        this.seasons = response.data.seasons
                        this.sizes = response.data.sizes
                        this.activeSubcategory = response.data.subcategory
                        EventBus.$emit('setGendersSelector', response.data.isGendersItems);
                        this.countPages(response.data.paginate)
                        this.$refs.filter.setPriceValues(response.data.price)

                        setTimeout(() => {
                            this.gridItems = response.data.items
                            this.$refs.filter.setDataFromQuery()
                            NProgress.done()
                            this.preloader = false
                        }, 200);

                        if (currentPath !== fullPath) this.$router.replace(fullPath)
                    })
            },
            sortFilterItems(filterModal, id) {
                let path, fullPath, currentPath, isGender
                const phrase = this.$route.query.phrase ? `phrase=${this.$route.query.phrase}` : ''
                this.preloader = true
                NProgress.start()
                isGender = id ? `&c=${id}` : ''
                path = `${this.$route.path}?` + phrase + isGender
                fullPath = path + this.$refs.filter.getQueryString()
                currentPath = this.$route.fullPath.replace(/,/g,'%2C')
                axios.get(`/api${fullPath}`)
                    .then(response => {
                        this.preloader = false
                        if (response.data.length !== 0)
                        {
                            EventBus.$emit('setIsEmptyItems', false);
                            this.gridItems = response.data.items
                            this.colors = response.data.colors
                            this.sizes = response.data.sizes
                            this.brands = response.data.brands
                            this.seasons = response.data.seasons
                            this.$refs.filter.setPriceValues(response.data.price)
                            this.countPages(response.data.paginate)
                            this.currentPage = 1

                            if (currentPath !== fullPath) this.$router.replace(fullPath)

                        } else EventBus.$emit('setIsEmptyItems', true);

                        if (filterModal) this.$refs.filter.reverseFilterModal(filterModal)
                        this.$refs.filter.setDataFromQuery()
                        NProgress.done()
                    })

            },
            toggleFilterGender(id, slug) {
                EventBus.$emit('setGenderID', id);
                this.$refs.filter.filtersResetAll(false)
                this.sortFilterItems(null, id)
            },
            countPages(paginate) {
                this.totalPages = Math.ceil(paginate.total / paginate.perPage)
                this.totalItems = paginate.total
            },
            paginateItems() {
                let url, page, fullPath
                url = `${this.$route.path}?phrase=${this.$route.query.phrase}`
                page = this.currentPage > 1 ? `&page=${this.currentPage}` : ''
                fullPath = url + this.$refs.filter.getQueryString() + page
                NProgress.start()
                this.preloader = true
                this.scrollToTop()
                axios.get(`/api${fullPath}`)
                    .then(response => {
                        this.gridItems = response.data.items
                        this.$router.replace(fullPath)
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
.search {
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
    &-input {
        &__actions {
            margin-bottom: 10px;
        }
    }
    &-content {
        @include get-media($laptop, $desktop) {
            .product-card__grid {
                width: 75%;
            }
            display: flow-root;
        }
    }
}
</style>
