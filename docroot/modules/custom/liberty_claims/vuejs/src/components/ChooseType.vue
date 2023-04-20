<template>
  <div class="pane choose-type">
    <div class="type">
      <div class="icon-cont"><img v-bind:src="personIcon" width="45" height="44"></div>
      <h3>Asegurado</h3>
      <p>Si eres un asegurado da click al siguiente enlace para avisar de tu siniestro</p>
      <button v-on:click="chooseType('Asegurado')" type="button">Iniciar</button>
    </div>
    <div class="type">
      <div class="icon-cont"><img v-bind:src="terceIcon" width="50" height="44"></div>
      <h3>Tercero afectado</h3>
      <p>Si eres el afectado por uno de nuestros asegurados da click en el siguiente enlace</p>
      <button v-on:click="chooseType('Tercero')" type="button">Iniciar</button>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    chooseType: function (type) {
      this.$emit('chooseType', type);
    }
  },
  data() {
    return {

    }
  },
  computed: {
    personIcon: function () {
      return this.drupalSettings.assetsPath ? '/' + this.drupalSettings.assetsPath + 'icon-person.svg' : 'src/assets/icon-person.svg';
    },
    terceIcon: function () {
      return this.drupalSettings.assetsPath ? '/' + this.drupalSettings.assetsPath + 'icon-terceros.svg' : 'src/assets/icon-person.svg';
    }
  },
  created() {
    this.drupalSettings = window.drupalSettings && window.drupalSettings.claimSettings ? window.drupalSettings.claimSettings : {};
  },
}
</script>
