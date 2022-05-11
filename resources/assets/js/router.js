import Vue from "vue";
import Router from "vue-router";
import Events from "./components/Events.vue";
import Registration from "./components/Registration.vue";
import Dashboard from "./components/Dashboard.vue";

Vue.use(Router);

const routes = [
  { path: "/event", name: "event", component: Events },
  { path: "/register", name: "register", component: Registration },
  { path: "/dashboard", name: "dashboard", component: Dashboard },
];

export default new Router({
  mode: "history",
  routes,
});
