<template>
    <div class="container-fluid">
        <div class="content-header" v-if="$route.name === 'adminmain'">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">
                                <a href="#">Dashboard</a>
                            </li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <div id="content">
            <div class="container-fluid">
                <div v-if="$route.name === 'adminmain'" class="container">
                    <div class="row">
                        <div class="col-lg-4 col-8">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ AllProducts }}</h3>

                                    <h4>Total Products</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer"
                                    >More info
                                    <i class="fas fa-arrow-circle-right"></i
                                ></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-8">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ AllUsers }}</h3>

                                    <h4>User Registrations</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer"
                                    >More info
                                    <i class="fas fa-arrow-circle-right"></i
                                ></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-8">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ AllAdmins }}</h3>

                                    <h4>Unique Admin</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer"
                                    >More info
                                    <i class="fas fa-arrow-circle-right"></i
                                ></a>
                            </div>
                        </div>
                        <!-- <div class="col-lg-3 col-6">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3>
                                                53<sup style="font-size: 20px"
                                                    >%</sup
                                                >
                                            </h3>

                                            <p>Bounce Rate</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                        <a href="#" class="small-box-footer"
                                            >More info
                                            <i
                                                class="fas fa-arrow-circle-right"
                                            ></i
                                        ></a>
                                    </div>
                                </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
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
