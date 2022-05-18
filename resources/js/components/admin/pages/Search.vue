<template>
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product Info</h1>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <div class="row justify-content-center mt-3">
            <div v-if="barcodescan" class="col-md-7">
                <div class="card">
                    <div class="card-header">Barcode Scan</div>
                    <div class="card-body">
                        <StreamBarcodeReader
                            v-if="onlybarcodescan"
                            @decode="onDecode"
                        ></StreamBarcodeReader>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="formpage" class="row justify-content-center mt-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Profile Page</div>
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
                                        v-model="alldata.SNo"
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
                                        v-model="alldata.name"
                                        autofocus
                                        placeholder="Enter Name"
                                        readonly
                                    />
                                </div>
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="category"
                                        v-model="alldata.category"
                                        autofocus
                                        placeholder="Enter Category"
                                        readonly
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <textarea
                                        class="form-control"
                                        name="description"
                                        v-model="alldata.description"
                                        rows="3"
                                        autofocus
                                        placeholder="Enter Description"
                                        readonly
                                    ></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <select
                                        class="form-control"
                                        v-model="alldata.status"
                                        name="selected"
                                        disabled
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
                                        v-model="alldata.dateofpurchase"
                                        placeholder="Enter Date Of Purchase"
                                        readonly
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="assigned"
                                        v-model="alldata.assigned"
                                        placeholder="Enter Assigned To"
                                        readonly
                                    />
                                </div>
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="condition"
                                        v-model="alldata.condition"
                                        placeholder="Enter Condition"
                                        readonly
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
                                        v-model="alldata.cost"
                                        readonly
                                    />
                                </div>
                                <div class="col-md-6">
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="dcost"
                                        placeholder="Enter Disposal/Transfer Inward/Outward Cost"
                                        v-model="alldata.disposal_cost"
                                        readonly
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
                                        v-model="alldata.book_value"
                                        readonly
                                    />
                                </div>
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="deptrate"
                                        placeholder="Enter Department Rate in (%)"
                                        v-model="alldata.deptrate"
                                        readonly
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
                                        v-model="alldata.depreciation"
                                        readonly
                                    />
                                </div>
                                <div class="col-md-6">
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="accumulated_dept"
                                        placeholder="Enter Accumulated Department"
                                        v-model="alldata.accumulated_dept"
                                        readonly
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input
                                        type="number"
                                        class="form-control"
                                        placeholder="Enter NBV"
                                        v-model="alldata.NBV"
                                        readonly
                                    />
                                </div>
                            </div>
                            <div
                                class="row mb-3"
                                v-for="(input, k) in alldeptdata"
                                :key="k"
                            >
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="depreciationname.*"
                                        placeholder="Depreciation Year e.g(2010-2012)"
                                        v-model="input.name"
                                        readonly
                                    />
                                </div>
                                <div class="col-md-4">
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="depreciationcost.*"
                                        placeholder="Depreciation Cost"
                                        v-model="input.cost"
                                        readonly
                                    />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col justify-content-center d-flex">
                                    <button
                                        class="btn btn-primary"
                                        @click="LocationSubmit"
                                    >
                                        UPDATE LOCATION
                                    </button>
                                    <router-link
                                        :to="{
                                            name: 'ProductUpdate',
                                            params: { SNO: alldata.SNo },
                                        }"
                                        class="btn btn-warning"
                                        >UPDATE ALL</router-link
                                    >
                                    <button
                                        class="btn btn-secondary"
                                        @click="SearchRefresh"
                                    >
                                        SEARCH
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
import { StreamBarcodeReader } from "vue-barcode-reader";
import axios from "../../store/axios.js";

export default {
    data() {
        return {
            form: {
                SNo: "",
                name: "",
                category: "",
                description: "",
                selected: null,
                dateofpurchase: null,
                cost: null,
                dcost: null,
                assigned: null,
                condition: null,
                bvalue: null,
                deptrate: null,
                NBV: null,
                depreciation: null,
                accumulated_dept: null,
                inputs: [
                    {
                        depreciationname: "",
                        depreciationcost: "",
                    },
                ],
            },
            alldata: {},
            alldeptdata: {},
            barcodescan: true,
            formpage: false,
            clickme: false,
            onlybarcodescan: true,
            token: sessionStorage.getItem("token"),
        };
    },
    components: {
        StreamBarcodeReader,
    },
    methods: {
        async onDecode(result) {
            await axios.get("productsearch/" + result).then((res) => {
                if (res.data.message === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "This Product Does Not Exist!",
                    });
                } else {
                    this.barcodescan = false;
                    this.formpage = true;
                    this.alldata = res.data.message[0];
                    this.alldeptdata = res.data.message[1];
                }
            });
        },
        SearchRefresh() {
            window.location.reload();
        },
        async LocationSubmit() {
            const { value: text } = await Swal.fire({
                title: "Update Location",
                input: "text",
                inputLabel: "Assigned Location",
                showCancelButton: true,
                // inputPlaceholder: "Enter your location",
                inputValue: this.alldata.assigned,
            });

            if (text) {
                Swal.fire(`Location Updated: ${text}`).then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .post("locationupdate/" + this.alldata.SNo, text)
                            .then((res) => {
                                window.location.reload();
                            });
                    }
                });
            }
        },
    },
    mounted() {
        if (!this.token) {
            this.$router.push({ name: "Login" });
        } else {
        }
    },
};
</script>
