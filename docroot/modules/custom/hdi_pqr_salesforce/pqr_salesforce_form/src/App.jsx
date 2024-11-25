import { useState } from 'react'
import { InputField } from './components/inputField'
import { RadiosInputs } from './components/radiosInput'
import { SelectCountry } from './components/selectCountry'
import { SelectDocumentType } from './components/selectDocumetType'
import { SelectGender } from './components/selectGender'
import { TermsAndConditions } from './components/termsAndConditions'
import { SelectSpecialCondition } from './components/selectSpecialCondition'
import { SelectProduct } from './components/selectProduct'
import { SelectMotive } from './components/selectMotive'
import { UploadFiles } from './uploadFiles'

const App = () => {
  const [reconsideration, setReconsideration] = useState(false)
  const [termsConditions, setTermsConditions] = useState(false)
  const [specicialCondition, setSpecialCondition] = useState(false)
  const [product, setProduct] = useState(null)

  const handleSubmit = (e) => {
    e.preventDefault()
  }

  return (
    <>
      <h2>Escribe tu queja o reclamo</h2>

      <form onSubmit={(e) => handleSubmit(e)}>
        <SelectCountry />

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
          />
        }

        <InputField
          label="Ingresa tu nombre completo"
          type="text"
          name="SFPQR_NombresApellidosRazonSocial__c"
          required={true}
        />

        <SelectDocumentType />

        <InputField
          label="Ingresa tu número de identificación"
          type="number"
          name="PQR_NumeroDocumentoIdentidad__c"
          required={true}
        />

        <InputField
          label="Ingresa tu correo electrónico"
          type="email"
          name="PQR_CorreoElectronico__c"
          toolTipId="CorreoElectronico"
          toolTipText="Por este canal generamos la respuesta a tu caso"
          required={true}
        />

        <InputField
          label="Ingresa tu dirección"
          type="text"
          name="PQR_Direccion__c"
          required={true}
        />

        <InputField
          label="Ingresa tu celular de contacto"
          type="number"
          name="PQR_CelularContacto__c"
          required={true}
        />

        <SelectGender />

        <TermsAndConditions
          setTermsConditions={setTermsConditions}
        />

        {termsConditions &&
          <>
            <RadiosInputs
              text="¿Perteneces a la comunidad LGBTIQ+?"
              toolTipId="LGBTIQ"
              toolTipText="Lesbiana, Gay, Trasgénero, Intersexual, Queer y todos los colectivos que no están representados en las siglas anteriores"
              fieldName="SSP_LGBTIQ__c"
            />

            <RadiosInputs
              text="¿Tienes alguna condición especial?"
              fieldName="SSP_TieneAlgunaCondicionEspecial__c"
              handleChange={setSpecialCondition}
              toolTipId={false}
            />

            {specicialCondition &&
              <SelectSpecialCondition />
            }
          </>
        }

        <hr />

        <div className="form-item js-form-type-textarea form-type-textarea">
          <label htmlFor="description">Describe tu queja o reclamo</label>
          <div>
            <textarea name="description" rows="5" cols="60" className="form-textarea" autoComplete="off"></textarea>
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
            pattern='/^([A-Z]{3}\d{3}|[A-Z]\d{5}|[A-Z]{3}\d{2}[A-Z]|\d{3}[A-Z]{3})$/i'
          />
        }

        <SelectMotive />

        <UploadFiles />

      </form>
    </>
  )
}

export default App
