<template>
<el-card>
    <el-tabs v-model="activeName" @tab-click="handleClick">
        <el-tab-pane label="列表" name="first">
            <el-table :data="authors" border element-loading-text="拼命加载中" stripe v-loading="loading" style="width: 100%">
            <el-table-column prop="id" label="编号" width="50"></el-table-column>
            <el-table-column prop="name" label="主讲人名称"></el-table-column>
            <el-table-column prop="picture" label="图片">
                <template slot-scope="scope">
                    <img :src="scope.row.avatar" alt="">
                </template>
            </el-table-column>
            <el-table-column prop="introduction" label="简介" width="150"></el-table-column>
            <el-table-column prop="number" label="序号"></el-table-column>
            <el-table-column label="操作">
                <template slot-scope="scope">
                    <el-button size="mini" @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                    <!-- <router-link :to="`show/${scope.row.id}`" append>
                        <el-button size="mini">编辑</el-button>
                    </router-link> -->
                    <el-button size="mini" type="danger" @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <div class="text-center pt-2" v-show="!loading">
            <el-pagination  layout="total, prev, pager, next, sizes, jumper"
                           @current-change="fetchData"
                           @size-change="handleSizeChange"
                           :page-sizes="[3, 5, 10, 15]"
                           :page-size="pagination.page_size"
                           :current-page="filter.page"
                           :total="pagination.total">
            </el-pagination>
        </div>
    </el-tab-pane>
    <el-tab-pane label="添加" name="second">
        <el-form label-width="80px" :model="form" label-position="top" :rules="rules" ref="ruleForm">
            <el-form-item label="主讲人名称">
                <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item label="图片(建议分辨率750*350)" prop="avatar">
                <img-upload v-model="form.avatar" :config="{width: 400}" style="width: 400px; height: 300px;">
                    <div class="image-box">
                        <img :src="form.avatar" class="image" v-if="form.avatar">
                        <i class="el-icon-plus avatar-uploader-icon" v-else></i>
                    </div>
                </img-upload>
            </el-form-item>
            <el-form-item label="简介">
                <el-input type="textarea" v-model="form.introduction"></el-input>
            </el-form-item>
            <el-form-item class="center">
                <el-button type="primary" @click="submit">{{ status == 'add' ? '保存' : '更新' }}</el-button>
            </el-form-item>
        </el-form>
    </el-tab-pane>
    </el-tabs>
</el-card>
</template>
<script>
import {Table, TableColumn, Tabs, Card, TabPane, Form, FormItem, Input, Button, Pagination} from 'element-ui';
// import ImgUpload from '../../components/base/ImgUpload.vue';
import ImgUpload from '../../components/base/BasicUpload.vue';
export default {
    data() {
        return {
            activeName: 'first',
            authors: [],
            loading: false,
            form: {
                id: '',
                name: '',
                avatar: '',
                introduction: ''
            },
            filter: {
                page: 1
            },
            pagination: {
                page_size: 0,
                total: 0
            },
            status: 'add',
            rules: {
              avatar: [
                { required: true, message: '请上传图片', trigger: 'blur' },
              ],
            }
        }
    },
    components: {
        ElTable: Table,
        ElTableColumn: TableColumn,
        ElTabs: Tabs,
        ElCard: Card,
        ElTabPane: TabPane,
        ElForm: Form,
        ElFormItem: FormItem,
        ElInput: Input,
        ElButton: Button,
        ElPagination: Pagination,
        ImgUpload
    },
    created() {
        this.filter.page = +this.filter.page;
        this.fetchData();
    },
    methods: {
        handleClick(tab, event) {
            if (tab.name == 'second') {
                this.form.id = '';
                this.form.name = '';
                this.form.avatar = '';
                this.form.introduction = '';
                this.status = 'add';
            }
            console.log(tab.name);
        },
        handleEdit(index, row) {
            API.get('author/edit?id=' + row.id).then((r) => {
                this.form.id = row.id;
                this.form.name = r.name;
                this.form.avatar = r.avatar;
                this.form.introduction = r.introduction;
            });
            this.status = 'edit';
            this.activeName = 'second';
            // this.$router.push({name: 'Author.show', params: {id: row.id}});
        },
        handleDelete(index, row) {
            Element.$confirm('此操作将永久删除该数据, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                API.get('author/destroy/' + row.id).then(() => {
                    this.authors.splice(index, 1);
                    Element.$message({
                        type: 'success',
                        message: '删除成功!'
                    });
                })
            })
        },
        submit() {
            this.$refs['ruleForm'].validate((valid) => {
                if (valid) {
                    if (this.status == 'add') {
                        API.post('author/create', this.form).then((res) => {
                            this.$router.go(-1);
                        });
                    } else {
                       API.put('author/update', this.form).then((res) => {
                            this.$router.go(-1);
                        });
                    }
                }
            });
        },
        handleSizeChange(val = null) {
            console.log(val);
        },
        fetchData(page = null) {
            if (page) {
                this.filter.page = page;
            }
            this.loading = true;
            API.get('author/list', {
                    params: this.filter
                }).then((res) => {
                    this.authors = res.data;
                    this.pagination.total = parseInt(res.total);
                    this.pagination.page_size = res.per_page;
            }).finally(() => this.loading = false);
        }
    }
    // beforeRouteEnter(to, from, next) {
    //     this.fetchData();
    // }
}
</script>
<style type="scss" scrop>
    .img-upload{
        width: 750px;
        height: 353px;
    }
    .image-box {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        height: 100%;
        line-height: 353px;
    }
    .image-box:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .image {
        width: 100%;
        height: 353px;
        display: block;
    }
</style>
