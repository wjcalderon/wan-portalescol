<template>
  <div class="pane first-step">
    <h1>Comienza aquí</h1>
    <p>Por favor completa la siguiente información:</p>

    <div v-bind:class="{field: true, error: submited && hasError('tellus'), filled: casualtyData.tellus}">
      <float-label label="¿Qué nos quieres contar?" :dispatch="false">
        <select
          name="tellus"
          id="tellus"
          v-model="casualtyData.tellus">
          <option :value="index"
            v-for="(option, index) in tellusOptions"
            v-bind:key="index"
          >{{ option }}</option>
        </select>
      </float-label>
      <div class="error-message" v-show="submited && hasError('tellus')">{{ hasError('tellus') }}</div>
    </div>

    <div v-bind:class="{field: true, error: submited && hasError('plate'), filled: casualtyData.plate}">
      <float-label>
        <input type="text" name="plate" v-model="casualtyData.plate" placeholder="¿Cuál es la placa del vehículo que te afectó?" v-uppercase>
      </float-label>
      <span class="ayudas">Placa del vehículo asegurado por Liberty</span>
      <div class="error-message" v-show="submited && hasError('plate')">{{ hasError('plate') }}</div>
    </div>

    <div v-bind:class="{field: true, error: submited && hasError('date')}">
      <datepicker
        format='YYYY-MM-DD HH:mm'
        v-show="page"
        v-model="casualtyData.date"
        label="¿En que día ocurrió?"
        locale="es"
        min-date="1900-01-01 00:00"
        :max-date="getMaxDate"
        strict='true'>
      </datepicker>
      <span class="ayudas">Día/ Mes/ Año</span>
      <div class="error-message" v-show="submited && hasError('date')">{{ hasError('date') }}</div>
    </div>

    <div class="actions">
      <button v-on:click="getPolicy" type="button">Continuar</button>
    </div>

    <alert :open="modal" icon="invalid-plate" v-on:closeModal="closeModal($event)" v-bind:button="true">
      <div slot="body">
        <div v-if="modal == 'no-guarantee'">
          <h2>Ups, la placa que ingresaste no tiene la cobertura seleccionada</h2>
          <p>Verifica la información e inténtalo nuevamente.</p>
        </div>
        <div v-else-if="modal == 'invalid'">
          <h2>Ups, la placa que ingresaste no nos permite continuar con el proceso</h2>
          <p>Verifica la información e inténtalo nuevamente.</p>
        </div>
        <div v-else-if="modal == 'not-in-time'">
          <h2>Ups, no hemos encontrado pólizas asociadas a la fecha que indica</h2>
          <p>Verifica la información e inténtalo nuevamente.</p>
        </div>
        <div v-else-if="modal == 'error'">
          <h2>Ups, en este momento el sistema no esta en funcionamiento</h2>
          <p>Intente más tarde.</p>
        </div>
      </div>
      <div slot="footer" class="footer-popup">
        <span>Para más información comunícate por <strong>Whatsapp al 316 4821802</strong></span>
        <span>de lunes A viernes de 7 A.m. a 5 p.m. y Sábados de 8 a.m. a 12 p.m</span>
      </div>
    </alert>
  </div>
</template>
<script>
import Datepicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
import steps from '../mixins/steps';
import popUp from '../components/popUpInvalidPlate';

export default {
  props: ['page'],
  mixins: [steps],
  components: {
    'datepicker': Datepicker,
    'pop-up-invalid-plate': popUp
  },
  computed: {
    getMaxDate: function () {
      const date = new Date();
      let month = '',
          day = '',
          hours = '',
          minutes = '',
          m = '';

      day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
      month = date.getMonth() + 1;
      month = month < 10 ? '0' + month : month;
      hours = date.getHours();
      minutes = date.getMinutes();

      return `${date.getFullYear()}-${month}-${day} ${hours}:${minutes}`;
    },
  },
  data() {
    return {
      validationRules: {
        tellus: {
          diff: {
            val: 0
          },
        },
        plate: {
          required: {},
          length: {
            equal: 6
          },
          match: {
            regExp: /^([A-Z]{3}[0-9]{3}|[A-Z]{1}[0-9]{5}|[A-Z]{3}[0-9]{2}[A-Z]{1})$/i,
            msg: 'Este dato no corresponde con un formato de placa valido.'
          }
        },
        date: {
          required: {}
        }
      },
      casualtyData: {
        plate: '',
        date: '',
        tellus: 0,
        policy: ''
      },
      tellusOptions: {
        0: '¿Qué nos quieres contar?',
        'THIRD_PARTY': 'Daños ocasionados por un asegurado de Liberty.',
      },
      modal: null
    }
  },
  methods: {
    getPolicy: function () {
      this.submited = true;
      if (this.isFormOk()) {
        let loader = this.$loading.show({
          canCancel: false,
        });

        let date = this.casualtyData.date.replace(' ', 'T');
        date = date.replace(/\//g, '-');

        this.$http.get(
          '/claim-data/plate/' + this.casualtyData.plate + '/' + this.casualtyData.tellus + '/' + date,
          {
            headers: {
            'token': this.drupalSettings.token,
            }
          }
        )
        .then(function (data) {
            loader.hide();
            // console.log(data);
            if (data.body == "invalid" || data.body == "no-guarantee" || data.body == "not-in-time" || data.body == "error") {
              document.location.href = document.location.origin + '/aviso-de-siniestros-webform#tab-1';
            }
            else if (data.status != 200) {
              document.location.href = document.location.origin + '/aviso-de-siniestros-webform#tab-1';
            }
            else {
              this.casualtyData.policy = data.body;
              this.nextStep();
            }
          }, function (error) {
            this.modal = null;
            loader.hide();
        });
      }
    },
    closeModal: function () {
      this.modal = null;
    }
  }
}
</script>
