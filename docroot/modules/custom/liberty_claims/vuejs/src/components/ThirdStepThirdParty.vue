<template>
  <div class="pane third-step">
    <h1>Cuéntanos lo sucedido</h1>
    <p>Describe todo lo ocurrido con el mayor detalle posible.</p>

    <div v-bind:class="{ field: true, descrip: true, error: submited && hasError('description') }">
      <float-label label="Descripción de los hechos.">
        <textarea name="description" cols="30" rows="5" v-model="casualtyData.description" v-on:keyup="countDown"
          placeholder="Descripción de los hechos, piezas afectadas, lugares etc." tabindex=1>
              </textarea>
      </float-label>
      <p class="countdown">Ingresa mínimo {{ validationRules.description.length.min }} caracteres contando espacios <span
          class="remain">{{ countDownVal }}</span></p>
      <div class="error-message" v-show="submited && hasError('description')">{{ hasError('description') }}</div>
    </div>

    <div class="label label-img-adj">Adjunta documentos o imagenes, formatos admitidos: pdf y jpg, máximo permitido: pdf -
      2MB, jpg - 60KB (opcional)</div>
    <dropzone id="dropzone-affected" ref="dropzoneEl" :options="dropzoneOptions" :useCustomSlot="true"
      :duplicateCheck="true" @vdropzone-success="fileUploaded" @vdropzone-removed-file="fileRemoved"
      @vdropzone-file-added="fileAdded" :class="{ error: submited && hasError('files') }" v-if="userData">
      <span class="arch-desck">Arrastra tus archivos para adjuntar, o <strong>búscalos aquí</strong></span>
      <span class="arch-mobile">Adjunta tus archivos aquí</span>
    </dropzone>
    <div class="error-message dropzone-error" v-show="submited && hasError('files')">
      {{ hasError('files') }}
    </div>

    <div class="row">
      <div class="col">
        <div class="option-buttons">
          <div class="label">¿El declarante es el mismo tercero afectado?</div>
          <div class="option-buttons-items">
            <button type="button" v-on:click="isDeclarant(true)"
              v-bind:class="{ selected: casualtyData.isDeclarant === true }">Si</button>
            <button type="button" v-on:click="isDeclarant(false)"
              v-bind:class="{ selected: casualtyData.isDeclarant === false }">No</button>
          </div>
        </div>
      </div>
      <div class="col"></div>
    </div>

    <div class="row flied-no-mb segundo-nivel tercer-afec">

      <div v-bind:class="{ field: true, error: submited && hasError('declarantName'), filled: casualtyData.declarantName }">
        <float-label>
          <input type="text" name="name" v-model.lazy="casualtyData.declarantName" placeholder="Nombre del declarante">
        </float-label>
        <div class="error-message" v-show="submited && hasError('declarantName')">{{ hasError('declarantName') }}</div>
      </div>

      <div
        v-bind:class="{ field: true, error: submited && hasError('declarantPhone'), filled: casualtyData.declarantPhone }">
        <float-label>
          <input type="text" v-model="casualtyData.declarantPhone" name="phone" placeholder="Teléfono">
        </float-label>
        <div class="error-message" v-show="submited && hasError('declarantPhone')">{{ hasError('declarantPhone') }}</div>
      </div>

      <div
        v-bind:class="{ field: true, error: submited && hasError('declarantDocType'), filled: casualtyData.declarantDocType }">
        <float-label label="Tipo de documento" :dispatch="false">
          <select v-model="casualtyData.declarantDocType">
            <option v-for="(index, option) in documentTypes" v-bind:key="index" :selected="index === 0"
              v-bind:value="index">{{ option }}</option>
          </select>
        </float-label>
        <div class="error-message" v-show="submited && hasError('declarantDocType')">{{ hasError('declarantDocType') }}
        </div>
      </div>

      <div
        v-bind:class="{ field: true, error: submited && hasError('declarantDocumentId'), filled: casualtyData.declarantDocumentId }">
        <float-label>
          <input type="text" name="id" v-model="casualtyData.declarantDocumentId"
            placeholder="Escribe tu número de documento">
        </float-label>
        <div class="error-message" v-show="submited && hasError('declarantDocumentId')">{{ hasError('declarantDocumentId')
        }}</div>
      </div>

      <div v-bind:class="{ field: true, error: submited && hasError('city'), filled: casualtyData.city }">
        <div class="label label-img-adj">
          ¿En que ciudad vas a reparar tu vehículo?
          <button v-tooltip="{ content: cityHelpMessage, placement: 'top-center' }">Help</button>
        </div>
        <float-label label="Ciudad" :dispatch="false">
          <select v-model="casualtyData.city">
            <option v-for="item in cities" v-bind:key="item[0]" v-bind:value="item[0]">{{ item[1] }}</option>
          </select>
        </float-label>
        <div class="error-message" v-show="submited && hasError('city')">{{ hasError('city') }}</div>
      </div>

      <div
        v-bind:class="{ field: true, address: true, error: submited && hasError('whereAddress'), filled: casualtyData.whereAddress }">
        <float-label>
          <input type="text" v-model="casualtyData.whereAddress" placeholder="Dirección o Ciudad de ocurrencia">
        </float-label>
        <div class="error-message" v-show="submited && hasError('whereAddress')">{{ hasError('whereAddress') }}</div>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="option-buttons">
          <div class="label">¿Hubo heridos?</div>
          <div class="option-buttons-items">
            <button type="button" v-on:click="changeRules('withInjured', 'casualties', true)"
              v-bind:class="{ selected: casualtyData.withInjured === true }">
              Si
            </button>
            <button type="button" v-on:click="changeRules('withInjured', 'casualties', false)"
              v-bind:class="{ selected: casualtyData.withInjured === false }">
              No
            </button>
          </div>
        </div>
      </div>
      <div class="col campo-heridos">
        <div v-bind:class="{ field: true, error: submited && hasError('casualties'), filled: casualtyData.casualties }">
          <float-label label="¿Cuántos?">
            <select v-model="casualtyData.casualties" v-bind:disabled="casualtyData.withInjured === false">
              <option v-for="option in counts" v-bind:key="option.value" :value="option.value">{{ option.label }}</option>
            </select>
          </float-label>
          <div class="error-message" v-show="submited && hasError('casualties')">{{ hasError('casualties') }}</div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="option-buttons">
          <div class="label">¿Hubo muertos?</div>
          <div class="option-buttons-items">
            <button type="button" v-on:click="changeRules('withDeaths', 'deaths', true)"
              v-bind:class="{ selected: casualtyData.withDeaths === true }">
              Si
            </button>
            <button type="button" v-on:click="changeRules('withDeaths', 'deaths', false)"
              v-bind:class="{ selected: casualtyData.withDeaths === false }">
              No
            </button>
          </div>
        </div>
      </div>
      <div class="col campo-muerte">
        <div v-bind:class="{ field: true, error: submited && hasError('deaths'), filled: casualtyData.deaths }">
          <float-label label="¿Cuántos?">
            <select v-model="casualtyData.deaths" v-bind:disabled="casualtyData.withDeaths === false">
              <option v-for="option in counts" v-bind:key="option.value" :value="option.value">{{ option.label }}</option>
            </select>
          </float-label>
          <div class="error-message" v-show="submited && hasError('deaths')">{{ hasError('deaths') }}</div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="option-buttons">
          <div class="label">¿Intervino policía de tránsito?</div>
          <div class="option-buttons-items">
            <button type="button" v-on:click="yesNoOptions('withPolice', true)"
              v-bind:class="{ selected: casualtyData.withPolice === true }">Si</button>
            <button type="button" v-on:click="yesNoOptions('withPolice', false)"
              v-bind:class="{ selected: casualtyData.withPolice === false }">No</button>
          </div>
        </div>
      </div>
      <div class="col"></div>
    </div>

    <h2>Marca las zonas afectadas de tu vehículo</h2>

    <div class="error" v-show="submited && hasError('damages')">
      <div class="error-message">
        {{ hasError('damages') }}
      </div>
    </div>
    <div class="image-car">
      <img v-bind:src="carImage" alt="Daños en el vehículo" />
      <p-check color="primary-o" class="p-default p-round p-thick" v-model="casualtyData.damages"
        v-for="option in damages" v-bind:key="option" v-bind:value="option">
        <i class="icon mdi mdi-check" slot="extra"></i>
        {{ option }}
      </p-check>
    </div>

    <div class="actions">
      <a href="#" v-on:click.prevent="prevStep">Volver</a>
      <button v-on:click="nextStep" type="button">Continuar</button>
    </div>

    <alert :open="modal" icon="invalid-plate" v-on:closeModal="closeModal($event)">
      <div slot="body">
        <div>
          <h2>{{ modalTitle }}</h2>
          <p> {{ modalBody }}</p>
        </div>
      </div>
    </alert>


  </div>
