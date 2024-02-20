<template>
  <section
    :class="['medical-network-form-container', isMobile ? 'mobile' : '']"
    ref="form_container"
  >
    <form
      :class="['medical-network-form', 'cog--mq', isMobile ? 'mobile' : '']"
      @submit="searchMedicalNetwork"
      method="post"
      autocomplete="off"
      ref="search_form"
    >
      <span
        :class="['back']"
        @click="resetForm"
        v-show="isMobile && selected_plan_tids"
      >
        Atrás
      </span>
      <fieldset :class="['plan-types', 'row']">
<<<<<<< HEAD
=======
        <legend></legend>
>>>>>>> main
        <div
          :class="[
            'form-item',
            'col-sm-12',
            'col-md-6',
            isMobile && selected_plan == plan.tid
              ? 'selected'
              : selected_plan == null
              ? ''
              : 'hide-mobile',
          ]"
          v-for="(plan, index) in list"
          :key="index"
        >
          <input
            class="form-radio"
            v-model="selected_plan"
            type="radio"
            :id="`plan-type-${index}`"
            name="plan_type"
            :value="plan.tid"
          />
          <label
            :for="`plan-type-${index}`"
            class="option"
            v-tooltip.top="{
              content: plan.description,
              class: 'custom-tooltip',
            }"
          >
            {{ plan.name }}
          </label>
        </div>
      </fieldset>
      <fieldset
        :class="['form-lists', 'row', selected_plan_tids ? '' : 'hide-mobile']"
      >
<<<<<<< HEAD
=======
        <legend></legend>
>>>>>>> main
        <div
          class="form-item js-form-type-select form-type-select form-item-search-institution col-sm-12 col-md-5"
        >
          <label for="search-institution">
            Nombre de la institución o especialista
          </label>
          <input
            type="text"
            class="search-institution form-select"
            v-model="selected_institution"
            @click="selected_institution = null"
            id="search-institution"
            list="institutionsList"
            :disabled="!selected_plan"
          />
          <datalist id="institutionsList">
            <option v-for="(institution, key) in institutions_list" :key="key">
              {{ institution.title }}
            </option>
          </datalist>
        </div>
        <div
          class="form-item js-form-type-select form-type-select form-item-search-city col-sm-12 col-md-3 col-md-offset-1"
        >
          <label for="search-city">Ciudad</label>
          <input
            type="text"
            class="search-city form-select"
            v-model="selected_city"
            id="search-city"
            list="citiesList"
            @input="selectCity"
            @click="
<<<<<<< HEAD
              selected_city = null
              selected_city_tid = null
              selected_speciality = null
              selected_speciality_tid = null
=======
              selected_city = null;
              selected_city_tid = null;
              selected_speciality = null;
              selected_speciality_tid = null;
>>>>>>> main
            "
            :disabled="!selected_plan"
            autocomplete="off"
          />
          <datalist id="citiesList">
            <option
              v-for="(city, key) in cities_list"
              :key="key"
              :data-value="city.tid"
            >
              {{ city.name }}
            </option>
          </datalist>
        </div>
        <div
          class="form-item js-form-type-select form-type-select form-item-search-speciality col-sm-12 col-md-3"
        >
          <label for="search-speciality">Especialidad</label>
          <input
            type="text"
            class="search-speciality form-select"
            v-model="selected_speciality"
            id="search-speciality"
            list="specialityList"
            @click="
<<<<<<< HEAD
              selected_speciality = null
              selected_speciality_tid = null
=======
              selected_speciality = null;
              selected_speciality_tid = null;
>>>>>>> main
            "
            @input="selectSpeciality"
            :disabled="!selected_city_tid"
          />
          <datalist id="specialityList">
            <option
              v-for="(speciality, key) in specialities_list"
              :key="key"
              :data-value="speciality.tid"
            >
              {{ speciality.name }}
            </option>
          </datalist>
        </div>
      </fieldset>
      <fieldset
        :class="[
          'filter-icons',
          'row',
          selected_plan_tids ? '' : 'hide-mobile',
        ]"
      >
<<<<<<< HEAD
=======
        <legend></legend>
