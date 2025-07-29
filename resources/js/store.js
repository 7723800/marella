import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
        items: [],
        wishlist: [],
        visited: [],
        returnPath: '',
        customer: {},
        isUpdateBasket: true
  },
  plugins: [
        createPersistedState({
            paths: ['items', 'wishlist', 'customer'],
     }),
        createPersistedState({
            paths: ['visited', 'returnPath', 'isUpdateBasket'],
            storage: window.sessionStorage
        })
    ],
  mutations: {
    addToCart(state, item) {
        const isItemInCart = state.items.find(goods => goods.key === item.key)
        isItemInCart ? isItemInCart.inCart ++ : state.items.push(item)
    },
    updateItemInCart(state, params) {
        const itemInCart = state.items.find(goods => goods.key === params.key)
        itemInCart.inCart = params.value
    },
    removeFromCart(state, key) {
        const itemIndex = state.items.map(goods => goods.key).indexOf(key)
        state.items.splice(itemIndex, 1);
    },
    addToWishlist(state, item) {
        state.wishlist.push(item);
    },
    setCustomerData(state, data) {
        state.customer = data;
    },
    addToVisited(state, item) {
        state.visited.unshift(item);
    },
    removeFromWishlist(state, index) {
        state.wishlist.splice(index, 1);
    },
    setReturnPath(state, path) {
        state.returnPath = path
    },
    clearCart(state) {
        state.items = []
    },
    UPDATE_WISHLIST(state, payload) {
        state.wishlist = payload
    },
    SET_BASKET(state, payload) {
        let items = []
        payload.map(item => {
            const product = state.items.find(product => product.id == item.id)
            if (product) {
                item.inCart = product.inCart
                item.key = product.key
                const selectedSize = product.sizes.find(size => size.isSelected == true)
                for (const size of item.sizes) {
                    if (size.id == selectedSize.id) {
                        size.isSelected = true
                        items.push(item)
                    }
                }
            };
        });
        state.items = items
        state.isUpdateBasket = false
    }
  },
  actions: {
    addToCart(context, item) {
        const clone = _.cloneDeep(item, true) //remove reactivity
        clone.inCart ++
        context.commit('addToCart', clone);
    },
    addToVisited(context, item) {
        const isItemInVisited = context.state.visited.find(goods => goods.id === item.id)
        if (!isItemInVisited) context.commit('addToVisited', item);
    },
    setToWishlist(context, item) {
        const isWishlist = context.state.wishlist.find(wishes => wishes.id === item.id);
        if (isWishlist) {
            const index = context.state.wishlist.indexOf(isWishlist)
            context.commit('removeFromWishlist', index)
        } else context.commit('addToWishlist', item)
    },
    setReturnPath(context, path) {
        let url, searchParams, category, items, search
        url = new URL(path)
        searchParams = new URLSearchParams(url.search)
        category = searchParams.has('c')
        items = searchParams.has('items')
        search = searchParams.has('phrase')
        if (category && items || search) context.commit('setReturnPath', path)
    },
    updateWishlist({ commit, state }) {
        if (!state.wishlist.length) return false
        let ids = []
        state.wishlist.map(item => {
            ids.push(item.id)
        })
        axios.get(`/api/v2/wishlist?ids=${JSON.stringify(ids)}`)
        .then(response => {
            commit('UPDATE_WISHLIST', response.data)
        })
        .catch(error => console.log(error))
    },
    updateBasket({ commit, state }) {
        if (!state.items.length || !state.isUpdateBasket) return false
        let ids = []
        state.items.map(item => {
            ids.push(item.id)
        })
        axios.get(`/api/v2/basket?ids=${JSON.stringify(ids)}`)
        .then(response => {
            commit('SET_BASKET', response.data)
        })
        .catch(error => console.log(error))
    }
  }
})
