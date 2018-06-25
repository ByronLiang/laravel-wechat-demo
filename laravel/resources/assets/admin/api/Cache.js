export const handle = async (apiUrl, minutes = 1, params = {}, isCache = true) => {
    const cacheTime = new Date().getTime() + minutes * 60 * 1000;
    const cacheKey = apiUrl + JSON.stringify(params);
    let store = null;
    if (isCache) {
        console.log(cacheKey);
        store = SessionStore.get(cacheKey);
    }
    if (!store) {
        store = await API.get(apiUrl, {params});
        SessionStore.set(cacheKey, store, cacheTime);
    }
    return store;
};

/**
 * import {uploadToken} from 'api/Cache'
 * @returns {Promise<*>}
 * @constructor
 */
export const uploadToken = (drive) => handle('supplier/upload', 2, {drive});

/**
 * import {My} from 'api/Cache'
 * @returns {Promise.<void>}
 * @constructor
 */
export const my = async (commit = null) => {
    const store = handle('my/profile', 2);
    commit ? commit('setMy', store) : vm.$store.commit('setMy', store);
    return store;
};
