import './vendors';

/* ============
 * Vue
 * ============
 *
 * Vue.js is a library for building interactive web interfaces.
 * It provides data-reactive components with a simple and flexible API.
 *
 * http://vuejs.org/guide/
 */
import Vue from 'vue';

/**
 * variable | placeholder(type)
 */
Vue.filter('placeholder', require('../filters/placeholder').default);

/* ============
 * element-ui
 * ============
 *
 * A Vue.js 2.0 UI Toolkit for Web.
 *
 * https://github.com/ElemeFE/element
 */
/*
import {Loading, MessageBox, Notification, Message} from 'element-ui';

Vue.use(Loading.directive);

window.Element = {
    $loading: Loading.service,
    $msgbox: MessageBox,
    $alert: MessageBox.alert,
    $confirm: MessageBox.confirm,
    $prompt: MessageBox.prompt,
    $notify: Notification,
    $message: Message
};
window.Msg = {
    error(msg) {
        return Element.$message.error(msg);
    },
    info(msg) {
        return Element.$message.info(msg);
    },
    success(msg) {
        return Element.$message.success(msg);
    }
};
*/

window.Msg = {
    error(msg) {
        return alert(msg);
    },
    info(msg) {
        return alert(msg);
    },
    success(msg) {
        return alert(msg);
    },
};

// 全局api接口请求处理
import Api from '../api';

/**
 * @type {AxiosInstance}
 */
window.API = new Api().http;
