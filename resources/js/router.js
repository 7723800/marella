import Vue from 'vue'
import Router from 'vue-router';

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/search',
            name: 'search',
        },
        {
            path: '/catalog/:category/:subcategory/:id',
            name: 'product',
        },
        {
            path: '/catalog/sets',
            name: 'sets',
        },
        {
            path: '/catalog',
            name: 'catalog',
        },
        {
            path: '/catalog/perfume',
            name: 'perfume',
        },
        {
            path: '/giftcards',
            name: 'giftcards',
        },
    ]
})
