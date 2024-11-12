<template>
  <div class="modal select-taller">
    <button class="close" v-on:click="closeModal(false)">X</button>
    <div class="icon"></div>
    <div class="body">
      <span>Has seleccionado el taller</span>
      <h2>{{ item.nombre }}</h2>
      <span>Verifica la información y continua tu proceso</span>
      <div class="address">{{ item.direccion }}</div>
      <div class="phone">{{ item.telefono }}</div>
      <div class="schedule">
        <h4>Horario de atención:</h4>
        <p>Lunes a Sábado</p>
        <p>de 8:00 a.m. a 5:00 p.m.</p>
      </div>

      <button type="button" v-on:click="closeModal(true)">Continuar</button>
    </div>
  </div>
</template>
<script>
export default {
  props: ['item'],
  methods: {
    closeModal: function (flag) {
      if (flag) {
        this.$emit('closeModal', this.item.codTaller);
      }
      else {
        this.$emit('closeModal', 0);
      }
    }
  }
}
</script>
