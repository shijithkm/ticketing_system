/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import VueRouter from "vue-router";
import store from "./store";
import router from "./router";

axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://127.0.0.1:8000/api/";
const token = localStorage.getItem("token");
if (token) {
  axios.defaults.headers.common["Authorization"] = token;
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component("dashboard", require("./components/Dashboard.vue").default);
Vue.component("mainapp", require("./components/MainApp.vue"));

// manage error and expire token

axios.interceptors.response.use(undefined, function(error) {
  if (error) {
    const originalRequest = error.config;
    if (error.response.status === 401 && !originalRequest._retry) {
      originalRequest._retry = true;
      store.dispatch("logout");
      return router.push("/login");
    } else {
      store.commit("handle_error", JSON.parse(error.response.data.error));
    }
  }
});

Vue.use(VueAxios, axios);
Vue.use(VueRouter);

const app = new Vue({
  store,
  el: "#app",
  router,
});
