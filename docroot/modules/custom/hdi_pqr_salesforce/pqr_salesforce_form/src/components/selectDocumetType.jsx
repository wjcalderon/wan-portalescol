import { SelectField } from './selectField'

const documentTypes = {
  'Carnet Diplomático': 'Carnet Diplomático',
  'NIT': 'NIT',
  'NUIP': 'NUIP',
  'Pasaporte': 'Pasaporte',
  'Registro Civil': 'Registro Civil',
  'Tarjeta de Identidad': 'Tarjeta de Identidad',
  'No Válido': 'No Válido',
  'Cédula de ciudadanía': 'Cédula de ciudadanía',
  'Cédula de Extranjería': 'Cédula de Extranjería',
  'Permiso de proteccion temporal PPT': 'Permiso de proteccion temporal PPT',
}

const SelectDocumentType = () => {
  return (
    <div className="form-item js-form-type-select form-type-select">
      <label htmlFor="PQR_TipoIdentificacion__c">Selecciona tu tipo de documento</label>
      <SelectField
        name="PQR_TipoIdentificacion__c"
        optionList={documentTypes}
        required={true}
      />
    </div>
  )
}

export { SelectDocumentType }
