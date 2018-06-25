import imgHandle from '../helpers/imgHandle';
import {uploadToken} from './Cache';

export default async (files, imgOptions, ajaxOptions = {}, uploadPath, drive) => {
    if (!ajaxOptions.onUploadProgress) {
        ajaxOptions.onUploadProgress = (e) => {
            // console.log(parseInt((e.loaded / e.total).toFixed(2) * 100));
        };
    }

    const uploadParameter = await uploadToken(drive);
    const uploadForm = uploadParameter.form;
    console.log(uploadParameter);
    if (uploadPath) uploadPath += '/';
    if (!uploadPath) uploadPath = '';

    let filesUrl = [];
    for (let i = 0; i < files.length; i++) {
        let file = files[i];
        if (file.type.includes('image') && !file.type.includes('gif') && imgOptions) {
            const newFile = await imgHandle(file, imgOptions);
            console.log(imgOptions);
            console.log(newFile);
            newFile.name = file.name;
            file = newFile;
        }
        const ext = file.name.split('.').pop();
        const filename = (new Date()).getTime() + '.' + ext;
        uploadPath += filename;

        let formData = new FormData();
        formData.append('file', file, filename);
        for (const key in uploadForm) {
            if (!{}.hasOwnProperty.call(uploadForm, key)) continue;
            formData.append(key, uploadForm[key]);
        }
        formData.append('key', uploadPath);
        await axios.post(uploadParameter.upload_url, formData, ajaxOptions);

        filesUrl.push(uploadParameter.domain + uploadPath);
        console.log(filesUrl);
    }
    return filesUrl;
};
