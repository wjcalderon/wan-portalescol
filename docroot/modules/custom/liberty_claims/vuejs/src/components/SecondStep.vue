<template>
  <div class="pane second-step">
    <h3>Información Personal</h3>
    <p>Por favor completa la siguiente información del asegurado:</p>

    <div class="row columns-row">
      <div v-bind:class="{field: true, error: submited && hasError('name'), filled: casualtyData.name}">
        <float-label>
          <input
            type="text"
            name="name"
            v-model.lazy="casualtyData.name"
            placeholder="¿Cuál es tu nombre?"
            tabindex=1
            v-bind:disabled="personalInfo.name && personalInfo.name.length > 0">
        </float-label>
        <div class="error-message" v-show="submited && hasError('name')">{{ hasError('name') }}</div>
      </div>

      <div v-bind:class="{field: true, error: submited && hasError('lastname'), filled: casualtyData.lastname}">
        <float-label>
          <input
            type="text"
            name="lastname"
            v-model="casualtyData.lastname"
            placeholder="¿Cuales son tus apellidos?"
            tabindex=2
            v-bind:disabled="personalInfo.lastname && personalInfo.lastname.length > 0">
        </float-label>
        <div class="error-message" v-show="submited && hasError('lastname')">{{ hasError('lastname') }}</div>
      </div>

      <div v-bind:class="{field: true, error: submited && hasError('docType'), filled: casualtyData.docType}">
        <float-label label="Tipo de documento" :dispatch="false">
          <select v-model="casualtyData.docType" tabindex=3 v-bind:disabled="personalInfo.docType != 0">
            <option v-for="(index, option) in documentTypes" v-bind:key="index" :value="index" >{{ option }}</option>
          </select>
        </float-label>
        <div class="error-message" v-show="submited && hasError('docType')">{{ hasError('docType') }}</div>
      </div>

      <div v-bind:class="{field: true, error: submited && hasError('documentId'), filled: casualtyData.documentId}" >
        <float-label>
          <input
            v-if="personalInfo.documentId && personalInfo.documentId.length > 0"
            type="text"
            name="id"
            placeholder="Escribe tu número de documento"
            tabindex=4
            :value="idMask"
            disabled>
          <input
            v-else
            type="text"
            name="id"
            v-model="casualtyData.documentId"
            placeholder="Escribe tu número de documento"
            tabindex=4>
        </float-label>
        <div class="error-message" v-show="submited && hasError('documentId')">{{ hasError('documentId') }}</div>
      </div>

      <div v-bind:class="{field: true, address: true, error: submited && hasError('address'), filled: casualtyData.address}" >
        <float-label>
          <input
            v-if="personalInfo.address && personalInfo.address.length > 0"
            type="text"
            name="address"
            maxlength="50"
            placeholder="¿Cuál es tu dirección?"
            tabindex=5
            :value="addressMask"
            disabled>
          <input
            v-else
            type="text"
            name="id"
            maxlength="50"
            v-model="casualtyData.address"
            placeholder="¿Cuál es tu dirección?"
            tabindex=5>
        </float-label>
        <div class="error-message" v-show="submited && hasError('address')">{{ hasError('address') }}</div>
      </div>

      <div v-bind:class="{field: true, error: submited && hasError('phone'), filled: casualtyData.phone}">
        <float-label>
          <input type="text" v-model="casualtyData.phone" name="phone" placeholder="¿Cuál es tu número de teléfono?" tabindex=6>
        </float-label>
        <div class="error-message" v-if="submited && hasError('phone')">{{ hasError('phone') }}</div>
        <div class="info-message" v-else>Este número no modificará al consignado en la póliza</div>
      </div>

      <div v-bind:class="{field: true, error: submited && hasError('email'), filled: casualtyData.email}" >
        <float-label>
          <input
            type="mail"
            name="mail"
            v-model="casualtyData.email"
            placeholder="¿Cuál es tu email?"
            tabindex=7>
        </float-label>
        <div class="error-message" v-if="submited && hasError('email')">{{ hasError('email') }}</div>
        <div class="info-message" v-else>Este email no modificará al consignado en la póliza</div>
      </div>
    </div>

    <h2>Información del vehículo</h2>
    <div class="row">
      <div class="col">
        <div v-bind:class="{field: true, error: submited && hasError('brand'), filled: casualtyData.brand}">
          <float-label label="¿Cuál es la marca de tu vehículo?" :dispatch="false">
            <search-select :options="brands"
              v-model="casualtyData.brand"
              tabindex=8
              placeholder="¿Cuál es la marca de tu vehículo?"
              v-bind:isDisabled="personalInfo.brand ? true : false">
            </search-select>
          </float-label>
          <div class="error-message" v-show="submited && hasError('brand')">{{ hasError('brand') }}</div>
        </div>
      </div>

      <div class="col">
        <div v-bind:class="{field: true, error: submited && hasError('model'), filled: casualtyData.model}">
          <float-label label="¿Qué modelo es?" :dispatch="false">
            <select v-model="casualtyData.model" tabindex=9 v-bind:disabled="personalInfo.model">
              <option v-for="option in models" v-bind:key="option.value" :value="option.value">{{ option.label }}</option>
            </select>
          </float-label>
          <div class="error-message" v-show="submited && hasError('model')">{{ hasError('model') }}</div>
        </div>
      </div>
    </div>

    <div class="vehicle-type">
      <h2>Selecciona tu tipo de vehículo</h2>
      <div class="label label-type">Por favor indícanos tu tipo de vehículo</div>

      <div class="row">
        <div
          @click="updateVehicle('Liviano')"
          v-bind:class="{col: true, button: true, liviano: true, selected: casualtyData.vehicleType === 'Liviano'}">
          <strong>Liviano</strong>
          <p>Automovíl, camioneta, SUV's</p>
        </div>
        <div
          @click="updateVehicle('Pesado')"
          v-bind:class="{col: true, button: true, pesado: true, selected: casualtyData.vehicleType === 'Pesado'}">
          <strong>Pesado</strong>
          <p>Bus, camión, remolcador, furgon, volqueta, chasis</p>
        </div>
        <div
          @click="updateVehicle('Moto')"
          v-bind:class="{col: true, button: true, moto: true, selected: casualtyData.vehicleType === 'Moto'}">
          <strong>Moto</strong>
          <p>Motocarro, motocicleta</p>
        </div>
      </div>
      <div class="error-message" v-show="submited && hasError('vehicleType')">{{ hasError('vehicleType') }}</div>
    </div>

    <div class="actions">
      <a href="#" v-on:click.prevent="prevStep">Volver</a>
      <button v-on:click="nextStep" type="button">Continuar</button>
    </div>
  </div>
