<template>
  <section class="pagination">
    <paginate
      v-model="page"
      :page-count="this.pager_data.total_pages"
      :page-range="5"
      :margin-pages="0"
      :click-handler="clickCallback"
      :prev-text="'...'"
      :next-text="'...'"
      :container-class="'pagination'"
      :page-class="'page-item'"
      :hide-prev-next="true"
      :first-last-button="false"
      :force-page="this.pager_data.current_page + 1">
    </paginate>
  </section>
</template>

<script>
import Paginate from 'vuejs-paginate'

export default {
  name: 'Pager',
  data: function () {
    return {
      pager: [],
      page: this.pager_data.current_page + 1,
    }
  },
  props: [
    'pager_data'
  ],
  components: { Paginate },
  methods: {
    clickCallback: function (pageNum) {
      const element = document.getElementById('medical-network-result-container')
      const top = element.offsetTop
      window.scrollTo(0, top)

      this.$store.commit('setPage', pageNum - 1)
      this.page = pageNum
    }
  }
}
</script>
