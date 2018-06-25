/* eslint-disable no-undef */
import ErrorHandle from './ErrorHandle';
import BaseUrl from './BaseUrl';
import * as stringify from 'qs/lib/stringify';

export default class {
    constructor(prefix = '') {
        this.base_url = BaseUrl;
        this.base_url += prefix;
        this.http = axios.create({
            baseURL: this.base_url,
            withCredentials: true,
            paramsSerializer(params) {
                return stringify(params, {arrayFormat: 'brackets'});
            },
        });
        this.http.interceptors.request.use((config) => {
            return config;
        });
        this.http.interceptors.response.use(
            (response) => {
                if (response.data.status === 'success') {
                    return response.data.data;
                }
                if (response.data.code) {
                    new ErrorHandle(response.data);
                    return Promise.reject(response.data);
                }
                if (response.data.message) {
                    Msg.error(response.data.message);
                    return Promise.reject(response.data);
                }
            },
            (error) => {
                if (error.response && error.response.status > 200) {
                    return this.httpErrorHandle(error);
                }
                Msg.error(error.message);
                return Promise.reject(error);
            }
        );
    }

    httpErrorHandle(error) {
        const res = error.response.data;
        let msg = error.response.statusText;
        switch (error.response.status) {
            case 429:
                msg = '您的操作过于频繁！';
                break;
            case 401:
                msg = '未登录，请登录后操作';
                vm.$router.push('/login');
                break;
            default:
                if (res && res.message) {
                    msg = res.message;
                }
                break;
        }
        msg && Msg.error(msg);
        return Promise.reject(error);
    }
}
