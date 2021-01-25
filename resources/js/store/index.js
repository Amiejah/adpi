import Vue from 'vue';
import Vuex from 'vuex';

import joke from './modules/jokes';

Vue.use(Vuex);


export default new Vuex.Store({
    modules: {
        joke
    }
});
