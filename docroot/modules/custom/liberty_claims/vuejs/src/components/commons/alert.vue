<template>
  <div v-bind:class="{ container: true, [`${icon}`]: true }" v-show="open">
    <div class="modal">
      <button class="close" v-on:click="closeModal(false)">X</button>
      <header>
        <slot name="header"></slot>
      </header>
      <div v-bind:class="{ icon: true, [`icon-${icon}`]: true }"></div>
      <div class="body">
        <slot name="body"></slot>
      </div>
      <button v-show="button" type="button" v-on:click="closeModal(true)">{{ buttonText }}</button>
      <a  href="#" v-show="cancel" v-on:click.prevent="closeModal(false)">{{ cancelText }}</a>
      <slot name="footer"></slot>
    </div>
    <div class="overlay"></div>
  </div>
</template>
<script>
export default {
  props: ['open', 'icon', 'buttonLabel', 'cancelLabel', 'button', 'cancel'],
  computed: {
    buttonText: function () {
      return this.buttonLabel ? this.buttonLabel : 'Cerrar';
    },
    cancelText: function () {
      return this.cancelLabel ? this.cancelLabel : 'Cancelar';
    },
  },
  methods: {
    closeModal: function (c) {
      this.open = null;
      this.$emit('closeModal', c);
    }
  }
}
</script>