<template>
  <div class="pane second-step">
    <h1>Información Personal</h1>
    <p>Por favor completa la siguiente información:</p>

    <div class="row columns-row terceros">
        <div v-bind:class="{field: true, error: submited && hasError('name'), filled: casualtyData.name}">
          <float-label>
            <input type="text" name="name" v-model.lazy="casualtyData.name" placeholder="¿Cuál es tu nombre?" tabindex=1>
          </float-label>
          <div class="error-message" v-show="submited && hasError('name')">{{ hasError('name') }}</div>
        </div>

        <div v-bind:class="{field: true, error: submited && hasError('lastname'), filled: casualtyData.lastname}">
          <float-label>
            <input type="text" name="lastname" v-model="casualtyData.lastname" placeholder="¿Cuales son tus apellidos?" tabindex=2>
          </float-label>
          <div class="error-message" v-show="submited && hasError('lastname')">{{ hasError('lastname') }}</div>
        </div>

        <div v-bind:class="{field: true, error: submited && hasError('docType'), filled: casualtyData.docType}">
          <float-label label="Tipo de documento" :dispatch="false">
            <select v-model="casualtyData.docType" tabindex=3>
              <option v-for="(index, option) in documentTypes" v-bind:key="index" :value="index" >{{ option }}</option>
            </select>
          </float-label>
          <div class="error-message" v-show="submited && hasError('docType')">{{ hasError('docType') }}</div>
        </div>

        <div v-bind:class="{field: true, error: submited && hasError('documentId'), filled: casualtyData.documentId}" >
          <float-label>
            <input type="text" name="id" v-model="casualtyData.documentId" placeholder="Escribe tu número de documento" tabindex=4>
          </float-label>
          <div class="error-message" v-show="submited && hasError('documentId')">{{ hasError('documentId') }}</div>
        </div>

        <div v-bind:class="{field: true, address: true, error: submited && hasError('address'), filled: casualtyData.address}" >
          <float-label>
            <input type="text" name="address" v-model="casualtyData.address" placeholder="¿Cuál es tu dirección?" tabindex=7>
          </float-label>
          <div class="error-message" v-show="submited && hasError('address')">{{ hasError('address') }}</div>
        </div>

        <div v-bind:class="{field: true, error: submited && hasError('phone'), filled: casualtyData.phone}">
          <float-label>
            <input type="text" v-model="casualtyData.phone" name="phone" placeholder="¿Cuál es tu número de teléfono?" tabindex=6>
          </float-label>
          <div class="error-message" v-show="submited && hasError('phone')">{{ hasError('phone') }}</div>
        </div>

        <div v-bind:class="{field: true, error: submited && hasError('email'), filled: casualtyData.email}" >
          <float-label>
            <input type="mail" name="mail" v-model="casualtyData.email" placeholder="¿Cuál es tu email?" tabindex=5>
          </float-label>
          <div class="error-message" v-show="submited && hasError('email')">{{ hasError('email') }}</div>
        </div>


    </div>

    <h2>Información del vehículo</h2>
    <div class="row">
      <div class="col">
        <div v-bind:class="{field: true, error: submited && hasError('plateAffected'), filled: casualtyData.plateAffected}">
          <float-label>
            <input
              type="text"
              name="plateAffected"
              v-model="casualtyData.plateAffected"
              placeholder="¿Cuál es la placa de tu vehículo?"
              v-uppercase
              tabindex=8>
          </float-label>
          <div class="error-message" v-show="submited && hasError('plateAffected')">{{ hasError('plateAffected') }}</div>
        </div>

        <div v-bind:class="{field: true, error: submited && hasError('model'), filled: casualtyData.model}">
          <float-label label="¿Qué modelo es tu vehículo?" :dispatch="false">
            <select v-model="casualtyData.model" tabindex=9>
              <option v-for="option in models" v-bind:key="option.value" :value="option.value">{{ option.label }}</option>
            </select>
          </float-label>
          <div class="error-message" v-show="submited && hasError('model')">{{ hasError('model') }}</div>
        </div>
      </div>

      <div class="col">
        <div v-bind:class="{field: true, error: submited && hasError('brand'), filled: casualtyData.brand}">
          <float-label label="¿Cuál es la marca de tu vehículo?" :dispatch="false">
            <search-select :options="brands"
              v-model="casualtyData.brand"
              placeholder="¿Cuál es la marca de tu vehículo?">
            </search-select>
          </float-label>
          <div class="error-message" v-show="submited && hasError('brand')">{{ hasError('brand') }}</div>
        </div>

        <div v-bind:class="{field: true, error: submited && hasError('repairCity'), filled: casualtyData.repairCity}">
          <float-label label="Ciudad de reparación de tu vehículo" :dispatch="false">
            <select v-model="casualtyData.repairCity" name="repairCity">
              <option v-for="item in cities" v-bind:key="item[0]" v-bind:value="item[0]">{{ item[1] }}</option>
            </select>
          </float-label>
          <div class="error-message" v-show="submited && hasError('repairCity')">{{ hasError('repairCity') }}</div>
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
      <a  href="#" v-on:click.prevent="prevStep">Volver</a>
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
  methods: {
    updateVehicle: function (type) {
      this.casualtyData.vehicleType = type;
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
     }
  },
  created() {

    // Gets brands list.
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

    //Gets cities list.
    this.$http.get('/claim-data/cities-carshops').then(function (data) {
      this.cities = Object.entries(data.body).sort((a, b) => {
        if (a[1] > b[1])
          return 1;
        if (a[1] < b[1])
          return -1;
        return 0;
      });
      this.cities.unshift([0, 'Ciudad de reparación de tu vehículo']);
    }, function (params) {
      this.cities = {};
    });
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
        plateAffected: '',
        repairCity: 0
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
            regExp: /^[a-zA-ZáéíóúñÁÉÍÓÚÑ ]+$/g,
            /* regExp: /^\D+$/g, */
            msg: 'El campo solo debe contener letras.'
          },
          length: {
            max: 35,
            min: 3,
          },
        },
        lastname: {
          required: {},
         match: {
            regExp: /^[a-zA-ZáéíóúñÁÉÍÓÚÑ ]+$/g,
            /* regExp: /^\D+$/g, */
            msg: 'El campo solo debe contener letras.'
          },
          length: {
            max: 35,
            min: 3,
          },
        },
        phone: {
          required: {},
          match: {
            regExp: /^[0-9 ]+$/i,
            msg: 'El campo solo debe contener números.'
          },
          length: {
            max: 10,
            min: 7,
          },
        },
        email: {
          required: {},
          match: {
            regExp: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/i,
            msg: 'No es un formato de email válido.'
          }
        },
        documentId: {
          required: {},
          match: {
            regExp: /^[a-zA-Z0-9]+$/i,
            msg: 'El campo solo debe contener números o letras.'
          },
          length: {
            max: 20,
            min: 3
          },
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
        plateAffected: {
          required: {},
          length: {
            equal: 6
          },
          match: {
            regExp: /^([A-Z]{3}\d{3}|[A-Z]\d{5}|[A-Z]{3}\d{2}[A-Z]|\d{3}[A-Z]{3})$/i,
            msg: 'Este dato no corresponde con un formato de placa válido.'
          }
        },
        repairCity: {
          diff: {
            val: 0
          },
        },
        vehicleType: {
          required: {}
        }
      },
      cities: {},
      brands: []
    }
  }
}
</script>
