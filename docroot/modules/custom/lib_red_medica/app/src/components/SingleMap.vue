<template>
  <section :class="['map-result', 'modal', (isMobile ? 'mobile' : '')]">
    <div class="modal-content">
      <button class="close-modal" @click="$emit('close')"></button>
      <div id="map"></div>
    </div>
  </section>
</template>

<script>
import { Loader } from "@googlemaps/js-api-loader"

export default {
  name: 'SingleMap',
  props: [
    'latLong',
    'data',
    'services_list',
    'plan_list',
    'isMobile'
  ],
  mounted: function () {
    const loader = new Loader({
      apiKey: window.drupalSettings.medicalNetwork.maps_api,
      version: "weekly",
      libraries: [ "places" ]
    })

    loader.load().then(() => {
      const location = { lat: parseFloat(this.latLong[0]), lng: parseFloat(this.latLong[1]) }

      const map = new window.google.maps.Map(document.getElementById("map"), {
        center: location,
        zoom: 16,
        disableDefaultUI: true,
        zoomControl: true,
        scaleControl: false,
        fullscreenControl: false,
        streetViewControl: false,
        rotateControl: false,
      })

      let services = ''
      for (let index = 0; index < this.services_list.length; index++) {
        services += '<option>' + this.services_list[index] + '</option>'
      }

      let planList = ''
      for (let index = 0; index < this.plan_list.length; index++) {
        planList += '<li class="plan-type-' + this.plan_list[index].id + '">' + this.plan_list[index].name + '</li>'
      }

      const popUp = '<div class="info">' +
        '<h3>' + this.data.title + '</h3>' +
        '<span class="address">' + this.data.field_network_address + '</span>' +
        '<span class="phone">' + this.data.field_phone + '</span>' +
        (this.data.field_whatsapp != '' ? '<span class="whatsapp">' + this.data.field_whatsapp + '</span>' : '' ) +
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
        '</div>'

      const infowindow = new window.google.maps.InfoWindow({
        content: popUp,
      })

      const marker = new window.google.maps.Marker({
        position: location,
        map: map,
        icon: window.drupalSettings.medicalNetwork.dataBasePath + '/themes/custom/liberty_public/images/icons/pin-map-red.svg',
      })

      infowindow.open(map, marker)
    })
  },
}
</script>
