<template>
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Profile Page
                        <span class="d-flex float-end"
                            ><router-link
                                :to="{ name: 'AdminProductList' }"
                                class="btn btn-primary"
                                >RETURN TO LIST</router-link
                            ></span
                        >
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row mb-3">
                                <label
                                    for="productid"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Product ID Tag</label
                                >

                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="SNo"
                                        v-model="currentData.SNo"
                                        disabled
                                        autofocus
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="name"
                                        v-model="currentData.name"
                                        autofocus
                                        placeholder="Enter Name"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="category"
                                        v-model="currentData.category"
                                        autofocus
                                        placeholder="Enter Category"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <textarea
                                        class="form-control"
                                        name="description"
                                        v-model="currentData.description"
                                        rows="3"
                                        autofocus
                                        placeholder="Enter Description"
                                    ></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <select
                                        class="form-control"
                                        v-model="currentData.status"
                                        name="selected"
                                    >
                                        <option :value="null" disabled selected>
                                            Select Active/InActive
                                        </option>
                                        <option value="Active">Active</option>
                                        <option value="InActive">
                                            InActive
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input
                                        type="date"
                                        class="form-control"
                                        name="dateofpurchase"
                                        v-model="currentData.dateofpurchase"
                                        placeholder="Enter Date Of Purchase"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="assigned"
                                        v-model="currentData.assigned"
                                        placeholder="Enter Assigned To"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="condition"
                                        v-model="currentData.condition"
                                        placeholder="Enter Condition"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="cost"
                                        placeholder="Enter Cost"
                                        v-model="currentData.cost"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="dcost"
                                        placeholder="Enter  Disposal/Transfer Inward/Outward Cost"
                                        v-model="currentData.disposal_cost"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="bvalue"
                                        placeholder="Enter Book Value"
                                        v-model="currentData.book_value"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="deptrate"
                                        placeholder="Enter Department Rate in (%)"
                                        v-model="currentData.deptrate"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="depreciation"
                                        placeholder="Enter Disposal/Transfer Depreciation"
                                        v-model="currentData.depreciation"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="accumulated_dept"
                                        placeholder="Enter Accumulated Department"
                                        v-model="currentData.accumulated_dept"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input
                                        type="number"
                                        class="form-control"
                                        placeholder="Enter NBV"
                                        v-model="currentData.NBV"
                                    />
                                </div>
                            </div>
                            <div
                                class="row mb-3"
                                v-for="(input, k) in currentdeptData"
                                :key="k"
                            >
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="depreciationname.*"
                                        placeholder="Depreciation Year e.g(2010-2012)"
                                        v-model="input.name"
                                    />
                                </div>
                                <div class="col-md-4">
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="depreciationcost.*"
                                        placeholder="Depreciation Cost"
                                        v-model="input.cost"
                                    />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="justify-content-center d-flex">
                                    <button
                                        class="btn btn-primary"
                                        @click="FormUpdate"
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
            currentId: this.$route.params.SNO,
            currentData: {},
            currentdeptData: {},
            token: sessionStorage.getItem("token"),
        };
    },
    methods: {
        FormUpdate() {
            axios
                .post("/update/" + this.$route.params.SNO, [
                    this.currentData,
                    this.currentdeptData.reverse(),
                ])
                .then((res) => {
                    this.$router.push({ name: "AdminProductList" });
                });
        },
    },
    mounted() {
        if (!this.token) {
            this.$router.push({ name: "Login" });
        } else {
            axios.get(`/productview/${this.$route.params.SNO}`).then((res) => {
                this.currentData = res.data[0];
                this.currentdeptData = res.data[1].reverse();
            });
        }
    },
};
</script>
