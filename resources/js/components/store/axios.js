import axios from "axios";

const instance = axios.create({
    baseURL: "https://inventory-audit-system.herokuapp.com/api",
    withCredentials: true,
    headers: {
        common: {
            Authorization: `Bearer ${sessionStorage.getItem("token")}`,
        },
    },
});

export default instance;
