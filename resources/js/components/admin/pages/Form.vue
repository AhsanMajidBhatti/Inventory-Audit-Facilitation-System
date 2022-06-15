<template>
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product Entry</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">
                                <a href="#">Form</a>
                            </li>
                        </ol>
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
                                        v-model="form.SNo"
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
                                        v-model="form.name"
                                        autofocus
                                        placeholder="Enter Name"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="category"
                                        v-model="form.category"
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
                                        v-model="form.description"
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
                                        v-model="form.selected"
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
                                        v-model="form.dateofpurchase"
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
                                        v-model="form.assigned"
                                        placeholder="Enter Assigned To"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="condition"
                                        v-model="form.condition"
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
                                        v-model="form.cost"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="dcost"
                                        placeholder="Enter  Disposal/Transfer Inward/Outward Cost"
                                        v-model="form.dcost"
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
                                        v-model="form.bvalue"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="deptrate"
                                        placeholder="Enter Department Rate in (%)"
                                        v-model="form.deptrate"
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
                                        v-model="form.depreciation"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="accumulated_dept"
                                        placeholder="Enter Accumulated Department"
                                        v-model="form.accumulated_dept"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input
                                        type="number"
                                        class="form-control"
                                        placeholder="Enter NBV"
                                        v-model="form.NBV"
                                    />
                                </div>
                            </div>
                            <div
                                class="row mb-3"
                                v-for="(input, k) in form.inputs"
                                :key="k"
                            >
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="depreciationname.*"
                                        placeholder="Depreciation Year e.g(2010-2012)"
                                        v-model="input.depreciationname"
                                    />
                                </div>
                                <div class="col-md-4">
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="depreciationcost.*"
                                        placeholder="Depreciation Cost"
                                        v-model="input.depreciationcost"
                                    />
                                </div>
                                <div class="col-md-2">
                                    <span>
                                        <i
                                            class="fas fa-2x fa-minus-circle float-end"
                                            @click="remove(k)"
                                            v-show="
                                                k ||
                                                (!k && form.inputs.length > 1)
                                            "
                                        ></i>
                                        <i
                                            class="fas fa-2x fa-plus-circle float-end"
                                            @click="add(k)"
                                            v-show="k == form.inputs.length - 1"
                                        ></i>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="justify-content-center d-flex">
                                    <button
                                        class="btn btn-primary"
                                        @click="FormSubmit"
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
            barcodescan: true,
            formpage: false,
            clickme: false,
            onlybarcodescan: true,
            token: sessionStorage.getItem("token"),
        };
    },
    name: "Form",
    components: {
        StreamBarcodeReader,
    },
    methods: {
        add() {
            this.form.inputs.push({
                depreciationname: "",
                depreciationcost: "",
            });
            console.log(this.form.inputs);
        },

        remove(index) {
            this.form.inputs.splice(index, 1);
        },
        onDecode(result) {
            console.log(result);
            this.barcodescan = false;
            this.formpage = true;
            this.form.SNo = result;
        },
        async FormSubmit() {
            await axios.get("/sanctum/csrf-cookie").then((response) => {
                axios
                    .post("/create", this.form)
                    .then((res) => {
                        console.log(res);
                        this.$router.push({ name: "AdminProductList" });
                    })
                    .catch((error) => {
                        console.log(error);
                    });
                // console.log(this.form);
            });
        },
    },
    mounted() {
        if (!this.token) {
            this.$router.push({ name: "Login" });
        } else {
            this.onlybarcodescan = true;
            alert(
                "If the camera is blocked then refresh the page to again enable the camera!!!"
            );
        }
    },
};
</script>

<style scoped>
.barcode {
    width: 50%;
    height: 10%;
}
</style>
