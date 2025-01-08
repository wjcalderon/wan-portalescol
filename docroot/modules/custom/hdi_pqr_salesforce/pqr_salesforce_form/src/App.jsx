import { useState, useRef, useEffect } from 'react'
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
  const [documentType, setDocumentType] = useState('Cédula de ciudadanía')
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
  const [product, setProduct] = useState('')
  const [plate, setPlate] = useState(null)
  const [motive, setMotive] = useState('')
  const [uploadesFiles, setUploadedFiles] = useState([])
  const [disableSubmit, setDisableSubmit] = useState(true)
  const [loading, setLoading] = useState(false)
  const [caseNumber, setCaseNumber] = useState(false)
  const [errors, setErrors] = useState(
    {
      name: '',
      documentNumber: '',
      documentType: '',
      email: '',
      city: '',
      address: '',
      phone: '',
      description: '',
      plate: '',
      product: '',
      gender: '',
      motive: '',
    })
  const nameRef = useRef(null);
  const documentTypeRef = useRef(null);
  const documentNumberRef = useRef(null);
  const emailRef = useRef(null);
  const cityRef = useRef(null);
  const addressRef = useRef(null);
  const phoneRef = useRef(null);
  const descriptionRef = useRef(null);
  const productRef = useRef(null);
  const genderRef = useRef(null);
  const motiveRef = useRef(null);

  window.onbeforeunload = null

  useEffect(() => {
    if (caseNumber) return

    const onBeforeUnload = (e) => {
      e.preventDefault()
    }

    if (reconsideration || name !== '' || documentNumber !== '') {
      setDisableSubmit(false)
      window.addEventListener("beforeunload", onBeforeUnload)
    } else {
      setDisableSubmit(false)
    }

    return () => window.removeEventListener("beforeunload", onBeforeUnload)
  }, [reconsideration, name, documentNumber, caseNumber])

  const handleSubmit = (e) => {
    e.preventDefault()

    let newErrors = {};

    if (!name) newErrors.name = 'El nombre es obligatorio';
    if (!documentNumber) newErrors.documentNumber = 'El número de documento es obligatorio';
    if (!email) newErrors.email = 'El correo electrónico es obligatorio';
    if (city === '') newErrors.city = 'La ciudad es obligatoria';
    if (!address) newErrors.address = 'La dirección es obligatoria';
    if (!phone) newErrors.phone = 'El teléfono es obligatorio';
    if (!description) newErrors.description = 'La descripción es obligatoria';
    if (gender === '') newErrors.gender = 'Selecciona un genero';
    if (product === '') newErrors.product = 'Selecciona un producto';
    if (motive === '') newErrors.motive = 'Selecciona un motivo';

    setErrors(newErrors);

    // Si hay errores, desplazarse al primer campo con error
    if (Object.keys(newErrors).length > 0) {
      const firstErrorField = Object.keys(newErrors)[0];

      // Mover el scroll hasta el campo correspondiente con error
      if (firstErrorField === 'name' && nameRef.current) {
        nameRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' });
      } else if (firstErrorField === 'documentType' && documentTypeRef.current) {
        documentTypeRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' });
      } else if (firstErrorField === 'documentNumber' && documentNumberRef.current) {
        documentNumberRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' });
      } else if (firstErrorField === 'email' && emailRef.current) {
        emailRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' });
      } else if (firstErrorField === 'city' && cityRef.current) {
        cityRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' });
      } else if (firstErrorField === 'address' && addressRef.current) {
        addressRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' });
      } else if (firstErrorField === 'phone' && phoneRef.current) {
        phoneRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' });
      } else if (firstErrorField === 'description' && descriptionRef.current) {
        descriptionRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' });
      } else if (firstErrorField === 'product' && productRef.current) {
        productRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' });
      } else if (firstErrorField === 'gender' && genderRef.current) {
        genderRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' });
      } else if (firstErrorField === 'motive' && motiveRef.current) {
        motiveRef.current.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
      return;
    }

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

    if (product === 'AUTOS' || product === 'SOAT') {
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
            type="text"
            name="SFPQR_NumeroCasoWeb__c"
            class="inputText"
            setState={setReconsiderationNumber}
            pattern='^\d{4,11}$'
            minLength={4}
            maxLength={11}
          />
        }


        <InputField
          ref={nameRef}
          label="Ingresa tu nombre completo"
          type="text"
          name="SFPQR_NombresApellidosRazonSocial__c"
          class="inputText"
          setState={setName}
          minLength={5}
          maxLength={40}
          error={errors.name}
        />

        <SelectDocumentType
          ref={documentTypeRef}
          type="select"
          handleChange={setDocumentType}
          defaultValue="Cédula de ciudadanía"
          error={errors.documentType}
        />

        <InputField
          ref={documentNumberRef}
          label="Ingresa tu número de identificación"
          type="text"
          name="PQR_NumeroDocumentoIdentidad__c"
          class="inputText"
          setState={setDocumentNumber}
          minLength={4}
          maxLength={11}
          error={errors.documentNumber}
        />

        <InputField
          ref={emailRef}
          label="Ingresa tu correo electrónico"
          type="email"
          name="PQR_CorreoElectronico__c"
          toolTipId="CorreoElectronico"
          toolTipText="Por este canal generamos la respuesta a tu caso"
          setState={setEmail}
          error={errors.email}
          />

        <SelectCity
          ref={cityRef}
          type="select"
          handleChange={setCity}
          setState={setCity}
          error={errors.city}
        />

        <InputField
          ref={addressRef}
          label="Ingresa tu dirección"
          type="text"
          name="PQR_Direccion__c"
          setState={setAddress}
          minLength={5}
          error={errors.address}
        />

        <InputField
          ref={phoneRef}
          label="Ingresa tu celular de contacto"
          type="text"
          name="PQR_CelularContacto__c"
          setState={setPhone}
          pattern='\d{10}'
          error={errors.phone}
        />

        <SelectGender
          handleChange={setGender}
          ref={genderRef}
          type="select"
          setState={setGender}
          error={errors.gender}
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
              ref={descriptionRef}
              name="description"
              rows="5"
              cols="60"
              className="form-textarea"
              autoComplete="off"
              onChange={(e) => setDescription(e.target.value)}
            >
            </textarea>
          </div>
        </div>

        <SelectProduct
          handleChange={setProduct}
          ref={productRef}
          type="select"
          setState={setProduct}
          error={errors.product}
        />

        {(product === 'AUTOS' || product === 'SOAT') &&
          <InputField
            label="Ingresa tu placa"
            type="text"
            name="Placa__c"
            pattern='[A-Za-z]{3}\d{3}|[A-Za-z]\d{5}|[A-Za-z]{3}\d{2}[A-Za-z]|\d{3}[A-Z]a-z{3}'
            setState={setPlate}
          />
        }

        <SelectMotive
          handleChange={setMotive}
          ref={motiveRef}
          type="select"
          setState={setMotive}
          error={errors.motive}
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
