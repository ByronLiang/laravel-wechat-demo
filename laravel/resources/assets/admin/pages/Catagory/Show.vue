<template>
    <el-card>
        <el-form label-width="80px" :model="form" label-position="top" :rules="rules" ref="ruleForm">
            <div class="text-left">
                <el-form-item label="类型名称" prop="name">
                    <el-input placeholder="输入名称" v-model="form.name"></el-input>
                </el-form-item>
            </div>
            <el-form-item label="图片(建议分辨率750*350)" prop="img_url">
                <img-upload v-model="form.img_url" :max="{width: 200, height: 200}"
                    limit=".jpg,.png" drive="local">
                    <div class="image-box">
                        <img :src="form.img_url" class="image" v-if="form.img_url">
                        <i class="el-icon-plus avatar-uploader-icon" v-else></i>
                    </div>
                </img-upload>
            </el-form-item>
            <el-form-item label="" class="center">
                <el-button type="primary" @click="submit">{{ $route.params.id ? '修改' : '保存'}}</el-button>
            </el-form-item>
        </el-form>
    </el-card>
</template>
<script>
    import {Form, FormItem, Button, Input, Card, Select, Option, Radio} from 'element-ui';
    import ImgUpload from '../../components/base/qiniuUpload.vue';
    export default {
        components: {
            ElForm: Form,
            ElFormItem: FormItem,
            ElButton: Button,
            ElInput: Input,
            ElCard: Card,
            ImgUpload
        },
        data() {
            return {
                form: {
                    name: '',
                    status: '',
                    img_url: ''
                },
                rules: {
                  name: [
                    { required: true, message: '输入名称', trigger: 'blur' },
                  ],
                  img_url: [
                    {required: true, message: '请上传封面图片', trigger: 'blur'}
                  ],
                }
            };
        },
        methods: {
            submit() {
                this.$refs['ruleForm'].validate((valid) => {
                  if (valid) {
                    if (!this.$route.params.id) {
                        API.post('catagory/create', this.form).then((res) => {
                            console.log(res);
                            this.$router.go(-1);
                        })
                    } else {
                        this.form.banner_id = this.$route.params.id;
                        API.post('catagory/update', this.form).then((res) => {
                            this.$router.go(-1);
                        })
                    }
                  }
                });
            }
        },
        beforeRouteEnter(to, from, next) {
            if (to.params.id) {
                API.get('catagory/show/' + to.params.id).then((data) => {
                    console.log(data);
                    next(vm => {
                        vm.form = data;
                    });
                })
                return false;
            }
            next();
        }
    };
</script>
<style lang="scss" scrop>
    .el-form-item__content{
        text-align: center;
    }
    .text-left{
        .el-form-item__content{
            text-align: left;
        }
        .el-select{
            width: 100%;
        }
    }
    .img-upload{
        float: left;
        width: 450px;
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
