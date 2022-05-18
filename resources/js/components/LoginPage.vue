<template>
    <div>
        <h2 class="logincontainer" align="center">
            <u>INVENTORY AUDIT FACILITATION SYSTEM</u>
        </h2>
        <br />
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div
                            class="card-header"
                            style="background-color: blue; color: white"
                        >
                            Login Form
                        </div>
                        <div class="alert alert-danger" v-if="errors.invalid">
                            <p>{{ errors.invalid }}</p>
                        </div>
                        <div class="card-body">
                            <div class="form-floating">
                                <input
                                    id="floatingInput"
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    v-model="form.email"
                                />
                                <label for="floatingInput">Email Address</label>
                                <div
                                    class="alert alert-danger"
                                    v-if="credentials.email"
                                >
                                    {{ credentials.email }}
                                </div>
                            </div>
                            <br />
                            <div class="form-floating">
                                <input
                                    id="form1Example2"
                                    type="password"
                                    class="form-control"
                                    name="password"
                                    v-model="form.password"
                                />
                                <label for="form1Example2">Password</label>
                                <div
                                    class="alert alert-danger"
                                    v-if="credentials.password"
                                >
                                    {{ credentials.password }}
                                </div>
                            </div>
                            <br />
                            <button
                                type="button"
                                class="btn btn-primary btn-block mb-4"
                                @click.prevent="loginform"
                            >
                                Login
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// import axios from "axios";
import axios from "./store/axios.js";

export default {
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
            errors: [],
            credentials: "",
        };
    },
    methods: {
        async loginform() {
            await axios.get("/sanctum/csrf-cookie").then((response) => {
                axios
                    .post("/login", this.form)
                    .then((res) => {
                        if (res.data.invalid) {
                            this.credentials = res.data.invalid;
                        } else {
                            sessionStorage.setItem("token", res.data.token);
                            sessionStorage.setItem(
                                "Authentication",
                                res.data.data.admin
                            );
                            if (
                                res.data.data.admin === 1 ||
                                res.data.data.admin === 0
                            ) {
                                this.$router.go({ name: "adminmain" });
                            }
                        }
                    })
                    .catch((error) => {
                        this.errors = error.response.data;
                        console.log(error);
                    });
                this.credentials = "";
            });
        },
    },
    mounted() {
        if (!sessionStorage.getItem("token")) {
            this.$router.push({ name: "Login" });
        } else {
            if (
                sessionStorage.getItem("Authentication") === "1" ||
                sessionStorage.getItem("Authentication") === "0"
            ) {
                this.$router.push({ name: "adminmain" });
            }
        }
    },
};
</script>

<style scoped>
.logincontainer {
    margin-top: 5%;
    font-size: 8vmin;
    color: #c91313;
}
</style>
