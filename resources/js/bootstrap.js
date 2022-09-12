import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

export default function bootstrap(app) {
    app.config.globalProperties.$route = window.route;
}
