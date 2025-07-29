/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// require('../sass/fake.scss'); //resolve issue vue async import component
require('./plugins');

import Vue from 'vue';
import store from './store';
import router from './router';
import Vue2TouchEvents from 'vue2-touch-events'
import VueLazyload from 'vue-lazyload'
// import * as Sentry from '@sentry/browser';
// import { Vue as VueIntegration } from '@sentry/integrations';
import VueScrollactive from 'vue-scrollactive';

Vue.use(VueScrollactive);

Vue.use(VueLazyload, {
    preLoad: 1.3,
    loading: '/images/image-loader.svg',
    attempt: 1
  })

// Sentry.init({
//     dsn: 'https://1c46d5d82b0144bc92a81fd1895b5d3c@o384489.ingest.sentry.io/5216323',
//     integrations: [new VueIntegration({Vue, attachProps: true, logErrors: true })],
//     environment: process.env.NODE_ENV,
//     ignoreErrors: ['ResizeObserver loop limit exceeded', 'e.focus is not a function'],
// });
// NProgress.configure({ easing: 'ease', speed: 8500});

Vue.use(Vue2TouchEvents, {
    swipeTolerance: 50,
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// Vue.component('jobs', () => import('./pages/employer/jobs/Index.vue'));

Vue.component('category-component', () => import('./components/CategoryComponent.vue'));
Vue.component('item-component', () => import('./components/ItemComponent.vue'));
Vue.component('basket-component', () => import('./components/BasketComponent.vue'));
Vue.component('cart-component', () => import('./components/CartComponent.vue'));
Vue.component('wishes-component', () => import('./components/WishesComponent.vue'));
Vue.component('sale-component', () => import('./components/SaleComponent.vue'));
Vue.component('catalog-component', () => import('./components/CatalogComponent.vue'));
Vue.component('search-component', () => import('./components/SearchComponent.vue'));
Vue.component('my-component', () => import('./components/MyComponent.vue'));
Vue.component('sets-component', () => import('./components/SetsComponent.vue'));
Vue.component('new-on-week-component', () => import('./components/NewOnWeekComponent.vue'));
Vue.component('subscribe-component', () => import('./components/SubscribeComponent.vue'));
Vue.component('y-map', () => import('./components/YandexMapComponent.vue'));
Vue.component('perfume-component', () => import('./components/PerfumeComponent.vue'));
Vue.component('giftcard-component', () => import('./components/GiftcardComponent.vue'));
Vue.component('order-confirm-component', () => import('./components/OrderConfirmComponent.vue'));
Vue.component('home-blog', () => import('./components/HomeBlogComponent.vue'));
Vue.component('office-component', () => import('./components/OfficeComponent.vue'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store
});
