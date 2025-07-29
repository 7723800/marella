<template>
    <div class="category-inner">
        <div class="control-section">
            <div @click="revealSubcategories" class="navigation">
                <div class="text">{{ activeSubcategory.name }}</div>
                <div class="icon-nav" :class="{'is-reveal': isReveal}">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 7.4 12" style="enable-background:new 0 0 7.4 12;" xml:space="preserve"><path d="M0,10.6L4.6,6L0,1.4L1.4,0l6,6l-6,6L0,10.6z"/></svg>
                </div>
            </div>

            <filter-component ref="filter"
                :colors="colors"
                :sizes="sizes"
                :brands="brands"
                :seasons="seasons"
                :branches="branches"
                :dataPrice="data.price"
                :totalItems="totalItems"
                @sortFilterItems="sortFilterItems"
                @toggleFilterGender="toggleFilterGender"
            ></filter-component>
        </div>

        <!-- subcategories start -->
        <div ref="subCategoriesPanel" class="subcategories">
            <ul class="subcategories-list">
                <li v-for="subcategory in data.subcategories" :key="subcategory.id" class="subcategories-item">
                    <div class="subcategories-item-title" @click="setSubcategory(subcategory)">
                        <span>{{ subcategory.name }}</span>
                        <svg v-if="activeSubcategory.slug == subcategory.slug" class="is-subcategory" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    </div>
                    <ul v-if="subcategory.second_subcategories.length">
                        <li v-for="secondSubcategory in subcategory.second_subcategories" :key="secondSubcategory.id" class="subcategories-item">
                            <div class="subcategories-item-title subcategories-item-title__subtitem" @click="setSubcategory(secondSubcategory)">
                                <span>{{ secondSubcategory.name }}</span>
                                <svg v-if="activeSubcategory.slug == secondSubcategory.slug" class="is-subcategory" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- subcategories end-->

        <div class="category-holder">
            <!-- desktop categories catalog start -->
            <catalog-component :catalog="data.catalog"></catalog-component>
            <!-- desktop categories catalog end -->

            <!-- items start -->
            <items-grid-component :preloader="preloader" :items="gridItems"></items-grid-component>
            <!-- items end-->
        </div>

        <!-- pagination start-->
        <paginate v-show="totalItems > data.paginate.perPage"
            v-model="currentPage"
            :page-count="totalPages"
            :click-handler="paginateItems"
            :prev-text="'❮'"
            :next-text="'❯'"
            :page-class="'pagination-item'"
            :prev-class="'pagination-link'"
            :next-class="'pagination-link'"
            :container-class="'pagination'"
        </paginate>
            <!-- pagination end-->

        <!-- subscribe start -->
        <subscribe-component></subscribe-component>
        <!-- subscribe end -->
    </div>
</template>

