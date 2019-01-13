
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Vuex = require('vuex');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('gambit', require('./components/Gambit.vue'));

Vue.use(Vuex);
const store = new Vuex.Store({
    state: {
        devices: [
        ]
    },
    mutations: {
        clear (state) {
            state.devices = [];
            console.log('Store cleared.');
        },

        populate() {
            axios.get('/data')
                .then(response => {
                    if (response.data.status === false) {
                        alert(response.data.data);
                        return false;
                    }

                    if ( ! response.data) {
                        alert('No data in response');
                        return false;
                    }

                    this.state.devices = this.state.devices.concat(
                        response.data
                    );

                    console.log(response.data);
                    return true;
                })
                .catch(function (error) {
                    alert(error);
                });

            console.log('Store populated.');
        }
    }
});

const app = new Vue({
    el: '#app',
    store
});
