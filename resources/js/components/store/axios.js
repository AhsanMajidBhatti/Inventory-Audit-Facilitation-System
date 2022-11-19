import axios from "axios";

const instance = axios.create({
    // baseURL: "https://inventory-audit-system.herokuapp.com/api",
    baseURL: "http://127.0.0.1:8000/api",
    withCredentials: true,
    headers: {
        common: {
            Authorization: `Bearer ${sessionStorage.getItem("token")}`,
        },
    },
});

export default instance;
