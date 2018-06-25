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
                <el-form-item label="筛选产品参数">
                    <el-select v-model="form.product" filterable remote reserve-keyword placeholder="请输入商品名称或商品编号" :remote-method="getProduct" :loading="loading">
                        <el-option v-for="item in product_result" :key="item.id" :label="item.name" :value="item.id"></el-option>
                    </el-select>
                </el-form-item>
                <el-button type="primary" @click="show">主要按钮</el-button>
            </div>
            <div class="form-item-box">
                <h3>基本信息</h3>
                <div class="form-box mt-4">
                    <el-form-item label="名称" prop="name">
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item label="作者" prop="author_id">
                        <el-select
                            v-model="form.author_id"
                            filterable
                            remote
                            reserve-keyword
                            placeholder="可搜索作者"
                            :remote-method="fetchAuthorData"
                            :loading="loading">
                            <el-option
                                v-for="item in author_options"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="类型" prop="type">
                        <el-select
                            v-model="form.type"
                            multiple
                            filterable
                            remote
                            reserve-keyword
                            placeholder="可搜索类型"
                            :remote-method="fetchTypeData"
                            :loading="loading">
                            <el-option
                                v-for="item in options4"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </div>
                <div class="form-box mt-4">
                    <el-form-item label="价格" prop="drink_price">
                        <el-input v-model.number="form.price"></el-input>
                    </el-form-item>
                    <el-form-item label="是否推荐" prop="recommend">
                        <el-select v-model="form.recommend" placeholder="请选择">
                            <el-option label="是" value="1"></el-option>
                            <el-option label="否" value="0"></el-option>
                        </el-select>
                    </el-form-item>
                </div>
            </div>
            <!-- http://pa9jr09c8.bkt.clouddn.com/1529138220090.mp4 -->
            <div class="form-item-box">
                <h3 class="mb-4">商品详情</h3>
                <div>
                    <el-form-item label="视频" prop="video" style="height: 280px;">
                        <img-upload v-model="form.video" style="width: 400px; height: 300px;"
                            drive='qiniu' limit=".mp4,.wmv,.avi">
                            <video :src="form.video" controls="controls" id="video" ref="video"
                                @play="handlePlay" @seeked="handleSeeked"
                                v-if="form.video">No support</video>
                        <el-button size="small" type="primary" v-else>Upload Video File</el-button>
                        </img-upload>
                    </el-form-item>
                <div>
                    <el-button type="normal" @click="cutPic" v-if="form.video">手动截图</el-button>
                </div>
                <div>
                    <el-button type="normal" @click="handleHightLight(29)" v-if="form.video">精彩点一</el-button>
                    <el-button type="normal" @click="handleHightLight(39)" v-if="form.video">精彩点二</el-button>
                    <el-button type="normal" @click="handleHightLight(69)" v-if="form.video">精彩点三</el-button>
                </div>
                    <el-form-item label="视频截图" id="video_poster" prop="video_poster">
                            <!-- <img :src="form.video_poster" class="image" v-if="form.video_poster"
                                style="width: 400px; height: 300px;"> -->
                        <div class="view-image-box" v-if="form.video">
                            <div class="view-image" v-for="(i, index) in form.video_poster" :key="index">
                                <sample-img-upload v-model="i.picture" :config="{width: 300}">
                                    <div class="image-box">
                                        <img :src="i.picture">
                                    </div>
                                </sample-img-upload>
                                    <i class="el-icon-remove" @click="removeImage(index)"></i>
                            </div>
                        </div>
                            <!-- <input type="hidden" name="video_poster" :value="form.video_poster"> -->
                    </el-form-item>
                </div>
            </div>
            <div class="form-item-box" v-if="form.video">
                <div style="width: 100%; height: 400px;">
                    <video-play :video_url="form.video" :sample="false" v-if="form.video"></video-play>
                </div>
            </div>
            <!-- <div class="form-item-box">
                <div style="width: 100%; height: 400px;">
                    <video-play id='video' :sample="false" :highTime="highTime"></video-play>
                </div>
                <el-button type="primary" @click="highTime=15">15second</el-button>
            </div> -->
            <div class="flex justify-center mt1">
                <el-button type="primary" @click="submit" :loading="isBtnLoading">{{ $route.params.id ? '修改' : '保存'}}</el-button>
            </div>
        </el-form>
    </el-card>
