import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    data: {
      plan_id: null,
      ubication_id: null,
      speciality_id: null,
      institution_name: null,
      page: 0,
      show_results: false,
      telemedicine: 'all',
      category: null,
      map_proximity: 'all'
    }
  },
  mutations: {
    setSearchData: function (state, payload) {
      state.data = { ...payload }
    },
    resetSearch: function (state) {
      state.data.show_results = false
    },
    setPage: function (state, page) {
      state.data.page = page
    }
  },
})
