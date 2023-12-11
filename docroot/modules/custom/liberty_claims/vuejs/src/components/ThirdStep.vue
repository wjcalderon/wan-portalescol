<template>
  <div class="pane third-step">
    <h1>Cuéntanos lo sucedido</h1>
    <p>Describe todo lo ocurrido con el mayor detalle posible.</p>
    <div class="help-box">
      <p class="help-text">
        Relata como ocurrió el siniestro, indicando el lugar, otros
        involucrados, partes del vehículo que observas con daños en lo posible
        entregar el mayor detalle de los hechos.
      </p>
      <button v-tooltip="{ content: helpMessage, placement: 'top-center' }">
        Help
      </button>
    </div>

    <div
      v-bind:class="{
        field: true,
        descrip: true,
        error: submited && hasError('description')
      }"
    >
      <float-label label="Descripción de los hechos.">
        <textarea
          @click="getData"
          name="description"
          cols="30"
          rows="5"
          v-model="casualtyData.description"
          v-on:keyup="countDown"
          placeholder="Descripción de los hechos, piezas afectadas, lugares etc."
          tabindex="1"
        >
        </textarea>
      </float-label>
      <p class="countdown">
        Ingresa mínimo {{ validationRules.description.length.min }} caracteres
        contando espacios <span class="remain">{{ countDownVal }}</span>
      </p>
      <div class="error-message" v-show="submited && hasError('description')">
        {{ hasError("description") }}
      </div>
    </div>

    <div class="label label-img-adj" v-if="claimType === 'CLAIM_TYPE_PTH'">
      Adjunta documentos o imagenes, formatos admitidos: pdf y jpg, máximo
      permitido: pdf - 2MB, jpg - 60KB (obligatorio)
    </div>
    <div class="label label-img-adj" v-else>
      Adjunta documentos o imagenes, formatos admitidos: pdf y jpg, máximo
      permitido: pdf - 2MB, jpg - 60KB (opcional)
    </div>
    <dropzone
      id="dropzone"
      ref="dropzoneEl"
      :options="dropzoneOptions"
      :useCustomSlot="true"
      :duplicateCheck="true"
      @vdropzone-success="fileUploaded"
      @vdropzone-removed-file="fileRemoved"
      @vdropzone-file-added="fileAdded"
      :class="{ error: submited && hasError('files') }"
      v-if="userData"
    >
      <span class="arch-desck"
        >Arrastra tus archivos para adjuntar, o
        <strong>búscalos aquí</strong></span
      >
      <span class="arch-mobile">Adjunta tus archivos aquí</span>
    </dropzone>
    <div
      class="error-message dropzone-error"
      v-show="submited && hasError('files')"
      tabindex="2"
    >
      {{ hasError("files") }}
    </div>
    <div class="row">
      <div class="col">
        <div class="option-buttons">
          <div class="label">¿El conductor es el mismo asegurado?</div>
          <div class="option-buttons-items">
            <button
              type="button"
              v-on:click="isDriver(true)"
              v-bind:class="{ selected: casualtyData.isDriver === true }"
            >
              Si
            </button>
            <button
              type="button"
              v-on:click="isDriver(false)"
              v-bind:class="{ selected: casualtyData.isDriver === false }"
            >
              No
            </button>
          </div>
        </div>
      </div>
      <div class="col"></div>
    </div>

    <div class="row flied-no-mb segundo-nivel">
      <div
        v-bind:class="{
          field: true,
          error: submited && hasError('driverName'),
          filled: casualtyData.driverName
        }"
      >
        <float-label>
          <input
            type="text"
            name="name"
            v-model.lazy="casualtyData.driverName"
            placeholder="Nombre del conductor"
            tabindex="3"
          />
        </float-label>
        <div class="error-message" v-show="submited && hasError('driverName')">
          {{ hasError("driverName") }}
        </div>
      </div>

      <div
        v-bind:class="{
          field: true,
          error: submited && hasError('driverPhone'),
          filled: casualtyData.driverPhone
        }"
      >
        <float-label>
          <input
            type="text"
            v-model.lazy="casualtyData.driverPhone"
            name="phone"
            placeholder="Teléfono"
            tabindex="5"
          />
        </float-label>
        <div class="error-message" v-show="submited && hasError('driverPhone')">
          {{ hasError("driverPhone") }}
        </div>
      </div>

      <div
        v-bind:class="{
          field: true,
          error: submited && hasError('driverDocType'),
          filled: casualtyData.driverDocType
        }"
      >
        <float-label label="Tipo de documento" :dispatch="false">
          <select v-model="casualtyData.driverDocType" tabindex="4">
            <option
              v-for="(index, option) in documentTypes"
              v-bind:key="index"
              :selected="index === 0"
              v-bind:value="index"
              >{{ option }}</option
            >
          </select>
        </float-label>
        <div
          class="error-message"
          v-show="submited && hasError('driverDocType')"
        >
          {{ hasError("driverDocType") }}
        </div>
      </div>

      <div
        v-bind:class="{
          field: true,
          error: submited && hasError('driverDocumentId'),
          filled: casualtyData.driverDocumentId
        }"
      >
        <float-label>
          <input
            v-if="casualtyData.isDriver"
            type="text"
            name="id"
            :value="idMask"
            tabindex="6"
            disabled
          />
          <input
            v-else
            type="text"
            name="id"
            v-model="casualtyData.driverDocumentId"
            placeholder="Escribe tu número de documento"
            tabindex="6"
          />
        </float-label>
        <div
          class="error-message"
          v-show="submited && hasError('driverDocumentId')"
        >
          {{ hasError("driverDocumentId") }}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="option-buttons">
          <div class="label">¿El declarante es el mismo asegurado?</div>
          <div class="option-buttons-items">
            <button
              type="button"
              v-on:click="isDeclarant(true)"
              v-bind:class="{ selected: casualtyData.isDeclarant === true }"
            >
              Si
            </button>
            <button
              type="button"
              v-on:click="isDeclarant(false)"
              v-bind:class="{ selected: casualtyData.isDeclarant === false }"
            >
              No
            </button>
          </div>
        </div>
      </div>
      <div class="col"></div>
    </div>

    <div class="row flied-no-mb tercer-nivel">
      <div
        v-bind:class="{
          field: true,
          error: submited && hasError('declarantName'),
          filled: casualtyData.declarantName
        }"
      >
        <float-label>
          <input
            type="text"
            name="name"
            v-model.lazy="casualtyData.declarantName"
            placeholder="Nombre del declarante"
            tabindex="7"
          />
        </float-label>
        <div
          class="error-message"
          v-show="submited && hasError('declarantName')"
        >
          {{ hasError("declarantName") }}
        </div>
      </div>

      <div
        v-bind:class="{
          field: true,
          error: submited && hasError('declarantPhone'),
          filled: casualtyData.declarantPhone
        }"
      >
        <float-label>
          <input
            type="text"
            v-model="casualtyData.declarantPhone"
            name="phone"
            placeholder="Teléfono"
            tabindex="9"
          />
        </float-label>
        <div
          class="error-message"
          v-show="submited && hasError('declarantPhone')"
        >
          {{ hasError("declarantPhone") }}
        </div>
      </div>

      <div
        v-bind:class="{
          field: true,
          error: submited && hasError('city'),
          filled: casualtyData.city
        }"
      >
        <div class="label label-img-adj">
          ¿En que ciudad vas a reparar tu vehículo?
          <button
            v-tooltip="{ content: cityHelpMessage, placement: 'top-center' }"
          >
            Help
          </button>
        </div>
        <float-label label="Ciudad" :dispatch="false">
          <select v-model="casualtyData.city" name="city" tabindex="8">
            <option
              v-for="item in cities"
              v-bind:key="item[0]"
              v-bind:value="item[0]"
              >{{ item[1] }}</option
            >
          </select>
        </float-label>
        <div class="error-message" v-show="submited && hasError('city')">
          {{ hasError("city") }}
        </div>
      </div>

      <div
        v-bind:class="{
          field: true,
          address: true,
          error: submited && hasError('whereAddress'),
          filled: casualtyData.whereAddress
        }"
      >
        <float-label>
          <input
            type="text"
            name="address"
            v-model="casualtyData.whereAddress"
            placeholder="Dirección o Ciudad de ocurrencia"
            tabindex="10"
          />
          <span class="ayudas lh-normal"
            >*Es importante que registres la dirección exacta en donde ocurrió el
            siniestro</span
          >
        </float-label>
        <div
          class="error-message"
          v-show="submited && hasError('whereAddress')"
        >
          {{ hasError("whereAddress") }}
        </div>
      </div>
    </div>

    <div
      class="extra-info"
      v-show="claimType === 'CLAIM_TYPE_PPD' || claimType === 'CLAIM_TYPE_LR'"
    >
      <div class="row">
        <div class="col">
          <div class="option-buttons">
            <div class="label">¿Hubo heridos?</div>
            <div class="option-buttons-items">
              <button
                type="button"
                v-on:click="changeRules('withInjured', 'casualties', true)"
                v-bind:class="{ selected: casualtyData.withInjured === true }"
              >
                Si
              </button>
              <button
                type="button"
                v-on:click="changeRules('withInjured', 'casualties', false)"
                v-bind:class="{ selected: casualtyData.withInjured === false }"
              >
                No
              </button>
            </div>
          </div>
        </div>
        <div class="col campo-heridos">
          <div
            v-bind:class="{
              field: true,
              error: submited && hasError('casualties'),
              filled: casualtyData.casualties
            }"
          >
            <float-label label="¿Cuántos?">
              <select
                v-model="casualtyData.casualties"
                v-bind:disabled="casualtyData.withInjured === false"
              >
                <option
                  v-for="option in counts"
                  v-bind:key="option.value"
                  :value="option.value"
                  >{{ option.label }}
                </option>
              </select>
            </float-label>
            <div
              class="error-message"
              v-show="submited && hasError('casualties')"
            >
              {{ hasError("casualties") }}
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="option-buttons">
            <div class="label">
              ¿Hubo un tercero involucrado en el accidente?
            </div>
            <div class="option-buttons-items">
              <button
                type="button"
                v-on:click="
                  changeRules('withInvolved', 'withThirdPartyInvolved', true)
                "
                v-bind:class="{ selected: casualtyData.withInvolved === true }"
              >
                Si
              </button>
              <button
                type="button"
                v-on:click="
                  changeRules('withInvolved', 'withThirdPartyInvolved', false)
                "
                v-bind:class="{ selected: casualtyData.withInvolved === false }"
              >
                No
              </button>
            </div>
          </div>
        </div>
      </div>

      <div v-if="casualtyData.withInvolved">
        <div class="row">
          <div class="col">
            <div class="option-buttons">
              <div class="label">¿Conoce la placa del tercero involucrado?</div>
              <div class="option-buttons-items">
                <button
                  type="button"
                  v-on:click="
                    changeRules(
                      'withThirdPartyInvolvedPlate',
                      'plateThirdPartyInvolved',
                      true
                    )
                  "
                  v-bind:class="{
                    selected: casualtyData.withThirdPartyInvolvedPlate === true
                  }"
                >
                  Si
                </button>
                <button
                  type="button"
                  v-on:click="
                    changeRules(
                      'withThirdPartyInvolvedPlate',
                      'plateThirdPartyInvolved',
                      false
                    )
                  "
                  v-bind:class="{
                    selected: casualtyData.withThirdPartyInvolvedPlate === false
                  }"
                >
                  No
                </button>
              </div>
            </div>
          </div>
          <div class="col campo-heridos">
            <div
              v-bind:class="{
                field: true,
                error: submited && hasError('plateThirdPartyInvolved'),
                filled: casualtyData.plateThirdPartyInvolved
              }"
            >
              <float-label>
                <input
                  type="text"
                  name="plateThirdPartyInvolved"
                  v-model="casualtyData.plateThirdPartyInvolved"
                  v-bind:disabled="
                    casualtyData.withThirdPartyInvolvedPlate === false
                  "
                  placeholder="Ingresar placa patente"
                  v-uppercase
                />
              </float-label>
              <div
                class="error-message"
                v-show="submited && hasError('plateThirdPartyInvolved')"
              >
                {{ hasError("plateThirdPartyInvolved") }}
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="option-buttons">
              <div class="label">
                ¿Conoce el nombre del tercero involucrado?
              </div>
              <div class="option-buttons-items">
                <button
                  type="button"
                  v-on:click="
                    changeRules(
                      'withThirdPartyInvolvedName',
                      'plateThirdPartyInvolvedName',
                      true
                    )
                  "
                  v-bind:class="{
                    selected: casualtyData.withThirdPartyInvolvedName === true
                  }"
                >
                  Si
                </button>
                <button
                  type="button"
                  v-on:click="
                    changeRules(
                      'withThirdPartyInvolvedName',
                      'plateThirdPartyInvolvedName',
                      false
                    )
                  "
                  v-bind:class="{
                    selected: casualtyData.withThirdPartyInvolvedName === false
                  }"
                >
                  No
                </button>
              </div>
            </div>
          </div>
          <div class="col campo-heridos">
            <div
              v-bind:class="{
                field: true,
                error: submited && hasError('plateThirdPartyInvolvedName'),
                filled: casualtyData.plateThirdPartyInvolvedName
              }"
            >
              <float-label>
                <input
                  type="text"
                  name="plateThirdPartyInvolvedName"
                  v-model="casualtyData.plateThirdPartyInvolvedName"
                  v-bind:disabled="
                    casualtyData.withThirdPartyInvolvedName === false
                  "
                  placeholder="Ingresar el nombre"
                  v-uppercase
                />
              </float-label>
              <div
                class="error-message"
                v-show="submited && hasError('plateThirdPartyInvolvedName')"
              >
                {{ hasError("plateThirdPartyInvolvedName") }}
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="option-buttons">
              <div class="label">
                ¿Conoce el tipo de identificación tercero involucrado?
              </div>
              <div class="option-buttons-items">
                <button
                  type="button"
                  v-on:click="
                    changeRules(
                      'withThirdPartyInvolvedTypeIdentificaction',
                      'plateThirdPartyInvolvedTypeIdentificaction',
                      true
                    )
                  "
                  v-bind:class="{
                    selected:
                      casualtyData.withThirdPartyInvolvedTypeIdentificaction ===
                      true
                  }"
                >
                  Si
                </button>
                <button
                  type="button"
                  v-on:click="
                    changeRules(
                      'withThirdPartyInvolvedTypeIdentificaction',
                      'plateThirdPartyInvolvedTypeIdentificaction',
                      false
                    )
                  "
                  v-bind:class="{
                    selected:
                      casualtyData.withThirdPartyInvolvedTypeIdentificaction ===
                      false
                  }"
                >
                  No
                </button>
              </div>
            </div>
          </div>
          <div class="col campo-heridos">
            <div
              v-bind:class="{
                field: true,
                error:
                  submited &&
                  hasError('plateThirdPartyInvolvedTypeIdentificaction'),
                filled: casualtyData.plateThirdPartyInvolvedTypeIdentificaction
              }"
            >
              <float-label label="Tipo de documento" :dispatch="false">
                <select
                  v-model="
                    casualtyData.plateThirdPartyInvolvedTypeIdentificaction
                  "
                  v-bind:disabled="
                    casualtyData.withThirdPartyInvolvedTypeIdentificaction ===
                      false
                  "
                >
                  <option
                    v-for="(index, option) in documentTypes"
                    v-bind:key="index"
                    :selected="index === 0"
                    v-bind:value="index"
                    >{{ option }}</option
                  >
                </select>
              </float-label>
              <div
                class="error-message"
                v-show="
                  submited &&
                    hasError('plateThirdPartyInvolvedTypeIdentificaction')
                "
              >
                {{ hasError("plateThirdPartyInvolvedTypeIdentificaction") }}
              </div>
            </div>
          </div>
        </div>
        <div class="row align-items-end">
          <div class="col">
            <div class="option-buttons">
              <div class="label">
                ¿Conoce el número de documento de identificación del tercero
                involucrado?
              </div>
              <div class="option-buttons-items">
                <button
                  type="button"
                  v-on:click="
                    changeRules(
                      'withThirdPartyInvolvedIdentificaction',
                      'plateThirdPartyInvolvedIdentificaction',
                      true
                    )
                  "
                  v-bind:class="{
                    selected:
                      casualtyData.withThirdPartyInvolvedIdentificaction ===
                      true
                  }"
                >
                  Si
                </button>
                <button
                  type="button"
                  v-on:click="
                    changeRules(
                      'withThirdPartyInvolvedIdentificaction',
                      'plateThirdPartyInvolvedIdentificaction',
                      false
                    )
                  "
                  v-bind:class="{
                    selected:
                      casualtyData.withThirdPartyInvolvedIdentificaction ===
                      false
                  }"
                >
                  No
                </button>
              </div>
            </div>
          </div>
          <div class="col campo-heridos">
            <div
              v-bind:class="{
                field: true,
                error:
                  submited &&
                  hasError('plateThirdPartyInvolvedIdentificaction'),
                filled: casualtyData.plateThirdPartyInvolvedIdentificaction
              }"
            >
              <float-label>
                <input
                  type="text"
                  name="plateThirdPartyInvolvedIdentificaction"
                  v-model="casualtyData.plateThirdPartyInvolvedIdentificaction"
                  v-bind:disabled="
                    casualtyData.withThirdPartyInvolvedIdentificaction === false
                  "
                  placeholder="Ingresar la identificación"
                  v-uppercase
                />
              </float-label>
              <div
                class="error-message"
                v-show="
                  submited && hasError('plateThirdPartyInvolvedIdentificaction')
                "
              >
                {{ hasError("plateThirdPartyInvolvedIdentificaction") }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="option-buttons">
            <div class="label">¿Hubo muertos?</div>
            <div class="option-buttons-items">
              <button
                type="button"
                v-on:click="changeRules('withDeaths', 'deaths', true)"
                v-bind:class="{ selected: casualtyData.withDeaths === true }"
              >
                Si
              </button>
              <button
                type="button"
                v-on:click="changeRules('withDeaths', 'deaths', false)"
                v-bind:class="{ selected: casualtyData.withDeaths === false }"
              >
                No
              </button>
            </div>
          </div>
        </div>
        <div class="col campo-muerte">
          <div
            v-bind:class="{
              field: true,
              error: submited && hasError('deaths'),
              filled: casualtyData.deaths
            }"
          >
            <float-label label="¿Cuántos?">
              <select
                v-model="casualtyData.deaths"
                v-bind:disabled="casualtyData.withDeaths === false"
              >
                <option
                  v-for="option in counts"
                  v-bind:key="option.value"
                  :value="option.value"
                  >{{ option.label }}
                </option>
              </select>
            </float-label>
            <div class="error-message" v-show="submited && hasError('deaths')">
              {{ hasError("deaths") }}
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="option-buttons">
            <div class="label">¿Intervino policía de tránsito?</div>
            <div class="option-buttons-items">
              <button
                type="button"
                v-on:click="yesNoOptions('withPolice', true)"
                v-bind:class="{ selected: casualtyData.withPolice === true }"
              >
                Si
              </button>
              <button
                type="button"
                v-on:click="yesNoOptions('withPolice', false)"
                v-bind:class="{ selected: casualtyData.withPolice === false }"
              >
                No
              </button>
            </div>
          </div>
        </div>
        <div class="col"></div>
      </div>
    </div>

    <div
      class="damages-section pt-2"
      v-if="claimType !== 'CLAIM_TYPE_PTH' && claimType !== 'CLAIM_TYPE_PL'"
    >
      <h2>Marca las zonas afectadas de tu vehículo</h2>

      <div class="field error" v-show="submited && hasError('damages')">
        <div class="error-message" tabindex="11">
          {{ hasError("damages") }}
        </div>
      </div>
      <div class="image-car">
        <img v-bind:src="carImage" alt="Daños en el vehículo" />
        <p-check
          color="primary-o"
          class="p-default p-round p-thick"
          v-model="casualtyData.damages"
          v-for="(option, index) in damages"
          v-bind:key="option"
          v-bind:value="index"
        >
          <i class="icon mdi mdi-check" slot="extra"></i>
          {{ option }}
        </p-check>
      </div>
    </div>

    <div class="actions">
      <a href="#" v-on:click.prevent="prevStep">Volver</a>
      <button v-on:click="nextStep" type="button">Continuar</button>
    </div>

    <alert
      :open="modal"
      icon="invalid-plate"
      v-on:closeModal="closeModal($event)"
    >
      <div slot="body">
        <div>
          <h2>{{ modalTitle }}</h2>
          <p>{{ modalBody }}</p>
        </div>
      </div>
    </alert>
  </div>
