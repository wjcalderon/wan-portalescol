<template>
  <section :class="['glossary', 'modal', (isMobile ? 'mobile modal-white' : '')]">
    <div class="modal-content">
      <button class="close-modal" @click="$emit('close')" v-show="!isMobile"></button>
      <span class="back" @click="$emit('close')" v-show="isMobile">Atrás</span>
      <h3>Glosario de especialidades</h3>
      <p>Conoce las especialidades que en la red médica de HDI Seguros Colombia tenemos disponibles para ti.</p>
      <ul class="tabs ">
        <li v-for="(tab, index) in tabs" :key="index" :class="{ 'is-active': tab.is_active }" @click="selectTab(tab.id)">{{ tab.title }}</li>
      </ul>
      <component
        :is="currentTab"
        :letters="selected_letters"
        :key="selected_tab"
      ></component>
    </div>
  </section>
</template>
<script>
import GlossaryDetails from './GlossaryDetails.vue'

export default {
  name: 'Glossary',
  data: function () {
    return {
      selected_letters: null,
      selected_tab: null,
      tabs: [
        {
          id: 'tab_1',
          title: 'A-C',
          letters: ['A', 'B', 'C'],
          is_active: false
        },
        {
          id: 'tab_2',
          title: 'D-F',
          letters: ['D', 'E', 'F'],
          is_active: false
        },
        {
          id: 'tab_3',
          title: 'G-K',
          letters: ['G', 'H', 'I', 'J', 'K'],
          is_active: false
        },
        {
          id: 'tab_4',
          title: 'L-Ñ',
          letters: ['L', 'M', 'N'],
          is_active: false
        },
        {
          id: 'tab_5',
          title: 'O-Q',
          letters: ['O', 'P', 'Q'],
          is_active: false
        },
        {
          id: 'tab_6',
          title: 'R-T',
          letters: ['R', 'S', 'T'],
          is_active: false
        },
        {
          id: 'tab_7',
          title: 'U-Z',
          letters: ['U', 'V', 'W', 'X', 'Y', 'Z'],
          is_active: false
        },
      ],
    }
  },
  components: { GlossaryDetails },
  props: [ 'isMobile' ],
  computed: {
    currentTab: function () {
      return GlossaryDetails
    }
  },
  created: function () {
    this.selectTab('tab_1')
  },
  methods: {
    selectTab(selectedTab) {
      this.tabs.forEach(tab => {
        tab.is_active = false
        if ((tab.id == selectedTab)) {
          tab.is_active = true
          this.selected_tab = tab.id
          this.selected_letters = tab.letters
        }
      })
    }
  }
}
</script>
