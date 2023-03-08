<template>
  <section
    :class="['medical-network-result-container', isMobile ? 'mobile' : '']"
    id="medical-network-result-container"
    v-show="show_results"
  >
    <div class="cog--mq">
      <div class="actions row">
        <button
          :class="[
            'show-results',
            'col-md-2',
            'col-xs-6',
            show_results_list ? 'active' : '',
          ]"
          @click="searchList"
          :disabled="show_no_results"
        >
          Ver listado
        </button>
        <button
          :class="[
            'show-map',
            'col-md-2',
            'col-xs-6',
            show_results_map ? 'active' : '',
          ]"
          @click="searchMap"
          :disabled="show_no_results"
        >
          Ver mapa
        </button>
        <span class="total-results col-md-6 col-xs-12">
          Hemos encontrado {{ pager.total_items }} resultado(s) para la búsqueda
          realizada
        </span>
      </div>

      <component
        :is="showResults"
        :results="results"
        :pager="pager"
        :isMobile="isMobile"
      ></component>
      <component :is="showMap" :results="results"></component>
      <component :is="showNoResults"></component>

      <button class="new-search" v-show="isMobile" @click="$emit('reset')">
        Nueva busqueda
      </button>
    </div>
  </section>
</template>

<script>
import Api from '@/helpers/Api'

import ResultsList from './ResultsList'
import ResultsMap from './ResultsMap'
import NoResults from './NoResults'

export default {
  name: 'SearchResult',
  data: function () {
    return {
      results: {},
      pager: {
        total_items: 0,
        total_pages: 0,
      },
      show_results: false,
      show_no_results: false,
      show_results_list: true,
      show_results_map: false,
    }
  },
  props: ['isMobile'],
  components: { ResultsList, ResultsMap, NoResults },
  computed: {
    showResults: function () {
      if (this.show_results && this.show_results_list) {
        return ResultsList
      }
      return null
    },
    showMap: function () {
      if (this.show_results && this.show_results_map) {
        return ResultsMap
      }
      return null
    },
    showNoResults: function () {
      if (this.show_no_results) {
        return NoResults
      }
      return null
    },
  },
  created: function () {
    this.$store.subscribe((mutation) => {
      if (mutation.type === 'setSearchData' || mutation.type === 'setPage') {
        if (this.$store.state.data.show_results === true) {
          this.search(this.$store.state.data)
        }
        this.show_results = true
      }
    })
  },
  methods: {
    searchList: function () {
      this.show_results_list = true
      this.show_results_map = false
      this.search(this.$store.state.data, 'list')
    },
    searchMap: function () {
      this.show_results_list = false
      this.show_results_map = true
      this.search(this.$store.state.data, 'map')
    },
    search: function (data, type) {
      if (type == 'map') {
        this.show_results_map = false
      }

      let search_data = []
      Object.keys(data).map(function (key) {
        if (data[key]) {
          search_data.push(key + '=' + data[key])
        }
      })

      let res = Api.get(
        type == 'map' ? 'search_map?' : 'search?',
        search_data.join('&'),
      )

      res.then((result) => {
        if (type == 'map') {
          this.results = result.rows
        } else {
          this.results = result.rows
          this.pager = result.pager
        }
        if (this.results.length > 0) {
          this.show_results = true
          this.show_no_results = false
        } else {
          this.show_results = true
          this.show_no_results = true
        }

        if (type == 'map') {
          this.show_results_map = true
        }
      })
    },
  },
}
</script>
