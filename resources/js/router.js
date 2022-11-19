import { createRouter, createWebHistory } from "vue-router";

//========================LOGIN WORK===================================
import LoginPage from "./components/LoginPage.vue";

//========================ADMIN PRODUCT WORK===================================
import Admin from "./components/admin/components/Main.vue";
import AdminDashboard from "./components/admin/pages/Dashboard.vue";
import AdminForm from "./components/admin/pages/products/Form.vue";
import AdminProductList from "./components/admin/pages/lists/List.vue";
import AdminProductSearch from "./components/admin/pages/products/Search.vue";
import AdminProductUpdate from "./components/admin/pages/products/Update.vue";
import ExcelVue from "./components/admin/pages/products/Excel.vue";
import Profile from "./components/admin/pages/Profile.vue";
import ProductLocation from "./components/admin/pages/lists/LocationList.vue";

//========================ADMIN USERS WORK===================================
import AdminUserUpdate from "./components/admin/pages/users/Update.vue";
import AdminUserList from "./components/admin/pages/users/List.vue";
import AdminUserCreate from "./components/admin/pages/users/Create.vue";

//========================ADMIN PRODUCT WORK===================================
import Chart from "./components/admin/pages/Chart.vue";
import Analysis from "./components/admin/pages/Analysis.vue";

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
            {
                path: "productlocation/:SNO",
                component: ProductLocation,
                name: "ProductLocation",
            },
            {
                path: "charts",
                component: Chart,
                name: "ChartPage",
            },
            {
                path: "analysis",
                component: Analysis,
                name: "AnalysisPage",
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
