<template>
    <el-card>
        <el-form :inline="true" :model="form.search" @submit.prevent="resetPage">
            <div class="flex items-center justify-between">
                <el-form-item label="选择排序">
                    <el-select v-model="form.sort" placeholder="请选择">
                        <el-option
                          v-for="item in options"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="时间段">
                    <el-date-picker v-model="form.date" type="date"
                        placeholder="选择日期">
                    </el-date-picker>
                </el-form-item>
            </div>
        </el-form>
        <el-table :data="products" border element-loading-text="拼命加载中" stripe v-loading="loading"
        style="width: 100%">
        <el-table-column prop="id" label="编号" width="50"></el-table-column>
        <el-table-column prop="name" label="名称"></el-table-column>
        <el-table-column prop="author.name" label="作者"></el-table-column>
        <el-table-column prop="price" label="价格"></el-table-column>
        <el-table-column label="操作">
            <template slot-scope="scope">
                <router-link :to="{name: 'Product.edit', params: { id: scope.row.id }}">
                <el-button size="mini">编辑</el-button>
                </router-link>
                <!-- <el-button size="mini" @click="handleEdit(scope.$index, scope.row)">编辑</el-button> -->
                <el-button size="mini" type="danger" @click="handleDelete(scope.$index, scope.row)">删除</el-button>
            </template>
        </el-table-column>
    </el-table>
    </el-card>
</template>

<script>
import {Table, TableColumn, Card, Pagination, Form, FormItem, Select, Option, DatePicker} from 'element-ui';
export default {
    data() {
        return {
            loading: false,
            products: [],
            form: {
                date: '',
                page: 1,
                sort: '',
            },
            pagination: {
                total: 0,
                page_size: 0,
            },
            options: [{
              value: '1',
              label: '销量'
            }, {
              value: '0',
              label: '创建时间'
            }],
        }
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
    },
    created() {
        this.form.page = +this.form.page;
        console.log(this.form.page);
        this.fetchData();
    },
    methods: {
        fetchData() {
            API.get('product/list', {params: this.form}).then((res) => {
                this.products = res.data;
            })
        }
    }
}
</script>
