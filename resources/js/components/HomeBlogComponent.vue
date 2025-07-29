<template>
    <div class="homeBlog">
        <div class="homeBlog-headline">Блог</div>
        <div class="homeBlog-posts">
            <div class="swiper-wrapper">
                <a v-for="post in posts" :href="`/blog#post${post.id}`" :key="post.id" track-by="id" class="homeBlog-post swiper-slide">
                    <div class="post-image" :style="{'background-image': `url(${post.imageUrl})`}"></div>
                    <div class="post-headline">{{ post.title }}</div>
                </a>

            </div>
        </div>
    </div>
</template>

<script>
import Swiper from 'swiper';
export default {
    props: ['posts'],
    mounted() {
        this.initSwiper()
        // console.log(this.posts);
    },
    methods: {
        initSwiper() {
                new Swiper ('.homeBlog-posts', {
                slidesPerView: 'auto',
                spaceBetween: 4,
            })
        }
    }
}
</script>

<style lang="scss">
$width: calc(100vw / 2.18658);
.homeBlog {
    margin-top: 3rem;
    margin-bottom: 3rem;
    @include get-media($laptop, $desktop) {
        display: none;
    }
    &-headline {
        text-transform: uppercase;
    }
    &-posts {
        margin: 0.75rem -1rem;
        width: 100%;
    }
    &-post {
        display: flex;
        width: $width;
        flex-direction: column;
        .post {
            &-image {
                padding-top: calc(#{$width} * 1.33333);
                background-position: left center;
                width: 100%;
                background-size: cover;
            }
            &-headline {
                font-size: 14px;
                padding: 0.5rem 0.5rem 0;
            }
        }
    }
}

</style>
