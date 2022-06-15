<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product List</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active d-flex">
                                <input
                                    type="text"
                                    name="keywords"
                                    placeholder="Search Product"
                                    size="40"
                                    v-model="keyword"
                                    @keyup="getData"
                                    class="form-control"
                                />
                                <!-- <button
                                    class="btn btn-primary"
                                    @click="SearchBar"
                                >
                                    Submit
                                </button> -->
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
                            <th>SNo</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Last Date Of Inactive</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody v-show="productdata.total > 0">
                        <tr
                            style="text-align: center"
                            v-for="post in productdata.data"
                            :key="post.id"
                        >
                            <td>{{ post.SNo }}</td>
                            <td>{{ post.name }}</td>
                            <td>{{ post.category }}</td>
                            <td>{{ post.status }}</td>
                            <td>{{ post.inactive_date }}</td>
                            <td>
                                <button
                                    class="btn btn-primary"
                                    style="margin-right: 2vmin"
                                    @click="viewData(post.SNo)"
                                >
                                    View
                                </button>
                                <router-link
                                    :to="{
                                        name: 'ProductUpdate',
                                        params: { SNO: post.SNo },
                                    }"
                                    style="margin-right: 2vmin"
                                    class="btn btn-warning"
                                    >Update</router-link
                                >
                                <!-- <button
                                    class="btn btn-danger"
                                    @click.prevent="deleteForm(post.SNo)"
                                >
                                    Delete
                                </button> -->
                                <button
                                    class="btn btn-danger"
                                    @click.prevent="deleteForm(post.SNo)"
                                >
                                    {{
                                        post.status == "Active"
                                            ? "InActive"
                                            : "Active"
                                    }}
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-show="productdata.total === 0">
                        <tr>
                            <td>No Data of Product</td>
                        </tr>
                    </tbody>
                </table>
                <Pagination
                    :data="productdata"
                    @pagination-change-page="getData"
                >
                </Pagination>
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";
import axios from "../../store/axios.js";
import LaravelVuePagination from "laravel-vue-pagination";
export default {
    data() {
        return {
            token: sessionStorage.getItem("token"),
            productdata: {},
            showdata: [],
            isDeleted: false,
            excelData: [],
            keyword: "",
        };
    },
    components: {
        Pagination: LaravelVuePagination,
    },
    methods: {
        // SearchBar() {
        //     axios.get("productsearchbar?q=" + this.keyword).then((res) => {
        //         return res.data;
        //         // console.log(res);
        //         // this.productdata = res.data;
        //     });
        // },
        getData(page = 1) {
            // if (this.keyword === "") {
            axios.get("/sanctum/csrf-cookie").then((response) => {
                axios
                    .get(`/productlist?q=` + this.keyword + `&page=` + page)
                    .then((res) => {
                        this.productdata = res.data;
                        // console.log(res.data);
                    });
            });
            // } else {
            //     axios.get("/sanctum/csrf-cookie").then((response) => {
            //         axios
            //             .get("productsearchbar/q=" + this.keyword)
            //             .then((res) => {
            //                 console.log(res.data.data);
            //                 this.productdata.data = res.data.data;
            //             });
            //     });
            // }
        },
        // SearchBar: _.debounce(function () {
        // if (this.keyword !== "") {
        // axios.get("productsearchbar/q=" + this.keyword).then((res) => {
        //     // console.log(res.data);
        //     this.productdata.data = res.data;
        // });
        //     }
        // }),
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
                    axios.delete("/productdel/" + index).then((res) => {
                        window.location.reload();
                    });
                }
            });
        },
        viewData(SNo) {
            axios.get("/productview/" + SNo).then((res) => {
                Swal.fire({
                    icon: "success",
                    title: `Product Detail`,
                    width: "800",
                    html: `<form>
                    <div class="form-group col-md-12 row justify-content-center">
                        <label class="col-sm-2 col-form-label">SNO</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" value="${
                                res.data[0].SNo
                            }">
                        </div>
                    </div>
                    <div class="form-group col-md-12 row justify-content-center">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" value="${
                                res.data[0].name
                            }">
                        </div>
                    </div>
                    <div class="form-group col-md-12 row justify-content-center">
                        <label class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" value="${
                                res.data[0].category
                            }">
                        </div>
                    </div>
                    <div class="form-group col-md-12 row justify-content-center">
                        <label class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" value="${
                                res.data[0].description
                            }">
                        </div>
                    </div>

                    <div class="form-group col-md-12 row justify-content-center">
                        <label class="col-sm-2 col-form-label">Assigned</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" value="${
                                res.data[0].assigned
                            }">
                        </div>
                    </div>
                    <div class="form-group col-md-12 row justify-content-center">
                        <label class="col-sm-2 col-form-label">Condition</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" value="${
                                res.data[0].condition
                            }">
                        </div>
                    </div>
                    <div class="form-group col-md-12 row justify-content-center">
                        <label class="col-sm-2 col-form-label">Cost</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" value="${
                                res.data[0].cost
                            }">
                        </div>
                    </div>

                    <div class="form-group col-md-12 row justify-content-center">
                        <label class="col-sm-2 col-form-label">Book Value</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" value="${
                                res.data[0].book_value
                            }">
                        </div>
                    </div>
                    <div class="form-group col-md-12 row justify-content-center">
                        <label class="col-sm-2 col-form-label">NBV</label>
                        <div class="col-sm-8">
                            <input type="text" disabled class="form-control" value="${
                                res.data[0].NBV
                            }">
                        </div>
                    </div>
                    <div class="form-group col-md-12 row justify-content-center">
                        <label class="col-sm-4 col-form-label">Date Of Purchase</label>
                        <div class="col-sm-6">
                            <input type="text" disabled class="form-control" value="${
                                res.data[0].dateofpurchase
                            }">
                        </div>
                    </div>
                    <div class="form-group col-md-12 row justify-content-center">
                        <label class="col-sm-4 col-form-label">Disposal Cost</label>
                        <div class="col-sm-6">
                            <input type="text" disabled class="form-control" value="${
                                res.data[0].disposal_cost
                            }">
                        </div>
                    </div>
                    <div class="form-group col-md-12 row justify-content-center">
                        <label class="col-sm-4 col-form-label">Department Rate</label>
                        <div class="col-sm-6">
                            <input type="text" disabled class="form-control" value="${
                                res.data[0].deptrate
                            }">
                        </div>
                    </div>
                    <div class="form-group col-md-12 row justify-content-center">
                        <label class="col-sm-4 col-form-label">Disposal Depreciation</label>
                        <div class="col-sm-6">
                            <input type="text" disabled class="form-control" value="${
                                res.data[0].depreciation
                            }">
                        </div>
                    </div>
                    <div class="form-group col-md-12 row justify-content-center">
                        <label class="col-sm-4 col-form-label">Accumulated Department</label>
                        <div class="col-sm-6">
                            <input type="text" disabled class="form-control" value="${
                                res.data[0].accumulated_dept
                            }">
                        </div>
                    </div>
                    <br/>
                    <div class="form-group col-md-12 row justify-content-center">
                        Depreciation Rate (Yearly Based)
                    </div>
                    <br/>
                    <div class="form-group col-md-12 row justify-content-center">
                     ${res.data[1]
                         .slice()
                         .reverse()
                         .map(
                             (input) => `
                                    <label class="col-sm-2 col-form-label">${input.name}</label>
                                    <div class="col-sm-8">
                                        <input type="text" disabled class="form-control" value="${input.cost}">
                                    </div>`
                         )}
                     </div>
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
        }
    },
};
</script>
