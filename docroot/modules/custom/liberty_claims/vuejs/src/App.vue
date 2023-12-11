<template>
  <div id="steps">
    <div id="chooseTypeOption" class="wrapper container-steps" v-show="!page">
      <choose-type v-on:chooseType="updateType($event)"></choose-type>
    </div>
    <div id="thirdParty" class="wrapper container-steps" v-show="page == 'Tercero'">
      <div id="chooseTypeMenu" class="form-steps">
        <div class="container-steps">
          <ul>
            <li v-bind:class="{ current: currentStep < 3 }"><span>1</span>Identificación</li>
            <li v-bind:class="{ current: currentStep === 3 }"><span>2</span>Descripción de los hechos</li>
            <li v-bind:class="{ current: currentStep === 4 }"><span>3</span>Listado de documentos</li>
          </ul>
        </div>

        <first-step-tp
          v-model="firstStepDataThirdParty"
          v-bind:step="currentStep"
          v-bind:page="page"
          v-show="currentStep === 0"
          v-on:nextStep="updateStep($event)">
        </first-step-tp>

        <case-step
          v-model="caseStepData"
          v-show="currentStep === 1"
          v-bind:step="currentStep"
          v-on:nextStep="updateStep($event)"
          v-on:prevStep="updateStep($event)">
        </case-step>

        <second-step-tp
          v-model="secondStepDataThirdParty"
          v-show="currentStep === 2"
          v-bind:step="currentStep"
          v-on:nextStep="updateStep($event)"
          v-on:prevStep="updateStep($event)">
        </second-step-tp>

        <third-step-tp
          v-model="thirdStepDataThirdParty"
          v-show="currentStep === 3"
          v-bind:step="currentStep"
          v-bind:userData="secondStepDataThirdParty"
          v-on:nextStep="updateStep($event)"
          v-on:prevStep="updateStep($event)">
        </third-step-tp>

        <documents-list
          v-show="currentStep === 4"
          v-bind:step="currentStep"
          v-bind:caseType="caseStepData ? caseStepData.case : 0"
          v-bind:userData="secondStepDataThirdParty"
          v-on:submit="sendThirdParty($event)"
          v-on:prevStep="updateStep($event)">
        </documents-list>

      </div>
    </div>
    <div id="chooseType" class="wrapper container-steps" v-show="page == 'Asegurado'">
      <div id="chooseTypeMenu" class="form-steps">
        <div class="container-steps">
          <ol>
            <li v-bind:class="{ current: currentStep < 2 }"><span>1</span>Identificación</li>
            <li v-bind:class="{ current: currentStep === 2 }"><span>2</span>Descripción de los hechos</li>
            <li v-show="caseWithCarShop" v-bind:class="{ current: currentStep === 3 }"><span>3</span>Selección de taller</li>
            <li v-bind:class="{ current: currentStep === 4 }">
              <span v-if="caseWithCarShop">4</span>
              <span v-else>3</span>Resumen
            </li>
          </ol>
        </div>
      </div>

      <first-step
        id="first-step-component"
        v-model="firstStepData"
        v-bind:step="currentStep"
        v-bind:page="page"
        v-show="currentStep === 0"
        v-on:nextStep="updateStep($event)">
      </first-step>

      <second-step
        v-model="secondStepData"
        v-bind:personalInfo="firstStepData && firstStepData.personalData ? firstStepData.personalData : {}"
        v-show="currentStep === 1"
        v-bind:step="currentStep"
        v-on:nextStep="updateStep($event)"
        v-on:prevStep="updateStep($event)">
      </second-step>

      <third-step
        v-model="thirdStepData"
        v-show="currentStep === 2"
        v-bind:step="currentStep"
        v-bind:userData="secondStepData"
        v-bind:claimType="firstStepData ? firstStepData.tellus : ''"
        v-on:nextStep="updateStep($event)"
        v-on:prevStep="updateStep($event)">
      </third-step>

      <fourth-step
        v-model="fourthStepData"
        v-show="currentStep === 3 && caseWithCarShop"
        v-bind:step="currentStep"
        v-bind:vehicleData="secondStepData"
        v-bind:claimCity="thirdStepData ? thirdStepData.city : ''"
        v-bind:claimType="firstStepData ? firstStepData.tellus : ''"
        v-bind:isBroker="firstStepData && firstStepData.broker ? true : false"
        v-on:nextStep="updateStep($event)"
        v-on:prevStep="updateStep($event)">
      </fourth-step>

      <fifth-step
        v-show="currentStep === 4"
        v-bind:step="currentStep"
        v-bind:carShop="fourthStepData"
        v-bind:claimType="firstStepData ? firstStepData.tellus : ''"
        v-on:submit="sendInsured($event)"
        v-on:prevStep="updateStep($event)">
      </fifth-step>

    </div>

    <confirmation
      v-show="page == 'confirmation'"
      v-bind:number="claimNumber"
      v-bind:user="userConfirmationData">
    </confirmation>

    <confirmation
      v-show="page == 'confirmation-thirdparty'"
      v-bind:number="claimNumber"
      v-bind:user="userConfirmationDataThirdParty">
    </confirmation>

    <alert :open="modal" icon="invalid-plate" v-on:closeModal="closeModal($event)">
      <div slot="body">
        <div v-if="modal == 'claim-error'">
          <h2>Ups, su solicitud no pudo ser registrada debido a un error en el sistema.</h2>
          <p>{{ error }}</p>
          <p>Revise la información e intente más tarde.</p>
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
import ChooseType from './components/ChooseType.vue';
import FirstStep from './components/FirstStep.vue';
import FirstStepThirdParty from './components/FirstStepThirdParty.vue';
import SecondStep from './components/SecondStep.vue';
import SecondStepThirdParty from './components/SecondStepThirdParty.vue';
import ThirdStep from './components/ThirdStep.vue';
import FourthStep from './components/FourthStep.vue';
import FifthStep from './components/FifthStep.vue';
import confirmation from './components/confirmation.vue';
import caseStep from './components/caseStepThirdParty';
import ThirdStepThirdParty from './components/ThirdStepThirdParty';
import DocumentsList from './components/DocumentsListThirdParty';
import Alert from './components/commons/alert';

