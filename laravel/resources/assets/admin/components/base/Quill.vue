<template>
    <div class="quill-editor">
        <div ref="toolbar">
            <span class="ql-formats">
                <select class="ql-font"></select>
                <select class="ql-size"></select>
                <select class="ql-header"></select>
            </span>
            <span class="ql-formats">
                <button class="ql-bold"></button>
                <button class="ql-italic"></button>
                <button class="ql-underline"></button>
                <button class="ql-strike"></button>
            </span>
            <span class="ql-formats">
                <select class="ql-color"></select>
                <select class="ql-background"></select>
            </span>
            <span class="ql-formats">
                <button class="ql-script" value="sub"></button>
                <button class="ql-script" value="super"></button>
            </span>
            <span class="ql-formats">
                <button class="ql-blockquote"></button>
                <button class="ql-code-block"></button>
            </span>
            <span class="ql-formats">
                <button class="ql-list" value="ordered"></button>
                <button class="ql-list" value="bullet"></button>
                <button class="ql-indent" value="-1"></button>
                <button class="ql-indent" value="+1"></button>
            </span>
            <span class="ql-formats">
                <button class="ql-direction" value="rtl"></button>
                <select class="ql-align"></select>
            </span>
            <span class="ql-formats">
                <button class="ql-link"></button>
                <button class="ql-image"></button>
                <!--<button class="ql-video"></button>-->
                <!--<button class="ql-formula"></button>-->
            </span>
            <span class="ql-formats">
                <button class="ql-clean"></button>
            </span>
        </div>
        <div ref="editor"></div>
    </div>
</template>

<script>
    import Quill from 'quill/dist/quill.min';
    import fileUpload from '../../api/fileUpload';

    export default {
        components: {},
        props: {
            content: String,
            value: String,
            placeholder: String,
            disabled: Boolean,
            options: {
                type: Object,
                required: false,
                default() {
                    return {};
                }
            },
            imgMaxWidth: {
                type: Object,
                default: 1000
            },
        },
        data() {
            return {
                _content: '',
                modules: {
                    toolbar: {
                        container: null,
                        handlers: {
                            image: this.imagesUploadHandle,
                        }
                    }
                }
            };
        },
        computed: {},
        watch: {
            content(newVal, oldVal) {
                if (this.quill) {
                    if (!!newVal && newVal !== this._content) {
                        this._content = newVal;
                        this.quill.pasteHTML(newVal);
                    } else if (!newVal) {
                        this.quill.setText('');
                    }
                }
            },
            value(newVal, oldVal) {
                if (this.quill) {
                    if (!!newVal && newVal !== this._content) {
                        this._content = newVal;
                        this.quill.pasteHTML(newVal);
                    } else if (!newVal) {
                        this.quill.setText('');
                    }
                }
            },
            disabled(newVal, oldVal) {
                if (this.quill) {
                    this.quill.enable(!newVal);
                }
            }
        },
        methods: {
            imagesUploadHandle() {
                let fileInput = this.$refs.toolbar.querySelector('input.ql-image[type=file]');
                if (!fileInput) {
                    fileInput = document.createElement('input');
                    fileInput.setAttribute('type', 'file');
                    fileInput.setAttribute('multiple', true);
                    fileInput.setAttribute('accept', 'image/png, image/gif, image/jpeg, image/bmp, image/x-icon');
                    fileInput.classList.add('ql-image');
                    fileInput.addEventListener('change', async (event) => {
                        if (!event.target.files || !event.target.files.length) return;

                        let insertIndex = this.quill.getSelection(true).index;

                        const filesUrl = await fileUpload(event.target.files, {
                            maxWidth: this.imgMaxWidth
                        });
                        for (const fileUrl of filesUrl) {
                            this.quill.insertEmbed(insertIndex, 'image', fileUrl, {
                                maxWidth: '100%'
                            });
                            insertIndex++;
                        }

                        this.quill.setSelection(insertIndex);
                        fileInput.value = '';
                    });
                    this.$refs.toolbar.appendChild(fileInput);
                }
                fileInput.click();
            },
            initialize() {
                const $editor = this.$refs.editor;

                // options and instance
                this.options.modules = this.options.modules || this.modules;
                this.options.theme = this.options.theme || 'snow';
                this.options.boundary = this.options.boundary || this.$el;
                this.options.placeholder = this.options.placeholder || this.placeholder || 'Insert text here ...';
                this.options.readOnly = !!this.options.readOnly;
                this.options.modules.toolbar.container = this.$refs.toolbar;
                this.quill = new Quill($editor, this.options);

                // set editor content
                if (this.value || this.content) {
                    this.quill.pasteHTML(this.value || this.content);
                }

                // mark model as touched if editor lost focus
                this.quill.on('selection-change', (range) => {
                    if (!range) {
                        this.$emit('blur', this.quill);
                    } else {
                        this.$emit('focus', this.quill);
                    }
                });
                // update model if text changes
                this.quill.on('text-change', (delta, oldDelta, source) => {
                    let html = $editor.querySelector('.ql-editor').innerHTML;
                    const text = this.quill.getText();
                    html.replace('<p><br></p>', '');
                    this._content = html;
                    this.$emit('input', this._content);
                    this.$emit('change', {
                        editor: this.quill,
                        html,
                        text
                    });
                });
                // emit ready
                this.$emit('ready', this.quill);
            }
        },
        mounted() {
            this.initialize();
        },
        beforeDestroy() {
        }
    };
</script>

<style lang="scss">
    @import '../../../../../node_modules/quill/dist/quill.snow.css';

    .quill-editor {
        .ql-editor {
            min-height: 150px;
        }
    }
</style>