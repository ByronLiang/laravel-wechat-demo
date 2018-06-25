<template>
    <div>
        <el-card class="mb-2">
            <quill v-model="form.content" placeholder="请输入内容"></quill>
        </el-card>
        <el-card>
            <tinymce v-model="form.content"></tinymce>
        </el-card>
        <el-card>
            <drap></drap>
        </el-card>
    </div>
</template>

<script>
    export default {
        components: {
            Quill: () => import('admin/components/base/Quill.vue'),
            Tinymce: () => import('admin/components/base/Tinymce'),
            Drap: () => import('admin/components/base/DrapOrder')
        },
        props: [],
        data() {
            return {
                form: {
                    content: '',
                    content2: ''
                }
            };
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
</style>
