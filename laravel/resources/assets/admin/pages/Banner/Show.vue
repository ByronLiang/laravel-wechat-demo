<template>
  <el-card>
        <el-form label-width="80px" :model="form" label-position="top" :rules="rules" ref="ruleForm">
            <div class="text-left">
                <el-form-item label="上传类型" prop="type">
                    <el-radio v-model="form.type" label="1">图片</el-radio>
                    <el-radio v-model="form.type" label="2">音频</el-radio>
                    <el-radio v-model="form.type" label="3">视频</el-radio>
                </el-form-item>
            </div>
            <el-form-item label="图片(建议分辨率750*350)" prop="picture" v-show="form.type == 1">
                <img-upload v-model="form.picture" :config="{width: 400}">
                    <div class="image-box">
                        <img :src="form.picture.url" class="image" v-if="form.picture">
                        <i class="el-icon-plus avatar-uploader-icon" v-else></i>
                    </div>
                    <input type="hidden" :value="form.picture.size" v-if="form.picture.size">
                </img-upload>
            </el-form-item>
            <div class="text-left">
            <el-form-item label="音频" prop="picture" v-show="form.type == 2">
                <img-upload v-model="form.picture" style="width: 300px; height: 20px;">
                        <audio :src="form.picture.url" controls="controls" v-if="form.picture">No support</audio>
                        <!-- <i class="el-icon-plus avatar-uploader-icon" v-else></i> -->
                        <el-button size="small" type="primary" v-else>Upload Radio File</el-button>
                    <input type="hidden" :value="form.picture.size" v-if="form.picture.size">
                </img-upload>
            </el-form-item>
            </div>
            <div class="text-left">
            <el-form-item label="视频" prop="picture" v-show="form.type == 3" style="height: 280px;">
                <img-upload v-model="form.picture" style="width: 400px; height: 300px;">
                        <video :src="form.picture.url" controls="controls" id="video" v-if="form.picture">No support</video>
                        <i class="el-icon-plus avatar-uploader-icon" v-else></i>
                    <input type="hidden" :value="form.picture.size" v-if="form.picture.size">
                </img-upload>
            </el-form-item>
            <div>
                <el-button type="normal" @click="cutPic" v-if="form.picture">手动截图</el-button>
            </div>
            <el-form-item label="视频截图" id="video_poster" prop="video_poster" v-show="form.type == 3">
                    <img :src="form.video_poster" class="image" v-if="form.video_poster"
                        style="width: 400px; height: 300px;">
                    <!-- <input type="hidden" name="video_poster" :value="form.video_poster"> -->
            </el-form-item>
            </div>
            <!-- <div class="text-left">
                <el-form-item label="链接参数设置" prop="resource">
                    <el-select v-model="form.resource" filterable remote reserve-keyword placeholder="请输入商品编号或商品名称" :remote-method="remoteMethod" :loading="loading" name="form.resource">
                        <el-option v-for="item in results" :key="item.id" :label="item.name" :value="item.id"></el-option>
                    </el-select>
                </el-form-item>
            </div> -->
            <div class="text-left">
                <el-form-item label="是否启用" prop="status">
                    <el-radio v-model="form.status" label="1">是</el-radio>
                    <el-radio v-model="form.status" label="2">否</el-radio>
                </el-form-item>
            </div>
            <el-form-item label="" class="center">
                <el-button type="primary" @click="submit">{{ $route.params.id ? '修改' : '保存'}}</el-button>
            </el-form-item>
        </el-form>
    </el-card>
</template>

<script>
import {Form, FormItem, Button, Input, Card, Select, Option, Radio} from 'element-ui';
    import ImgUpload from '../../components/base/ImgUpload.vue';
    import {uploadToken} from '../../api/Cache';
    import BasicUpload from '../../components/base/BasicUpload.vue';

    export default {
        components: {
            ElForm: Form,
            ElFormItem: FormItem,
            ElButton: Button,
            ElInput: Input,
            ElCard: Card,
            ElSelect: Select,
            ElOption: Option,
            ElRadio: Radio,
            ImgUpload
            // BasicUpload
        },
        props: [],
        data() {
            return {
                show: true,
                results: [],
                form: {
                    picture: '',
                    status: '',
                },
                rules: {
                  picture: [
                    { required: true, message: '请上传图片', trigger: 'blur' },
                  ],
                }
            };
        },
        watch: {
            // 'form.status'() {
            //     if (this.form.status == 1) {
            //         this.show = true;
            //     } else {
            //         this.show = false;
            //     }
            //     console.log(this.form.status);
            // },
            'form.picture'() {
                if (this.form.type == 3 && this.form.picture) {
                    let video = document.getElementsByTagName('video')[0];
                    console.log(video);
                }
            }
        },
        methods: {
            // remoteMethod(query) {
            //     if (query !== '') {
            //         this.loading = true;
            //         API.get('banner/product', {params: {keyword: query}}).then((data) => {
            //             this.loading = false;
            //             this.results = data;
            //         })
            //     } else {
            //       this.results = [];
            //     }
            // },
            submit() {
                this.$refs['ruleForm'].validate((valid) => {
                  if (valid) {
                    if (!this.$route.params.id) {
                        API.post('banner/create', this.form).then((res) => {
                            this.$router.go(-1);
                        })
                    } else {
                        this.form.banner_id = this.$route.params.id;
                        API.post('banner/update', this.form).then((res) => {
                            this.$router.go(-1);
                        })
                    }
                  }
                });
            },
            cutPic() {
                let ci = $('#video');
                console.log(ci);
                return false;
                console.log('aaa');
                var scale = 0.9;
                let output = document.getElementById("video_poster");
                let outValue = document.getElementsByName('video_poster')[0];
                let video = document.getElementById("video");
                //base64图像编码转换成Blob对象文件
                var dataURItoBlob = function (dataURI) {
                    const binary = atob(dataURI.split(',')[1]);
                    const array = [];
                    for (let i = 0; i < binary.length; i += 1) {
                        array.push(binary.charCodeAt(i));
                    }
                    return new Blob([new Uint8Array(array)], { type: 'image/png' });
                }
                var canvas = document.createElement("canvas");
                canvas.width = video.videoWidth * scale;
                canvas.height = video.videoHeight * scale;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                //异步上传截图图片
                let filename = `${+new Date()}.png`;
                let formData = new FormData();
                formData.append('file', dataURItoBlob(canvas.toDataURL('image/png')), filename);
                formData.append('key', filename);
                API.post('supplier/normal', formData).then(response => {
                    console.log(response);
                    this.form.video_poster = '/upload/' + filename;
                });


                // 未上传图片获取图片预览
                // var img = new Image();
                // img.setAttribute("crossOrigin",'Anonymous');
                // img.src = window['URL']['createObjectURL'](dataURItoBlob(canvas.toDataURL("image/png")));
                // img.width = 400;
                // img.height = 300;
                // if (output.childNodes.length > 0) {
                //     output.removeChild(output.childNodes[0]);
                //     outValue.value = '';

                // }
                // output.appendChild(img);
                // outValue.value = '/upload/' + filename;
            }
        },
        beforeRouteEnter(to, from, next) {
            if (to.params.id) {
                API.get('banner/show/' + to.params.id).then((data) => {
                    next(vm => {
                        vm.form = data.banner;
                        vm.results = [data.product];
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
