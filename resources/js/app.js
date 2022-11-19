require("./bootstrap");

import { createApp } from "vue";
import router from "./router.js";
import { StreamBarcodeReader } from "vue-barcode-reader";
import LaravelVuePagination from "laravel-vue-pagination";

createApp({
    components: {
        Pagination: LaravelVuePagination,
    },
})
    .use(StreamBarcodeReader)
    .use(router)
    .mount("#app");
