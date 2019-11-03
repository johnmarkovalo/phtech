require('./bootstrap');
window.Vue = require('vue');

import moment from 'moment';
import swal from 'sweetalert2'
import VueProgressBar from 'vue-progressbar'
import VueRouter from 'vue-router'
import {routes} from './routes';
import Vuetify from 'vuetify'
import Vue from 'vue'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/dist/vuetify.min.css'
import 'vue/dist/vue.js'
import colors from 'vuetify/es5/util/colors'
// import VueMaterial from 'vue-material'
// import '../stylus/main.styl'
// import 'vue-material/dist/vue-material.min.css'
import {CldContext, CldImage, CldVideo, CldTransformation} from 'cloudinary-vue'
import Cloudinary from 'cloudinary-vue';
Vue.use(Cloudinary, {
  configuration: {
    cloudName: "mactimestwo"
  }
});


// import VuetifyGoogleAutocomplete from 'vuetify-google-autocomplete';
// Vue.use(VuetifyGoogleAutocomplete, {
//   apiKey: 'AIzaSyBLvHFeixDacvhmdX-L_0EoG4of6n0pM1A', // Can also be an object. E.g, for Google Maps Premium API, pass `{ client: <YOUR-CLIENT-ID> }`
//   // version: '...', // Optional
//   // language: '...', // Optional
// });

import * as VueGoogleMaps from 'vue2-google-maps'
Vue.use(VueGoogleMaps, {
  load: {
    key: "AIzaSyBLvHFeixDacvhmdX-L_0EoG4of6n0pM1A",
    libraries: "places" // necessary for places input
  }
});

const opts = {
  theme: {
    dark: true,
    themes: {
      light: {
        primary: colors.teal.lighten2
      },
      dark: {
        primary: colors.teal.lighten2
      }
    }
  },
  icons: {
      iconfont: 'mdi',
    },

}
Vue.use(Vuetify)
Vue.use(VueRouter)

Vue.use(VueProgressBar, {
  color: '#FF8F00',
  thickness: '7px',
  failedColor: 'red',
  height: '3px'
})

window.toast = toast;

window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000  
});


// window.custEvent = new Vue();

  const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })
  
Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
});

//filter event date and time
Vue.filter('eventDate', function(created){
    return moment(created).format("ddd, MMM D, h:mm A")
});



Vue.component('App', require('./components/App.vue').default);
import App from './components/App.vue'
// import Event from './components/main/EventTemplate.vue'
// Vue.component('Home', require('./components/main/Home.vue').default);
// import Home from './components/main/Home.vue'

const app = new Vue({
  el: '#app',
  vuetify: new Vuetify(opts),
  router,
  components: {
    'App' : App,
  },
  data: () => ({
     
  }),
}).$mount('#app');
