import PropTypes from 'prop-types'
import { SelectField } from './selectField'

const genderList = {
  'Masculino': 'Masculino',
  'Femenino': 'Femenino',
  'No aplica': 'Prefiero no decir',
  'No binario': 'No binario',
}

const SelectGender = ({ handleChange }) => {
  return (
    <div className="form-item js-form-type-select form-type-select">
      <label htmlFor="SSP_Sexo__c">Selecciona tu género</label>
      <SelectField
        name="SSP_Sexo__c"
        optionList={genderList}
        required={true}
        handleChange={handleChange}
      />
    </div>
  )
}

SelectGender.propTypes = {
  handleChange: PropTypes.func,
}

export { SelectGender }
