import { SelectField } from './selectField'

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

const SelectSpecialCondition = () => {
  return (
    <div className="form-item js-form-type-select form-type-select">
      <label htmlFor="SSP_CondicionEspecial__c">Condición Especial</label>
      <SelectField
        name="SSP_CondicionEspecial__c"
        optionList={conditionList}
        required={true}
      />
    </div>
  )
}

export { SelectSpecialCondition }