</template>

<script>
import PrettyCheck from "pretty-checkbox-vue/check";
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import steps from "../mixins/steps";
import Alert from "./../components/commons/alert";

export default {
  mixins: [steps],
  props: ["userData", "claimType"],
  components: {
    "p-check": PrettyCheck,
    dropzone: vue2Dropzone,
    Alert
  },
  methods: {
    getData() {
      if (localStorage.getItem("GMFChevrolet-codigoConcesionario")) {
        this.$http.get("/claim-data/cities-carshops/chevrolet").then(
          function(data) {
            this.cities = Object.entries(data.body).sort((a, b) => {
              if (a[1] > b[1]) return 1;
              if (a[1] < b[1]) return -1;
              return 0;
            });
            this.cities.unshift([0, "Ciudad"]);
          },
          function(params) {
            this.cities = {};
          }
        );
      } else {
        this.$http.get("/claim-data/cities-carshops").then(
          function(data) {
            this.cities = Object.entries(data.body).sort((a, b) => {
              if (a[1] > b[1]) return 1;
              if (a[1] < b[1]) return -1;
              return 0;
            });
            this.cities.unshift([0, "Ciudad"]);
          },
          function(params) {
            this.cities = {};
          }
        );
      }
    },
    changeRules: function(field, required, opt) {
      const fieldsToReset = [
        "plateThirdPartyInvolved",
        "plateThirdPartyInvolvedName",
        "plateThirdPartyInvolvedIdentificaction",
        "plateThirdPartyInvolvedTypeIdentificaction"
      ];
      const platesValidation = [
        {
          plateThirdPartyInvolvedIdentificaction: {
            required: {},
            match: {
              regExp: /^[a-zA-Z0-9]+$/i,
              msg: "El campo solo debe contener números o letras."
            },
            length: {
              max: 20,
              min: 3
            }
          }
        },
        {
          plateThirdPartyInvolvedName: {
            required: {},
            length: {
              max: 50
            },
            match: {
              regExp: /^[a-zA-ZáéíóúñÁÉÍÓÚÑ ]+$/i,
              msg: "El campo solo debe contener letras."
            }
          }
        },
        {
          plateThirdPartyInvolved: {
            required: {},
            length: {
              equal: 6
            },
            match: {
              regExp: /^([A-Z]{3}[0-9]{3}|[A-Z]{1}[0-9]{5}|[A-Z]{3}[0-9]{2}[A-Z]{1})$/i,
              msg: "Este dato no corresponde con un formato de placa válido."
            }
          }
        },
        {
          plateThirdPartyInvolvedTypeIdentificaction: {
            diff: {
              val: 0
            }
          }
        }
      ];
      console.log(required);
      if (fieldsToReset.includes(required)) {
        this.casualtyData[required] = opt ? this.casualtyData[required] : "";

        const desiredValidation = platesValidation.find(
          item => Object.keys(item)[0] === required
        );

        this.validationRules[required] = opt ? desiredValidation[required] : {};
      } else {
        this.casualtyData[required] = opt ? this.casualtyData[required] : 0;
        this.validationRules[required] = opt ? { diff: { val: 0 } } : {};
      }
      if (required == "withThirdPartyInvolved" && opt == false) {
        const desiredValidation = platesValidation;
        for (let x = 0; x < desiredValidation.length; x++) {
          const element = desiredValidation[x];
          for (const key in element) {
            this.validationRules[key] = opt ? false : {};
          }
        }
      }
      if (required == "withThirdPartyInvolved" && opt == true) {
        this.validationRules[required] = {};
      }
      console.log(this.validationRules);
      this.yesNoOptions(field, opt);
    },
    yesNoOptions: function(field, opt) {
      this.casualtyData[field] = opt;
    },
    isDriver: function(val) {
      if (val) {
        this.casualtyData.driverName =
          this.userData.name + " " + this.userData.lastname;
        this.casualtyData.driverPhone = this.userData.phone;
        this.casualtyData.driverDocType = this.userData.docType;
        this.casualtyData.driverDocumentId = this.userData.documentId;
      } else {
        this.casualtyData.driverName = "";
        this.casualtyData.driverPhone = "";
        this.casualtyData.driverDocType = 0;
        this.casualtyData.driverDocumentId = "";
      }
      this.yesNoOptions("isDriver", val);
    },
    isDeclarant: function(val) {
      if (val) {
        this.casualtyData.declarantName =
          this.userData.name + " " + this.userData.lastname;
        this.casualtyData.declarantPhone = this.userData.phone;
      } else {
        this.casualtyData.declarantName = "";
        this.casualtyData.declarantPhone = "";
      }
      this.yesNoOptions("isDeclarant", val);
    },
    closeModal: function() {
      this.modal = false;
    },
    countDown: function() {
      const description = this.casualtyData.description;
      const sanitizedDescription = description.replace(/\s+/g, " ");
      this.casualtyData.description = sanitizedDescription;
      this.countDownVal =
        this.validationRules.description.length.max -
        this.casualtyData.description.length;
    }
  },
  computed: {
    idMask: function() {
      let id = this.casualtyData.driverDocumentId.toString();
      const l = id.length;
      const mask = l - 3;
      id = id.substring(mask);
      return "*".repeat(mask) + id;
    },
    carImage: function() {
      return this.drupalSettings.assetsPath
        ? "/" + this.drupalSettings.assetsPath + "car-form.png"
        : "src/assets/car-form.png";
    },
    dropzoneOptions: function() {
      if (this.userData) {
        return {
          url: "/claim/files/" + this.userData.documentId + "/save",
          thumbnailWidth: 150,
          acceptedFiles: "image/jpeg, application/pdf",
          addRemoveLinks: true,
          capture: false,
          /*resizeWidth: 600,
          resizeHeight: 400,*/
          dictFileTooBig:
            "El archivo es demasiado grande ({{filesize}}MB), supera el máximo de {{maxFilesize}}MB.",
          headers: {
            token: this.drupalSettings.token
          }
        };
      } else {
        return {};
      }
    }
  },
  created() {
    this.countDown();
    delete this.documentTypes["¿Cuál es tu tipo de documento?"];
    this.documentTypes["Tipo de documento"] = 0;
  },
  updated() {
    if (
      this.claimType == "CLAIM_TYPE_PPD" ||
      this.claimType == "CLAIM_TYPE_PPH"
    ) {
      this.validationRules.damages = {
        required: {
          msg:
            this.claimType == "CLAIM_TYPE_PPD"
              ? "Debes seleccionar la(s) zona(s) de daño(s)."
              : "Debes seleccionar la(s) zona(s) de hurto(s)"
        }
      };
    } else {
      this.validationRules.damages = {};
    }
    if (this.claimType === "CLAIM_TYPE_PTH") {
      this.validationRules.files = {
        required: { msg: "Debes adjuntar la denuncia del robo de tu vehículo." }
      };
    }
  },
  data() {
    return {
      casualtyData: {
        city: 0,
        description: "",
        driverName: "",
        driverPhone: "",
        driverDocType: 0,
        driverDocumentId: "",
        declarantName: "",
        declarantPhone: "",
        whereAddress: "",
        isDriver: false,
        isDeclarant: false,
        withDeaths: false,
        withInjured: false,
        withPolice: false,
        withInvolved: false,
        withThirdPartyInvolvedPlate: false,
        withThirdPartyInvolvedName: false,
        withThirdPartyInvolvedTypeIdentificaction: false,
        withThirdPartyInvolvedIdentificaction: false,
        casualties: 0,
        withThirdPartyInvolved: false,
        thirdaInvolved: 0,
        plateThirdPartyInvolved: "",
        plateThirdPartyInvolvedName: "",
        plateThirdPartyInvolvedTypeIdentificaction: "",
        plateThirdPartyInvolvedIdentificaction: "",
        deaths: 0,
        damages: [],
        files: []
      },
      validationRules: {
        description: {
          required: {},
          length: {
            max: 1000,
            min: 100
          }
        },
        driverName: {
          required: {},
          length: {
            max: 50
          },
          match: {
            regExp: /^[a-zA-ZáéíóúñÁÉÍÓÚÑ ]+$/i,
            msg: "El campo solo debe contener letras."
          }
        },
        driverPhone: {
          required: {},
          length: {
            max: 10
          },
          match: {
            regExp: /^[0-9 ]+$/i,
            msg: "El campo solo debe contener números."
          }
        },
        driverDocumentId: {
          required: {},
          length: {
            max: 20,
            min: 3
          },
          match: {
            regExp: /^[A-Za-z0-9]+$/i,
            msg: "El campo solo debe contener números o letras."
          }
        },
        declarantName: {
          required: {},
          length: {
            max: 50
          },
          match: {
            regExp: /^[a-zA-ZáéíóúñÁÉÍÓÚÑ ]+$/i,
            msg: "El campo solo debe contener letras."
          }
        },
        declarantPhone: {
          required: {},
          length: {
            max: 10
          },
          match: {
            regExp: /^[0-9 ]+$/i,
            msg: "El campo solo debe contener números."
          }
        },
        driverDocType: {
          diff: {
            val: 0
          }
        },
        whereAddress: {
          required: {},
          length: {
            max: 40
          },
          match: {
            regExp: /^[A-Za-z0-9# -]+$/i,
            msg:
              "El campo solo debe contener números,letras o estos caracteres (#, -)"
          }
        },
        city: {
          diff: {
            val: 0
          }
        }
      },
      cities: {},
      counts: [
        { value: 0, label: "¿Cuántos?" },
        { value: 1, label: "1" },
        { value: "more", label: "Mas de uno" }
      ],
      damages: [
        "Sección delantera",
        "Lateral delantero derecho",
        "Lateral delantero izquierdo",
        "Lateral trasero derecho",
        "Lateral trasero izquierdo",
        "Sección posterior",
        "Techo",
        "Por debajo"
      ],
      modal: false,
      modalBody: "",
      modalTitle: "",
      countDownVal: 0,
      helpMessage: `Ej: Me dirigía vía la Calera y al llegar al CAI de la Calera, impacto\n
                    con el vehículo de placas XXX111, el cual me choca por la parte\n
                    trasera dañando el parachoque.`,
      cityHelpMessage:
        "Si tu ciudad no se encuentra en el listado seleccióna la ciudad más cercana."
    };
  }
};
</script>
