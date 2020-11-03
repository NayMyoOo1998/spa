require("./bootstrap");

window.Vue = require("vue");

import { Form, HasError, AlertError } from "vform";
import Swal from "sweetalert2";

import VueProgressBar from "vue-progressbar";
import Loading from 'vue-loading-overlay';
Vue.use(Loading);

Vue.use(VueProgressBar, {
    color: "rgb(143, 255, 199)",
    failedColor: "red",
    thickness : "5px",
});

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.component("pagination", require("laravel-vue-pagination"));
Vue.component(
    "product-component",
    require("./components/ProductComponent.vue").default
);

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: toast => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    }
});

window.Toast = Toast;

window.Form = Form;
window.Swal = Swal;

const app = new Vue({
    el: "#app",
    data: {}
});
