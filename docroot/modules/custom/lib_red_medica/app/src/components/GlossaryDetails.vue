<template>
  <section class="tab-content">
    <ul v-for="(data, index) in resultArr" :key="index">
      <li class="letter">{{ data.letter }}</li>

      <ul>
        <div v-for="(term, key) in data.list" :key="key">
          <li class="term">{{ term.item }}</li>
          <li>{{ term.description }}</li>
        </div>
      </ul>
    </ul>
  </section>
</template>

<script>
import Api from '@/helpers/Api'

export default {
  name: 'GlossaryDetails',
  data: function () {
    return {
      results: []
    }
  },
  props: [ 'letters' ],
  computed: {
    resultArr: function () {
      return this.results.concat().sort(this.sortBy('index'))
    }
  },
  created: function () {
    this.letters.forEach((letter, index) => {
      this.getGlossary(letter, index)
    })

  },
  methods: {
    sortBy: function (key) {
      return (a, b) => (a[key] > b[key]) ? 1 : ((b[key] > a[key]) ? -1 : 0)
    },
    getGlossary: function (letter, index) {
      Api.get(
          'glossary?',
          'glossary_letter=' + letter
        )
      .then((result) => {
        let data = {
          index: index,
          letter: letter,
          list: result
        }

        if (data.list.length > 0) {
          this.results.push(data)
        }
      })
    }
  }
}
</script>
