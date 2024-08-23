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
        <input type="text" name="plate" v-model="casualtyData.plate" placeholder="¿Cuál es la placa de tu vehículo?" v-uppercase>
      </float-label>
      <span class="ayudas">Ejemplo: FOV 575</span>
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

    <alert
      :open="modal"
      icon="invalid-plate"
      v-on:closeModal="closeModal($event)"
      v-bind:cancelLabel="cancelLabel"
      v-bind:cancel="hasCancelLink"
      v-bind:buttonLabel="buttonLabel"
      v-bind:button="true">
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
        <div v-else-if="modal == 'theft'">
          <h2>Recuerda que para completar tu solicitud debes tener el documento de la denuncia del robo</h2>
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
    tellusOptions: function () {
      let opts = {
        0: '¿Qué nos quieres contar?',
        'CLAIM_TYPE_PPD': 'Daños en el vehículo a causa de un accidente o evento súbito e imprevisto.',
        'CLAIM_TYPE_PPH': 'Hurto de cualquier parte o accesorio de su vehículo.',
        'CLAIM_TYPE_PTH': 'Hurto de su vehículo.',
        'CLAIM_TYPE_AC': 'Pequeños accesorios.',
        'CLAIM_TYPE_PL': 'Perdida de llaves.',
        'CLAIM_TYPE_LR': 'Llantas estalladas.'
      }
      return opts;
    },
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
    buttonLabel: function () {
      if (this.modal === 'theft') {
        return 'Lo tengo';
      }
      return 'Cerrar'
    },
    cancelLabel: function () {
      if (this.modal === 'theft') {
        return 'Aún no lo tengo';
      }
      return 'Cancelar'
    },
    hasCancelLink: function () {
      if (this.modal === 'theft') {
        return true;
      }
      return false;
    }
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
            regExp: /^([A-Z]{3}\d{3}|[A-Z]\d{5}|[A-Z]{3}\d{2}[A-Z]|\d{3}[A-Z]{3})$/i,
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
        policy: '',
        personalData: {},
        guarantees: {},
        GMFChevrolet: {},
        previusPolicy: '',
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

            if (
              data.body == "invalid" ||
              data.body == "no-guarantee" ||
              data.body == "not-in-time" ||
              data.body == "error" ||
              data.body == "no-data") {
              document.location.href = document.location.origin + '/aviso-de-siniestros-webform#tab-0';
            }
            else if (data.status != 200) {
              document.location.href = document.location.origin + '/aviso-de-siniestros-webform#tab-0';
            }
            else {

              if (data.body.GMFChevrolet) {
                localStorage.setItem('GMFChevrolet-codigoConcesionario', data.body.GMFChevrolet.codigoConcesionario)
              }else{
                localStorage.removeItem('GMFChevrolet-codigoConcesionario');
              }

              this.casualtyData.policy = data.body.token;
              this.casualtyData.personalData = data.body.personalInfo;
              this.casualtyData.guarantees = data.body.guarantees;
              this.casualtyData.broker = data.body.broker ? data.body.broker : null;
              this.casualtyData.previusPolicy = data.body.previusPolicy;
              if (this.casualtyData.tellus === 'CLAIM_TYPE_PTH') {
                this.modal = 'theft';
              }
              else {
                this.nextStep();
              }
            }
          }, function (error) {
            this.modal = 'error';
            loader.hide();
        });
      }
    },
    closeModal: function (flag) {
      if (flag && this.modal === 'theft') {
        this.nextStep();
      }
      this.modal = null;
    }
  }
}
</script>