export default {
  components: {
    'choose-type': ChooseType,
    'first-step': FirstStep,
    'first-step-tp': FirstStepThirdParty,
    'second-step': SecondStep,
    'third-step': ThirdStep,
    'fourth-step': FourthStep,
    'fifth-step': FifthStep,
    'confirmation': confirmation,
    'case-step': caseStep,
    'second-step-tp': SecondStepThirdParty,
    'third-step-tp': ThirdStepThirdParty,
    'documents-list': DocumentsList,
    Alert,
  },
  computed: {
    userConfirmationData: function() {
      let obj = {};
      if (this.firstStepData) {
        obj.plate = this.firstStepData.plate;
        obj.claimType = this.firstStepData.tellus;
        obj.date = this.firstStepData.date;
      }
      if (this.secondStepData) {
        obj.name = this.secondStepData.name + ' ' + this.secondStepData.lastname;
        obj.email = this.secondStepData.email;
        obj.document = this.secondStepData.documentId;
        obj.number = this.claimNumber;
      }
      if (this.thirdStepData) {
        obj.description = this.thirdStepData.description;
      }
      if (this.fourthStepData) {
        obj.carShop = this.fourthStepData;
      }
      return obj;
    },
    userConfirmationDataThirdParty: function() {
      let obj = {};
      if (this.firstStepDataThirdParty) {
        obj.plate = this.firstStepDataThirdParty.plate;
        obj.claimType = this.firstStepDataThirdParty.tellus;
      }
      if (this.secondStepDataThirdParty) {
        obj.name = this.secondStepDataThirdParty.name + ' ' + this.secondStepDataThirdParty.lastname;
        obj.email = this.secondStepDataThirdParty.email;
        obj.document = this.secondStepDataThirdParty.documentId;
        obj.number = this.claimNumber;
      }
      if (this.thirdStepDataThirdParty) {
        obj.description = this.thirdStepDataThirdParty.description;
      }
      return obj;
    },
    caseWithCarShop: function() {
      if (this.firstStepData && this.firstStepData.tellus && this.firstStepData.tellus === 'CLAIM_TYPE_PTH') {
        if (this.currentStep === 3) {
          this.currentStep = 4;
        }
        return false;
      }
      return true;
    }
  },
  methods: {
    updateStep: function (step) {
      this.currentStep = step;
    },
    updateType: function (type) {
      this.page = type;
    },
    send: function(appData) {
      let loader = this.$loading.show({
        canCancel: false,
      });

      this.$http.post('/claim/submit/' + this.page, appData,
      {
        headers: {
          'token': this.drupalSettings.token,
          'Content-Type': 'application/json'
        }
      }).then(function (data) {

        if (data.status != 200 || (data.body && data.body.hasOwnProperty('error'))) {
          //@TODO Validar errores.
          this.claimNumber = 0;
          this.modal = 'claim-error';

          if (data.body.error) {
            this.error = 'Detalle del error: ' + data.body.error.split('ERROR: ')[1];
          }
        }
        else {
          this.claimNumber = data.body.success;
        }

        loader.hide();

      }, function () {
        loader.hide();
        this.claimNumber = 0;
        this.modal = 'claim-error';
      });
    },
    sendInsured: function () {
      if (this.fourthStepData === null || Object.keys(this.fourthStepData).length === 0) {
        this.fourthStepData = {codTaller: 0};
      }

      this.send({
        ...this.fourthStepData,
        ...this.thirdStepData,
        ...this.secondStepData,
        ...this.firstStepData,
      });

      this.page = 'confirmation';
    },
    sendThirdParty: function () {
      this.send({
        ...this.thirdStepDataThirdParty,
        ...this.secondStepDataThirdParty,
        ...this.firstStepDataThirdParty,
      });

      this.page = 'confirmation-thirdparty';
    },
    closeModal: function () {
      this.modal = null;
    }
  },
  data () {
    return {
      firstStepData: null,
      secondStepData: null,
      thirdStepData: null,
      fourthStepData: null, 
      firstStepDataThirdParty: null,
      caseStepData: null,
      secondStepDataThirdParty: null,
      thirdStepDataThirdParty: null,
      page: null,
      currentStep: 0,
      claimNumber: 0,
      modal: null,
      error: ''
    }
  },
  created() {
    this.drupalSettings = window.drupalSettings && window.drupalSettings.claimSettings ? window.drupalSettings.claimSettings : {};
  },
}
</script>
