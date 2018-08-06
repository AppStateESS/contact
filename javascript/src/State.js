'use strict'
import React from 'react'
import PropTypes from 'prop-types'
import {states} from './stateList'

const State = ({change, currentState}) => {
  
  const stateOptions = states.map((val, key)=>{
    return <option key={key} value={val.value}>{val.label}</option>
  })
  
  return (<div>
    <label>State</label>&nbsp;<a data-toggle="tooltip" title="Not shown if city absent"><i className="text-info fas fa-question-circle"></i></a><br/>
    <select name="state" onChange={change} className="form-control" value={currentState}>
      {stateOptions}
    </select>
  </div>)
}

State.propTypes = {
  change: PropTypes.func,
  currentState: PropTypes.string,
}

State.defaultProps = {}

export default State
