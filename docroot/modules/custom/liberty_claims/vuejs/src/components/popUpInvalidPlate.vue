<template>
  <div class="modal invalid-plate">
    <button class="close" v-on:click="closeModal">X</button>
    <div class="icon"></div>
    <div class="body">
      <h2>Ups, la placa que ingresaste <br/> no tiene la cobertura seleccionada</h2>
      <p>Verificarla información e inténtanlo de nuevamente.</p>
      <button type="button" v-on:click="closeModal">Cerrar</button>
      <div class="footer-popup">
        <span>Para más información comunícate por <strong>Whatsapp al 316 4821802</strong></span>
        <span>de lunes A viernes de 7 A.m. a 5 p.m. y Sábados de 8 a.m. a 12 p.m</span>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  methods: {
    closeModal: function () {
      this.$emit('closeModal');
    }
  }
}
</script>