</template>

<script>
import steps from '../mixins/steps';
import { ModelSelect } from 'vue-search-select';
import 'vue-search-select/dist/VueSearchSelect.css'

export default {
  components: {
    'search-select': ModelSelect
  },
  mixins: [steps],
  props: ['personalInfo'],
  methods: {
    updateVehicle: function (type) {
      this.casualtyData.vehicleType = type;
    },
    maskField: function(value, length) {
      const l = value.length;
      const mask = l - length;
      value = value.substring(mask);
      return "*".repeat(mask) + value;
    }
  },
  computed: {
    models: function () {
      const date = new Date();
      let modelsList = [];
      var range = (start, end) => [...Array(end - start + 1)].map((_, i) => start + i);
      range = range(1973, date.getFullYear() + 2).reverse();
      modelsList.push({value: 0, label: '¿Qué modelo es?'});

      range.forEach( y => {
        modelsList.push({value: y, label: y});
      });

      return modelsList;
    },
    idMask: function () {
      return this.maskField(this.personalInfo.documentId.toString(), 3);
    },
    addressMask: function () {
      return this.maskField(this.personalInfo.address, 5);
    },
  },
  mounted() {
    this.$http.get('/claim-data/brands').then(function (data) {
       Object.values(data.body).forEach(element => {
         this.brands.push({ value: element, text: element });
      });
    }, function (params) {
      this.brands = {
        'MAZDA': 'MAZDA',
        'RENAULT': 'RENAULT'
      };
    });
  },
  watch: {
    personalInfo: function(val, oldVal) {
      if (!this.casualtyData.model) {
        Object.assign(this.casualtyData, val);
      }
      if (this.casualtyData.isJuridic) {
        this.validationRules.name = null;
        this.validationRules.lastname = null;
      }
    }
  },
  data() {
    return {
      casualtyData: {
        name: '',
        lastname: '',
        phone: '',
        email: '',
        documentId: '',
        address: '',
        docType: 0,
        vehicleType: '',
        brand: '',
        model: 0,
        isJuridic: false
      },
      validationRules: {
        docType: {
          diff: {
            val: 0
          },
        },
        name: {
          required: {},
          match: {
            /* regExp: /^[a-zA-ZáéíóúñÁÉÍÓÚÑ ]+$/g, */
            regExp: /^\D+$/g,
            msg: 'El campo solo debe contener letras y caracteres especiales.'
          }
        },
        lastname: {
          required: {},
         match: {
            /* regExp: /^[a-zA-ZáéíóúñÁÉÍÓÚÑ ]+$/g, */
            regExp: /^\D+$/g,
            msg: 'El campo solo debe contener letras y caracteres especiales.'
          }
        },
        phone: {
          required: {},
          length: {
            max: 10,
            min: 7,
          },
          match: {
            regExp: /^[0-9 ]+$/i,
            msg: 'El campo solo debe contener números.'
          }
        },
        email: {
          required: {},
          match: {
            regExp: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/i,
            msg: 'No es un formato de email válido.'
          },
        },
        documentId: {
          required: {},
          length: {
            max: 20,
            min: 3
          },
          match: {
            regExp: /^[a-zA-Z0-9]+$/i,
            msg: 'El campo solo debe contener números o letras.'
          }
        },
        address: {
          required: {},
          length: {
            max: 50
          }
        },
        brand: {
          required: {}
        },
        model: {
          diff: {
            val: 0
          }
        },
        vehicleType: {
          required: {}
        }
      },
      brands: []
    }
  }
}
</script>
