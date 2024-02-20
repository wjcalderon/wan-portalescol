<template>
  <div class="pane confirmation-page">
    <h2>¡Hemos recibido la información!</h2>
    <h4>En Liberty queremos que estés tranquilo mientras nos encargamos de tu proceso.</h4>
    <div class="icon">
      <img v-bind:src="bgImage" alt="Resumen" />
    </div>
    <h1 class="number">
      {{ number }}
<<<<<<< HEAD
      <button v-tooltip="{content: msg, placement: 'bottom-center'}">Help</button>
=======
      <button v-tooltip="{ content: msg, placement: 'bottom-center' }"></button>
>>>>>>> main
    </h1>
    <h3>Número de radicado</h3>

    <div class="links">
<<<<<<< HEAD
      <a  class="download-pdf" v-on:click.prevent="download" target="_blank" rel="noreferrer" href="#">Descarga PDF</a>
      <a  class="send-email" href="#" v-on:click.prevent="sendEmail">Enviar por correo</a>
    </div>
    <p>
      Te hemos enviado un correo electrónico con la información del taller y los pasos para continuar con tu proceso. Para mas información escribenos por <strong>Whatsapp al 3164821802</strong> de lunes a viernes de 7 a.m a 5 p.m y sabados de 8 a.m a 12 p.m
=======
      <a class="download-pdf" v-on:click.prevent="download" target="_blank" rel="noreferrer" href="#">Descarga PDF</a>
      <a class="send-email" href="#" v-on:click.prevent="sendEmail">Enviar por correo</a>
    </div>
    <p>
      Te hemos enviado un correo electrónico con la información del taller y los pasos para continuar con tu proceso. Para
      mas información escribenos por <strong>Whatsapp al 3164821802</strong> de lunes a viernes de 7 a.m a 5 p.m y sabados
      de 8 a.m a 12 p.m
>>>>>>> main
    </p>

    <div class="actions">
      <button v-on:click="refresh('href')" class="btn-secon" type="button">Iniciar nuevo reporte</button>
      <button v-on:click="refresh('origin')" type="button">Ir a inicio</button>
    </div>

    <component :is="modal" v-on:closeModal="close($event)" v-bind:userData="user"></component>
<<<<<<< HEAD
    <div v-bind:class="{overlay: true, hide: modal === null }"></div>
=======
    <div v-bind:class="{ overlay: true, hide: modal === null }"></div>
>>>>>>> main
  </div>
</template>
<script>
import popUpSendEmail from "../components/popUpSendEmail";

export default {
  props: {
    number: {
      type: Number,
      required: true
    },
    user: {
      type: Object,
      required: true
    }
  },
  components: {
    "pop-up-email": popUpSendEmail
  },
  data() {
    return {
      msg:
        "Con el número de radicado podrás hacer seguimiento a todos los estados de tu siniestro y recibir toda la información que necesites",
      modal: null,
      modalData: null,
      downloadUrl: '#'
    };
  },
  computed: {
<<<<<<< HEAD
    bgImage: function() {
=======
    bgImage: function () {
>>>>>>> main
      return this.drupalSettings.assetsPath
        ? "/" + this.drupalSettings.assetsPath + "Ilustracion-autos.png"
        : "src/assets/Ilustracion-autos.png";
    }
  },
  methods: {
<<<<<<< HEAD
    sendEmail: function() {
      this.modal = "pop-up-email";
    },
    refresh: function(where) {
      window.location = document.location[where];
    },
    close: function() {
      this.modal = null;
    },
    download: function() {
      this.$http.post("/claim/download/" + this.number, this.user, {
          responseType: "blob"
        })
        .then(function(response) {
=======
    sendEmail: function () {
      this.modal = "pop-up-email";
    },
    refresh: function (where) {
      window.location = document.location[where];
    },
    close: function () {
      this.modal = null;
    },
    download: function () {
      this.$http.post("/claim/download/" + this.number, this.user, {
        responseType: "blob"
      })
        .then(function (response) {
>>>>>>> main
          let blob = new Blob([response.data], {
            type: "application/pdf;charset=utf-8"
          })
          this.downloadUrl = window.URL.createObjectURL(blob);
          const a = document.createElement('a');
          a.style.display = 'none';
          a.href = this.downloadUrl;
          // the filename you want
          a.download = 'resumen.pdf';
          document.body.appendChild(a);
          a.click();
          window.URL.revokeObjectURL(this.downloadUrl);
        },
<<<<<<< HEAD
        function(error) {
          console.log(error);
      });
=======
          function (error) {
            console.log(error);
          });
>>>>>>> main
    }
  },
  created() {
    this.drupalSettings =
      window.drupalSettings && window.drupalSettings.claimSettings
        ? window.drupalSettings.claimSettings
        : {};
  }
};
</script>
