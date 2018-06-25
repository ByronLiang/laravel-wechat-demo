<template>
<el-card>
    <div class="text-right mb-2">
        <el-button type='primary' @click="designOrder = true">自定义分类</el-button>
    </div>
    <el-table :data="catagory" border element-loading-text="拼命加载中" stripe v-loading="loading"
        style="width: 100%">
        <el-table-column prop="id" label="编号" width="50"></el-table-column>
        <el-table-column prop="name" label="名称"></el-table-column>
        <el-table-column prop="img_url" label="封面图">
            <template slot-scope="scope">
                <img :src="scope.row.img_url" alt="" style="width:120px; height: 120px;" v-if="scope.row.img_url">
                <span v-else>暂无图片</span>
            </template>
        </el-table-column>
        <el-table-column label="操作">
            <template slot-scope="scope">
                <router-link :to="{name: 'Catagory.show', params: { id: scope.row.id }}">
                <el-button size="mini">编辑</el-button>
                </router-link>
                <!-- <el-button size="mini" @click="handleEdit(scope.$index, scope.row)">编辑</el-button> -->
                <el-button size="mini" type="danger" @click="handleDelete(scope.$index, scope.row)">删除</el-button>
            </template>
        </el-table-column>
    </el-table>
    <div class="text-center pt-2" v-show="!loading">
        <el-pagination  layout="total, prev, pager, next"
                       @current-change="fetchData"
                       :page-size="pagination.page_size"
                       :current-page="filter.page"
                       :total="pagination.total">
        </el-pagination>
    </div>
    <el-dialog title="自定义排序" :visible.sync="designOrder" width="70%" center>
        <drap :dataList="catagory"></drap>
    </el-dialog>
</el-card>
</template>

<script>
import {Table, TableColumn, Card, Pagination, Form, FormItem, Select, Option, DatePicker, Dialog} from 'element-ui';
export default {
    data() {
        return {
            designOrder: false,
            loading: false,
            catagory: [],
            filter: {
                page: 1
            },
            pagination: {
                page_size: 0,
                total: 0
            },
        };
    },
    components: {
        ElTable: Table,
        ElTableColumn: TableColumn,
        ElPagination: Pagination,
        ElCard: Card,
        ElSelect: Select,
        ElOption: Option,
        ElForm: Form,
        ElFormItem: FormItem,
        ElDatePicker: DatePicker,
        ElDialog : Dialog,
        Drap: () => import('admin/components/base/DrapOrder')
    },
    created() {
        this.filter.page = +this.filter.page;
        this.fetchData();
    },
    // beforeRouteEnter(to, from, next) {
    //     // API.get('catagory/list').then((data) => {
    //     //     next(vm => {
    //     //         vm.catagory = data;
    //     //     });
    //     // })
    // },
    methods: {
        handleEdit(index, row) {
            this.$router.push({name: 'Catagory.show', params: {id: row.id}});
        },
        handleDelete(index, row) {
            Element.$confirm('此操作将永久删除该数据, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                API.get('catagory/destroy/' + row.id).then(() => {
                    this.catagory.splice(index, 1);
                    Element.$message({
                        type: 'success',
                        message: '删除成功!'
                    });
                })
            })
        },
        fetchData(page = null) {
            if (page) {
                this.filter.page = page;
            }
            this.loading = true;
            API.get('catagory/list', {params: this.filter}).then((res) => {
                this.catagory = res.data;
                this.pagination.total = parseInt(res.total);
                this.pagination.page_size = res.per_page;
            }).finally(() => this.loading = false);
        }
    }
};
</script>
