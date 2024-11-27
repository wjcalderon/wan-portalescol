import PropTypes from 'prop-types'
import { SelectField } from './selectField'
import { useEffect, useRef, useState } from 'react'

const conditionList = {
  'Adulto mayor': 'Adulto mayor',
  'Afrocolombiano': 'Afrocolombiano',
  'Desplazado': 'Desplazado',
  'Discapacidad auditiva': 'Discapacidad auditiva',
  'Discapacidad cognitiva': 'Discapacidad cognitiva',
  'Discapacidad física': 'Discapacidad física',
  'Discapacidad visual': 'Discapacidad visual',
  'Indígena': 'Indígena',
  'Madre cabeza de familia': 'Madre cabeza de familia',
  'Menor de edad': 'Menor de edad',
  'Mujer embarazada': 'Mujer embarazada',
  'No aplica': 'No aplica',
  'Otra': 'Otra',
  'Pensionado': 'Pensionado',
  'Periodista': 'Periodista',
  'Receptor de subsidio': 'Receptor de subsidio',
  'Reinsertado': 'Reinsertado',
  'Sordomudo': 'Sordomudo',
  'Víctima del conflicto armado': 'Víctima del conflicto armado',
}

const SelectSpecialCondition = ({ handleChange }) => {
  const selectRef = useRef()
  const [activeClass, setActiveClass] = useState('')

  useEffect(() => {
    if (selectRef?.current?.value !== '') {
      setActiveClass('form__input--activo')
    }
  }, [selectRef])

  return (
    <div className={`form-item js-form-type-select form-type-select ${activeClass}`}>
      <label htmlFor="SSP_CondicionEspecial__c">Condición Especial</label>
      <SelectField
        ref={selectRef}
        name="SSP_CondicionEspecial__c"
        optionList={conditionList}
        required={true}
        handleChange={handleChange}
      />
    </div>
  )
}

SelectSpecialCondition.propTypes = {
  handleChange: PropTypes.func,
}

export { SelectSpecialCondition }
