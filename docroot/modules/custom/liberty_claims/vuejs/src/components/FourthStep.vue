<template>
  <div class="pane fourth-step">
    <h1>Estamos en donde nos necesitas</h1>
    <p>
      Busca la ciudad de reparación que prefieras y asigna el taller más cercano
    </p>
    <div class="search-bar">
      <div class="filters">
        <div class="filter">
          <h4>Marca</h4>
          <span v-if="vehicleData">{{ vehicleData.brand }}</span>
        </div>
        <div class="filter">
          <h4>Modelo</h4>
          <span v-if="vehicleData">{{ vehicleData.model }}</span>
        </div>
        <div class="filter">
          <h4>Tipo</h4>
          <span v-if="vehicleData">{{ vehicleData.vehicleType }}</span>
        </div>
      </div>

      <div v-bind:class="{ field: true, filled: claimCity }">
        <float-label label="Buscar ciudad de reparación" fixed>
          <select
            v-model="claimCity"
            v-on:change="findCarShops"
            ref="citySelect"
            @click="getData"
          >
            <option
              v-for="item in cities"
              v-bind:key="item[0]"
              v-bind:value="item[0]"
              >{{ item[1] }}</option
            >
          </select>
        </float-label>
      </div>
    </div>

    <div class="error" v-show="showError">
      <div class="error-message">Debes seleccionar un taller.</div>
    </div>

    <div class="list">
      <div class="car-shops" v-if="carShopsLength > 0">
        <p class="total">
          Hemos encontrado {{ carShopsLength }} <strong>talleres</strong>
          <span v-if="carShops[0].hasOwnProperty('external')">
            en ciudades cercanas</span
          >
          <span v-else>para la búsqueda realizada</span>
        </p>
        <ol>
          <li
            v-for="(item, index) in currentPage"
            v-bind:key="index"
            v-bind:class="{ row: true, assigned: item.codTaller === assigned }"
          >
            <div class="col">
              <div class="title">
                <h3>{{ item.nombre }}</h3>
                <h4 v-show="item.hasOwnProperty('external')">
                  <strong>Ciudad: {{ item.external }}</strong>
                </h4>
              </div>
              <div class="address">
                {{ item.direccion }}
              </div>
              <div class="phone">
                {{ item.telefono }}
              </div>
              <span class="label">Horario de atención:</span>
              <div class="info">
                <p>Lunes a Sábado</p>
                <p>de 8:00 a.m. a 5:00 p.m.</p>
              </div>
            </div>
            <div class="col">
              <button
                type="button"
                v-on:click="openModal(item)"
                v-bind:class="{ 'button-secondary': item.codTaller !== assigned, 'button--primary': item.codTaller === assigned }"
              >
                {{ buttonLabel(item.codTaller) }}
              </button>
            </div>
          </li>
        </ol>
        <div class="pager" v-if="carShopsLength > offset">
          <ul>
            <li class="page-item first-page">
              <a href="0" v-on:click.prevent="changePage(1)">first</a>
            </li>
            <li
              :class="{ 'page-item': true, current: index - 1 === page }"
              v-for="index in totalPages"
              v-bind:key="index"
            >
              <a :href="index" v-on:click.prevent="changePage(index)">{{
                index
              }}</a>
            </li>
            <li class="page-item last-page">
              <a :href="totalPages" v-on:click.prevent="changePage(totalPages)"
                >last</a
              >
            </li>
          </ul>
        </div>
        <div
          class="trusted"
          v-show="carShopsLength > 0 && carShops[0].hasOwnProperty('external')"
        >
          <p class="total">O selecciona tu taller de confianza</p>
          <ul>
            <li
              v-bind:class="{
                row: true,
                assigned: defaultCS.codTaller === assigned
              }"
            >
              <div class="col">
                <div class="title">
                  <h3>Taller de confianza</h3>
                  <h4 style="display:none">&nbsp;</h4>
                </div>
                <div class="list">
                  <dd>
                    1. <strong>Copia el informe de tránsito</strong> (Croquis) o
                    <strong>Fallo o resolución de tránsito</strong> o
                    <strong>acuerdo conciliatorio</strong> o
                    <strong>carta del asegurado</strong> donde indique la
                    versión de los hechos, fotografías que demuestren
                    concurrencia, fecha, lugar, nombre del conductor y
                    autorización para afectar su poliza. Para este caso adjuntar
                    copia de cédula del asegurado.
                  </dd>
                  <dd>
                    2.
                    <strong
                      >Fotografías claras de los daños del vehículo.</strong
                    >
                  </dd>
                  <dd>
                    3.
                    <strong
                      >Cotización de mano de obra y repuestos de tu taller de
                      confianza.</strong
                    >
                  </dd>
                </div>
              </div>
              <div class="col">
                <button
                  type="button"
                  v-on:click="assignTRD"
                  v-bind:class="{ assigned: defaultCS.codTaller === assigned }"
                >
                  {{ buttonLabel(defaultCS.codTaller) }}
                </button>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="no-results" v-else-if="searchExecuted">
        <h3>
          Ups, lo sentimos no hemos encontrado talleres disponibles en esta
          ciudad
        </h3>
        <p>
          Puedes seleccionar otra ciudad, o reparar tu vehículo en un taller de
          confianza.
        </p>
        <p>Posteriormente debes reunir los siguientes documentos:</p>

        <ol>
          <li>
            <strong>Copia de informe de tránsito</strong> (croquis) o
            <strong>Fallo o resolución de tránsito</strong> o
            <strong>Acuerdo conciliatorio</strong> o
            <strong>Carta del asegurado</strong> donde indique la versión de los
            hechos, fotografías que demuestren ocurrencia, fecha, lugar, nombre
            del conductor y autorización para afectar su póliza. Para este caso
            adjuntar copia de cédula del asegurado.
          </li>
          <li>
            <strong>Fotografías claras de los daños del vehículo.</strong>
          </li>
          <li>
            <strong
              >Cotización de mano de obra y repuestos de tu taller de
              confianza.</strong
            >
          </li>
        </ol>
      </div>
    </div>

    <div class="actions">
      <a href="#" v-on:click.prevent="prevStep">Volver</a>
      <button
        v-on:click="validateCarShop"
        type="button"
        :disabled="
          assigned || (!assigned && carShopsLength === 0) ? disabled : ''
        "
      >
        Continuar
      </button>
    </div>

    <component
      :is="modal"
      :item="selected"
      v-on:closeModal="assign($event)"
    ></component>
    <div v-bind:class="{ overlay: true, hide: modal === null }"></div>
  </div>