</template>

<script>
import PrettyCheck from 'pretty-checkbox-vue/check';
import vue2Dropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';
import steps from '../mixins/steps';
import Alert from './../components/commons/alert';

export default {
  mixins: [steps],
  props: ['userData'],
  components: {
    'p-check': PrettyCheck,
    'dropzone': vue2Dropzone,
    Alert,
  },
  methods: {
    changeRules: function (field, required, opt) {
      this.validationRules[required] = opt ? { diff: { val: 0 } } : {};
      this.casualtyData[required] = opt ? this.casualtyData[required] : 0;
      this.yesNoOptions(field, opt);
    },
    yesNoOptions: function (field, opt) {
      this.casualtyData[field] = opt;
    },
    isDeclarant: function (val) {
      if (val) {
        this.casualtyData.declarantName = this.userData.name + ' ' + this.userData.lastname;
        this.casualtyData.declarantPhone = this.userData.phone;
        this.casualtyData.declarantDocType = this.userData.docType;
        this.casualtyData.declarantDocumentId = this.userData.documentId;
      }
      else {
        this.casualtyData.declarantName = '';
        this.casualtyData.declarantPhone = '';
        this.casualtyData.declarantDocType = 0;
        this.casualtyData.declarantDocumentId = '';
      }
      this.yesNoOptions('isDeclarant', val);
    },
    closeModal: function () {
      this.modal = false;
    },
    countDown: function () {
      this.countDownVal = this.validationRules.description.length.max - this.casualtyData.description.length;
    }
  },
  computed: {
    carImage: function () {
      return this.drupalSettings.assetsPath ? '/' + this.drupalSettings.assetsPath + 'car-form.png' : 'src/assets/car-form.png';
    },
    dropzoneOptions: function () {
      if (this.userData) {
        return {
          url: '/claim/files/' + this.userData.documentId + '/save/',
          thumbnailWidth: 150,
          acceptedFiles: 'image/jpeg, application/pdf',
          capture: false,
          resizeWidth: 600,
          resizeHeight: 400,
          dictFileTooBig: 'El archivo es demasiado grande ({{filesize}}MB), supera el máximo de {{maxFilesize}}MB.',
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
  created() {
    delete this.documentTypes['¿Cuál es tu tipo de documento?'];
    this.documentTypes['Tipo de documento'] = 0;
    this.$http.get('/claim-data/cities-carshops').then(function (data) {
      this.cities = Object.entries(data.body).sort((a, b) => {
        if (a[1] > b[1])
          return 1;
        if (a[1] < b[1])
          return -1;
        return 0;
      });
      this.cities.unshift([0, 'Ciudad']);
    }, function (params) {
      this.cities = {
        '63001': 'ARMENIA',
        '08001': 'BARRANQUILLA',
        '11001': 'BOGOTA'
      };
    });
  },
  data() {
    return {
      casualtyData: {
        city: 0,
        description: '',
        declarantDocType: 0,
        declarantDocumentId: '',
        declarantName: '',
        declarantPhone: '',
        whereAddress: '',
        isDeclarant: false,
        withDeaths: false,
        withInjured: false,
        withPolice: false,
        casualties: 0,
        deaths: 0,
        damages: [],
        files: []
      },
      validationRules: {
        description: {
          required: {},
          length: {
            max: 1000,
            min: 50,
          },
        },
        declarantDocumentId: {
          required: {},
          match: {
            regExp: /^[A-Za-z0-9]+$/i,
            msg: 'El campo solo debe contenter números o letras.'
          },
          length: {
            max: 20,
            min: 3
          }
        },
        declarantName: {
          required: {},
          length: {
            max: 70
          },
          match: {
            regExp: /^[a-zA-ZáéíóúñÁÉÍÓÚÑ ]+$/i,
            msg: 'El campo solo debe contenter letras.'
          }
        },
        declarantPhone: {
          required: {},
          length: {
            max: 10
          },
          match: {
            regExp: /^[0-9 ]+$/i,
            msg: 'El campo solo debe contenter números.'
          }
        },
        declarantDocType: {
          diff: {
            val: 0
          },
        },
        whereAddress: {
          required: {},
          length: {
            max: 60
          },
          match: {
            regExp: /^[A-Za-z0-9# -]+$/i,
            msg: 'El campo solo debe contenter números,letras o estos caracteres (#, -)'
          }
        },
        city: {
          diff: {
            val: 0
          },
        },
        damages: {
          required: { msg: 'Debes seleccionar la(s) zona(s) de daño(s).' }
        }
      },
      cities: {},
      counts: [
        { value: 0, label: '¿Cuántos?' },
        { value: 1, label: '1' },
        { value: 'more', label: 'Mas de uno' }
      ],
      damages: [
        'Sección delantera',
        'Lateral delantero derecho',
        'Lateral delantero izquierdo',
        'Lateral trasero derecho',
        'Lateral trasero izquierdo',
        'Techo',
        'Sección posterior',
        'Por debajo'
      ],
      modal: false,
      modalBody: '',
      modalTitle: '',
      countDownVal: 0,
      cityHelpMessage: 'Si tu ciudad no se encuentra en el listado seleccióna la ciudad más cercana.'
    }
  }
}
</script>
