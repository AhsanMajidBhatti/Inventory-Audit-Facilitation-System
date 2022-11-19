<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">User Update</h1>
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
                        User Update Page
                        <span class="d-flex float-end"
                            ><router-link
                                :to="{ name: 'AdminUserList' }"
                                class="btn btn-primary"
                                >Back</router-link
                            ></span
                        >
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
                                        v-model="currentData.name"
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
                                        v-model="currentData.email"
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
                                        v-model="currentData.password"
                                        autofocus
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="justify-content-center d-flex">
                                    <button
                                        class="btn btn-primary"
                                        @click="UpdateData()"
                                    >
                                        Update
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
            currentId: this.$route.params.id,
            currentData: {},
        };
    },
    methods: {
        async UpdateData() {
            await axios
                .post("/userupdate/" + this.$route.params.id, this.currentData)
                .then((res) => {
                    this.$router.push({ name: "AdminUserList" });
                });
        },
    },
    mounted() {
        axios.get(`/userview/${this.$route.params.id}`).then((res) => {
            this.currentData = res.data[0];
        });
    },
};
</script>
