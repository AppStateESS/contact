'use strict'
import React from 'react'
import PropTypes from 'prop-types'

const SocialForm = ({social, saveUrl, update}) => {
  let url = ''
  if (social.url) {
    url = social.url
  }
  
  return (
    <div>
      <h3><i className={social.icon}></i>&nbsp;{social.title}</h3>
      <div className="input-group">
        <div className="input-group-prepend"><span className="input-group-text">{social.prefix}</span></div>
        <input type="text" className="form-control" value={url} onChange={update}/>
      </div>
      <button className="btn btn-primary" onClick={saveUrl}>Save social icon</button>
    </div>
  )
}

SocialForm.propTypes = {
  social: PropTypes.object,
  saveUrl: PropTypes.func,
  update: PropTypes.func,
}

SocialForm.defaultProps = {}

export default SocialForm
