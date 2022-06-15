<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">User Create</h1>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item active">
                                        <a href="#">Index</a>
                                    </li>
                                </ol>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <div class="card">
                    <div class="card-header">
                        User Create Page
                        <span class="d-flex float-end"
                            ><router-link
                                :to="{ name: 'AdminUserList' }"
                                class="btn btn-primary"
                                >Back</router-link
                            ></span
                        >
                    </div>
                    <div class="alert alert-danger" v-if="errorcredential">
                        <p
                            v-for="(error, index) in errorcredential"
                            :key="index"
                        >
                            {{ error }}
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row mb-3">
                                <label
                                    for="name"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Name</label
                                >

                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="name"
                                        v-model="form.name"
                                        autofocus
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label
                                    for="category"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Email</label
                                >

                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="category"
                                        v-model="form.email"
                                        autofocus
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label
                                    for="description"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Password</label
                                >

                                <div class="col-md-6">
                                    <input
                                        type="password"
                                        class="form-control"
                                        name="description"
                                        v-model="form.password"
                                        autofocus
                                    />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label
                                    for="description"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Status</label
                                >
                                <div class="col-md-6">
                                    <label
                                        class="radio-inline"
                                        v-if="currentUser.admin === 1"
                                        ><input
                                            type="radio"
                                            name="status"
                                            value="1"
                                            v-model="form.status"
                                        />Admin</label
                                    >
                                    <label class="col-md-4 radio-inline"
                                        ><input
                                            type="radio"
                                            name="status"
                                            value="0"
                                            v-model="form.status"
                                        />User</label
                                    >
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="justify-content-center d-flex">
                                    <button
                                        class="btn btn-primary"
                                        @click="CreateData"
                                    >
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "../../../store/axios.js";
export default {
    data() {
        return {
            token: sessionStorage.getItem("token"),
            form: {
                name: "",
                email: "",
                password: "",
                status: "",
            },
            currentUser: {},
            errorcredential: "",
        };
    },
    methods: {
        async CreateData() {
            await axios.get("/sanctum/csrf-cookie").then((response) => {
                axios
                    .post("/usercreate", this.form)
                    .then((res) => {
                        if (res.data.invalid) {
                            this.errorcredential = res.data.invalid;
                        } else if (
                            (res.data.message = "User Created Successfully")
                        ) {
                            this.errorcredential = "";
                            this.form = {};
                            this.$router.push({ name: "AdminUserList" });
                        }
                    })
                    .catch((error) => {
                        this.errorcredential = error.response.data;
                    });
            });
        },
    },
    mounted() {
        // window.location.reload();
        if (!this.token) {
            this.$router.push({ name: "Login" });
        } else {
            axios.get("/user").then((res) => {
                this.currentUser = res.data;
            });
        }
    },
};
</script>
