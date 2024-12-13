import PropTypes from 'prop-types'
import ToolTip from './toolTip'
import { useState, forwardRef } from 'react'

const InputField = forwardRef(({
  type,
  required = false,
  name,
  label,
  toolTipId = '',
  toolTipText = '',
  pattern = '',
  setState,
  minLength = 3,
  maxLength = 60,
  error,
}, ref) => {
  const [activeClass, setActiveClass] = useState('')

  const handleChange = (e) => {
    const val = e.target.value
    setState(val)

    if (val !== '') {
      setActiveClass('form__input--activo')
    } else {
      setActiveClass('')  // Si el campo está vacío, se restablece la clase activa.
    }
  }


  return (
    <div className={`form-item js-form-type-${type} form-type-${type} ${activeClass}`}>
      {error !== '' && (
        <div className="error-message">
          <span className="error-icon"></span>
          <span>{error}</span>
        </div>
      )}
      <label htmlFor={name} className={`label-${type} ${error ? 'input-error' : ''}`}>{label}</label>
      {pattern === '' && type !== 'number' &&
        <input
          ref={ref}
          type={type}
          required={required}
          name={name}
          className={`form-${type} ${error ? 'input-error' : ''}`}
          onChange={handleChange}
          minLength={minLength}
          maxLength={maxLength}
          error={error}
        />
      }
      {pattern !== '' && type !== 'number' &&
        <input
          ref={ref}
          type={type}
          required={required}
          name={name}
          className={`form-${type} ${error ? 'input-error' : ''}`}
          onChange={handleChange}
          pattern={pattern}
          minLength={minLength}
          maxLength={maxLength}
          error={error}
        />
      }
      {type === 'number' &&
        <input
          ref={ref}
          type={type}
          required={required}
          name={name}
          className={`form-${type} ${error ? 'input-error' : ''}`}
          onChange={handleChange}
          min={minLength}
          max={maxLength}
          error={error}
        />
      }
      {toolTipId !== '' &&
        <ToolTip
          id={toolTipId}
          text={toolTipText}
        />
      }
    </div>
  )
})

InputField.propTypes = {
  type: PropTypes.oneOf(['text', 'email', 'number']),
  required: PropTypes.bool,
  name: PropTypes.string,
  label: PropTypes.string,
  toolTipId: PropTypes.string,
  toolTipText: PropTypes.string,
  pattern: PropTypes.string,
  setState: PropTypes.func,
  minLength: PropTypes.number,
  maxLength: PropTypes.number,
  error: PropTypes.string,
}

export { InputField }
