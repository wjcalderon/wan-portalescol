<template>
  <section :class="['preferential-help', 'modal', (isMobile ? 'mobile' : '')]">
    <div class="modal-content">
      <button class="close-modal" @click="$emit('close')"></button>
      <h2>{{ this.drupalSettings.preferential.title }}</h2>
      <p>{{ this.drupalSettings.preferential.description }}</p>
      <div class="modal-footer">
        <button @click="$emit('close')">Cerrar</button>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'PreferentialHelp',
  props: [ 'isMobile' ],
  created: function () {
    this.drupalSettings = window.drupalSettings.medicalNetwork
  }
}
</script>
