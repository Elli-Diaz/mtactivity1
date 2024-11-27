/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;
import Vue from "vue";
import VueSimpleAlert from "vue-simple-alert";
import { ClientTable } from "vue-tables-2";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import VueToastr from "vue-toastr";

Vue.use(ClientTable, {}, false, "bootstrap4");
Vue.use(VueSweetalert2);

Vue.use(VueSimpleAlert);

Vue.use(VueToastr, {
    defaultTimeout: 3000,
    defaultProgressBar: true,
    defaultProgressBarValue: 0,
    // defaultType: "success",
    defaultPosition: "toast-top-right",
    defaultCloseOnHover: false,
    // defaultStyle: {"background-color": "Red"},
    defaultClassName: ["animated", "zoomInUp"],
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);
Vue.component(
    "users-component",
    require("./components/MasterData/UsersComponent.vue").default
);
Vue.component(
    "assetgroup-component",
    require("./components/MasterData/AssetGroupComponent.vue").default
);

Vue.component(
    "test-component",
    require("./components/TestComponent.vue").default
);

Vue.component(
    "assignment-component",
    require("./components/MasterData/AssignmentComponent.vue").default
);

Vue.component(
    "region-component",
    require("./components/MasterData/RegionComponent.vue").default
);

Vue.component(
    "province-component",
    require("./components/MasterData/ProvinceComponent.vue").default
);

Vue.component(
    "city-component",
    require("./components/MasterData/CityComponent.vue").default
);

Vue.component(
    "company-component",
    require("./components/MasterData/CompanyComponent.vue").default
);

Vue.component(
    "department-component",
    require("./components/MasterData/DepartmentComponent.vue").default
);

Vue.component(
    "employee-component",
    require("./components/MasterData/EmployeeComponent.vue").default
);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
});
