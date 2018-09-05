'use strict'
import React, {Component} from 'react'
import PropTypes from 'prop-types'
import BigCheckbox from 'canopy-react-bigcheckbox'

export default class EmailSettings extends Component {
  constructor(props) {
    super(props)
    this.state = {}
  }

  render() {
    const {settings, update,} = this.props
    console.log(settings.linkSupport)
    return (
      <div>
        <h2>Email Link Support</h2>
        <BigCheckbox
          label="Add email link support"
          checked={settings.linkSupport}
          handle={(e) => update(e)}/>
        <p>Email link support changes email links to a pop-up with contact options.</p>
      </div>
    )
  }
}

EmailSettings.propTypes = {
  settings: PropTypes.object,
  update: PropTypes.func
}

EmailSettings.defaultProps = {}
