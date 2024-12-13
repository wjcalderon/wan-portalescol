<template>
  <div id="app" :class="[(this.isMobile ? 'mobile' : ''), 'bootstrap-wrapper']" ref="main">
    <network-form :plan_list="plan_list" :isMobile="this.isMobile" @search="show_results = true" @reset="show_results = false" ref="network_form" @hideResults="hideResults"/>
    <component :is="showResults" :isMobile="this.isMobile" @reset="newSearch" />
  </div>
</template>

<script>
import DetectMobile from './helpers/DetectMobile'

import NetworkForm from './components/NetworkForm.vue'
import SearchResult from './components/SearchResult.vue'

export default {
  name: 'App',
  mixins: [ DetectMobile ],
  data: function () {
    return {
      show_results: false,
      'plan_list': []
    }
  },
  components: { NetworkForm, SearchResult },
  computed: {
    showResults: function () {
      // Show results component
      if (this.show_results) {
        return SearchResult
      }

      return null
    }
  },
  created() {
    // Read module settings
    this.drupalSettings = window.drupalSettings.medicalNetwork
    this.plan_list = this.drupalSettings.plan_list
  },
  methods: {
    newSearch: function () {
      this.$refs.network_form.resetForm()
      this.show_results = false

      const element = document.getElementsByClassName('component__form--red-medica')
      const top = element.offsetTop
      window.scrollTo(0, top)
    },
    hideResults: function () {
      this.show_results = false
    }
  }
}
</script>
