import { useEffect, useRef } from 'react'
import IconAlert from '../assets/icon-alert.svg'

const AlertMessage = () => {
  const dialogRef = useRef()

  useEffect(() => {
    dialogRef.current.showModal()
  }, [])

  return (
    <dialog id="confirmation" ref={dialogRef}>
      <span className="close"
        onClick={() => dialogRef.current.showModal()}
        id="closeDialogHeader">
      </span>
      <img src={IconAlert} alt="Estás a punto de salir del formulario" />
      <h3>Estás a punto de salir del formulario</h3>
      <p>La información dilienciada se borrará y no será posible recuperarla</p>

      <button
        className="button button-secondary"
        onClick={() => window.location.reload()}
      >
        Salir del formulario
      </button>
      <button
        className="button button--primary"
        onClick={() => dialogRef.current.showModal()}
      >
        Seguir diligenciando
      </button>
    </dialog>
  )
}

export default AlertMessage
