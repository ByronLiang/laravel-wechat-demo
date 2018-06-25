<template>
    <el-table :data="banners" border element-loading-text="拼命加载中" stripe v-loading="loading" style="width: 100%">
        <el-table-column prop="id" label="编号" width="50"></el-table-column>
        <el-table-column prop="picture" label="图片">
            <template slot-scope="scope">
                <img :src="scope.row.picture.url" alt="" v-if="scope.row.type == 1">
                <span v-if="scope.row.type == 2">NO Picture</span>
                <img :src="scope.row.video_poster" alt="" v-if="scope.row.type == 3">
            </template>
        </el-table-column>
        <el-table-column prop="picture.url" label="图片地址"></el-table-column>
        <el-table-column prop="resource" label="跳转参数"></el-table-column>
        <el-table-column label="操作">
            <template slot-scope="scope">
                <!-- <el-button size="mini" @click="handleEdit(scope.$index, scope.row)">编辑</el-button> -->
                <router-link :to="`show/${scope.row.id}`" append>
                    <el-button size="mini">编辑</el-button>
                </router-link>
                <el-button size="mini" type="danger" @click="handleDelete(scope.$index, scope.row)">删除</el-button>
            </template>
        </el-table-column>
    </el-table>
</template>

<script>
import {Table, TableColumn} from 'element-ui';
export default {
    data() {
        return {
            banners: [],
            loading: false,
        }
    },
    components: {
        ElTable: Table,
        ElTableColumn: TableColumn,
    },
    methods: {
        handleEdit(index, row) {
            this.$router.push({name: 'Banner.show', params: {id: row.id}});
        },
        handleDelete(index, row) {
            Element.$confirm('此操作将永久删除该数据, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                API.get('banner/destroy/' + row.id).then(() => {
                    this.banners.splice(index, 1);
                    Element.$message({
                        type: 'success',
                        message: '删除成功!'
                    });
                })
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        API.get('banner/list').then((data) => {
            next(vm => {
                vm.banners = data;
            });
        })
    }

}
</script>

<style lang="scss">
</style>
