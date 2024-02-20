<template>
  <div class="pane documents-step">
    <h1>Adjunta los siguientes documentos</h1>
    <p>Debes tenerlos todos para finalizar tu proceso</p>

    <div class="documents-list">
      <ul>
        <li>
          <p><strong>Tarjeta de propiedad o documento que acredite la propiedad del vehículo</strong>
          o bien afectado. Para este caso adjuntar copia de la cédula del asegurado.</p>
        </li>
        <li>
          <p>
            <strong>Cédula o Cámara de comercio</strong> del propietario del vehículo o bien afectado.
          </p>
        </li>
        <li>
          <p>
            <strong>Copia de informe de tránsito </strong> (croquis) o <strong>Fallo o resolución de tránsito</strong> o
          <strong>Acuerdo conciliatorio</strong> o <strong>Carta del asegurado</strong> donde indique la versión de los hechos,
          fotografías que demuestren ocurrencia, fecha, luga, nombre del conductor y
          autorización para afectar su póliza. Para este caso adjuntar copia de la cédula del asegurado.
          </p>
        </li>
        <li v-show="caseType == 1">
          <p>
            Certificado de no reclamación (se solicita en tu aseguradora)
          </p>
        </li>
        <li v-show="caseType == 2">
          <p>
            Declaración extra juicio donde indiques que no se encuentra asegurado
          </p>
        </li>
        <li v-show="caseType == 3">
          <p>
            <strong>Factura del deducible pagado y certificación del deducible</strong> <br/> (se solicita en la aseguradora)
          </p>
        </li>
        <li v-show="caseType == 1 || caseType == 2">
          <p>
            Cotización de mano de obra y repuestos y fotografías de los daños del vehículo
          </p>
        </li>
      </ul>
    </div>

    <div v-bind:class="{field: true, error: submited && hasError('files')}">
      <div class="label label-img-adj">Adjunta documentos o imagenes, formatos admitidos: pdf y jpg, máximo permitido: pdf - 2MB, jpg 60KB  (obligatorio)</div>
      <dropzone
        id="dropzone-documents"
        ref="dropzoneEl"
        :options="dropzoneOptions"
        :useCustomSlot="true"
        :duplicateCheck="true"
        @vdropzone-success="fileUploaded"
        @vdropzone-removed-file="fileRemoved"
        @vdropzone-file-added="fileAdded"
        v-if="userData">
        <span class='arch-desck'>Arrastra tus archivos para adjuntar, o <strong>búscalos aquí</strong></span>
        <span class='arch-mobile'>Adjunta tus archivos aquí</span>
      </dropzone>
      <div class="error-message" v-show="submited && hasError('files')">
        {{ errorMsg }}
      </div>
    </div>

    <div class="actions">
      <a  href="#" v-on:click.prevent="prevStep">Volver</a>
      <button v-on:click="submit" type="button">Finalizar</button>
    </div>

    <alert :open="modal" icon="invalid-plate" v-on:closeModal="closeModal($event)">
      <div slot="body">
        <div >
          <h2>{{ modalTitle}}</h2>
          <p> {{ modalBody }}</p>
        </div>
      </div>
    </alert>

  </div>
</template>
<script>
import steps from '../mixins/steps';
import vue2Dropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';
import Alert from './../components/commons/alert';

export default {
  mixins: [steps],
  props: ['userData', 'caseType'],
  components: {
    'dropzone': vue2Dropzone,
    Alert,
  },
  computed: {
    dropzoneOptions: function() {
      if (this.userData) {
        return {
<<<<<<< HEAD
          url: '/claim/files/' + this.userData.documentId + '/save/',
          thumbnailWidth: 150,
          acceptedFiles: 'image/jpeg, application/pdf',
          addRemoveLinks: true,
          resizeWidth: 600,
          resizeHeight: 400,
=======
          url: '/claim/files/' + this.userData.documentId + '/save',
          thumbnailWidth: 150,
          acceptedFiles: 'image/jpeg, application/pdf',
          addRemoveLinks: true,
          /*resizeWidth: 600,
          resizeHeight: 400,*/
>>>>>>> main
          dictFileTooBig: 'El archivo es demasiado grande ({{filesize}}MB), supera el máximo de {{maxFilesize}}MB.',
          createImageThumbnails: false,
          headers: {
            'token': this.drupalSettings.token
          }
        };
      }
      else {
        return {};
      }
    },
  },
  methods: {
    submit: function () {
      this.submited = true;

      if (this.isFormOk()) {
        this.$emit('submit');
      }
      else {
        this.errorMsg = 'Debes adjuntar mínimo ' + this.validationRules.files.length.min + ' archivo.';
      }
    },
     closeModal: function () {
      this.modal = false;
    }
  },
  watch: {
    caseType: function(val, oldVal) {
     /*  if (val == 3) {
        this.validationRules.files.length.equal = 4;

      }
      else {
        this.validationRules.files.length.equal = 5;
      } */
    }
  },
  data() {
    return {
      validationRules: {
        files: {
          length: { min: 1 }
        }
      },
      casualtyData: {
        files: [],
      },
      errorMsg: '',
      modal: false,
      modalBody: '',
      modalTitle: ''
    }
  },
  mounted () {

  }
}
</script>
