/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
import router from "./routes";
import VueRouter from "vue-router";
import Index from "./Index";
import moment from "moment";
import StarRating from "./shared/components/StarRating";
import FatalError from "./shared/components/FatalError";
import Success from "./shared/components/Success";
import ValidationErrors from "./shared/components/ValidationErrors";
import Vuex from 'vuex';
import definition from "./store";


window.Vue = require("vue");

Vue.use(VueRouter);
Vue.filter("fromNow", value => moment(value).fromNow());
Vue.component("star-rating", StarRating);
Vue.component("fatal-error", FatalError);
Vue.component("success", Success);
Vue.component("v-errors", ValidationErrors);
Vue.use(Vuex);

const store = new Vuex.Store(definition);
window.axios.interceptors.response.use(
  response => {
    return response;
  },
  error => {
    if (401 === error.response.status) {
      store.dispatch("logout");
    }

    return Promise.reject(error);
  }
);

const app = new Vue({
    el: "#app",
    router,
    store,
    components: {
        "index": Index,
    },
    async beforeCreate() {
      this.$store.dispatch("loadStoredState");
      this.$store.dispatch("loadUser");
    },
});
