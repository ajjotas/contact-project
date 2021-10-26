import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    userType: null,
  },
  mutations: {
    setAdministrator (state) {
      state.userType = 'Administrator'
    },
    setVisitor (state) {
      state.userType = 'Visitor'
    }    
  },
  actions: {
  },
  modules: {
  }
})
