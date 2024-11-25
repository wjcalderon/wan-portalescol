import PropTypes from 'prop-types'
import ToolTip from "./toolTip"

const RadiosInputs = ({text, toolTipId, toolTipText = '', fieldName = '', handleChange}) => {
  return (
    <div className="form-item js-form-type-radios form-type-radios">
      <p>
        {text}
        {toolTipId && toolTipId !== '' &&
          <ToolTip
            id={toolTipId}
            text={toolTipText}
          />
        }
      </p>
      <div className='radios'>
        <input
          type="radio"
          id="Si"
          value="SI"
          name={fieldName}
          onChange={() => handleChange(true)}
        />
        <label htmlFor="Si">Sí</label>
        <input
          type="radio"
          id="No"
          value="NO"
          name={fieldName}
          onChange={() => handleChange(false)}
        />
        <label htmlFor="No">No</label>
      </div>
    </div>
  )
}

RadiosInputs.propTypes = {
  text: PropTypes.string,
  toolTipId: PropTypes.oneOfType([
    PropTypes.string,
    PropTypes.bool,
  ]),
  toolTipText: PropTypes.string,
  fieldName: PropTypes.string,
  handleChange: PropTypes.func,
}

export { RadiosInputs }
