import Vue from 'vue'

export const validator = new Vue({
  methods: {
    validateField: function (field, rules) {
      for (const rule in rules) {
        switch (rule) {
          case 'required':
            if (!field || (Array.isArray(field) && field.length === 0)) {
              return rules[rule].hasOwnProperty('msg') ? rules[rule].msg : 'Este campo es requerido.';
            }
            break;
          case 'diff':
            if (field == rules[rule].val) {
              return rules[rule].hasOwnProperty('msg') ? rules[rule].msg : 'Seleccione una opción.';
            }
            break;
          case 'match':
            if (!field.match(rules[rule].regExp)) {
              return rules[rule].hasOwnProperty('msg') ? rules[rule].msg : 'El formato del campo es incorrecto.';
            }
            break;
          case 'length':
            if (rules[rule].hasOwnProperty('equal')) {
              if (!(field.length === rules[rule].equal)) {
                return rules[rule].hasOwnProperty('msg') ? rules[rule].msg : 'El campo debe tener ' + rules[rule].equal + ' caractéres.';
              }
            }
            if (rules[rule].hasOwnProperty('min')) {
              if (field.length < rules[rule].min) {
                return rules[rule].hasOwnProperty('msg') ? rules[rule].msg : 'El campo debe tener mínimo ' + rules[rule].min + ' caractéres.';
              }
            }
            if (rules[rule].hasOwnProperty('max')) {
              if (field.length > rules[rule].max) {
                return rules[rule].hasOwnProperty('msg') ? rules[rule].msg : 'El campo debe tener máximo ' + rules[rule].max + ' caractéres.';
              }
            }
            break;
          default:
              break;
        }
      }
      return false;
    },
    validateForm: function (fields, rules) {
      for (const field in fields) {

        if (this.validateField(fields[field], rules[field])) {
          return true;
        }
      }
    }
  }
})