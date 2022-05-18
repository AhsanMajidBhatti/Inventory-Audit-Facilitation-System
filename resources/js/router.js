import { createRouter, createWebHistory } from "vue-router";

//========================LOGIN WORK===================================
import LoginPage from "./components/LoginPage.vue";

//========================ADMIN PRODUCT WORK===================================
import Admin from "./components/admin/components/Main.vue";
import AdminDashboard from "./components/admin/pages/Dashboard.vue";
import AdminForm from "./components/admin/pages/Form.vue";
import AdminProductList from "./components/admin/pages/List.vue";
import AdminProductSearch from "./components/admin/pages/Search.vue";
import AdminProductUpdate from "./components/admin/pages/Update.vue";
import ExcelVue from "./components/admin/pages/Excel.vue";
import Profile from "./components/admin/pages/Profile.vue";

//========================ADMIN USERS WORK===================================
import AdminUserUpdate from "./components/admin/pages/users/Update.vue";
import AdminUserList from "./components/admin/pages/users/List.vue";
import AdminUserCreate from "./components/admin/pages/users/Create.vue";

const routes = [
    {
        path: "/",
        component: LoginPage,
        name: "Login",
    },
    {
        path: "/admin",
        component: Admin,
        children: [
            {
                path: "",
                component: AdminDashboard,
                name: "adminmain",
            },
            {
                path: "form",
                component: AdminForm,
                name: "AdminForm",
            },
            {
                path: "productupdate/:SNO",
                component: AdminProductUpdate,
                name: "ProductUpdate",
            },
            {
                path: "productlist",
                component: AdminProductList,
                name: "AdminProductList",
            },
            {
                path: "productsearch",
                component: AdminProductSearch,
                name: "AdminProductSearch",
            },
            {
                path: "excel",
                component: ExcelVue,
                name: "excel",
            },
            {
                path: "userlist",
                component: AdminUserList,
                name: "AdminUserList",
            },
            {
                path: "usercreate",
                component: AdminUserCreate,
                name: "AdminUserCreate",
            },
            {
                path: "Userupdate/:id",
                component: AdminUserUpdate,
                name: "UserUpdate",
            },
            {
                path: "profile",
                component: Profile,
                name: "Profile",
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    mode: "history",
});

export default router;
