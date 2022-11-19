<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product Location List</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label
                                for="productid"
                                class="col-form-label text-md-end"
                                >Product ID</label
                            >

                            <input
                                type="text"
                                class="form-control"
                                name="SNo"
                                :value="this.currentloc.id"
                                disabled
                            />
                        </div>
                        <div class="col-md-4">
                            <label
                                for="productid"
                                class="col-form-label text-md-end"
                                >Current Location</label
                            >

                            <input
                                type="text"
                                class="form-control"
                                name="SNo"
                                :value="this.currentloc.location"
                                disabled
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <tr style="text-align: center">
                            <th>No</th>
                            <th>Previous Location</th>
                            <th>location Change Dates</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            style="text-align: center"
                            v-for="(prev, keyindex) in prevloclist"
                            :key="prev.id"
                        >
                            <td>{{ ++keyindex }}</td>
                            <td>{{ prev.previous_location }}</td>
                            <td>{{ prev.location_change_date }}</td>
                        </tr>
                    </tbody>
                    <tbody v-show="prevloclist.length === 0">
                        <tr>
                            <td>No Data of Previous Location</td>
                        </tr>
                    </tbody>
                </table>
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
            currentId: this.$route.params.SNO,
            currentloc: {
                id: "",
                location: "",
            },
            prevloclist: {},
            locid: 0,
        };
    },
    mounted() {
        if (!this.token) {
            this.$router.push({ name: "Login" });
        } else {
            axios.get("/productlocationlist/" + this.currentId).then((res) => {
                this.currentloc.id = res.data[0][0].SNo;
                this.currentloc.location = res.data[0][0].assigned;

                this.prevloclist = res.data[1];
            });
        }
    },
};
</script>
