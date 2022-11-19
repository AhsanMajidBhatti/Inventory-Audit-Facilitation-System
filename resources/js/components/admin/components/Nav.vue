<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-widget="pushmenu"
                    href="#"
                    role="button"
                    ><i class="fas fa-bars"></i
                ></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-wrench"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a @click.prevent="profilepage" class="dropdown-item">
                        <div class="media">
                            <div class="media-body">
                                <i class="fas fa-user"></i>
                                Profile
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a @click.prevent="logout" class="dropdown-item">
                        <i class="fas fa-arrow-right"></i> LogOut
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-widget="fullscreen"
                    href="#"
                    role="button"
                >
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
import axios from "../../store/axios.js";

export default {
    name: "Nav",
    data() {
        return {
            currentUser: {},
            token: sessionStorage.getItem("token"),
            sessiondata: true,
        };
    },
    methods: {
        async logout() {
            await axios.get("/sanctum/csrf-cookie").then((response) => {
                axios.post("/logout", this.form).then((res) => {
                    sessionStorage.removeItem("token");
                    sessionStorage.removeItem("Authentication");
                    this.$router.push("/");
                });
            });
        },
        profilepage() {
            this.$router.push({ name: "Profile" });
        },
    },
    mounted() {
        axios.get("/user").then((res) => {
            this.currentUser = res.data;
        });
    },
    beforeRouteEnter(to, from, next) {
        this.$router.go();
    },
};
</script>
