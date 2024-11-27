import PropTypes from 'prop-types'
import { SelectField } from './selectField'

const motivesList = {
  'Demora o no emisión de la póliza': 'Demora o no emisión de la póliza',
  'Demora en el servicio requerido para emisión de póliza': 'Demora en el servicio requerido para emisión de póliza',
  'Demora o no entrega de recibo de pago': 'Demora o no entrega de recibo de pago',
  'Error en la facturación o cobro no pactado': 'Error en la facturación o cobro no pactado',
  'Demora o no realización de modificación de financiación de póliza': 'Demora o no realización de modificación de financiación de póliza',
  'Error en modificación de financiación de póliza': 'Error en modificación de financiación de póliza',
  'Demora o no confirmación de pago': 'Demora o no confirmación de pago',
  'Demora o error en devolución de prima o aporte': 'Demora o error en devolución de prima o aporte',
  'Demora o no aplicación del recaudo': 'Demora o no aplicación del recaudo',
  'Error en la aplicación del recaudo': 'Error en la aplicación del recaudo',
  'Cambios no informados en coberturas': 'Cambios no informados en coberturas',
  'Incrementos no pactados o informados de la prima': 'Incrementos no pactados o informados de la prima',
  'Inconformidad por cobros de terceros': 'Inconformidad por cobros de terceros',
  'Cobros a póliza terminada': 'Cobros a póliza terminada',
  'Demora en atención del siniestro': 'Demora en atención del siniestro',
  'No atención del siniestro': 'No atención del siniestro',
  'Fallas en el registro del siniestro': 'Fallas en el registro del siniestro',
  'Asesoría incorrecta o imprecisa en la atención del siniestro': 'Asesoría incorrecta o imprecisa en la atención del siniestro',
  'Demora en la definición de indemnización': 'Demora en la definición de indemnización',
  'Demora en la autorización de servicios': 'Demora en la autorización de servicios',
  'Demora en dictamen de calificación de pérdida de capacidad laboral o enfermedad grave': 'Demora en dictamen de calificación de pérdida de capacidad laboral o enfermedad grave',
  'Inconformidad con la definición, autorización, dictamen o diagnóstico': 'Inconformidad con la definición, autorización, dictamen o diagnóstico',
  'Inconformidad con el valor de indemnización o suma asegurada': 'Inconformidad con el valor de indemnización o suma asegurada',
  'Demora en el pago de la indemnización o suma asegurada': 'Demora en el pago de la indemnización o suma asegurada',
  'Demora en el pago de mesada': 'Demora en el pago de mesada',
  'Error en el pago de la indemnización o suma asegurada': 'Error en el pago de la indemnización o suma asegurada',
  'Error en el pago de la mesada': 'Error en el pago de la mesada',
  'Inconformidad con documentos exigidos para presentar reclamación': 'Inconformidad con documentos exigidos para presentar reclamación',
  'Rescisión del título sin autorización': 'Rescisión del título sin autorización',
  'Error en la nivelación de títulos': 'Error en la nivelación de títulos',
  'Fallas en la asignación de posición para sorteo': 'Fallas en la asignación de posición para sorteo',
  'Demora en la prestación del servicio': 'Demora en la prestación del servicio',
  'No prestación del servicio': 'No prestación del servicio',
  'Inconformidad con el servicio prestado por el proveedor': 'Inconformidad con el servicio prestado por el proveedor',
  'Incumplimiento de obligaciones en prestación del servicio': 'Incumplimiento de obligaciones en prestación del servicio',
  'Mal trato por parte el proveedor': 'Mal trato por parte el proveedor',
  'No cumplimiento con los servicios de valor agregado ofrecidos': 'No cumplimiento con los servicios de valor agregado ofrecidos',
  'Cambio de asesor': 'Cambio de asesor',
  'Demora o no modificación de la póliza': 'Demora o no modificación de la póliza',
  'Error en la modificación de la póliza': 'Error en la modificación de la póliza',
  'Póliza terminada sin justificación': 'Póliza terminada sin justificación',
  'No devolución de contragarantías': 'No devolución de contragarantías',
  'Error en la emisión de la póliza': 'Error en la emisión de la póliza',
  'Envío erroneo de cobro o factura': 'Envío erroneo de cobro o factura',
  'Demora o no cancelación de la póliza': 'Demora o no cancelación de la póliza',
  'Emisión poliza de la seriedad de la candidatura': 'Emisión poliza de la seriedad de la candidatura',
  'Otros motivos': 'Otros motivos',
  'Publicidad engañosa': 'Publicidad engañosa',
  'Dificultad en el acceso a la información': 'Dificultad en el acceso a la información',
  'Información o asesoría incompleta y/o errada': 'Información o asesoría incompleta y/o errada',
  'Información inoportuna': 'Información inoportuna',
  'Dificultad en la comunicación con la entidad': 'Dificultad en la comunicación con la entidad',
  'Mal trato por parte de un funcionario': 'Mal trato por parte de un funcionario',
  'Mal trato por parte del asesor comercial o proveedor': 'Mal trato por parte del asesor comercial o proveedor',
  'Presunta actuación fraudulenta o no ética del personal': 'Presunta actuación fraudulenta o no ética del personal',
  'Incumplimiento de los términos del contrato': 'Incumplimiento de los términos del contrato',
  'Presunta suplantación de personas': 'Presunta suplantación de personas',
  'Cotización errada': 'Cotización errada',
  'Demora o no entrega de la cotización y/o simulación': 'Demora o no entrega de la cotización y/o simulación',
  'Demora o no entrega del contrato o de la póliza': 'Demora o no entrega del contrato o de la póliza',
  'Error o falta de claridad en las cláusulas del contrato o de la póliza': 'Error o falta de claridad en las cláusulas del contrato o de la póliza',
  'Diferencia del producto expedido con el solicitado o cotizado o simulado': 'Diferencia del producto expedido con el solicitado o cotizado o simulado',
  'Vinculación no autorizada': 'Vinculación no autorizada',
  'Condicionamiento a la adquisición de productos o servicios': 'Condicionamiento a la adquisición de productos o servicios',
  'No cancelación o terminación de los productos': 'No cancelación o terminación de los productos',
  'Fallas en débito automático': 'Fallas en débito automático',
  'Demora o no modificación de datos personales': 'Demora o no modificación de datos personales',
  'Actualización equivocada de datos personales': 'Actualización equivocada de datos personales',
  'Inadecuado tratamiento de datos personales': 'Inadecuado tratamiento de datos personales',
  'Inconformidad con procesos internos de conocimiento del cliente y SARLAFT': 'Inconformidad con procesos internos de conocimiento del cliente y SARLAFT',
}

const SelectMotive = ({ handleChange }) => {
  return (
    <div className="form-item js-form-type-select form-type-select">
      <label htmlFor="SSP_MotivoSFC__c">Selecciona el motivo de tu queja o reclamo</label>
      <SelectField
        name="SSP_MotivoSFC__c"
        optionList={motivesList}
        required={true}
        handleChange={handleChange}
      />
    </div>
  )
}

SelectMotive.propTypes = {
  handleChange: PropTypes.func,
}

export { SelectMotive }
