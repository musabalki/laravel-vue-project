import Vue from "vue"
import Vuex from "vuex"
Vue.use(Vuex)

export default new Vuex.Store({
    state:{
        counter:100
    },
    mutations:{
        changeTheCounter(state,data){
            state.counter+=data;
        }
    }
})