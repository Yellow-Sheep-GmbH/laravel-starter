import axios from "axios";
import { createI18n } from "vue-i18n";

window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

export default function bootstrap(app) {
    const i18nApp = createI18n({
        locale: document.documentElement.lang,
        fallbackLocale: "de",
        legacy: false,
        messages: {
            de: {},
            en: {},
        },
    });

    app.use(i18nApp);

    app.config.globalProperties.$route = window.route;
}
