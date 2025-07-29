<template>
<span></span>
</template>

<script>
import { mapMutations } from 'vuex';
    export default {
        created() {
            this.clearCart()
        },
        methods: {
            ...mapMutations(['clearCart'])
        },
    }
</script>
