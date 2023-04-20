<template>
  <div class="modal send-email">
    <button class="close" v-on:click="closeModal">X</button>
    <div class="send-email-box" v-if="!sended">
      <div class="icon"></div>
      <div class="body">
        <h3>¿A que correo deseas enviar la información?</h3>
        <div v-bind:class="{field: true, error: submited && hasError('email'), filled: casualtyData.email}">
          <float-label>
            <input
              type="mail"
              name="mail"
              v-model="casualtyData.email"
              placeholder="¿Cuál es tu email?"
            />
          </float-label>
          <div class="error-message" v-show="submited && hasError('email')">{{ hasError('email') }}</div>
        </div>
        <div>
          <button type="button" v-on:click="sendEmail">Enviar</button>
        </div>
      </div>
    </div>
    <div class="email-sent" v-else>
      <div class="icon"></div>
      <div class="body">
        <h2>¡El mensaje ha sido enviado con éxito!</h2>
        <button type="button" v-on:click="closeModal">Continuar</button>
      </div>
    </div>
  </div>
</template>
<script>
import steps from "../mixins/steps";

export default {
  props: ["userData"],
  mixins: [steps],
  methods: {
    closeModal: function() {
      this.$emit("closeModal");
    },
    sendEmail: function() {
      this.userData.email = this.casualtyData.email;
      this.submited = true;

      if (this.isFormOk()) {
        let loader = this.$loading.show({
          canCancel: false
        });

        this.$http
          .post("/claim/email", this.userData, {
            headers: {
              token: this.drupalSettings.token,
              "Content-Type": "application/json"
            }
          })
          .then(
            function(data) {
              if (data.ok && data.body.result) {
                this.sended = true;
              }
              //@todo Validar si el mail no se pudo enviar.
              loader.hide();
            },
            function(error) {
              console.log(error);
              this.modal = null;
              loader.hide();
            }
          );
      }
    }
  },
  data() {
    return {
      sended: false,
      casualtyData: {
        email: ""
      },
      validationRules: {
        email: {
          required: {},
          match: {
            regExp: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/i,
            msg: "No es un formato de email válido."
          }
        }
      }
    };
  }
};
</script>
