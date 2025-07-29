<template>
    <div class="search-input">
        <!-- <div class="container"> -->
            <div class="search-input__actions">
                <input :class="{ 'in-focus': keywords.length > 0 && isKeywordsList }" ref="searchInput" @input="getKeywords" type="text" placeholder="Введите..." v-model="phrase">
                <div class="search-input__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg>
                </div>
                <transition name="fade">
                    <div v-show="phrase.length" @click="eraseInput" class="search-input__delete">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                    </div>
                </transition>
            </div>
            <div class="search-input__list">
                <ul v-show="isKeywordsList" class="search-input__keywords">
                    <li v-for="keyword in keywords" :key="keyword.id" @click="keywordClickHandler(keyword.name)">
                        <span v-html="highlightChar(keyword.name)"></span>
                        <svg class="svgIcon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z"/></svg>
                    </li>
                    <li v-show="isEmptyKeywords">Ничего не найдено</li>
                </ul>
            </div>
        <!-- </div> -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                keywords: [],
                phrase: '',
                isEmptyKeywords: false,
                isKeywordsList: true,
            }
        },
        mounted() {
            if (this.$route.query.phrase) this.phrase = this.$route.query.phrase
        },
        methods: {
            getKeywords() {
                this.isKeywordsList = true
                const category = this.$route.query.c ? `&c=${this.$route.query.c}` :''
                if (this.phrase.length > 2) {
                    const path = `/api/search-keywords?phrase=${encodeURIComponent(this.phrase)}` + category
                    axios.get(path)
                        .then(response => {
                            this.keywords = response.data
                        })
                }
                if (this.phrase == '') this.keywords = []
            },
            highlightChar(name) {
                const highlight = name.replace(new RegExp(this.phrase, 'ig'), `<b>${this.phrase.toLowerCase()}</b>`)
                return highlight
            },
            keywordClickHandler(keyword) {
                this.phrase = keyword
                this.isKeywordsList = false
                this.$emit('keywordClick', keyword)
            },
            eraseInput() {
                this.phrase = ''
                this.keywords = []
                this.$refs.searchInput.focus()
            }
        },
        watch: {
            keywords(newValue) {
                this.phrase == '' || this.keywords.length ? this.isEmptyKeywords = false : this.isEmptyKeywords = true
            },
        }
    }
</script>

<style lang="scss">
.search {
    &-content {
        @include get-media($laptop, $desktop) {
            .product-card__wishes {
                width: 17%;
                height: 12%;
            }
        }
    }
    &-input {
        position: relative;
        @include get-media($laptop, $desktop) {
            float: right;
            width: 75%;
        }
        &__actions {
            position: relative;
            display: flex;
            background: white;
            align-items: center;
            input {
                padding: 0 40px;
                color: $main-color;
                transition: $transition;
            }
            svg {
                width: 24px;
                height: 24px;
            }
            .in-focus {
                box-shadow: 0 3px 7px 0 rgba(0,0,0,.2);
                border: none;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
            }
        }
        &__icon {
            position: absolute;
            left: 10px;
            top: 1em;
        }
        &__delete {
            position: absolute;
            right: 10px;
            top: 1em;
            transform: rotate(45deg)
        }
        &__list {
            position: absolute;
            background: white;
            box-shadow: 0 3px 7px 0 rgba(0,0,0,.2);
            z-index: 10;
            width: 100%;
            margin-top: -1em;
            border-bottom-left-radius: $btn-radius;
            border-bottom-right-radius: $btn-radius;
            box-sizing: border-box;
        }
        &__keywords {
            li {
                @include tableRowStyle;
                cursor: pointer;
            }
            .svgIcon {
                transform: rotate(-45deg);
            }
        }
    }
}
</style>
