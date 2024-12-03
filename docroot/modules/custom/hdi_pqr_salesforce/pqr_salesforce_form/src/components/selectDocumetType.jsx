import PropTypes from 'prop-types'
import { SelectField } from './selectField'

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

const SelectDocumentType = ({ handleChange }) => {
  return (
    <div className="form-item js-form-type-select form-type-select form__input--activo">
      <label htmlFor="PQR_TipoIdentificacion__c">Selecciona tu tipo de documento</label>
      <SelectField
        name="PQR_TipoIdentificacion__c"
        defaultValue="Cédula de ciudadanía"
        optionList={documentTypes}
        required={true}
        handleChange={handleChange}
      />
    </div>
  )
}

SelectDocumentType.propTypes = {
  handleChange: PropTypes.func,
}

export { SelectDocumentType }
