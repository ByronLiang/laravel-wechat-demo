<template>
    <el-menu router class="container-menu"
             :collapse="collapse"
             :default-openeds="defaultOpeneds"
             :default-active="activeMenu">
        <template>
            <router-link class="site" to="/" tag="li">
                <i class="fa fa-bandcamp" aria-hidden="true"></i>
                <span class="title">{{ $store.state.site_title }}</span>
            </router-link>
        </template>
        <template v-for="(route, index) in menus">
            <template v-if="route.children">
                <el-submenu :index="route.name">
                    <template slot="title">
                        <i class="fa fa-list-ul" aria-hidden="true"></i>
                        <span>{{route.meta.title}}</span>
                    </template>
                    <el-menu-item v-for="(cRoute, cIndex) in route.children"
                                  :key="cRoute"
                                  :index="cRoute.name"
                                  :route="cRoute">
                        <span slot="title">{{cRoute.meta.title}}</span>
                    </el-menu-item>
                </el-submenu>
            </template>

            <template v-if="!route.children">
                <el-menu-item :index="route.name" :route="route">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                    <span slot="title">{{route.meta.title}}</span>
                </el-menu-item>
            </template>
        </template>
    </el-menu>
</template>

<script>
    import {MenuItem, Menu, Submenu} from 'element-ui';
    import {mapState} from 'vuex';

    export default {
        components: {
            ElMenu: Menu,
            ElMenuItem: MenuItem,
            ElSubmenu: Submenu,
        },
        props: ['collapse'],
        data() {
            return {
                activeMenu: '',
                defaultOpeneds: [],
                isCollapse: false,
            };
        },
        computed: {
            ...mapState([
                'my'
            ]),
            menus() {
                const index = this.$router.options.routes.length - 2;
                return this.filterMenus(this.$router.options.routes[index].children);
            }
        },
        watch: {
            '$route'(to, from) {
                this.setActiveMenu();
            },
        },
        methods: {
            filterMenus(arr) {
                return arr.filter(i => {
                    if (!i.meta) return false;
                    if (!i.meta.title) return false;
                    if(!this.my) return true;

                    if (this.my.role === 'root') return true;

                    if (!i.meta.roles) return true;
                    if (!i.meta.roles.length) return false;

                    let ret = false;
                    for (const role of i.meta.roles) {
                        if (!this.my.role.includes(role)) continue;
                        ret = true;
                        break;
                    }
                    if(!ret) return false;

                    if (!i.meta.jurisdictions) return true;

                    for (const jurisdictionName of this.my.jurisdictions_key) {
                        if (i.meta.jurisdictions.includes(jurisdictionName)) return true;
                    }
                    return false;
                }).map((v, index) => {
                    if (v.children && v.children.length) {
                        v.children = this.filterMenus(v.children);
                    }
                    if (v.children && !v.children.length) {
                        delete v.children;
                    }
                    if (v.component) delete v.component;

                    //设定默认展开
                    // if (index <= 2 && v.children && v.children.length) this.defaultOpeneds.push(v.name);
                    return v;
                });
            },
            setActiveMenu() {
                const matched = this.$route.matched.filter(i => i.meta && i.meta.title);
                if (matched.length >= 2) {
                    this.activeMenu = matched[matched.length - 1].name;
                    return;
                }
                this.activeMenu = this.$route.name;
            },
        },
        created() {
            this.activeMenu = this.$route.name;
        }
    }
</script>

<style lang="scss">
    // slide-menu
    .container-menu {
        flex-grow: 0;
        flex-shrink: 0;
        border-right: 0;
        background: #001529;

        .site {
            height: 60px;
            line-height: 60px;
            padding-left: 20px;
            transition: all .3s;
            background: #002140;
            overflow: hidden;
            white-space: nowrap;
            color: #fff;
            font-size: 20px;
            font-weight: bold;
        }

        &.el-menu--collapse {
            .site .title {
                opacity: 0;
            }

            .el-submenu .el-menu-item {
                background: #001529;
            }
        }

        &:not(.el-menu--collapse) {
            width: 256px;
            min-height: 100%;
        }

        .el-menu, .el-footer {
            background-color: transparent;
        }
        .el-submenu {
            .el-submenu__title, .el-submenu__title i {
                color: rgba(255, 255, 255, 0.65);

                &:hover {
                    color: #fff;
                    background-color: transparent;
                }
            }

            &.is-active {
                .el-submenu__title, .el-submenu__title i {
                    color: #fff;
                }
            }

        }

        .el-menu-item {
            color: rgba(255, 255, 255, 0.65);

            &:hover {
                color: #fff;
                background-color: transparent;
            }
            &.is-active {
                color: #fff;
                background-color: #1890ff;
            }
        }

        .el-menu-item, .el-submenu__title {
            height: 40px;
            line-height: 40px;
        }
    }
</style>