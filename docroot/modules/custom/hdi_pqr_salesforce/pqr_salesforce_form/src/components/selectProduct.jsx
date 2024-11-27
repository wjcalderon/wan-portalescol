import PropTypes from 'prop-types'
import { SelectField } from './selectField'

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

const SelectProduct = ({ handleChange }) => {
  return (
    <div className="form-item js-form-type-select form-type-select">
      <label htmlFor="SFPQR_Producto__c">Selecciona tu producto</label>
      <SelectField
        name="SFPQR_Producto__c"
        optionList={productList}
        required={true}
        handleChange={handleChange}
      />
    </div>
  )
}

SelectProduct.propTypes = {
  handleChange: PropTypes.func,
}

export { SelectProduct }
