import PropTypes from 'prop-types'
import { SelectField } from './selectField'
import { useEffect, useRef, useState } from 'react'

const documentTypes = {
  'Cédula de ciudadanía': 'Cédula de ciudadanía',
  'Cédula de Extranjería': 'Cédula de Extranjería',
  'Pasaporte': 'Pasaporte',
  'Carnet Diplomático': 'Carnet Diplomático',
  'NIT': 'NIT',
  'NUIP': 'NUIP',
  'Registro Civil': 'Registro Civil',
  'Tarjeta de Identidad': 'Tarjeta de Identidad',
  'No Válido': 'No Válido',
  'Permiso de proteccion temporal PPT': 'Permiso de proteccion temporal PPT',
}

const SelectDocumentType =  ({ type, error, handleChange }) => {
  const selectRef = useRef()
  const [activeClass, setActiveClass] = useState('')

  useEffect(() => {
    if (selectRef?.current?.value !== '') {
      setActiveClass('form__input--activo')
    }
  }, [selectRef])

  return (
    <div className={`form-item js-form-type-${type} form-type-${type} ${activeClass}`}>
       {error !== '' && (
        <div className="error-message">
          <span className="error-icon"></span>
          <span>{error}</span>
        </div>
      )}
      <label htmlFor="PQR_TipoIdentificacion__c" className={`label-${type} ${error ? 'select-error' : ''}`}>Selecciona tu tipo de documento</label>
      <SelectField
        ref={selectRef}
        name="PQR_TipoIdentificacion__c"
        className={`form-${type} ${error ? 'select-error' : ''}`}
        defaultValue="Cédula de ciudadanía"
        optionList={documentTypes}
        handleChange={handleChange}
      />
    </div>
  )
}

SelectDocumentType.propTypes = {
  type: PropTypes.oneOf(['select']),
  handleChange: PropTypes.func,
  error: PropTypes.string,
}

export { SelectDocumentType }