<script>
import SmoothScroll from 'smooth-scroll';
import { disableBodyScroll, enableBodyScroll, clearAllBodyScrollLocks } from 'body-scroll-lock';
import axios from 'axios';
import NProgress from 'nprogress';
import Paginate from 'vuejs-paginate'
import { EventBus } from '../event-bus.js'

    export default {
        components: {
            Paginate,
            'items-grid-component': () => import('./containers/_itemsGridComponent'),
            'filter-component': () => import('./containers/_filterComponent'),
            'subscribe-component': () => import('./SubscribeComponent')
        },
        data() {
            return {
                gridItems: Array,
                colors: Array,
                sizes: Array,
                brands: Array,
                seasons: Array,
                branches: Array,
                isReveal: false,
                activeSubcategory: Object,
                preloader: false,
                currentPage: 1,
                totalPages: 0,
                totalItems: 0,
            }
        },
        props: ['data'],
        created() {
            this.gridItems = this.data.items
            this.colors = this.data.colors
            this.sizes = this.data.sizes
            this.brands = this.data.brands
            this.seasons = this.data.seasons
            this.branches = this.data.branches
            this.setActiveSubcategory(this.$route.query.items)
        },
        beforeMount() {
            if (this.$route.query.page) this.currentPage = parseInt(this.$route.query.page)
        },
        mounted() {
            const dummyProducts = document.getElementById('dummy-products')
            dummyProducts.remove();
            this.countPages(this.data.paginate)
            console.log(this.data.branches)
        },
        methods: {
            revealSubcategories() {
                let panel = this.$refs.subCategoriesPanel
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null
                    this.isReveal = false
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                    this.isReveal = true
                }
            },
            setSubcategory(category) {
                let panel = this.$refs.subCategoriesPanel
                panel.style.maxHeight = null
                this.activeSubcategory = category
                this.getCategoryItems(category.category_id, category.slug)
                this.isReveal = false
                this.scrollToTop()
            },
            getCategoryItems(id, slug) {
                let url, fullPath
                const priceMin = this.$route.query.price_min
                const priceMax = this.$route.query.price_max
                url = `${this.$route.path}?c=${id}&items=${slug}`
                url += this.$route.query.sale ? `&sale=${this.$route.query.sale}` : ""
                fullPath = url + this.$refs.filter.getQueryString()
                this.preloader = true
                NProgress.start()
                axios.get(`/api${fullPath}`)
                    .then(response => {
                        if (response.data.length === 0 && this.$route.query.sale === null) {
                            return Promise.resolve(this.$refs.filter.filtersResetAll(false)).then(this.getCategoryItems(id, slug))
                        } else if ((response.data.length === 0 && this.$route.query.sale) ) {
                            return Promise.resolve(this.$refs.filter.filtersResetAll(false)).then(
                                this.setSubcategory({
                                "category_id": "1",
                                "id": 0,
                                "name": "Все товары",
                                "slug": "all"
                            })
                        )
                        }
                        this.gridItems = []
                        this.colors = response.data.colors
                        this.sizes = response.data.sizes
                        this.brands = response.data.brands
                        this.seasons = response.data.seasons
                        this.countPages(response.data.paginate)
                        this.$refs.filter.setPriceValues(response.data.price)
                        if ((priceMax > response.data.price.max && priceMin < response.data.price.min) || priceMin < response.data.price.min || priceMax > response.data.price.max) {
                            this.$refs.filter.setRangeValues(response.data.price.min, response.data.price.max)
                            fullPath = url + this.$refs.filter.getQueryString()
                        }
                        if (this.$route.fullPath !== fullPath) this.$router.replace(fullPath)
                        this.$refs.filter.setDataFromQuery()
                        return response.data.items
                    }).then(items => {
                        if (items) {
                            this.gridItems = items
                            this.currentPage = 1
                            NProgress.done()
                            this.preloader = false
                        }
                    })
            },
            sortFilterItems(filterModal) {
                let path, fullPath, currentPath
                path = `${this.$route.path}?c=${this.activeSubcategory.category_id}&items=${this.activeSubcategory.slug}`
                path += this.$route.query.sale ? `&sale=${this.$route.query.sale}` : ""
                fullPath = path + this.$refs.filter.getQueryString()
                currentPath = this.$route.fullPath.replace(/,/g,'%2C')
                this.preloader = true
                NProgress.start()
                axios.get(`/api${fullPath}`)
                    .then(response => {
                        if (response.data.length === 0) return EventBus.$emit('setIsEmptyItems', true);
                        EventBus.$emit('setIsEmptyItems', false);
                        this.gridItems = response.data.items
                        this.colors = response.data.colors
                        this.sizes = response.data.sizes
                        this.brands = response.data.brands
                        this.seasons = response.data.seasons
                        this.countPages(response.data.paginate)
                        if (currentPath !== fullPath) this.$router.replace(fullPath)
                        if (filterModal) this.$refs.filter.reverseFilterModal(filterModal)
                    }).then(() => {
                        this.currentPage = 1
                        NProgress.done()
                        this.preloader = false
                    })
            },
            setActiveSubcategory(slug) {
                this.data.subcategories.map(category => {
                    if (category.slug === slug) return this.activeSubcategory = category
                    category.second_subcategories.forEach(nestedCategory => {
                        if (nestedCategory.slug === slug) return this.activeSubcategory = nestedCategory
                    });
                })
            },
            scrollToTop() {
                const scroll = new SmoothScroll();
			    scroll.animateScroll(0, null, {
                    speed: 200,
                    speedAsDuration: true
                });
            },
            paginateItems() {
                let url, page, fullPath
                url = `${this.$route.path}?c=${this.activeSubcategory.category_id}&items=${this.activeSubcategory.slug}`
                url += this.$route.query.sale ? `&sale=${this.$route.query.sale}` : ""
                page = this.currentPage > 1 ? `&page=${this.currentPage}` : ''
                fullPath = url + this.$refs.filter.getQueryString() + page
                console.log(fullPath);
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
            countPages(paginate) {
                this.totalPages = Math.ceil(paginate.total / paginate.perPage)
                this.totalItems = paginate.total
            },
            toggleFilterGender(id, slug, activeGenderID) {
                if (activeGenderID !== id) {
                    EventBus.$emit('setGenderID', id);
                    this.$refs.filter.filtersResetAll(false)
                    NProgress.start()
                    this.preloader = true
                    this.scrollToTop()
                    const url = `${slug}?c=${id}&items=all${this.$refs.filter.getQueryString()}`
                    axios.get(`/api/catalog/${url}`)
                        .then(response => {
                            this.gridItems = response.data.items
                            this.colors = response.data.colors
                            this.sizes = response.data.sizes
                            this.brands = response.data.brands
                            this.seasons = response.data.seasons
                            this.data.subcategories = response.data.subcategories
                            this.data.page = response.data.page
                            this.setActiveSubcategory('all')
                            this.countPages(response.data.paginate)
                            this.$router.replace(url)
                        }).then(() => {
                            this.currentPage = 1
                            this.preloader = false
                            NProgress.done()
                        })
                }
            }
        }
    }
