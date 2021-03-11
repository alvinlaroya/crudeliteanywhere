import Vue from 'vue';
import Vuex from 'vuex';
/* import categories from './modules/categories';
import restaurants from './modules/restaurants';
import menus from './modules/menus'; */
import organizations from './modules/organizations';
import persons from './modules/persons';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        organizations,
        persons
    }
});

