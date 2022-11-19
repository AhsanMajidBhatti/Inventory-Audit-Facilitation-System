<template>
    <div class="wrapper">
        <Nav />
        <Sidebar />
        <div class="content-wrapper" style="background-color: #d7e1f0">
            <router-view></router-view>
        </div>
        <Footer />
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>
</template>

<script>
import Nav from "./Nav.vue";
import Footer from "./Footer.vue";
import Sidebar from "./Sidebar.vue";
import axios2 from "axios";
import axios from "../../store/axios.js";
export default {
    data() {
        return {
            token: sessionStorage.getItem("token"),
            currentRoute: this.$route.name,
            AllUsers: "",
            AllAdmins: "",
            AllProducts: "",
        };
    },
    components: {
        Nav,
        Footer,
        Sidebar,
    },
    mounted() {
        if (!this.token) {
            this.$router.push({ name: "Login" });
        } else {
            axios2
                .all([
                    axios.get("/allusers"),
                    axios.get("/alladmins"),
                    axios.get("/allproducts"),
                ])
                .then(
                    axios2.spread((data1, data2, data3) => {
                        this.AllUsers = data1.data;
                        this.AllAdmins = data2.data;
                        this.AllProducts = data3.data;
                    })
                );
        }

        if (this.$route.name !== "adminDashboard") {
            this.currentRoute = false;
        }
    },
};
</script>

<style scoped>
.center {
    display: flex;
    justify-content: center;
}
</style>
