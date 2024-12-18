import PropTypes from 'prop-types'
import { SelectField } from './selectField'
import { useEffect, useRef, useState } from 'react'

const productList = {
  'ARL': 'ARL',
  'AUTOS': 'AUTOS',
  'FIANZAS': 'FIANZAS',
  'GENERALES': 'GENERALES',
  'SALUD': 'SALUD',
  'SOAT': 'SOAT',
  'VIDA GRUPO': 'VIDA GRUPO',
  'VIDA R.M.': 'VIDA R.M.',
}

const SelectProduct = ({ type, error, handleChange }) => {
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
      <label htmlFor="SFPQR_Producto__c" className={`label-${type} ${error ? 'select-error' : ''}`}>Selecciona tu producto</label>
      <SelectField
        ref={selectRef}
        name="SFPQR_Producto__c"
        optionList={productList}
        className={`form-${type} ${error ? 'select-error' : ''}`}
        handleChange={handleChange}
      />
    </div>
  )
}

SelectProduct.propTypes = {
  type: PropTypes.oneOf(['select']),
  error: PropTypes.string,
  handleChange: PropTypes.func,
}

export { SelectProduct }
