'use strict'
import React from 'react'
import PropTypes from 'prop-types'
import InputField from 'canopy-react-inputfield'
import State from './State'
import BigCheckbox from 'canopy-react-bigcheckbox'

const ContactInfo = ({settings, update, save, errors,}) => {
  return (
    <div>
      <BigCheckbox
        label="Show only on front page"
        checked={settings.front_only}
        handle={() => update('front_only', !settings.front_only)}/>
      <div className="row">
        <div className="col-md-6">
          <h3>On Campus</h3>
          <div className="row">
            <div className="col-sm-7">
              <InputField
                name="building"
                label="Building"
                value={settings.building}
                required={true}
                errorMessage={errors.building === true
                  ? 'Building may not be empty'
                  : null}
                classes="mb-3"
                change={(e) => update('building', e)}/>
            </div>
            <div className="col-sm-5">
              <InputField
                name="room_number"
                label="Room number"
                placeholder="Numbers only"
                value={settings.room_number}
                classes="mb-3"
                change={(e) => update('room_number', e)}/>
            </div>
          </div>
          <div className="row">
            <div className="col-sm-6">
              <InputField
                name="phone_number"
                label="Phone number"
                value={settings.phone_number}
                placeholder="###-###-####"
                errorMessage={errors.phone_number === true
                  ? 'Phone number may not be empty'
                  : null}
                classes="mb-3"
                change={(e) => update('phone_number', e)}/>
            </div>
            <div className="col-sm-6">
              <InputField
                name="fax_number"
                label="Fax number"
                placeholder="###-###-####"
                value={settings.fax_number}
                classes="mb-3"
                change={(e) => update('fax_number', e)}/>
            </div>
          </div>
          <label>Email address</label>&nbsp;<a data-toggle="tooltip" title="You may also use the social icon">
            <i className="text-info fas fa-question-circle"></i>
          </a>
          <InputField
            name="email"
            classes="mb-3"
            value={settings.email}
            change={(e) => update('email', e)}/>
        </div>
        <div className="col-md-6">
          <h3>Mailing address</h3>
          <div className="row">
            <div className="col-sm-4">
              <InputField
                name="post_box"
                label="Post box"
                classes="mb-3"
                value={settings.post_box}
                change={(e) => update('post_box', e)}/>
            </div>
            <div className="col-sm-8">
              <InputField
                name="street"
                label="Street"
                classes="mb-3"
                value={settings.street}
                change={(e) => update('street', e)}/>
            </div>
          </div>
          <div className="row">
            <div className="col-sm-6">
              <InputField
                name="city"
                classes="mb-3"
                label="City"
                value={settings.city}
                change={(e) => update('city', e)}/>
            </div>
            <div className="col-sm-6">
              <div className="mb-3">
                <State change={(e) => update('state', e)} currentState={settings.state}/>
              </div>
            </div>
          </div>
          <div className="row">
            <div className="col-sm-4">
              <InputField
                name="zip"
                label="Zip"
                classes="mb-3"
                value={settings.zip}
                change={(e) => update('zip', e)}/>
            </div>
          </div>
        </div>
      </div>
      <h3>Site contact&nbsp;
        <a
          data-toggle="tooltip"
          title="Name and email of person responsible for your web site">
          <i className="text-info fas fa-question-circle"></i>
        </a>
      </h3>
      <div className="row">
        <div className="col-sm-6">
          <InputField
            name="site_contact_name"
            label="Name"
            errorMessage={errors.site_contact_name !== false
              ? errors.site_contact_name
              : null}
            value={settings.site_contact_name}
            change={(e) => update('site_contact_name', e)}/>
        </div>
        <div className="col-sm-6">
          <InputField
            name="site_contact_email"
            label="Email address"
            value={settings.site_contact_email}
            change={(e) => update('site_contact_email', e)}/>
        </div>
      </div>
      <h3 className="mt-3">Other information</h3>
      <textarea
        id="other-information"
        name="other_information"
        className="form-control"
        defaultValue={settings.other_information}></textarea>
      <button className="mt-3 btn btn-primary" onClick={save}>Save contact info</button>
    </div>
  )
}

ContactInfo.propTypes = {
  settings: PropTypes.object,
  update: PropTypes.func,
  save: PropTypes.func,
  errors: PropTypes.object
}

ContactInfo.defaultProps = {}

export default ContactInfo
