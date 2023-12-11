<template>
  <div class="modal alert-taller">
    <button class="close" v-on:click="closeModal(false)">X</button>
    <div class="icon"></div>
    <div class="body">
      <h1>¿Estás seguro que deseas asignar otro taller?</h1>
      <button type="button" v-on:click="closeModal(true)">Asignar otro</button>
      <a  href="#" v-on:click.prevent="closeModal(false)">Cancelar</a>
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
