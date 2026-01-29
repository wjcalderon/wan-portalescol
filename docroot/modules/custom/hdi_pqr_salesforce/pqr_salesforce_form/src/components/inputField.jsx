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

    setActiveClass(val !== '' ? 'form__input--activo' : '')
  }

  return (
    <div className={`form-item js-form-type-${type} form-type-${type} ${activeClass}`}>
      {error !== '' && (
        <div className="error-message" id={`${name}-error`} role="alert">
          <span className="error-icon"></span>
          <span>{error}</span>
        </div>
      )}

      <label htmlFor={name} className={`label-${type} ${error ? 'input-error' : ''}`}>
        {label}
      </label>

      {pattern === '' && type !== 'number' &&
        <input
          ref={ref}
          id={name}
          type={type}
          required={required}
          name={name}
          className={`form-${type} ${error ? 'input-error' : ''}`}
          onChange={handleChange}
          minLength={minLength}
          maxLength={maxLength}
          aria-invalid={error}
          aria-describedby={error ? `${name}-error` : undefined}
        />
      }
      {pattern !== '' && type !== 'number' &&
        <input
          ref={ref}
          id={name}
          type={type}
          required={required}
          name={name}
          className={`form-${type} ${error ? 'input-error' : ''}`}
          onChange={handleChange}
          pattern={pattern}
          minLength={minLength}
          maxLength={maxLength}
          aria-invalid={error}
          aria-describedby={error ? `${name}-error` : undefined}
        />
      }
      {type === 'number' &&
        <input
          ref={ref}
          id={name}
          type={type}
          required={required}
          name={name}
          className={`form-${type} ${error ? 'input-error' : ''}`}
          onChange={handleChange}
          min={minLength}
          max={maxLength}
          aria-invalid={error}
          aria-describedby={error ? `${name}-error` : undefined}
        />
      }

      {toolTipId !== '' && (
        <ToolTip id={toolTipId} text={toolTipText} />
      )}
    </div>
  )
})

InputField.displayName = 'InputField'

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
