import { useState } from 'react'
import axios from 'axios'
import ReCAPTCHA from 'react-google-recaptcha'
import { InputField } from './components/inputField'
import { RadiosInputs } from './components/radiosInput'
import { SelectCountry } from './components/selectCountry'
import { SelectDocumentType } from './components/selectDocumetType'
import { SelectGender } from './components/selectGender'
import { TermsAndConditions } from './components/termsAndConditions'
import { SelectSpecialCondition } from './components/selectSpecialCondition'
import { SelectProduct } from './components/selectProduct'
import { SelectMotive } from './components/selectMotive'
import { UploadFiles } from './components/uploadFiles'
import { SelectCity } from './components/selectCity'
import { Loader } from './components/loader'
import { Confirmation } from './components/confirmation'

const App = () => {
  const [country, setCountry] = useState('Colombia')
  const [reconsideration, setReconsideration] = useState(false)
  const [reconsiderationNumber, setReconsiderationNumber] = useState(0)
  const [name, setName] = useState('')
  const [documentType, setDocumentType] = useState('')
  const [documentNumber, setDocumentNumber] = useState('')
  const [email, setEmail] = useState('')
  const [city, setCity] = useState('')
  const [address, setAddress] = useState('')
  const [phone, setPhone] = useState('')
  const [gender, setGender] = useState('')
  const [termsConditions, setTermsConditions] = useState(false)
  const [lgbti, setLgbti] = useState(false)
  const [specicialCondition, setSpecialCondition] = useState(false)
  const [specialConditionOption, setSpecialConditionOption] = useState(false)
  const [description, setDescription] = useState(false)
  const [product, setProduct] = useState(null)
  const [plate, setPlate] = useState(null)
  const [motive, setMotive] = useState(null)
  const [uploadesFiles, setUploadedFiles] = useState([])
  const [disableSubmit, setDisableSubmit] = useState(window.drupalSettings.pqrSalesforce.showRecaptcha)
  const [loading, setLoading] = useState(false)
  const [caseNumber, setCaseNumber] = useState(false)

  const handleSubmit = (e) => {
    e.preventDefault()

    let formData = {
      'SSP_PaisEvento__c': country,
      'PQR_CasoReconsideracion__c': reconsideration,
      'SFPQR_NombresApellidosRazonSocial__c': name,
      'PQR_TipoIdentificacion__c': documentType,
      'PQR_NumeroDocumentoIdentidad__c': documentNumber,
      'PQR_CorreoElectronico__c': email,
      'PQR_DescripcionCiudad__c': city,
      'PQR_Direccion__c': address,
      'PQR_CelularContacto__c': phone,
      'SSP_Sexo__c': gender,
      'SSP_AutorizacionTratamientoDatoSensibles__c': termsConditions,
      'description': description,
      'SFPQR_Producto__c': product,
      'SSP_MotivoSFC__c': motive,
      'files': uploadesFiles,
    }

    if (reconsideration) {
      formData = {
        ...formData,
        'SFPQR_NumeroCasoWeb__c': reconsiderationNumber,
      }
    }

    if (termsConditions) {
      formData = {
        ...formData,
        'SSP_LGBTIQ__c': lgbti,
        'SSP_TieneAlgunaCondicionEspecial__c': specicialCondition,
      }
    }

    if (specicialCondition) {
      formData = {
        ...formData,
        'SSP_CondicionEspecial__c': specialConditionOption,
      }
    }

    if (product === 'AUTOS') {
      formData = {
        ...formData,
        'Placa__c': plate,
      }
    }

    setLoading(true)

    axios.post('/api/pqr-salesforce', formData, {
      headers: {
        'Content-Type': 'application/json',
        'Token': window.drupalSettings.pqrSalesforce.token,
      }
    })
      .then(response => {
        setCaseNumber(response.data.caseNumber)
        setLoading(false)
      })
  }

  const onChangeRecaptcha = () => {
    setDisableSubmit(false)
  }

  return (
    <>
      <h2>Escribe tu queja o reclamo</h2>

      <form onSubmit={(e) => handleSubmit(e)}>
        <SelectCountry
          handleChange={setCountry}
        />

        <RadiosInputs
          text="¿Este caso es una reconsideración?"
          toolTipId="CasoReconsideracion"
          toolTipText="Reconsideración: es la inconformidad con una respuesta emitida por la compañía con anterioridad"
          fieldName="PQR_CasoReconsideracion__c"
          handleChange={setReconsideration}
        />

        {reconsideration &&
          <InputField
            label="Ingresa el número de tu caso"
            type="number"
            name="SFPQR_NumeroCasoWeb__c"
            setState={setReconsiderationNumber}
          />
        }

        <InputField
          label="Ingresa tu nombre completo"
          type="text"
          name="SFPQR_NombresApellidosRazonSocial__c"
          required={true}
          setState={setName}
        />

        <SelectDocumentType
          handleChange={setDocumentType}
        />

        <InputField
          label="Ingresa tu número de identificación"
          type="number"
          name="PQR_NumeroDocumentoIdentidad__c"
          required={true}
          setState={setDocumentNumber}
        />

        <InputField
          label="Ingresa tu correo electrónico"
          type="email"
          name="PQR_CorreoElectronico__c"
          toolTipId="CorreoElectronico"
          toolTipText="Por este canal generamos la respuesta a tu caso"
          required={true}
          setState={setEmail}
        />

        <SelectCity
          handleChange={setCity}
        />

        <InputField
          label="Ingresa tu dirección"
          type="text"
          name="PQR_Direccion__c"
          required={true}
          setState={setAddress}
        />

        <InputField
          label="Ingresa tu celular de contacto"
          type="number"
          name="PQR_CelularContacto__c"
          required={true}
          setState={setPhone}
        />

        <SelectGender
          handleChange={setGender}
        />

        <TermsAndConditions
          setTermsConditions={setTermsConditions}
        />

        {termsConditions &&
          <>
            <RadiosInputs
              text="¿Perteneces a la comunidad LGBTIQ+?"
              toolTipId="LGBTIQ"
              toolTipText="Lesbiana, Gay, Trasgénero, Intersexual, Queer y todos los colectivos que no están representados en las siglas anteriores"
              handleChange={setLgbti}
              fieldName="SSP_LGBTIQ__c"
            />

            <RadiosInputs
              text="¿Tienes alguna condición especial?"
              fieldName="SSP_TieneAlgunaCondicionEspecial__c"
              handleChange={setSpecialCondition}
              toolTipId={false}
            />

            {specicialCondition &&
              <SelectSpecialCondition
                handleChange={setSpecialConditionOption}
              />
            }
          </>
        }

        <hr />

        <div className="form-item js-form-type-textarea form-type-textarea">
          <label htmlFor="description">Describe tu queja o reclamo</label>
          <div>
            <textarea
              name="description"
              rows="5"
              cols="60"
              className="form-textarea"
              autoComplete="off"
              required={true}
              onChange={(e) => setDescription(e.target.value)}
            >
            </textarea>
          </div>
        </div>

        <SelectProduct
          handleChange={setProduct}
        />

        {product === 'AUTOS' &&
          <InputField
            label="Ingresa tu placa"
            type="text"
            name="Placa__c"
            required={true}
            pattern='[A-Za-z]{3}\d{3}|[A-Za-z]\d{5}|[A-Za-z]{3}\d{2}[A-Za-z]|\d{3}[A-Z]a-z{3}'
            setState={setPlate}
          />
        }

        <SelectMotive
          handleChange={setMotive}
        />

        <UploadFiles
          handleChange={setUploadedFiles}
        />

        {window.drupalSettings.pqrSalesforce.showRecaptcha &&
          <div className="recaptcha">
            <ReCAPTCHA
              sitekey={window.drupalSettings.pqrSalesforce.recaptchaKey}
              onChange={onChangeRecaptcha}
            />
          </div>
        }

        <div className="form-item form-actions">
          <input
            className="btn-next button--primary button form-submit"
            type="submit"
            name="submit"
            value="Enviar"
            disabled={disableSubmit}
          />
        </div>

      </form>

      {loading &&
        <Loader />
      }

      {caseNumber &&
        <Confirmation
          caseId={caseNumber}
          email={email}
        />
      }
    </>
  )
}

export default App
