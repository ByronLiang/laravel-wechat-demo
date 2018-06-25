<template>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <slot></slot>
            <div class="swiper-slide" v-if="items" v-for="item in items">
                <slot name="item" :item="item"></slot>
            </div>
        </div>

        <!-- If we need pagination -->
        <div class="swiper-pagination" ref="pagination" v-show="pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev" v-show="navigation"></div>
        <div class="swiper-button-next" v-show="navigation"></div>
    </div>
</template>

<script>
    /* ============
     * Swiper
     * ============
     * ie10+
     * http://idangero.us/swiper/
     * https://github.com/nolimits4web/Swiper
     */
    import Swiper from 'swiper/dist/js/swiper.min';

    export default {
        components: {},
        filters: {},
        directive: {},
        props: ['items', 'pagination', 'scrollbar', 'navigation', 'config'],
        data() {
            return {
                default_config: {}
            };
        },
        computed: {},
        watch: {},
        methods: {},
        mounted() {
            if (this.$slots.default) {
                for (const i of this.$el.querySelectorAll('.swiper-wrapper > div')) {
                    i.classList.add('swiper-slide');
                }
            }
            if (typeof this.config === 'object') Object.assign(this.default_config, this.config);
            if (this.pagination) {
                if (typeof this.pagination !== 'object') this.pagination = {};
                Object.assign(this.default_config, this.pagination, {
                    pagination: this.$refs.pagination,
                });
            }
            if (this.navigation) {
                if (typeof this.navigation !== 'object') this.navigation = {};
                Object.assign(this.default_config, this.navigation, {
                    nextButton: '.swiper-button-next',
                    prevButton: '.swiper-button-prev',
                });
            }
            this.$nextTick(() => {
                this.swiper = new Swiper(this.$el, this.default_config);
            });
        },
        updated() {
            if (this.swiper) this.swiper.update();
        },
        beforeDestroy() {
            if (this.swiper) {
                this.swiper.destroy();
                delete this.swiper;
            }
        }
    };
</script>

<style lang="css" src="swiper/dist/css/swiper.min.css"></style>
