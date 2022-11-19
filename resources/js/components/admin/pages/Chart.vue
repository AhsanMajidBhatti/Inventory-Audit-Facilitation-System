<template>
    <Line
        :chart-options="chartOptions"
        :chart-data="chartData"
        :chart-id="chartId"
        :dataset-id-key="datasetIdKey"
        :plugins="plugins"
        :css-classes="cssClasses"
        :styles="styles"
        :width="width"
        :height="height"
    />
</template>

<script>
import axios from "../../store/axios.js";

import { Line } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    PointElement,
    CategoryScale,
    Plugin,
} from "chart.js";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    PointElement,
    CategoryScale
);

export default {
    components: {
        Line,
        ChartJS,
    },
    props: {
        chartId: {
            type: String,
            default: "line-chart",
        },
        width: {
            type: Number,
            default: 500,
        },
        height: {
            type: Number,
            default: 200,
        },
        cssClasses: {
            default: "",
            type: String,
        },
        styles: {
            type: Object,
            default: () => {},
        },
        plugins: {
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {
            alldata: [],
            minvalue: "",
            maxvalue: "",
            token: sessionStorage.getItem("token"),
            currentRoute: this.$route.name,
            chartData: {
                labels: [],
                datasets: [{ data: [] }],
            },
            chartOptions: {
                responsive: true,
                scales: {
                    y: {
                        min: this.minvalue,
                        max: this.maxvalue,
                    },
                },
            },
        };
    },
    mounted() {
        let TestArray = new Array();
        if (!this.token) {
            this.$router.push({ name: "Login" });
        } else {
            axios.get("/sanctum/csrf-cookie").then((response) => {
                axios.get("/chartlist").then((res) => {
                    res.data.forEach((element) => {
                        this.chartData.labels.push(element.name);
                    });
                });
            });
            axios.get("/sanctum/csrf-cookie").then((response) => {
                axios.get("/chartcostlist").then((res) => {
                    res.data.map((element) => {
                        TestArray.push(element.cost);
                        console.log(element);
                    });

                    this.minvalue = Math.min.apply(Math, TestArray);
                    this.maxvalue = Math.max.apply(Math, TestArray);

                    this.chartData.datasets = [
                        {
                            label: "Cost",
                            backgroundColor: "#f87979",
                            data: TestArray,
                        },
                    ];
                });
            });
        }
    },
};
</script>