>>>>>>> main
        <div
          :class="[
            'col-sm-12',
            'col-md-6',
            'row',
            isMobile ? '' : 'col-md-offset-6',
          ]"
        >
          <p class="col-sm-12">Haz clic en los iconos para filtrar</p>
          <div
            class="form-item form-type-checkbox form-item-search-telemedicine col-md-4"
          >
            <input
              type="checkbox"
              name="search_telemedicine"
              v-model="search_telemedicine"
              id="search-telemedicine"
              :disabled="!selected_speciality_tid"
            />
            <label for="search-telemedicine">Telemedicina</label>
          </div>
          <div class="form-item form-item-search-institutions col-md-4">
            <input
              type="radio"
              v-model="search_category"
              value="1"
              id="search-institutions"
              :disabled="!selected_speciality_tid"
              @click.self="
                search_category != null ? (search_category = null) : null
              "
            />
            <label for="search-institutions">Instituciones</label>
          </div>
          <div class="form-item form-item-search-specialists col-md-4">
            <input
              type="radio"
              v-model="search_category"
              value="2"
              id="search-specialists"
              :disabled="!selected_speciality_tid"
              @click.self="
                search_category != null ? (search_category = null) : null
              "
            />
            <label for="search-specialists">Especialistas</label>
          </div>
        </div>
      </fieldset>
      <fieldset
        :class="['bottom-form', 'row', selected_plan_tids ? '' : 'hide-mobile']"
      >
<<<<<<< HEAD
=======
        <legend></legend>
>>>>>>> main
        <div
          class="form-item form-type-checkbox form-item-search-telemedicine col-md-5 col-sm-12"
        >
          <input
            type="checkbox"
            name="search_near"
            v-model="search_near"
            id="search-near"
            :disabled="!selected_speciality_tid"
          />
          <label for="search-near">Buscar cerca de mi</label>
          <span class="error error-message" v-show="error_location">
            ¡No esta habilitado el acceso a la ubicación!
          </span>
        </div>
        <div class="col-md-4 col-sm-12">
          <input
            type="submit"
            value="Buscar"
            class="button"
            @click="searchMedicalNetwork && $emit('search')"
            ref="searchButton"
            @search="searchMedicalNetwork"
          />
        </div>
        <span
          class="glossary-link col-md-3 col-sm-12"
          @click="show_glossary = true"
        >
          Glosario de especialidades
        </span>
        <component
          :is="showGlossary"
          @close="show_glossary = false"
          :isMobile="isMobile"
        />
      </fieldset>
    </form>

    <div
      :class="[
        'preferential-medical-network',
        'cog--mq',
        isMobile ? 'mobile' : '',
      ]"
      v-show="show_preferential"
    >
      <span
        :class="['back']"
        @click="showForm"
        v-show="isMobile && selected_plan_tids"
      >
        Mostrar filtros
      </span>
      <div class="row">
        <h4 class="title col-md-4 col-xs-4">Red Médica Preferencial</h4>
        <span class="institutions col-md-3 col-xs-4">Instituciones</span>
        <span class="specialists col-md-3 col-xs-4">Especialistas</span>
        <span
          class="info col-md-2 col-xs-12"
          @click="show_preferential_help = true"
        >
          Ver información
        </span>
        <component
          :is="preferentialHelp"
          @close="show_preferential_help = false"
          :isMobile="isMobile"
        />
      </div>
    </div>

    <div
      :class="['selected-filters', 'cog--mq', isMobile ? 'mobile' : '']"
      v-show="show_preferential"
    >
      <ul>
        <li v-show="selected_institution">
          {{ selected_institution }}
          <span
            @click.self="
<<<<<<< HEAD
              ;[(selected_institution = null), (selected_institution = null)]
=======
              [(selected_institution = null), (selected_institution = null)]
>>>>>>> main
            "
            @click="search()"
          >
            X
          </span>
        </li>
        <li v-show="selected_city_tid">
          {{ selected_city }}
          <span
<<<<<<< HEAD
            @click.self=";[(selected_city_tid = null), (selected_city = null)]"
=======
            @click.self="[(selected_city_tid = null), (selected_city = null)]"
>>>>>>> main
            @click="search()"
          >
            X
          </span>
        </li>
        <li v-show="selected_speciality_tid">
          {{ selected_speciality }}
          <span
            @click.self="
<<<<<<< HEAD
              ;[(selected_speciality_tid = null), (selected_speciality = null)]
=======
              [(selected_speciality_tid = null), (selected_speciality = null)]
>>>>>>> main
            "
            @click="search()"
          >
            X
          </span>
        </li>
        <li v-show="search_telemedicine">
          Telemedicina
          <span @click.self="search_telemedicine = null" @click="search()">
            X
          </span>
        </li>
        <li v-show="search_category == 1">
          Instituciones
          <span @click.self="search_category = null" @click="search()">X</span>
        </li>
        <li v-show="search_category == 2">
          Especialistas
          <span @click.self="search_category = null" @click="search()">X</span>
        </li>
      </ul>
    </div>
  </section>
