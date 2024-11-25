import PropTypes from 'prop-types'

const SelectField = ({ optionList, name, defaultValue, required = false, handleChange }) => {
  const options = []

  for (const [key, value] of Object.entries(optionList)) {
    options.push({key, value})
  }

  return (
    <select
      name={name}
      className="form-select"
      defaultValue={defaultValue}
      required={required}
      onChange={handleChange}
    >
      <option value="">--</option>
      {options.map((option) => (
        <option key={option.key} value={option.key}>{option.value}</option>
      ))}
    </select>
  )
}

SelectField.propTypes = {
  optionList: PropTypes.array,
  name: PropTypes.string,
  defaultValue: PropTypes.string,
  required: PropTypes.bool,
  handleChange: PropTypes.func,
}

export { SelectField }
