import imgHandle from '../helpers/imgHandle';
import {uploadToken} from './Cache';

export default async (files, imgOptions, ajaxOptions = {}, uploadPath, drive) => {
    if (!ajaxOptions.onUploadProgress) {
        ajaxOptions.onUploadProgress = (e) => {
            // console.log(parseInt((e.loaded / e.total).toFixed(2) * 100));
        };
    }

    const UploadToken = await uploadToken(drive);
    if (uploadPath) uploadPath += '/';
    if (!uploadPath) uploadPath = '';

    let filesUrl = [];
    for (let i = 0; i < files.length; i++) {
        let file = files[i];
        if (file.type.includes('video')) {
            console.log("It's video");
            const video = document.createElement('video');

            video.addEventListener('loadedmetadata', function loadedmetadata() {
                setTimeout(() => {
                    const canvas = document.createElement('canvas');
                    canvas.width = this.videoWidth;
                    canvas.height = this.videoHeight;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(this, 0, 0);

                  const image = new Image();
                  image.src = canvas.toDataURL('image/png');
                  console.log('created_image step');
                  image.onload(() => {
                    const formData = new FormData();
                    const binary = atob(canvas.toDataURL('image/png').split(',')[1]);
                    const array = [];
                    for (let i = 0; i < binary.length; i += 1) {
                        array.push(binary.charCodeAt(i));
                    }
                    const cover = new Blob([new Uint8Array(array)], { type: 'image/png' });
                    formData.append('file', cover, `${+new Date()}.png`);
                    console.log('ok');
                    // $.ajax({
                    //   url: upload_url,
                    //   crossDomain: true,
                    //   data: formData,
                    //   dataType: 'json',
                    //   method: 'POST',
                    //   contentType: false,
                    //   processData: false,
                    // }).done((jsonData) => {
                    //   //.....
                    //   //将值存储在id为thumbnail的input标签当中的value属性当中
                    //   const body = jsonData.body;
                    //   $('#thumbnail').val(body);
                    // }).fail(() => {
                    //   layer.alert('上传失败');
                    // });
                  });
                }, 300);
              }, false);
        }
        if (file.type.includes('image') && !file.type.includes('gif') && imgOptions) {
            const newFile = await imgHandle(file, imgOptions);
            newFile.name = file.name;
            file = newFile;
            console.log('qq');
        }

        const ext = file.name.split('.').pop();
        const filename = (new Date()).getTime() + '.' + ext;
        uploadPath += filename;

        let formData = new FormData();
        console.log(file);
        console.log(filename);
        formData.append('file', file, filename);
        console.log(UploadToken.form);
        // for (const key in UploadToken.form) {
        //     if (!{}.hasOwnProperty.call(foo, key)) continue;
        //     formData.append(key, UploadToken.form[key]);
        // }
        console.log(uploadPath);
        formData.append('_token', UploadToken.form._token);
        formData.append('key', uploadPath);
        console.log(formData);
        console.log(UploadToken.upload_url);
        await axios.post(UploadToken.upload_url, formData, ajaxOptions);

        filesUrl.push({
            url: UploadToken.domain + uploadPath,
            size: file.size
        });
    }
    return filesUrl;
};
