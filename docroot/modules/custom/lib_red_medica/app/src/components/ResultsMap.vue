<template>
  <div id="map"></div>
</template>

<script>
import { Loader } from "@googlemaps/js-api-loader"

export default {
  name: 'ResultsMap',
  props: [ 'results' ],
  mounted: function () {
    const loader = new Loader({
      apiKey: window.drupalSettings.medicalNetwork.maps_api,
      version: "weekly",
      libraries: [ "places" ]
    })

    loader.load().then(() => {
      const centerLocation = this.location(this.results[0].field_location_map)

      const map = new window.google.maps.Map(document.getElementById("map"), {
        center: centerLocation,
        zoom: 13,
        disableDefaultUI: true,
        zoomControl: true,
        scaleControl: false,
        fullscreenControl: false,
        streetViewControl: false,
        rotateControl: false,
      })

      for (let index = 0; index < this.results.length; index++) {
        let data = this.results[index]

        let services = ''
        let services_list = this.servicesList(data.field_speciality)
        for (let index = 0; index < services_list.length; index++) {
          services += '<option>' + services_list[index] + '</option>'
        }

        let planList = ''
        let plan_list = this.planTypes(data.field_type_plan)
        for (let index = 0; index < plan_list.length; index++) {
          planList += '<li class="plan-type-' + plan_list[index].id + '">' + plan_list[index].name + '</li>'
        }

        const popUp = '<article class="search-result"><div class="info">' +
          '<h3>' + data.title + '</h3>' +
          '<span class="address">' + data.field_network_address + '</span>' +
          '<span class="phone">' + data.field_phone + '</span>' +
          (data.field_whatsapp != '' ? '<span class="whatsapp">' + data.field_whatsapp + '</span>' : '' ) +
          '<span class="services">' +
          '<select>' +
          '<option>Servicios</option>' +
          services +
          '</select>' +
          '</span>' +
          '<span class="plan-type">Aplica para:</span>' +
          '<ul>' +
          planList +
          '</ul>' +
          '</div></article>'

        const infowindow = new window.google.maps.InfoWindow({
          content: popUp,
        })

        const marker = new window.google.maps.Marker({
          position: this.location(this.results[index].field_location_map),
          map: map,
          icon: window.drupalSettings.medicalNetwork.dataBasePath + '/themes/custom/liberty_public/images/icons/pin-map-red.svg',
        })

        marker.addListener("click", () => {
          infowindow.open(map, marker);
        })
      }
    })
  },
  methods: {
    location: function (location) {
      let latlong = location.split(', ')
      return { lat: parseFloat(latlong[0]), lng: parseFloat(latlong[1]) }
    },
    servicesList: function (speciality_list) {
      return speciality_list.split('|')
    },
    planTypes: function (plan_list) {
      let new_plan_list = []
      let list = plan_list.split(', ')

      for (let index = 0; index < list.length; index++) {
        let plan = list[index].split('|')

        let plan_data = {
          'id': plan[0],
          'name': plan[1]
        }

        new_plan_list.push(plan_data)
      }

      return new_plan_list
    }
  }
}
</script>
