<template>
  <article class="search-result">
    <div :class="['icon', 'category-' + data.field_lender_category, data.sticky == 'On' ? 'preferential' : '']"></div>
    <div class="info">
      <h3>{{ data.title }}</h3>
      <span class="address">{{ data.field_network_address }} - {{ data.field_ubication }}</span>
      <span class="phone">{{ data.field_phone }}</span>
      <span class="whatsapp" v-show="data.field_whatsapp != ''">{{ data.field_whatsapp }}</span>
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
    </div>
    <div class="map">
      <div class="show-map" @click="show_map = true">
        Ver mapa
      </div>
      <component
        :is="showMap"
        :latLong="data.field_location_map.split(', ')"
        :data="data"
        :services_list="services_list"
        :plan_list="plan_list"
        @close="show_map = false"
        />

      <button class="report">Reportar datos errados</button>
    </div>
  </article>
</template>

<script>
import SingleMap from './SingleMap'

export default {
  name: 'Result',
  data: function () {
    return {
      services_list: [],
      plan_list: [],
      show_map: false
    }
  },
  props: [ 'data' ],
  components: { SingleMap },
  computed: {
    showMap: function () {
      if (this.show_map) {
        return SingleMap
      }
      return false
    }
  },
  created: function() {
    this.servicesList()
    this.planTypes()
  },
  methods: {
    servicesList: function () {
      this.services_list = this.data.field_speciality.split('|')
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
    }
  }
}
</script>
