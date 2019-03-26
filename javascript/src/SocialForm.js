'use strict'
import React from 'react'
import PropTypes from 'prop-types'
import {FontAwesomeIcon} from '@fortawesome/react-fontawesome'
import {fas} from '@fortawesome/free-solid-svg-icons'
import {fab} from '@fortawesome/free-brands-svg-icons'
import {far} from '@fortawesome/free-regular-svg-icons'

const SocialForm = ({social, saveUrl, update, clearUrl}) => {
  let url = ''
  if (social.url) {
    url = social.url
  }
  
  return (
    <div>
      <h3><FontAwesomeIcon icon={social.fa} />&nbsp;{social.title}</h3>
      <div className="input-group">
        <div className="input-group-prepend"><span className="input-group-text">{social.prefix}</span></div>
        <input type="text" className="form-control" value={url} onChange={update} placeholder="Type or paste in a web address, phone number, email address, etc."/>
      </div>
      <button className="btn btn-primary mt-3 mr-2" onClick={saveUrl}><i className="fas fa-save"></i>&nbsp;Save social icon</button>
      <button className="btn btn-success mt-3" onClick={clearUrl}><i className="fas fa-eraser"></i>&nbsp;Clear link</button>
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
