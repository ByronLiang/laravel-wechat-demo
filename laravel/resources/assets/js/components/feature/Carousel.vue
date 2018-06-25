<template>
    <swiper :pagination="true" class="carousel">
        <div v-for="item in items">
            <a :href="item.url || 'javascript:void(0);'" :style="'background-image: url('+item.image+')'" class="picture"></a>
        </div>
    </swiper>
</template>

<script>
    import Swiper from '../base/Swiper.vue';

    export default {
        components: {
            Swiper
        },
        filters: {},
        directive: {},
        props: ['items'],
        data() {
            return {};
        },
        computed: {},
        watch: {},
        methods: {},
        mounted() {
        },
        beforeDestroy() {
        }
    };
</script>

<style lang="scss">
    .carousel{
        width: 100%;
        .picture {
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            display: block;
            width: 100%;
            height: 400px;
        }
            .swiper-pagination-bullet {
                background: #38adf4;
                opacity: 1;
            }
            .swiper-pagination-bullet-active {
                background: #f08400;
            }
    }
</style>
