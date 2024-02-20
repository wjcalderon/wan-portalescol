<template>
  <section
    :class="['error-form', 'modal', isMobile ? 'mobile modal-white' : '']"
  >
    <div :class="['modal-content', show_confirmation ? 'small' : '']">
      <button
        class="close-modal"
        @click="$emit('close')"
        v-show="!isMobile"
      ></button>
      <span
        class="back"
        @click="$emit('close')"
        v-show="isMobile && !show_confirmation"
        >Atrás</span
      >
      <form
        method="post"
        autocomplete="off"
        @submit="submitForm"
        :class="this.errors ? 'errors' : false"
        v-show="!show_confirmation"
      >
        <fieldset class="title">
          <legend></legend>
          <h2>Reportar datos errados</h2>
          <p>
            Diligencia los siguientes datos y repórtanos el error que has
            evidenciado
          </p>
        </fieldset>
        <div
          class="form-item js-form-type-text form-type-textfield form-item-lender form__input--activo"
        >
          <label for="lender">Prestador</label>
          <input
            type="text"
            v-model="lender"
            disabled
            id="lender"
            class="form-text"
          />
        </div>
        <div
          class="form-item js-form-type-text form-type-textfield form-item-name"
          ref="name"
        >
          <label for="name">Nombre</label>
          <input
            type="text"
            v-model="name"
            id="name"
            required
            class="form-text"
            maxlength="30"
            @invalid="invalidateForm"
            @change="labelClass('name')"
            @focus="labelClass('name')"
            @blur="removeLabelClass(name, 'name')"
          />
        </div>
        <div
          class="form-item js-form-type-text form-type-textfield form-item-lastname"
          ref="lastname"
        >
          <label for="lastname">Apellido</label>
          <input
            type="text"
            v-model="lastname"
            id="lastname"
            required
            class="form-text"
            maxlength="30"
            @invalid="invalidateForm"
            @change="labelClass('lastname')"
            @focus="labelClass('lastname')"
            @blur="removeLabelClass(lastname, 'lastname')"
          />
        </div>
        <div
          class="form-item js-form-type-email form-type-email form-item-email"
          ref="email"
        >
          <label for="email">Correo electrónico</label>
          <input
            type="email"
            v-model="email"
            id="email"
            required
            class="form-email"
            @invalid="invalidateForm"
            @change="labelClass('email')"
            @focus="labelClass('email')"
            @blur="removeLabelClass(email, 'email')"
          />
        </div>
        <div
          class="form-item js-form-type-select form-type-select form-item-error_type"
          ref="error_type"
        >
          <label for="error_type">Tipo de error</label>
          <select
            class="form-select"
            id="error_type"
            v-model="error_type"
            required
            @invalid="invalidateForm"
            @change="labelClass('error_type')"
            @focus="labelClass('error_type')"
            @blur="removeLabelClass(error_type, 'error_type')"
          >
            <option value="" selected="selected">- Seleccionar -</option>
            <option value="address">Dirección</option>
            <option value="phone">Teléfono</option>
            <option value="whatsapp">WhatsApp</option>
            <option value="services">Servicios</option>
            <option value="other">Otros</option>
          </select>
        </div>
        <div
          class="form-item js-form-type-textarea form-type-textarea form-item-observation"
          ref="observation"
        >
          <label for="observation">Observación…</label>
          <div>
            <textarea
              class="form-textarea required"
              id="observation"
              v-model="observation"
              rows="5"
              cols="60"
              autocomplete="off"
              @change="labelClass('observation')"
              @focus="labelClass('observation')"
              @blur="removeLabelClass(observation, 'observation')"
            ></textarea>
          </div>
        </div>
        <div
          class="form-item js-form-type-checkbox form-type-checkbox form-item-personal_data"
        >
          <input
            type="checkbox"
            v-model="authorize_personal_data_use"
            id="personal_data"
          />
          <label for="personal_data">
            Autorizo el uso de mis datos personales por parte de Liberty Seguros
            S.A.
            <a
              :href="personal_data_url"
              target="_blank"
              rel="noreferrer"
              title="Política de tratamiento de datos de Liberty Seguros"
              >de acuerdo a sus términos, condiciones y políticas de
              privacidad</a
            >
          </label>
        </div>
        <fieldset class="bottom-form">
          <legend></legend>
          <div>
            <p>
              Te estaremos notificando cuando el error haya sido revisado y
              solucionado
            </p>
            <input
              type="submit"
              value="Enviar"
              class="button"
              :disabled="!authorize_personal_data_use && !errors"
            />
          </div>
        </fieldset>
      </form>
      <div class="form-confirmation" v-show="show_confirmation">
        <div class="icon"></div>
        <h2>Tu información ha sido enviada</h2>
        <button v-show="isMobile" @click="$emit('close')">
          Volver a resultados
        </button>
      </div>
    </div>
  </section>
</template>

<script>
import Api from "../helpers/Api";

export default {
  name: "ErrorForm",
  data: function () {
    return {
      lender: this.lender_name,
      name: null,
      lastname: null,
      email: null,
      error_type: null,
      observation: null,
      errors: false,
      authorize_personal_data_use: false,
      personal_data_url: window.drupalSettings.medicalNetwork.personal_data_url,
      csrf_token: null,
      show_confirmation: false,
    };
  },
  props: ["lender_name", "isMobile"],
  created: function () {
    Api.getCsrfToken().then((response) => {
      this.csrf_token = response;
    });
  },
  methods: {
    invalidateForm: function () {
      this.errors = true;
    },
    labelClass: function (ref) {
      this.$refs[ref].classList.add("form__input--activo");
    },
    removeLabelClass: function (value, ref) {
      if (value == null) {
        this.$refs[ref].classList.remove("form__input--activo");
      }
    },
    submitForm: function (e) {
      const data = {
        lender: this.lender,
        name: this.name,
        lastname: this.lastname,
        email: this.email,
        error_type: this.error_type,
        observation: this.observation,
        authorize_personal_data_use: this.authorize_personal_data_use,
        webform_id: "reporte_de_datos_errados",
        in_draft: false,
      };

      Api.postWebForm(data, this.csrf_token).then((response) => {
        this.show_confirmation = true;
        console.log(response);
      });

      e.preventDefault();
    },
  },
};
</script>
