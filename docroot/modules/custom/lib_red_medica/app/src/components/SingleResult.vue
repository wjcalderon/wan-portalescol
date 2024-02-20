<template>
  <article :class="['search-result', (isMobile ? 'mobile' : '')]" ref="single_result">
    <span class="back" @click="closeInfo" v-show="show_info">Atrás</span>
    <div :class="['icon', 'category-' + data.field_lender_category, data.sticky == 'On' ? 'preferential' : '']"></div>
    <div class="info">
      <h3>{{ data.title }}</h3>
      <span :class="['address']">{{ data.field_network_address }} - {{ data.field_ubication }}</span>
      <span :class="['phone']">{{ data.field_phone }}</span>
      <span :class="['whatsapp']" v-show="data.field_whatsapp != ''">{{ data.field_whatsapp }}</span>
      <span class="services">
        <select>
          <option>Servicios</option>
          <option v-for="(service, index) in services_list" :key="index">{{ service }}</option>
        </select>
      </span>
      <span class="plan-type">Aplica para:</span>
      <ul>
        <li v-for="(plan, index) in plan_list" :key="index" :class="`plan-type-${plan.id}`">{{ plan.name }}</li>
      </ul>
      <div :class="['mobile-actions']" v-show="isMobile && !show_info">
        <div class="view-info" @click="viewInfo">
          Ver información
        </div>
        <div class="show-map" @click="show_map = true">
          Ver mapa
        </div>
      </div>
    </div>
    <div :class="['map']" v-show="!isMobile || show_info">
      <div :class="['show-map', (isMobile ? 'hide-mobile' : '')]" @click="show_map = true">
        Ver mapa
      </div>
      <button class="report" @click="show_error_form = true">Reportar datos errados</button>
    </div>
    <component :is="showMap" :latLong="data.field_location_map.split(', ')" :data="data" :services_list="services_list"
      :plan_list="plan_list" @close="show_map = false" :isMobile="isMobile" />
    <component :is="showErrorForm" :lender_name="data.title" @close="show_error_form = false" :isMobile="isMobile" />
  </article>
</template>

<script>
import SingleMap from './SingleMap'
import ErrorForm from './ErrorForm'

export default {
  name: 'SingleResult',
  data: function () {
    return {
      services_list: [],
      plan_list: [],
      show_map: false,
      show_error_form: false,
      show_info: false
    }
  },
  props: ['data', 'isMobile'],
  components: { SingleMap, ErrorForm },
  computed: {
    showMap: function () {
      if (this.show_map) {
        document.querySelector('html').classList.add('is-modal')
        return SingleMap
      }

      document.querySelector('html').classList.remove('is-modal')
      return false
    },
    showErrorForm: function () {
      if (this.show_error_form) {
        document.querySelector('html').classList.add('is-modal')
        return ErrorForm
      }

      document.querySelector('html').classList.remove('is-modal')
      return false
    }
  },

  created: function () {
    this.servicesList()
    this.planTypes()
  },
  watch: {
    'data.field_speciality': function () {
      this.servicesList();
    }
  },
  methods: {
    servicesList: function () {
      this.services_list = this.data.field_speciality.split('|').sort()
    },
    planTypes: function () {
      let list = this.data.field_type_plan.split(', ')

      for (let index = 0; index < list.length; index++) {
        let plan = list[index].split('|')

        let plan_data = {
          'id': plan[0],
          'name': plan[1]
        }

        this.plan_list.push(plan_data)
      }
    },
    viewInfo: function () {
      this.$refs.single_result.classList.add('modal-white')
      this.show_info = true
    },
    closeInfo: function () {
      this.$refs.single_result.classList.remove('modal-white')
      this.show_info = false
    }
  }
}
</script>
