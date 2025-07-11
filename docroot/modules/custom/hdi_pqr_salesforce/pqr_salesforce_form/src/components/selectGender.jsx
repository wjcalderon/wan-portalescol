import PropTypes from 'prop-types'
import { SelectField } from './selectField'
import { useEffect, useRef, useState } from 'react'

const genderList = {
  'Masculino': 'Masculino',
  'Femenino': 'Femenino',
  'No binario': 'No binario',
  'No aplica': 'No aplica',
}

const SelectGender = ({ type, error, handleChange }) => {
  const selectRef = useRef()
  const [activeClass, setActiveClass] = useState('')

  useEffect(() => {
    if (selectRef?.current?.value !== '') {
      setActiveClass('form__input--activo')
    }
  }, [selectRef])

  return (
    <div className={`form-item js-form-type-select form-type-select ${activeClass}`}>
      {error !== '' && (
        <div className="error-message">
          <span className="error-icon"></span>
          <span>{error}</span>
        </div>
      )}
      <label htmlFor="SSP_Sexo__c" className={`label-${type} ${error ? 'select-error' : ''}`}>Selecciona tu género</label>
      <SelectField
        ref={selectRef}
        name="SSP_Sexo__c"
        className={`form-${type} ${error ? 'select-error' : ''}`}
        optionList={genderList}
        //required={true}
        handleChange={handleChange}
      />
    </div>
  )
}

SelectGender.propTypes = {
  type: PropTypes.oneOf(['select']),
  handleChange: PropTypes.func,
  error: PropTypes.string,
}

export { SelectGender }