</template>

<script>
<<<<<<< HEAD
import Api from '../helpers/Api'

import Glossary from './Glossary'
import PreferentialHelp from './PreferentialHelp'

export default {
  name: 'NetworkForm',
=======
import Api from "../helpers/Api";

import Glossary from "./Glossary";
import PreferentialHelp from "./PreferentialHelp";

export default {
  name: "NetworkForm",
>>>>>>> main
  data: function () {
    return {
      list: [],
      cities_list: [],
      specialities_list: [],
      institutions_list: [],
      error_location: false,
      selected_city: null,
      selected_city_tid: null,
      selected_speciality: null,
      selected_speciality_tid: null,
      selected_plan: null,
      selected_plan_tids: null,
      selected_institution: null,
      search_telemedicine: null,
      search_category: null,
      search_near: null,
      location_cordinates: null,
      show_glossary: false,
      show_preferential: false,
      show_preferential_help: false,
<<<<<<< HEAD
    }
  },
  props: ['plan_list', 'isMobile'],
=======
    };
  },
  props: ["plan_list", "isMobile"],
>>>>>>> main
  components: { Glossary, PreferentialHelp },
  computed: {
    showGlossary: function () {
      if (this.show_glossary === true) {
<<<<<<< HEAD
        document.querySelector('html').classList.add('is-modal')
        return Glossary
      }
      document.querySelector('html').classList.remove('is-modal')
      return null
    },
    preferentialHelp: function () {
      if (this.show_preferential_help) {
        document.querySelector('html').classList.add('is-modal')
        return PreferentialHelp
      }
      document.querySelector('html').classList.remove('is-modal')
      return null
    },
  },
  mounted: function () {
    this.setPlanTypes()
=======
        document.querySelector("html").classList.add("is-modal");
        return Glossary;
      }
      document.querySelector("html").classList.remove("is-modal");
      return null;
    },
    preferentialHelp: function () {
      if (this.show_preferential_help) {
        document.querySelector("html").classList.add("is-modal");
        return PreferentialHelp;
      }
      document.querySelector("html").classList.remove("is-modal");
      return null;
    },
  },
  mounted: function () {
    this.setPlanTypes();
>>>>>>> main
  },
  watch: {
    selected_plan: function () {
      if (!this.isMobile) {
<<<<<<< HEAD
        this.resetForm()
      }
      for (let key in this.list) {
        if (this.list[key].tid === this.selected_plan) {
          this.selected_plan_tids = this.list[key].tids
=======
        this.resetForm();
      }
      for (let key in this.list) {
        if (this.list[key].tid === this.selected_plan) {
          this.selected_plan_tids = this.list[key].tids;
>>>>>>> main
        }
      }
      if (this.selected_plan) {
        if (this.isMobile) {
<<<<<<< HEAD
          document.querySelector('html').classList.add('is-modal')
          this.$refs.form_container.classList.add('modal-white')
        }
        this.citieslist()
      }
    },
    selected_institution: function () {
      this.searchInstitution()
    },
    selected_city: function () {
      this.searchCity()
    },
    selected_speciality: function () {
      this.searchSpeciality()
    },
    search_near: function () {
      this.getGeolocation()
=======
          document.querySelector("html").classList.add("is-modal");
          this.$refs.form_container.classList.add("modal-white");
        }
        this.citieslist();
      }
    },
    selected_institution: function () {
      this.searchInstitution();
    },
    selected_city: function () {
      this.searchCity();
    },
    selected_speciality: function () {
      this.searchSpeciality();
    },
    search_near: function () {
      this.getGeolocation();
>>>>>>> main
    },
  },
  created: function () {},
  methods: {
    setPlanTypes: function () {
      // Iterate over selected plans
      for (let index = 0; index < this.plan_list.length; index++) {
        let new_plan = {
          tid: this.plan_list[index].id,
          description: this.plan_list[index].description,
          name: null,
<<<<<<< HEAD
        }

        // Search additional plan data
        Api.get('plan/', this.plan_list[index].id).then((result) => {
          new_plan.name = result[0].name
          new_plan.tids = result[0].tid
        })

        this.list.push(new_plan)
=======
        };

        // Search additional plan data
        Api.get("plan/", this.plan_list[index].id).then((result) => {
          new_plan.name = result[0].name;
          new_plan.tids = result[0].tid;
        });

        this.list.push(new_plan);
>>>>>>> main
      }
    },
    // Get cities list
    citieslist: function () {
<<<<<<< HEAD
      Api.get('cities/', this.selected_plan).then((result) => {
        this.cities_list = result
      })
=======
      Api.get("cities/", this.selected_plan).then((result) => {
        this.cities_list = result;
      });
>>>>>>> main
    },
    // Get speciality list in city
    specialitylist: function () {
      Api.get(
<<<<<<< HEAD
        'specialities/',
        this.selected_plan + '/' + this.selected_city_tid,
      ).then((result) => {
        this.specialities_list = result
      })
=======
        "specialities/",
        this.selected_plan + "/" + this.selected_city_tid
      ).then((result) => {
        this.specialities_list = result;
      });
