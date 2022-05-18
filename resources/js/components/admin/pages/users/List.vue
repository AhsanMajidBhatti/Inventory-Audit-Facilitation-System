<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User List</h1>
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
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <tr style="text-align: center">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Admin</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody v-show="userdata.total > 0">
                        <tr
                            style="text-align: center"
                            v-for="post in userdata.data"
                            :key="post.id"
                        >
                            <td>{{ post.id }}</td>
                            <td>{{ post.name }}</td>
                            <td>{{ post.email }}</td>
                            <td>
                                {{
                                    post.admin == 1
                                        ? "Super Admin"
                                        : "Only User"
                                }}
                            </td>
                            <td>
                                <button
                                    class="btn btn-primary"
                                    style="margin-right: 2vmin"
                                    @click="viewData(post.id)"
                                >
                                    View
                                </button>
                                <router-link
                                    :to="{
                                        name: 'UserUpdate',
                                        params: { id: post.id },
                                    }"
                                    style="margin-right: 2vmin"
                                    class="btn btn-warning"
                                    >Update</router-link
                                >
                                <button
                                    class="btn btn-danger"
                                    @click.prevent="deleteForm(post.id)"
                                    :disabled="
                                        currentUser.email == post.email &&
                                        currentUser.admin == 0
                                    "
                                >
                                    DELETE
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-show="userdata.total === 0">
                        <tr>
                            <td>No Data of Users</td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :data="userdata" @pagination-change-page="getData">
                </Pagination>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "../../../store/axios.js";
import LaravelVuePagination from "laravel-vue-pagination";
export default {
    data() {
        return {
            token: sessionStorage.getItem("token"),
            currentUser: {},
            userdata: {},
            showdata: [],
            isDeleted: false,
            excelData: [],
        };
    },
    components: {
        Pagination: LaravelVuePagination,
    },
    methods: {
        getData(page = 1) {
            axios.get("/sanctum/csrf-cookie").then((response) => {
                axios.get("/userlist?page=" + page).then((res) => {
                    this.userdata = res.data;
                });
            });
        },
        async deleteForm(index) {
            Swal.fire({
                title: "Are you sure?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete("/userdel/" + index).then((res) => {
                        window.location.reload();
                    });
                }
            });
        },
        viewData(SNo) {
            axios.get("/userview/" + SNo).then((res) => {
                Swal.fire({
                    icon: "success",
                    title: `Product Detail`,
                    width: "800",
                    html: `<form>
                    <div class="form-group col-md-12 row justify-content-center">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" value="${res.data[0].name}">
                        </div>
                    </div>
                    <div class="form-group col-md-12 row justify-content-center">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" value="${res.data[0].email}">
                        </div>
                    </div>
                    <br/>
                     </form>
                     `,
                    showClass: {
                        popup: "animate__animated animate__fadeInDown",
                    },
                    hideClass: {
                        popup: "animate__animated animate__fadeOutUp",
                    },
                });
            });
        },
    },
    mounted() {
        // window.location.reload();
        if (!this.token) {
            this.$router.push({ name: "Login" });
        } else {
            this.getData();
            axios.get("/user").then((res) => {
                this.currentUser = res.data;
            });
        }
    },
};
</script>
