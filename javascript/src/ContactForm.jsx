'use strict'
import React, {Component} from 'react'
import PropTypes from 'prop-types'
import Navs from '@essappstate/canopy-react-navs'
import ContactInfo from './ContactInfo'
import Map from './Map'
import SocialIcons from './SocialIcons'
import Hours from './Hours'
import EmailSettings from './EmailSettings'

/* global $, CKEDITOR */

export default class ContactForm extends Component {
  constructor(props) {
    super(props)
    this.state = {
      settings: Object.assign({}, props.settings),
      active: 'contact',
      errors: {
        building: false,
        phone_number: false
      },
      message: null,
      messageType: 'success'
    }
    this.tabs = [
      {
        label: 'Contact Information',
        name: 'contact'
      }, {
        label: 'Mapping',
        name: 'map'
      }, {
        label: 'Social icons',
        name: 'social'
      }, {
        label: 'Email',
        name: 'email'
      }
    ]
  }

  componentDidMount() {
    if (this.state.active === 'contact') {
      $('[data-toggle="tooltip"]').tooltip()
      CKEDITOR.replace('other-information')
    }
  }

  componentDidUpdate(prevProps, prevState) {
    if (this.state.active === 'contact' && prevState.active !== 'contact') {
      CKEDITOR.replace('other-information')
    }
  }

  checkSettings() {
    let saveAllowed = true
    const errors = this.state.errors
    const {site_contact_email, site_contact_name} = this.state.settings

    if ((site_contact_email !== null && site_contact_email.length > 0) && (site_contact_name === null || site_contact_name.length === 0)) {
      saveAllowed = false
      errors.site_contact_name = 'Site contact name needed with email address'
    } else {
      errors.site_contact_name = false
    }

    this.setState({errors})
    return saveAllowed
  }

  getForm() {
    switch (this.state.active) {
      case 'contact':
        return (
          <ContactInfo
            {...this.state}
            update={(param, value) => this.update(param, value)}
            save={() => this.saveContactInfo()}
            errors={this.state.errors}/>
        )

      case 'map':
        return (
          <Map
            {...this.state}
            update={(param, value) => this.update(param, value)}
            saveAccessToken={() => this.saveAccessToken()}
            errors={this.state.errors}/>
        )

      case 'hours':
        return <Hours {...this.state}/>

      case 'social':
        return <SocialIcons
          clearMessage={() => this.setState({message: ''})}
          clearUrl={(e, icon) => this.updateSocial(e, icon)}
          saveSocial={(label) => this.saveSocial(label)}
          social={this.state.settings.social}
          update={(e, icon) => this.updateSocial(e, icon)}/>

      case 'email':
        return <EmailSettings
          settings={this.state.settings}
          update={(value) => this.toggleLinkAddress(value)}/>
    }
  }

  saveAccessToken() {
    $.ajax({
      url: './contact/admin/map/saveAccessToken',
      data: {
        accessToken: this.state.settings.accessToken
      },
      dataType: 'json',
      type: 'post',
      success: () => {},
      error: () => {}
    })
  }

  saveContactInfo() {
    if (this.checkSettings()) {
      const otherInformation = CKEDITOR.instances['other-information'].getData()
      const data = this.state.settings
      data.other_information = otherInformation
      $.ajax({
        url: './contact/admin/contactinfo',
        data: data,
        dataType: 'json',
        type: 'post',
        success: () => {
          this.setState({message: 'Settings saved', messageType: 'success'})
          window.scrollTo(0, 0)
        },
        error: () => {
          this.setState({message: 'Error: Could not save', messageType: 'danger'})
        }
      })
    } else {
      window.scrollTo(0, 0)
      this.setState(
        {message: 'Error: make sure required information is filled out', messageType: 'danger'}
      )
    }
  }

  saveSocial(label) {
    const url = this.state.settings.social[label].url
    $.ajax({
      url: 'contact/admin/social',
      data: {
        label,
        url
      },
      dataType: 'json',
      type: 'post',
      success: () => {
        this.setState({message: 'Social icon saved'})
      }
    })
  }

  setActive(tab) {
    this.setState({active: tab})
  }

  toggleLinkAddress(value) {
    this.update(
      'linkSupport',
      value
        ? '1'
        : '0'
    )
    $.ajax({
      url: 'contact/admin/email',
      data: {
        value
      },
      dataType: 'json',
      type: 'post',
      success: () => {},
      error: () => {}
    })
  }

  update(param, e) {
    const {settings} = this.state
    let value
    if (param === 'pitch') {
      e = settings.pitch === '60'
        ? '0'
        : '60'
    }
    if (e === null) {
      value = null
    } else if (typeof e === 'object') {
      value = e.target.value
    } else {
      value = e
    }

    settings[param] = value
    this.setState({settings})
  }

  updateSocial(e, icon) {
    let value
    if (e === null) {
      value = null
    } else if (typeof e === 'string') {
      value = e
    } else {
      value = e.target.value
    }
    const settings = this.state.settings
    const social = settings.social
    social[icon].url = value
    this.setState({settings})
  }

  render() {
    let message
    if (this.state.message) {
      const _class = `alert alert-${this.state.messageType}`
      message = <div className={_class}>{this.state.message}</div>
    }
    return (
      <div>
        <Navs
          tabs={this.tabs}
          defaultActive={this.state.active}
          handleClick={(active) => this.setActive(active)}/> {message}
        {this.getForm()}
      </div>
    )
  }
}

ContactForm.propTypes = {
  settings: PropTypes.object
}

ContactForm.defaultProps = {}
