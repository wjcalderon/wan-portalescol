import PropTypes from 'prop-types'
import ToolTip from './toolTip'
import { useState } from 'react'

const InputField = ({
  type,
  required = false,
  name,
  label, toolTipId = '',
  toolTipText = '',
  pattern = '',
}) => {
  const [activeClass, setActiveClass] = useState('')

  const handleChange = (e) => {
    const val = e.target.value

    if (val !== '') {
      setActiveClass('form__input--activo')
    }
  }

  return (
    <div className={`form-item js-form-type-${type} form-type-${type} ${activeClass}`}>
      <label htmlFor={name}>{label}</label>
      <input
        type={type}
        required={required}
        name={name}
        className={`form-${type}`}
        pattern={pattern}
        onChange={(e) => handleChange(e)}
      />
      {toolTipId !== '' &&
        <ToolTip
          id={toolTipId}
          text={toolTipText}
        />
      }
    </div>
  )
}

InputField.propTypes = {
  type: PropTypes.oneOf(['text', 'email', 'number']),
  required: PropTypes.bool,
  name: PropTypes.string,
  label: PropTypes.string,
  toolTipId: PropTypes.string,
  toolTipText: PropTypes.string,
  pattern: PropTypes.string
}

export { InputField }
