<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product List</h1>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <div class="card">
            <div class="card-body table-responsive">
                <div class="row">
                    <div class="col">
                        <select
                            class="form-control"
                            name="optionselect"
                            v-model="optionselect"
                            @change="onChange($event)"
                        >
                            <option value="" disabled selected>
                                SELECT OPTION
                            </option>
                            <option value="category">Category</option>
                            <option value="assigned">Assigned</option>
                            <option value="condition">Condition</option>
                            <option value="depreciation">Depreciation</option>
                        </select>
                    </div>
                    <div class="col">
                        <select
                            class="form-control"
                            name="categoryselect"
                            v-model="form.categoryselect"
                        >
                            <option value="" disabled selected>
                                SELECT TYPE
                            </option>
                            <option
                                v-for="temp in categorylist"
                                :value="temp.index"
                                :key="temp"
                            >
                                {{ temp.index }}
                            </option>
                            <!-- <option value="Furniture">Furniture</option> -->
                        </select>
                    </div>
                    <div class="col">
                        <select
                            class="form-control"
                            name="conditionselect"
                            v-model="form.conditionselect"
                        >
                            <option value="" disabled selected>
                                SELECT CONDITION
                            </option>
                            <option value="count">COUNT</option>
                            <option value="sum">SUM</option>
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" @click="FormSubmit">
                            SUBMIT
                        </button>
                    </div>
                </div>
                <div class="container">
                    <table class="table">
                        <thead>
                            <tr style="text-align: center">
                                <th>SNo</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody v-show="tablelist !== null">
                            <tr style="text-align: center">
                                <td>{{ tablelistname }}</td>
                                <td>{{ tablelist }}</td>
                            </tr>
                        </tbody>
                        <tbody v-show="tablelist === null">
                            <tr style="text-align: center">
                                <td colspan="2">No Data of Product</td>
                            </tr>
                        </tbody>
                    </table>
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
            token: sessionStorage.getItem("token"),
            form: {
                categoryselect: "",
                conditionselect: "",
            },
            tablelistname: "",
            optionselect: "",
            categorylist: [],
            tablelist: null,
        };
    },
    methods: {
        async FormSubmit() {
            await axios.get("/sanctum/csrf-cookie").then((response) => {
                axios
                    .post("/analysisdata", [this.form, this.optionselect])
                    .then((res) => {
                        this.tablelistname = this.form.categoryselect;
                        this.tablelist = res.data;
                        // console.log(res.data);
                    });
            });
        },
        onChange(event) {
            this.categorylist.splice(0);
            axios
                .post(`/analysisoption?option=` + event.target.value)
                .then((response) => {
                    response.data.forEach((element, index) => {
                        this.categorylist.push({
                            index: element[this.optionselect],
                        });
                        // console.log(this.categorylist);
                    });
                    // console.log(response.data);
                });
        },
    },
    mounted() {
        if (!this.token) {
            this.$router.push({ name: "Login" });
        } else {
            // axios.get("/analysiscolumndata").then((response) => {
            //     console.log(response);
            // });
        }
    },
};
</script>
