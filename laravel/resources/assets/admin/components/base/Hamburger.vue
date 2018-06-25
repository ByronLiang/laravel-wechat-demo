<template>
    <div class="hamburger" :class="classes" :style="styles">
        <div class="hamburger-box">
            <div class="hamburger-inner"></div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['type', 'active', 'scale'],
        data() {
            return {
                styles: {
                    transform: `scale(${this.scale})`
                }
            };
        },
        computed: {
            classes() {
                let ret = ['hamburger--' + this.type];
                if (this.active) ret.push('is-active');
                return ret;
            }
        }
    }
</script>

<style lang="scss">
    // Settings
    // ==================================================
    $hamburger-padding-x                       : 15px !default;
    $hamburger-padding-y                       : 15px !default;
    $hamburger-layer-width                     : 40px !default;
    $hamburger-layer-height                    : 4px !default;
    $hamburger-layer-spacing                   : 6px !default;
    $hamburger-layer-color                     : #000 !default;
    $hamburger-layer-border-radius             : 4px !default;
    $hamburger-hover-opacity                   : 0.7 !default;
    $hamburger-hover-transition-duration       : 0.15s !default;
    $hamburger-hover-transition-timing-function: linear !default;

    // To use CSS filters as the hover effect instead of opacity,
    // set $hamburger-hover-use-filter as true and
    // change the value of $hamburger-hover-filter accordingly.
    $hamburger-hover-use-filter: false !default;
    $hamburger-hover-filter    : opacity(50%) !default;

    // Types (Remove or comment out what you don’t need)
    // ==================================================
    $hamburger-types: (
            // 3dx,
            // 3dx-r,
            // 3dy,
            // 3dy-r,
            // 3dxy,
            // 3dxy-r,
            // arrow,
            // arrow-r,
            // arrowalt,
            arrowalt-r,
            // arrowturn,
            // arrowturn-r,
            // boring,
            // collapse,
            // collapse-r,
            // elastic,
            // elastic-r,
            // emphatic,
            // emphatic-r,
            // minus,
            // slider,
            // slider-r,
            // spin,
            // spin-r,
            // spring,
            // spring-r,
            // stand,
            // stand-r,
            // squeeze,
            // vortex,
            // vortex-r
    ) !default;

    @import "~hamburgers/_sass/hamburgers/hamburgers";
</style>