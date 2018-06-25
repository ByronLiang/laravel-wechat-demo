const lazyLoading = (name) => () => import(`../pages/${name}.vue`);
// const Loading = (name, index = false) => require(`../pages/${name}.vue`);

const DefaultIndex = {template: '<router-view></router-view>'};

module.exports = {
    base: '/admin/',
    // history,hash
    mode: 'history',
    routes: [
        {
            path: '/login',
            component: lazyLoading('Login'),
        }, {
            path: '/',
            component: require('../components/layout/Container.vue'),
            redirect: {
                name: 'Dashboard',
            },
            children: [
                {
                    name: 'Dashboard',
                    path: 'dashboard',
                    component: lazyLoading('Dashboard'),
                    meta: {
                        title: '信息面板',
                    },
                }, {
                    name: 'From',
                    path: 'from',
                    component: DefaultIndex,
                    redirect: {
                        name: 'From.List',
                    },
                    meta: {
                        title: '表单例子',
                    },
                    children: [
                        {
                            name: 'From.List',
                            path: 'editor',
                            component: lazyLoading('From/Editor'),
                            meta: {
                                title: '编辑器',
                            },
                        },
                    ],
                }, {
                    name: 'MyProfile',
                    path: 'my-profile',
                    component: lazyLoading('MyProfile'),
                },
                {
                    name: 'Product',
                    path: 'product',
                    component: DefaultIndex,
                    redirect: {
                        name: 'Product.List',
                    },
                    meta: {
                        title: '产品列表',
                    },
                    children: [
                        {
                            name: 'Product.List',
                            path: 'list',
                            component: lazyLoading('Product/List'),
                            meta: {
                                title: '产品列表',
                            },
                        },
                        {
                            name: 'Product.edit',
                            path: 'edit/:id?',
                            component: lazyLoading('Product/Edit'),
                            meta: {
                                title: '编辑产品',
                            },
                        }
                    ],
                },
                {
                    name: 'Banner',
                    path: 'banner',
                    component: DefaultIndex,
                    redirect: {
                        name: 'Banner.Home',
                    },
                    meta: {
                        title: '公告栏列表',
                    },
                    children: [
                        {
                            name: 'Banner.Home',
                            path: '/',
                            component: lazyLoading('Banner/Home'),
                            meta: {
                                title: '公告栏信息列表',
                            },
                        },
                        {
                            name: 'Banner.show',
                            path: 'show/:id?',
                            component: lazyLoading('Banner/Show'),
                            meta: {
                                title: '编辑公告栏',
                            },
                        }
                    ],
                },
                {
                    name: 'Catagory',
                    path: 'catagory',
                    component: DefaultIndex,
                    redirect: {
                        name: 'Catagory.Home',
                    },
                    meta: {
                        title: '类型列表',
                    },
                    children: [
                        {
                            name: 'Catagory.Home',
                            path: 'list',
                            component: lazyLoading('Catagory/Home'),
                            meta: {
                                title: '分类列表',
                            },
                        },
                        {
                            name: 'Catagory.show',
                            path: 'show/:id?',
                            component: lazyLoading('Catagory/Show'),
                            meta: {
                                title: '编辑分类',
                            },
                        }
                    ],
                },
                {
                    name: 'Author',
                    path: 'author',
                    component: DefaultIndex,
                    redirect: {
                        name: 'Author.Home',
                    },
                    meta: {
                        title: '主讲人管理',
                    },
                    children: [
                        {
                            name: 'Author.Home',
                            path: 'list',
                            component: lazyLoading('Author/Home'),
                            meta: {
                                title: '主讲人列表',
                            }
                        }, {
                            name: 'Author.Detail',
                            path: 'show/:id?',
                            component: lazyLoading('Author/Detail'),
                            meta: {
                                title: '主讲人详情',
                            }
                        }
                    ],
                }
            ],
        }, {
            path: '*',
            redirect: '/',
        },
    ],
};
