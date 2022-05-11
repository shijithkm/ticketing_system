import Vue from "vue";
import Router from "vue-router";
import Events from "./components/Events.vue";
import Registration from "./components/Registration.vue";
import Dashboard from "./components/Dashboard.vue";
import Login from "./components/Login.vue";
import store from "./store";

Vue.use(Router);

const router = new Router({
  mode: "history",
  routes: [
    {
      path: "/event",
      name: "event",
      component: Events,
      meta: { requireAuth: true },
    },
    {
      path: "/register",
      name: "register",
      component: Registration,
      meta: { requireAuth: true },
    },
    {
      path: "/dashboard",
      name: "dashboard",
      component: Dashboard,
      meta: { requireAuth: true },
    },
    {
      path: "",
      name: "dashboard",
      component: Dashboard,
      meta: { requireAuth: true },
    },
    { path: "/login", name: "login", component: Login, meta: { guest: true } },
  ],
});

// middleware

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.requireAuth)) {
    if (store.getters.isLoggedIn) {
      next();
      return;
    }
    next("/login");
  } else {
    next();
  }
});

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.guest)) {
    if (store.getters.isLoggedIn) {
      next("/dashboard");
      return;
    }
    next();
  } else {
    next();
  }
});

export default router;