>>>>>>> main
    },
    // Search city by name
    searchCity: function () {
      if (this.selected_plan && this.selected_city && !this.selected_city_tid) {
<<<<<<< HEAD
        Api.get('cities/', this.selected_plan + '/' + this.selected_city).then(
          (result) => {
            this.cities_list = result
          },
        )
=======
        Api.get("cities/", this.selected_plan + "/" + this.selected_city).then(
          (result) => {
            this.cities_list = result;
          }
        );
>>>>>>> main
      }
    },
    // Search speciality by name with the selcted plan and city
    searchSpeciality: function () {
      if (this.selected_city_tid && !this.selected_speciality_tid) {
        Api.get(
<<<<<<< HEAD
          'specialities/',
          this.selected_plan +
            '/' +
            this.selected_city_tid +
            '/' +
            this.selected_speciality,
        ).then((result) => {
          this.specialities_list = result
        })
=======
          "specialities/",
          this.selected_plan +
            "/" +
            this.selected_city_tid +
            "/" +
            this.selected_speciality
        ).then((result) => {
          this.specialities_list = result;
        });
>>>>>>> main
      }
    },
    // Search institution by name
    searchInstitution: function () {
      if (this.selected_plan && this.selected_institution) {
        Api.get(
<<<<<<< HEAD
          'institutions/',
          this.selected_plan + '/' + this.selected_institution,
        ).then((result) => {
          this.institutions_list = result
        })
=======
          "institutions/",
          this.selected_plan + "/" + this.selected_institution
        ).then((result) => {
          this.institutions_list = result;
        });
>>>>>>> main
      }
    },
    // Set city tid on select
    selectCity: function (e) {
      for (let key in this.cities_list) {
        if (this.cities_list[key].name === e.target.value) {
<<<<<<< HEAD
          this.selected_city_tid = this.cities_list[key].tid
=======
          this.selected_city_tid = this.cities_list[key].tid;
>>>>>>> main
        }
      }

      // Set the speciality list in selected city
<<<<<<< HEAD
      this.specialitylist()
    },
    selectSpeciality: function (e) {
      for (let key in this.specialities_list) {
        if (this.specialities_list[key].name === e.target.value) {
          this.selected_speciality_tid = this.specialities_list[key].tid
=======
      this.specialitylist();
    },
    selectSpeciality: function (e) {
      for (let key in this.specialities_list) {
        this.specialities_list[key].name = this.specialities_list[key].name
          .trim()
          .slice(0, this.specialities_list[key].name.trimRight().length);
        if (this.specialities_list[key].name === e.target.value) {
          this.selected_speciality_tid = this.specialities_list[key].tid;
>>>>>>> main
        }
      }
    },
    // If search near is active, try to get bowser location
    getGeolocation: function () {
      if (this.search_near) {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
            (pos) => {
              let max_distance =
<<<<<<< HEAD
                window.drupalSettings.medicalNetwork.max_distance
              this.location_cordinates =
                pos.coords.latitude +
                ',' +
                pos.coords.longitude +
                '<=' +
                max_distance +
                'km'
            },
            (err) => {
              this.error_location = true
              this.location_cordinates = {}
              this.search_near = null
              console.log(err.message)
            },
          )
=======
                window.drupalSettings.medicalNetwork.max_distance;
              this.location_cordinates =
                pos.coords.latitude +
                "," +
                pos.coords.longitude +
                "<=" +
                max_distance +
                "km";
            },
            (err) => {
              this.error_location = true;
              this.location_cordinates = {};
              this.search_near = null;
              console.log(err);
            }
          );
>>>>>>> main
        }
      }
    },
    // Search for results
    searchMedicalNetwork: function (e) {
<<<<<<< HEAD
      e.preventDefault()

      this.search()

      if (this.isMobile) {
        document.querySelector('html').classList.remove('is-modal')
        this.$refs.form_container.classList.remove('modal-white')
        this.$refs.search_form.classList.add('hide-mobile')
=======
      e.preventDefault();

      this.search();

      if (this.isMobile) {
        document.querySelector("html").classList.remove("is-modal");
        this.$refs.form_container.classList.remove("modal-white");
        this.$refs.search_form.classList.add("hide-mobile");
>>>>>>> main
      }
    },
    // Actual search
    search: function () {
<<<<<<< HEAD
      this.show_preferential = true
      this.$store.commit('resetSearch')
=======
      this.show_preferential = true;
      this.$store.commit("resetSearch");
>>>>>>> main

      // if (
      //   this.institution_name === null ||
      //   (this.selected_city_tid !== null &&
      //     this.selected_speciality_tid === null) ||
      //   (this.selected_city_tid === null &&
      //     this.selected_speciality_tid !== null)
      // ) {
      //   this.resetForm()
      // }

      // Form data
      let payload = {
        plan_id: this.selected_plan_tids,
        ubication_id: this.selected_city_tid,
        speciality_id: this.selected_speciality_tid,
        institution_name: this.selected_institution,
        page: 0,
        show_results: true,
<<<<<<< HEAD
      }

      // If selected telemedicine filter
      if (this.search_telemedicine) {
        payload['telemedicine'] = 1
=======
      };

      // If selected telemedicine filter
      if (this.search_telemedicine) {
        payload["telemedicine"] = 1;
>>>>>>> main
      }

      // If selected the category filter
      if (this.search_category) {
<<<<<<< HEAD
        payload['category'] = this.search_category
=======
        payload["category"] = this.search_category;
>>>>>>> main
      }

      // If selected  near search filter
      if (this.search_near) {
<<<<<<< HEAD
        payload['map_proximity'] = this.location_cordinates
=======
        payload["map_proximity"] = this.location_cordinates;
>>>>>>> main
      }

      // If no city is selected or institution name
      if (!this.selected_city_tid && !this.selected_institution) {
<<<<<<< HEAD
        this.show_preferential = false
      }

      // Set form data
      this.$store.commit('setSearchData', payload)
    },
    resetForm: function () {
      document.querySelector('html').classList.remove('is-modal')
      this.$refs.form_container.classList.remove('modal-white')

      if (this.isMobile) {
        this.selected_plan = null
        this.selected_plan_tids = null
        this.$refs.search_form.classList.remove('hide-mobile')
      }

      this.cities_list = []
      this.specialities_list = []
      this.institutions_list = []
      this.error_location = false
      this.selected_city = null
      this.selected_city_tid = null
      this.selected_speciality = null
      this.selected_speciality_tid = null
      this.selected_institution = null
      this.search_telemedicine = null
      this.search_category = null
      this.search_near = null
      this.location_cordinates = null
      this.show_glossary = false
      this.show_preferential = false
      this.show_preferential_help = false

      this.$emit('reset')
    },
    showForm: function () {
      this.$refs.search_form.classList.remove('hide-mobile')
      this.$refs.form_container.classList.add('modal-white')
      this.show_preferential = false
      this.$emit('hideResults')
    },
  },
}
=======
        this.show_preferential = false;
      }

      // Set form data
      this.$store.commit("setSearchData", payload);
    },
    resetForm: function () {
      document.querySelector("html").classList.remove("is-modal");
      this.$refs.form_container.classList.remove("modal-white");

      if (this.isMobile) {
        this.selected_plan = null;
        this.selected_plan_tids = null;
        this.$refs.search_form.classList.remove("hide-mobile");
      }

      this.cities_list = [];
      this.specialities_list = [];
      this.institutions_list = [];
      this.error_location = false;
      this.selected_city = null;
      this.selected_city_tid = null;
      this.selected_speciality = null;
      this.selected_speciality_tid = null;
      this.selected_institution = null;
      this.search_telemedicine = null;
      this.search_category = null;
      this.search_near = null;
      this.location_cordinates = null;
      this.show_glossary = false;
      this.show_preferential = false;
      this.show_preferential_help = false;

      this.$emit("reset");
    },
    showForm: function () {
      this.$refs.search_form.classList.remove("hide-mobile");
      this.$refs.form_container.classList.add("modal-white");
      this.show_preferential = false;
      this.$emit("hideResults");
    },
  },
};
>>>>>>> main
</script>
