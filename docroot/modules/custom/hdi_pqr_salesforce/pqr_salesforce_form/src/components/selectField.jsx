import PropTypes from 'prop-types'
import { useEffect, useRef, useState } from 'react'


const SelectField = ({ optionList, name, error, className,  defaultValue, handleChange }) => {
  const selectRef = useRef()
  const [activeClass, setActiveClass] = useState('')

  useEffect(() => {
    if (selectRef?.current?.value !== '') {
      setActiveClass('form__input--activo')
    }
  }, [selectRef])

  const options = []

  for (const [key, value] of Object.entries(optionList)) {
    options.push({key, value})
  }

  return (
    <select
      ref={selectRef}
      name={name}
      className={className}
      defaultValue={defaultValue}
      onChange={(e) => handleChange(e)}
      error={error}
    >
      <option value="">--</option>
      {options.map((option) => (
        <option key={option.key} value={option.key}>{option.value}</option>
      ))}
    </select>
  )
}

SelectField.propTypes = {
  optionList: PropTypes.object,
  name: PropTypes.string,
  defaultValue: PropTypes.string,
  required: PropTypes.bool,
  handleChange: PropTypes.func,
  error: PropTypes.string,
}

export { SelectField }
