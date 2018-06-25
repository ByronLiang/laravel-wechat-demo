<template>
    <popup v-model="visible" position="bottom" class="popup-picker">
        <picker @change="onChange"
                :slots="dateSlots"
                :visible-item-count="visibleItemCount">
        </picker>
    </popup>
</template>

<script>
    import {Picker, Popup} from 'mint-ui';

    /**
     * http://mint-ui.github.io/docs/#/zh-cn2/picker
     * 来源：https://github.com/ElemeFE/mint-ui/blob/master/packages/datetime-picker/src/datetime-picker.vue
     */
    export default {
        name: 'popup-picker',
        props: {
            cancelText: {
                type: String,
                default: '取消'
            },
            confirmText: {
                type: String,
                default: '确定'
            },
            visibleItemCount: {
                type: Number,
                default: 7
            },
            dateSlots: [],
        },
        data() {
            return {
                visible: false,
            };
        },
        components: {
            Picker,
            Popup
        },
        methods: {
            open() {
                this.visible = true;
            },
            close() {
                this.visible = false;
            },
            onChange(picker, values) {
                this.$emit('change', picker, values);
            },
        },
        computed: {
        },
        watch: {
        },
        mounted() {
        }
    };
</script>

<style lang="scss">
    .popup-picker{
        width: 100%;

        .picker-slot-wrapper, .picker-item {
            backface-visibility: hidden;
        }
    }
</style>