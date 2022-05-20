<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img
                :src="'/AdminLTE/dist/img/AdminLTELogo.png'"
                alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3"
                style="opacity: 0.8"
            />
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img
                        :src="'/AdminLTE/dist/img/user2-160x160.jpg'"
                        class="img-circle elevation-2"
                        alt="User Image"
                    />
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ currentUser.name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul
                    class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false"
                >
                    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a
                            :href="
                                $router.resolve({
                                    name: 'adminmain',
                                }).href
                            "
                            class="nav-link"
                            :class="$route.name === 'adminmain' ? 'active' : ''"
                        >
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            href="#"
                            class="nav-link"
                            :class="
                                $route.name === 'AdminUserList' ||
                                $route.name === 'AdminUserCreate' ||
                                $route.name === 'UserUpdate'
                                    ? 'active'
                                    : ''
                            "
                        >
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Users
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link
                                    :to="{ name: 'AdminUserList' }"
                                    class="nav-link"
                                    :class="
                                        $route.name === 'AdminUserList'
                                            ? 'active'
                                            : ''
                                    "
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Index
                                        <span class="badge badge-info right">{{
                                            AllUsers + AllAdmins
                                        }}</span>
                                    </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link
                                    :to="{ name: 'AdminUserCreate' }"
                                    :class="
                                        $route.name === 'AdminUserCreate'
                                            ? 'active'
                                            : ''
                                    "
                                    class="nav-link"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a
                            href="#"
                            class="nav-link"
                            :class="
                                $route.name === 'AdminProductList' ||
                                $route.name === 'AdminForm' ||
                                $route.name === 'excel'
                                    ? 'active'
                                    : ''
                            "
                        >
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Products
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link
                                    :to="{ name: 'AdminProductList' }"
                                    :class="
                                        $route.name === 'AdminProductList'
                                            ? 'active'
                                            : ''
                                    "
                                    class="nav-link"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Index
                                        <span class="badge badge-info right">{{
                                            AllProducts
                                        }}</span>
                                    </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link
                                    :to="{ name: 'AdminProductSearch' }"
                                    :class="
                                        $route.name === 'AdminProductSearch'
                                            ? 'active'
                                            : ''
                                    "
                                    class="nav-link"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Search</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link
                                    :to="{ name: 'AdminForm' }"
                                    :class="
                                        $route.name === 'AdminForm'
                                            ? 'active'
                                            : ''
                                    "
                                    class="nav-link"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Form Entry</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link
                                    :to="{ name: 'excel' }"
                                    :class="
                                        $route.name === 'excel' ? 'active' : ''
                                    "
                                    class="nav-link"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Excel Import & Export</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <!-- <li class="nav-header">EXAMPLES</li> -->
                </ul>
            </nav>
        </div>
    </aside>
</template>

<script>
import axios2 from "axios";
import axios from "../../store/axios.js";
export default {
    data() {
        return {
            AllUsers: "",
            AllAdmins: "",
            AllProducts: "",
            currentUser: {},
            interval: false,
        };
    },
    methods: {
        fetching() {
            axios2
                .all([
                    axios.get("/allusers"),
                    axios.get("/alladmins"),
                    axios.get("/allproductfiles"),
                ])
                .then(
                    axios2.spread((data1, data2, data3) => {
                        this.AllUsers = data1.data;
                        this.AllAdmins = data2.data;
                        this.AllProducts = data3.data;
                    })
                );
        },
    },
    mounted() {
        this.fetching();
        axios.get("/user").then((res) => {
            this.currentUser = res.data;
        });
    },
};
</script>
