import { Tooltip } from 'react-tooltip'
import PropTypes from 'prop-types'

const ToolTip = ({id, text}) => {
  return (
    <>
      <span id={id} className='tool-tip'></span>
      <Tooltip
        anchorSelect={`#${id}`}
        content={text}
        style={{ backgroundColor: "#003960E5", color: "#fff", maxWidth: "20rem" }}
      />
    </>
  )
}

ToolTip.propTypes = {
  id: PropTypes.string,
  text: PropTypes.string,
}

export default ToolTip
