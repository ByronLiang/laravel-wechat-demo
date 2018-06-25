<template>
    <div @click="click" class="basic-upload" id="aetherupload-wrapper">
        <slot></slot>
            <input type="file" id="file" ref="file" @change="onChange"
                :accept="input.accept"
                :disabled="input.disabled"
                :multiple="input.multiple"
            >
            <div class="progress " style="height: 6px;margin-bottom: 2px;margin-top: 10px;width: 200px;"
                v-if="upload_progress!==null">
                <div id="progressbar" style="background:blue;height:6px;width:0;"></div>
            </div>
            <span style="font-size:12px;color:#aaa;" id="output"></span>
        <!-- <div class="progress" id="progressbar" v-if="upload_progress!==null">
            <div>{{ upload_progress }}%</div>
        </div> -->
    </div>
</template>
<script>
// import basicFileUpload from '../../api/BasicFileUpload';
import aetherupload from '../../api/TestUpload';

export default {
    props: ['value', 'crop', 'max', 'disabled', 'multiple'],
    name: 'basic-upload',
    data() {
        return {
            input: {
                // accept: '.jpg,.png',
                disabled: this.disabled || false,
                multiple: this.multiple || false
            },
            upload_progress: null,
            options: {
                maxWidth: 1000,
                maxHeight: 1000,
                crop: !!this.crop,
            },
        };
    },
    computed: {},
    created() {
        if (this.max) {
            this.options.maxWidth = this.max.width || this.options.maxWidth;
            this.options.maxHeight = this.max.height || this.options.maxHeight;
        }
    },
    methods: {
        click() {
            if (this.upload_progress || this.disabled) return;
            this.$refs.file.click();
        },
        async onChange(event) {
            this.input.disabled = true;
            let $_this = this;
            aetherupload(event, 'file').success(function() {
                let $this = this;
                console.log($this);
                console.log($this.fileName);
                console.log($this.savedPath);
                let a = $this.savedPath.split('\\');
                let filesUrl = a.join('/');
                $_this.$emit('input', '/aetherupload/' + filesUrl);
                $_this.input.disabled = false;
                $_this.upload_progress = null;
            }).upload();
            // const filesUrl = await basicFileUpload(event.target.files, this.options, {
            //     onUploadProgress: (e) => {
            //         this.upload_progress = (e.loaded / e.total).toFixed(2);
            //         this.upload_progress = parseInt(this.upload_progress * 100);
            //     }
            // });
            // this.$emit('input', filesUrl);
            // for (const fileUrl of filesUrl) {
            //     this.$emit('input', fileUrl);
            // }
            event.target.value = '';
        }
    }
};

</script>

<style lang="scss" scoped>
    .basic-upload {
        display: inline-block;
        cursor: pointer;
        position: relative;

        > input {
            opacity: 0;
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height: 0;
            padding: 0;
            margin: 0;
            z-index: -1;
            display: none;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0)
        }

        > .progress {
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, .8);
            color: #000;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            margin: auto;
        }
    }
</style>