</template>

<script>
import {Table, TableColumn, Card, Pagination, Form, FormItem, Select, Option, DatePicker, Button, Input} from 'element-ui';
import SampleImgUpload from '../../components/base/ImgUpload.vue';
import ImgUpload from '../../components/base/qiniuUpload.vue';
import VideoPlay from '../../components/base/VideoPlayer.vue';
export default {
    data() {
        return {
            highTime: '',
            loading: false,
            products: [],
            form: {
                name: '',
                price: '',
                type: [],
                author_id: '',
                video_poster: [],
                recommend: 1
            },
            options: [{
              value: '1',
              label: '销量'
            }, {
              value: '0',
              label: '创建时间'
            }],
            options4: [],
            options5: [],
            author_options: []
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
        ElButton: Button,
        ElInput: Input,
        ImgUpload,
        VideoPlay
    },
    mounted() {
        API.get('product/catagory').then((data) => {
            console.log(data);
            this.options4 = data;
        });
        API.get('product/author').then((data) => {
            this.author_options = data;
        });
    },
    watch: {
        'form.date'() {
            console.log(this.form.date);
        }
    },
    methods: {
        show() {
            console.log(this.form.sort);
        },
        fetchTypeData(query) {
            if(query != '') {
                API.get('product/search', {params: {keyword: query, type: 'catagory'}}).then((data) => {
                    this.options4 = data;
                });
            } else {
                API.get('product/catagory').then((data) => {
                    this.options4 = data;
                });
            }
        },
        fetchAuthorData(query) {
            if(query != '') {
                API.get('product/search', {params: {keyword: query, type: 'author'}}).then((data) => {
                    this.author_options = data;
                });
            } else {
                API.get('product/author').then((data) => {
                    this.author_options = data;
                });
            }
        },
        cutPic() {
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
                    // this.form.video_poster = '/upload/' + filename;
                    this.form.video_poster.push({picture: '/upload/' + filename});
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
            },
            removeImage(index) {
                this.form.video_poster.splice(index, 1);
            },
            submit() {
                if (!this.$route.params.id) {
                    API.post('product/create', this.form).then((res) => {
                        Element.$confirm('添加成功', '提示', {
                            confirmButtonText: '继续发布',
                            cancelButtonText: '返回列表',
                            type: 'success'
                        }).then(() => {
                            history.go(0);
                        }).catch(() => {
                            this.$router.go(-1);
                        });
                    })
                } else {
                    this.form.product_id = this.$route.params.id;
                    API.post('product/update', this.form).then((res) => {
                        this.$router.go(-1);
                    })
                }
        },
        handlePlay() {
            let v = this.$refs.video;
            console.log(v.duration);
            console.log(v.currentTime);
        },
        handleHightLight(val) {
            let video = this.$refs.video;
            if (video) {
                video.currentTime = val;
            }
        },
        handleSeeked() {
            let video = this.$refs.video;
            console.log(video.currentTime);
        }
    },
    beforeRouteEnter(to, from, next) {
        if (to.params.id) {
            API.get('product/edit/' + to.params.id).then((res) => {
                next(vm => {
                    vm.form = res
                });
            })
            return false;
        }
        next();
    }
}
</script>

<style lang="scss" scrop>
    .form-box{
        .el-form-item{
            display: inline-block;
            margin-right: 20px;
            width: 30%;
            .el-select{
                width: 100%;
            }
        }
    }
    .view-image{
        display: inline-block;
        position: relative;
        margin-right: 10px;
        margin-bottom: 10px;

        img{
            height: 200px;
        }

        i{
            position: absolute;
            right: -10px;
            top: -10px;
            font-size: 28px;
            color: #409EFF;
            cursor: pointer;
        }
    }
    .img-upload-box, .view-image-box{
        display: inline-block;
        vertical-align: middle;
    }
    .image-box {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        height: 100%;
        line-height: 200px;
    }
</style>
