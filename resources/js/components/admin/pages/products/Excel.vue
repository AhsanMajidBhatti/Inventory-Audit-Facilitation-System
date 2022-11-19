<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Excel Page</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">
                                <a href="#">Excel</a>
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
            <div class="d-flex row">
                <div class="col">
                    <input
                        type="file"
                        class="form-control"
                        @change="excelExport"
                    />
                </div>
                <div class="col">
                    <button
                        @click="ExportData"
                        class="btn btn-success float-end"
                    >
                        EXPORT EXCEL
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <h3>DATABASE</h3>
                    <select class="form-control" v-model="selectvalue" size="7">
                        <option
                            v-for="(input, key) in allcolumn"
                            :key="key"
                            v-bind:value="input"
                        >
                            {{ input }}
                        </option>
                    </select>
                </div>
                <div class="col-md-1" id="addButton">
                    <button
                        class="btn btn-primary"
                        @click="AddValue"
                        :disabled="excelData.length == 0"
                    >
                        ADD
                    </button>
                </div>
                <div class="col">
                    <h3>EXCEL FILE</h3>
                    <select
                        class="form-control"
                        v-model="selectvalue2"
                        size="7"
                    >
                        <option
                            v-for="(input, key) in excelkeys"
                            :key="key"
                            v-bind:value="key"
                        >
                            {{ key }}
                        </option>
                    </select>
                </div>
            </div>

            <button
                @click="Checked"
                :disabled="excelData.length == 0"
                class="btn btn-primary"
            >
                Submit
            </button>

            <div height="1%" v-for="(input, key) in getallexceldata" :key="key">
                {{ key }} -> {{ input }}
            </div>
        </div>
    </div>
</template>

<script>
// import axios from "../../../store/axios.js";
import axios from "../../../store/axios.js";
import axios2 from "axios";
import * as XLSX from "xlsx/xlsx.mjs";

export default {
    data() {
        return {
            excelData: [],
            excelkeys: [],
            allcolumn: [],
            selectvalue: {},
            selectvalue2: {},
            getallexceldata: {},
            interval: false,
            token: sessionStorage.getItem("token"),
        };
    },
    methods: {
        excelExport(event) {
            var input = event.target;
            var reader = new FileReader();
            this.filename = reader.onload = () => {
                var fileData = new Uint8Array(reader.result);
                var wb = XLSX.read(fileData, {
                    type: "array",
                });

                wb.SheetNames.forEach((sheetName) => {
                    var rowObj = XLSX.utils.sheet_to_json(
                        wb.Sheets[sheetName],
                        {
                            defval: "",
                        }
                    );

                    this.excelData = JSON.parse(JSON.stringify(rowObj));
                    this.excelData.forEach((element, index) => {
                        this.excelkeys = element;
                    });
                });
            };
            reader.readAsArrayBuffer(input.files[0]);
        },
        AddValue() {
            this.getallexceldata[this.selectvalue2] = this.selectvalue;
        },
        async Checked() {
            await Swal.fire({
                title: "Are you sure?",
                text: "The Previous data will be removed. You still want to proceed!!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        "Succeed!",
                        "Your file has been Imported.",
                        "success"
                    );
                    axios.get("/sanctum/csrf-cookie").then((response) => {
                        axios
                            .post("/excellist", [
                                this.getallexceldata,
                                this.excelData,
                            ])
                            .then((res) => {
                                this.excelData = {};
                                this.getallexceldata = {};
                                window.location.reload();
                            });
                    });
                }
            });
        },
        ExportData() {
            Swal.fire({
                title: "Enter File Name To Export!",
                icon: "info",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off",
                },
                showCancelButton: true,
                confirmButtonText: "Export",
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    return axios
                        .get("/exportdata", { responseType: "blob" })
                        .then((res) => {
                            let fileUrl = window.URL.createObjectURL(res.data);
                            let fileLink = document.createElement("a");

                            fileLink.href = fileUrl;
                            fileLink.setAttribute("download", `${login}.xlsx`);
                            document.body.appendChild(fileLink);
                            fileLink.click();
                        });
                },
                allowOutsideClick: () => !Swal.isLoading(),
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "File Exported!",
                        icon: "success",
                    });
                }
            });
        },
    },
    mounted() {
        if (!this.token) {
            this.$router.push({ name: "Login" });
        } else {
            axios.get("/allcolumn").then((res) => {
                this.allcolumn = res.data;
            });
        }
    },
};
</script>

<style scoped>
#addButton {
    display: grid;
    align-items: center;
}
</style>
