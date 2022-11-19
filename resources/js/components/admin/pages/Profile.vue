<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Profile Page</h1>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <div class="card">
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
                                        v-model="currentUser.name"
                                        autofocus
                                        readonly
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
                                        v-model="currentUser.email"
                                        autofocus
                                        readonly
                                    />
                                </div>
                            </div>
                            <!-- <div class="row mb-3">
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
                            </div> -->

                            <div class="row mb-3">
                                <label
                                    for="description"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Status</label
                                >
                                <div class="col-md-6">
                                    <!-- <label class="radio-inline"
                                        ><input
                                            type="radio"
                                            name="status"
                                            value="1"
                                            v-model="currentUser.admin"
                                            disabled
                                        />Admin</label
                                    >
                                    <label class="col-md-4 radio-inline"
                                        ><input
                                            type="radio"
                                            name="status"
                                            value="0"
                                            v-model="currentUser.admin"
                                            disabled
                                        />User</label
                                    > -->
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="status"
                                        :value="
                                            currentUser.admin === 1
                                                ? 'Admin'
                                                : currentUser.admin === 0
                                                ? 'User'
                                                : ''
                                        "
                                        autofocus
                                        readonly
                                    />
                                </div>
                            </div>

                            <!-- <div class="row mb-3">
                                <div class="justify-content-center d-flex">
                                    <button
                                        class="btn btn-primary"
                                        @click="CreateData"
                                    >
                                        Submit
                                    </button>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "../../store/axios.js";
export default {
    data() {
        return {
            errorcredential: "",
            token: sessionStorage.getItem("token"),
            currentUser: {},
        };
    },
    methods: {},
    mounted() {
        axios.get("/user").then((res) => {
            this.currentUser = res.data;
            console.log(this.currentUser);
        });
    },
};
</script>
