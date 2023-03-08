import axios from 'axios'

const base_path = window.drupalSettings.medicalNetwork.dataBasePath + '/'
const api_path = base_path + 'api/medical-network/'

class Api {
  // Query views and module endpints
  async get(endpoint, data) {
    return axios
      .get(api_path + endpoint + (data != undefined ? data : ''))
      .then(response => {
        return response.data
      })
      .catch(error => {
        console.log(error)
      })
  }

  // Get csrf token to save webform
  async getCsrfToken() {
    return axios
      .get(base_path + 'session/token')
      .then(response => {
        return response.data
      })
      .catch(error => {
        console.log(error)
      })
  }

  // Save webform submition
  async postWebForm(data, csrfToken) {
    return axios
      .post(base_path + 'webform_rest/submit/?_format=json', data, {
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-Token': csrfToken,
        }
      })
      .then(response => {
        return response.data
      })
      .catch(error => {
        console.log(error)
      })
  }
}

export default new Api
