<template>
  <div class="pane case-step">
    <h1>¿Cuál es tu caso?</h1>
    <p>Selecciona alguna de las siguientes opciones de acuerdo a tu situación</p>

    <div v-bind:class="{'radiobutton-group': true, error: submited && hasError('case')}">
      <div v-for="option in cases" v-bind:key="option.value" v-bind:class="{ case: true, selected: option.value == casualtyData.case }">

        <input type="radio" v-bind:id="'radio-' + option.value" v-bind:value="option.value" v-model="casualtyData.case">
        <label v-bind:for="'radio-' + option.value">
          <div v-bind:class="{ 'icon': true, [`icon-${option.value}`] : true }"></div>
          {{ option.label }}
        </label>
      </div>
      <div class="error-message" v-show="submited && hasError('case')">{{ hasError('case') }}</div>
    </div>

    <div class="case-4-disclaimer" v-show="casualtyData.case">
      <h4>Para radicar tu siniestro debes tener los siguientes documentos:</h4>
      <ul>
        <li>Tarjeta de Propiedad o documento que acredite la propiedad de vehículo o bien afectado. Para este caso adjuntar copia de la cedula del asegurado.</li>
        <li>Cédula o Cámara de comercio del propietario del vehículo o bien afectado.</li>
        <li>Copia de informe de tránsito (croquis) o fallo de resolución de tránsito,
          o acuerdo conciliatorio o Carta del asegurado donde indique la versión de los hechos,
          fotografías que demuestren ocurrencia, fecha, lugar, nombre del conductor y autorización para afectar su póliza.
          Para este caso adjuntar copia de la cédula del asegurado.</li>
        <li v-show="casualtyData.case == 1">Certificado de no reclamación (se solicita en tu aseguradora)</li>
        <li v-show="casualtyData.case == 2">Declaración extra juicio donde indiques que no se encuentra asegurado</li>
        <li v-show="casualtyData.case == 3">Factura del deducible pagado y certificación del deducible (se solicita en tu aseguradora)</li>
        <li v-show="casualtyData.case == 1 || casualtyData.case == 2">
          Cotización de mano de obra y repuestos y fotografías de los daños del vehículo
        </li>
      </ul>
    </div>

    <div class="actions">
      <a  href="#" v-on:click.prevent="prevStep">Volver</a>
      <button v-on:click="next" type="button">Continuar</button>
    </div>

    <alert
      :open="modal"
      icon="modal-continue"
      v-on:closeModal="closeModal($event)"
      v-bind:cancel="true"
      v-bind:button="true"
      buttonLabel="Continuar">
      <div slot="body">
        <h2>¿Deseas continuar?</h2>
        <p>Recuerda que debes tener todos los documentos para finalizar el proceso</p>
      </div>
    </alert>
  </div>
</template>
<script>
import steps from '../mixins/steps';

export default {
  mixins: [steps],
  methods: {
    next: function () {
      this.submited = true;
      if (this.isFormOk()) {
        this.modal = 'continue';
      }
    },
    accept: function () {
        this.closeModal();
        this.nextStep();
        this.modal = null;
    },
    closeModal: function (c) {
      this.modal = null;
      if (c) {
        this.accept();
      }
    }
  },
  data() {
    return {
      modal: null,
      validationRules: {
        case: {
          required: {msg: 'Debe seleccionar uno de los casos.' },
        }
      },
      casualtyData: {
        case: ''
      },
      cases: [
        {value: 1, label: 'Tengo un seguro con una compañia diferente a Liberty'},
        {value: 2, label: 'No tengo seguro con ninguna compañia'},
        {value: 3, label: 'Quiero que me devuelvan el valor del deducible'}
      ]
    }
  }
}
</script>
