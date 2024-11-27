import { useEffect, useRef } from 'react'
import PropTypes from 'prop-types'
import IconConfirmation from '../assets/icon-confirmation.svg'

const Confirmation = ({caseId, email}) => {
  const dialogRef = useRef()

  useEffect(() => {
    dialogRef.current.showModal()
  }, [])

  return (
    <dialog id="confirmation" ref={dialogRef}>
      <span className="close"
        onClick={() => window.location.reload()}
        id="closeDialogHeader">
      </span>
      <img src={IconConfirmation} alt="¡Gracias por tus comentarios!" />
      <h3>¡Gracias por tus comentarios!</h3>
      <h4>Tu caso quedó bajo el radicado N° <span>{ caseId }</span></h4>
      <p>Te contactaremos dentro de las próximas 24 horas hábiles al email registrado:</p>
      <h4><span>{ email }</span></h4>

      <section className="dialog-footer">
        <h5>Para mayor información puedes consultar nuestros canales de atención:</h5>
        <ul>
          <li className="whatsapp">
            WhatsApp
            <span>+57 316 82 1802</span>
          </li>
          <li className="phone">
            Bogotá
            <span>60 1 307 70 50</span>
          </li>
          <li className="phone">
            Resto del país
            <span>01 8000 113390</span>
          </li>
        </ul>
      </section>

      <button onClick={() => window.location.reload()}>Cerrar</button>
    </dialog>
  )
}

Confirmation.propTypes = {
  caseId: PropTypes.string,
  email: PropTypes.string,
}

export {Confirmation}
