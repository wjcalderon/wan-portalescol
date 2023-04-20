<template>
  <div>
    <single-result v-for="(result, index) in results" :key="index" :data="result" :isMobile="isMobile"/>

    <pager :pager_data="pager"/>
  </div>
</template>

<script>
import SingleResult from './SingleResult.vue'
import Pager from './Pager.vue'

export default {
  name: 'ResultsList',
  props: [ 'results', 'pager', 'isMobile' ],
  components: { SingleResult, Pager }
}
</script>