</template>
<script>
import steps from "../mixins/steps";
import popUp from "../components/popUpCarShops";
import popUpChange from "../components/popUpChangeCarShop";

export default {
  components: {
    "pop-up-assign": popUp,
    "pop-up-change": popUpChange
  },
  mixins: [steps],
  props: ["vehicleData", "claimCity", "claimType", "isBroker"],
  data() {
    return {
      assigned: null,
      carShops: {},
      cities: {},
      modal: null,
      selected: {},
      casualtyData: {},
      searchExecuted: false,
      page: 0,
      offset: 4,
      showError: false,
      defaultCS: null,
      noWorkshopsCities: [],
      ciudad_original: false
    };
  },
  computed: {
    currentPage: function() {
      if (this.carShops) {
        return this.carShops.slice(
          this.page * this.offset,
          this.page * this.offset + this.offset
        );
      }
      return {};
    },
    carShopsLength: function() {
      return this.carShops.length;
    },
    noResultsImage: function() {
      return this.drupalSettings.assetsPath
        ? "/" + this.drupalSettings.assetsPath + "not-foundGuy.svg"
        : "src/assets/not-foundGuy.svg";
    },
    totalPages: function() {
      return Math.ceil(this.carShops.length / this.offset);
    }
  },
  methods: {
    changePage: function(index) {
      this.page = index - 1;
    },
    buttonLabel: function(current) {
      if (current === this.assigned) {
        return "Asignado";
      }
      return "Asignar Taller";
    },
    findCarShops: function() {
      if (this.vehicleData && this.vehicleData.brand) {
        let loader = this.$loading.show({
          canCancel: false
        });

        this.page = 0;
        this.assigned = null;
        this.selected = {};
        this.casualtyData = {};

        let brand = this.vehicleData.brand.replace(/\s+/g, "--");
        brand = brand.replace(/[\/]/g, "++");
        let model = this.vehicleData.model;

        if (
          this.isBroker &&
          this.vehicleData.model >= this.drupalSettings.lastModel - 5
        ) {
          model = this.drupalSettings.lastModel;
        }
        if (brand.includes("GREAT--WALL--MOTOR")) {
          brand = "GREAT--WALL";
        }
        const path = `/${this.claimCity}/${brand}/${model}/${this.vehicleData.vehicleType}`;
        this.$http.get("/claim-data/carshops" + path).then(
          function(data) {
            if (data.statusCode != 401 && Array.isArray(data.body)) {
              const vm = this;
              if (localStorage.getItem("GMFChevrolet-codigoConcesionario")) {
                vm.defaultCS = data.body;
              }

              let result = data.body.filter(carShop => {
                if (
                  carShop.nombre.includes("Taller para Arreglo Directo") &&
                  carShop.codExternal === undefined
                ) {
                  vm.defaultCS = carShop;
                }
                if (this.claimType === "CLAIM_TYPE_LR") {
                  return carShop.nombre.includes("LLANTAS ESTALLADAS");
                } else {
                  return (
                    !carShop.nombre.includes("(LLANTAS ESTALLADAS)") &&
                    !carShop.nombre.includes("(INACTIVO)") &&
                    !carShop.nombre.includes("Taller para PTH") &&
                    !carShop.nombre.includes("Taller para RCDBT") &&
                    !carShop.nombre.includes("Taller para Arreglo Directo")
                  );
                }
              });
              result.sort((a, b) => {
                if (
                  a.nombre.includes("PREFERENCIAL") &&
                  b.nombre.includes("PREFERENCIAL")
                ) {
                  return 0;
                } else if (a.nombre.includes("PREFERENCIAL")) {
                  return -1;
                }
                return 1;
              });

              this.carShops = result;
            } else {
              this.claimCity = 0;
            }

            loader.hide();
            this.searchExecuted = true;
          },
          function() {
            this.carShops = {
              codTaller: 1,
              nit: "1111",
              nombre: "FAKE",
              telefono: "555",
              email: "aseguradora@dacarplus.com",
              direccion: "Cr 20 B 76-79",
              sucursal: "1"
            };
            loader.hide();
          }
        );
      }
    },
    openModal: function(item) {
      this.selected = item;
      if (this.assigned === null || this.assigned === item.codTaller) {
        this.modal = "pop-up-assign";
      } else {
        this.modal = "pop-up-change";
      }
    },
    assign: function(cod) {
      if (cod !== 0) {
        if (this.modal === "pop-up-change") {
          this.modal = "pop-up-assign";
        } else {
          this.assigned = cod;
          this.casualtyData = this.selected;

          if ("codExternal" in this.selected) {
            this.casualtyData.repairCity = this.selected.codExternal;
          } else {
            this.casualtyData.repairCity = this.claimCity;
          }

          this.modal = null;
        }
      } else {
        this.modal = null;
      }
    },
    assignTRD: function() {
      this.casualtyData = this.defaultCS;
      this.casualtyData.repairCity = this.claimCity;
      this.assigned = this.defaultCS.codTaller;
    },
    validateCarShop: function() {
      // Validates whether the clam type requires assignation of carshop.
      if (this.claimType !== "CLAIM_TYPE_PTH" && this.assigned === null) {
        if (this.carShopsLength === 0) {
          this.showError = false;
          this.assignTRD();
          this.nextStep();
        } else {
          this.showError = true;
        }
      } else {
        this.showError = false;
        this.nextStep();
      }
    },
    getData() {
      if (localStorage.getItem("GMFChevrolet-codigoConcesionario")) {
        this.$http.get("/claim-data/cities-carshops/chevrolet").then(
          function(data) {
            this.cities = Object.entries(data.body).sort((a, b) => {
              if (a[1] > b[1]) return 1;
              if (a[1] < b[1]) return -1;
              return 0;
            });
          },
          function(params) {
            this.cities = {
              "63001": "ARMENIA",
              "08001": "BARRANQUILLA",
              "11001": "BOGOTA"
            };
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
          },
          function(params) {
            this.cities = {
              "63001": "ARMENIA",
              "08001": "BARRANQUILLA",
              "11001": "BOGOTA"
            };
          }
        );
      }
    }
  },
  mounted() {
    this.$http.get("/claim-data/cities-carshops").then(
      function(data) {
        this.cities = Object.entries(data.body).sort((a, b) => {
          if (a[1] > b[1]) return 1;
          if (a[1] < b[1]) return -1;
          return 0;
        });
      },
      function(params) {
        this.cities = {
          "63001": "ARMENIA",
          "08001": "BARRANQUILLA",
          "11001": "BOGOTA"
        };
      }
    );
    this.findCarShops();
  },
  watch: {
    claimCity: function(val, oldVal) {
      if (this.claimType !== "CLAIM_TYPE_PTH" && !oldVal && val) {
        this.findCarShops();
      }
    }
  }
};
</script>
