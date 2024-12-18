import PropTypes from 'prop-types'
import { useRef } from 'react'


const SelectField = ({ optionList, name, className,  defaultValue, handleChange }) => {
  const selectRef = useRef()
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
      onChange={(e) => handleChange(e.target.value)}
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
  className: PropTypes.string,
}

export { SelectField }
