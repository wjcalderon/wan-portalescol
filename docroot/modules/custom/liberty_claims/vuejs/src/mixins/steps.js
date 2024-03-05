import { validator } from "../validator";
import FloatLabel from "vue-float-label/components/FloatLabel";
import Alert from "../components/commons/alert";

export default {
  props: ["value", "step"],
  components: {
    FloatLabel,
    Alert
  },
  methods: {
    nextStep: function() {
      this.submited = true;
      if (this.isFormOk()) {
        document.getElementById("steps").scrollIntoView(true);
        this.$emit("nextStep", this.step + 1);
        this.$emit("input", this.casualtyData);
      } else {
        // Scroll the page to the first input with errors.
        let inputsWithErrors = document.getElementsByClassName("field error");
        if (inputsWithErrors.length > 0) {
          const first = inputsWithErrors[0];

          let observer = new MutationObserver(function() {
            if (first.style.display != "none") {
              first.scrollIntoView({ behavior: "smooth" });
            }
          });
          observer.observe(first, { attributes: true, childList: true });
          first.scrollIntoView({ behavior: "smooth" });
        }
      }
    },
    isFormOk: function() {
      return (
        !this.validationRules ||
        !validator.validateForm(this.casualtyData, this.validationRules)
      );
    },
    prevStep: function() {
      if (
        this.step === 4 &&
        typeof this.claimType !== "undefined" &&
        this.claimType === "CLAIM_TYPE_PTH"
      ) {
        this.$emit("prevStep", 2);
      } else {
        this.$emit("prevStep", this.step - 1);
      }
    },
    hasError: function(field) {
      return validator.validateField(
        this.casualtyData[field],
        this.validationRules[field]
      );
    },
    fileAdded: function(file) {
      const pdfLimit =
        parseFloat(this.drupalSettings.documentSize) * 1000 * 1000;
      const imageLimit =
        parseFloat(this.drupalSettings.imageSize) * 1000 * 1000;
      const pdfLimitMB = Math.round(pdfLimit / 1000 / 1000);
      const imageLimitKB = Math.round(imageLimit / 1000);

      if (file.type === "image/jpeg") {
        if (file.size > imageLimit) {
          this.$refs.dropzoneEl.removeFile(file);

          const kbSize = Math.round(file.size / 1000);
          this.modalTitle = "IMAGEN NO VÁLIDA";
          this.modalBody = `El peso de la imagen ${kbSize} KB sobrepasa el limite ${imageLimitKB} KB`;
          this.modal = true;
        }
      } else if (file.type === "application/pdf") {
        if (file.size > pdfLimit) {
          const mbSize = Math.round(file.size / 1000 / 1000);
          this.$refs.dropzoneEl.removeFile(file);

          this.modalTitle = "PDF NO VÁLIDO";
          this.modalBody = `El peso del PDF ${mbSize} MB sobrepasa el limite ${pdfLimitMB} MB`;
          this.modal = true;
        }
      } else {
        this.$refs.dropzoneTS.removeFile(file);
        this.modalTitle = "FORMATO DE ARCHIVO NO VÁLIDO";
        this.modalBody = `Solo se permiten archivos PDF e imágenes JPG`;
        this.modal = true;
      }
    },
    fileUploaded: function(file, response) {
      file.fileId = response.file_id;
      file.dataURL = "";
      this.casualtyData.files.push(file);

      if (this.errorMsg) {
        let msg = "Has cargado " + this.casualtyData.files.length;
        const total = this.validationRules.files.length.min;
        this.errorMsg = msg + " de " + total + " documentos obligatorios.";
      }
    },
    fileRemoved: function(file, error, xhr) {
      this.$http
        .post(
          "/claim/files/" + this.userData.documentId + "/delete",
          {
            fileName: file.name,
            fileId: file.fileId
          },
          {
            headers: {
              token: this.drupalSettings.token,
              "Content-Type": "application/json"
            }
          }
        )
        .then(
          function(data) {
            let tempFiles = this.casualtyData.files.filter(
              (obj, index, list) => {
                return obj.fileId != file.fileId;
              }
            );

            this.casualtyData.files = tempFiles;
          },
          function(params) {}
        );
    }
  },
  data() {
    return {
      submited: false,
      drupalSettings: {},
      documentTypes: {
        "¿Cuál es tu tipo de documento?": 0,
        "Cédula de ciudadanía": 36,
        "Cédula de Extranjería": 33,
        "Carnet Diplomático": 44,
        "Número de Identificación Tributaria": 37,
        Pasaporte: 40,
        "Registro Civil": 35,
        "Tarjeta de Identidad": 34
      }
    };
  },
  created() {
    this.drupalSettings =
      window.drupalSettings && window.drupalSettings.claimSettings
        ? window.drupalSettings.claimSettings
        : {};
  }
};