</script>

<style lang="scss">
@mixin filterModal {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    transform: translateX(105%);
    z-index: 105;
    box-shadow: 0px 0px 5px 0px $grey;
}
.category {
    &-overlay {
       @include overlay;
    }
    &-inner {
        margin-bottom: 5rem;
    }
    &__filters {
        align-items: center;
        .container {
            display: flex;
            align-items: center;
            .isFilters {
                width: 10px;
                height: 10px;
                background:$red;
                border-radius: 5px;
                margin-right: 5px;
            }
            .icon-filter {
                margin-top: 3px;
            }
        }
    }
    .subcategories {
        max-height: 0;
        overflow: hidden;
        margin: 0 -1em;
        &-list {
            width: 100vw;
            & > li:last-child {
                    border-bottom: 1px solid $line-color;
                }
        }
        &-item {
            border-top: 1px solid $line-color;
            align-items: center;
            &-title {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0 1rem;
                height: 50px;
                &__subtitem {
                    padding-left: 2rem
                }
            }
        }
    }
    &-holder {
        @include get-media($laptop, $desktop) {
            display: flow-root;
        }
    }
    .segment {
        &-control {
            display: flex;
            align-items: center;
            font-family: SegoeUI;
            font-size: 80%;
            width: 52vw;
            @include button;
            .btn {
                padding: 8px 0;
                background: transparent;
                color: $main-color;
                border: 1px solid $line-color;
            }
            .left {
                border-right: transparent;
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
            }
            .right {
                border-left: transparent;
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }
            .is-active {
                background: $donato-color;
                color: white;
                border-color: $donato-color;
            }
        }
    }
    .product-card__wishes {
        @include get-media($laptop, $desktop) {
            width: 23%; // 17%
            height: 17%; // 12%;
        }
    }
}
// filter modal fade
.bottom-fade-enter-active, .bottom-fade-leave-active {
    transition: all 0.35s ease;
}
.bottom-fade-enter, .bottom-fade-leave-to {
    transform: translateY(100%);
}
</style>
