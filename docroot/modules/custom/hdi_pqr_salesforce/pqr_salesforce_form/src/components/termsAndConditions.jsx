import { useRef, useState } from 'react'
import PropTypes from 'prop-types'

const TermsAndConditions = ({setTermsConditions}) => {
  const dialogRef = useRef()
  const [inputDisabled, setInputDisabled] = useState(true)
  const [inputChecked, setInputChecked] = useState(false)

  const handleAccept = () => {
    setInputChecked(true)
    setInputDisabled(false)
    setTermsConditions(true)
    dialogRef.current.close()
  }

  const handleChange = () => {
    setInputChecked(false)
    setInputDisabled(true)
    setTermsConditions(false)
  }

  return (
    <>
      <div className="form-item js-form-type-checkbox form-type-checkbox">
        <input
          id="SSP_AutorizacionTratamientoDatoSensibles__c"
          className="terms_checkbox form-checkbox"
          type="checkbox"
          name="SSP_AutorizacionTratamientoDatoSensibles__c"
          value="1"
          disabled={inputDisabled}
          checked={inputChecked}
          onClick={() => handleChange()}
        />
        <label
          htmlFor="SSP_AutorizacionTratamientoDatoSensibles__c"
          className="option"
          onClick={() => {dialogRef.current.showModal()}}
        >
          Acepta el <span>Tratamiento y uso de datos sensibles</span> para brindarte un mejor servicio.
        </label>
      </div>

      <dialog id="dialog" ref={dialogRef}>
        <span className="close"
          onClick={() => dialogRef.current.close()}
          id="closeDialogHeader">
        </span>
        <h3>Tratamiento y uso de datos sensibles</h3>
        <p>Autorizo a <strong>HDI Seguros Colombia S.A y HDI Compañía de Servicios e Inversiones S.A.S. (Las Compañías)</strong> el uso de mi información personal y sensible para efectos relacionados con la atención de mi reclamación. Declaro que he sido informado de la existencia de las Políticas de Tratamiento de datos personales, las cuales se encuentran publicadas en <strong>www.hdiseguros.com.co</strong> y también pueden ser solicitadas a <strong>atención.cliente@libertycolombia.com</strong> o al teléfono <strong>57 1 307 7050</strong> de Bogotá.</p>

        <button onClick={() => handleAccept()}>Aceptar</button>
      </dialog>
    </>
  )
}

TermsAndConditions.propTypes = {
  setTermsConditions: PropTypes.func,
}

export { TermsAndConditions }
