'use strict'
import React, {Component} from 'react'
import PropTypes from 'prop-types'
import InputField from '@essappstate/canopy-react-inputfield'
import BigCheckbox from '@essappstate/canopy-react-bigcheckbox'
import {states} from './stateList'

/* global $ */

class Map extends Component {
  constructor(props) {
    super(props)

    this.state = {
      thumbAllowed: false,
      fullAddress: null,
      accessToken: null,
      latitude: 0,
      longitude: 0,
    }
  }

  componentDidMount() {
    const {street, city, state, zip,} = this.props.settings
    const thumbAllowed = (street.length > 0 && city.length > 0 && state.length > 0)
    const fullAddress = `${street}, ${city}, ${state}, ${zip}`
    const {latitude, longitude,} = this.props.settings

    this.setState({
      thumbAllowed,
      fullAddress,
      accessToken: this.props.settings.accessToken,
      latitude,
      longitude,
    })
  }

  accessTokenForm() {
    const {settings} = this.props
    const style = {
      overflowX: 'scroll'
    }
    if (settings.accessToken) {
      return (
        <div>
          <dl>
            <dt>Access token:</dt>
            <dd style={style}>{settings.accessToken}</dd>
          </dl>
          <button className="btn btn-outline-dark" onClick={() => this.clearToken()}>Edit token</button>
        </div>
      )
    } else {
      return (
        <div>
          <InputField
            name="accessToken"
            label="Access token"
            value={this.state.accessToken}
            change={(e) => this.setState({'accessToken': e.target.value})}/>
          <p>Maps require a&nbsp;
            <a href="https://www.mapbox.com/account/access-tokens" target="_blank">MapBox Access Token</a>. Create an account and paste the access code above.
          </p>
          <button className="btn btn-primary" onClick={() => this.saveAccessToken()}>Save access token</button>
        </div>
      )
    }
  }

  clearToken() {
    this.setState({accessToken: ''})
    this.props.update('accessToken', '')
  }

  dropThumbnail() {
    $.getJSON('./contact/admin/map/clearThumbnail').done(function () {
      this.props.update('thumbnail_map', '')
    }.bind(this))
  }

  getFullStateName(stateAbbr) {
    // 50 states
    for (let i = 0; i < 50; i++) {
      if (states[i].value === stateAbbr) {
        return states[i].label
      }
    }
    return 'State not found'
  }

  getGeo() {
    const address = this.state.fullAddress.replace(/\s/g, '+').replace(/,/g, '%2C')
    const full = `https://nominatim.openstreetmap.org/search.php?format=json&q=${address}&email=${this.props.settings.site_contact_email}`
    return $.getJSON(full)
  }

  saveThumbnail() {

    $.getJSON('./contact/admin/map/saveThumbnail', {
      latitude: this.state.latitude,
      longitude: this.state.longitude,
      dimensions: this.props.settings.dimensions,
      pitch: this.props.settings.pitch,
      zoom: this.props.settings.zoom,
    }).done(function (data) {
      const imageUrl = data.image
      this.props.update('thumbnail_map', imageUrl)
    }.bind(this))
  }

  getThumbnail() {
    const promise = this.getGeo()
    promise.done((data) => {
      const latitude = data[0].lat
      const longitude = data[0].lon
      this.setState({
        latitude,
        longitude
      }, () => this.saveThumbnail())
    })
  }
  
  saveAccessToken() {
    this.props.update('accessToken', this.state.accessToken)
    this.props.saveAccessToken()
  }

  useLatLong() {
    this.saveThumbnail()
  }

  thumbnailForm() {
    if (!this.props.settings.accessToken) {
      return null
    }
    let thumbnail
    let getThumbnailButton = <button className="btn btn-primary mr-2" onClick={() => this.getThumbnail()}>Create thumbnail from address</button>

    let clearThumbnailButton
    if (this.props.settings.thumbnail_map) {
      thumbnail = <img src={this.props.settings.thumbnail_map}/>
      getThumbnailButton = <button className="btn btn-info mr-2" onClick={() => this.getThumbnail()}>Refresh GPS</button>
      clearThumbnailButton = <button className="btn btn-danger" onClick={() => this.dropThumbnail()}>Remove thumbnail</button>
    }

    return (
      <div>
        <div className="row mb-2">
          <div className="col-sm-6">
            <h3>Thumbnail settings</h3>
            <BigCheckbox
              label="Pitch thumbnail"
              checked={this.props.settings.pitch === '60'}
              handle={() => this.props.update('pitch', '60')}/>
            <div className="mt-4">
              <div className="row">
                <div className="col-sm-6">
                  <h4>Dimensions</h4>
                  <div>
                    <label>
                      <input
                        type="radio"
                        name="dimensions"
                        value="300x200"
                        checked={this.props.settings.dimensions === '300x200'}
                        onChange={() => this.props.update('dimensions', '300x200')}/>
                      <span>300x200</span>
                    </label>
                  </div>
                  <div>
                    <label>
                      <input
                        type="radio"
                        name="dimensions"
                        value="300x300"
                        checked={this.props.settings.dimensions === '300x300'}
                        onChange={() => this.props.update('dimensions', '300x300')}/>
                      <span>300x300</span>
                    </label>
                  </div>
                </div>
                <div className="col-sm-6">
                  <h4>Zoom level</h4>
                  <select
                    className="form-control"
                    value={this.props.settings.zoom}
                    onChange={(e) => this.props.update('zoom', e)}>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                  </select>
                </div>
              </div>
            </div>
            <div className="row">
              <div className="col-6">
                <label>Latitude</label><br/>
                <input
                  type="text"
                  className="form-control"
                  name="latitude"
                  value={this.state.latitude}
                  onChange={(e) => {
                    this.setState({latitude: e.target.value})
                  }}/>
              </div>
              <div className="col-6">
                <label>Longitude</label><br/>
                <input
                  type="text"
                  className="form-control"
                  name="longitude"
                  value={this.state.longitude}
                  onChange={(e) => {
                    this.setState({longitude: e.target.value})
                  }}/>
              </div>
            </div>
            <div className="mt-4">
              {getThumbnailButton}
              <button className="btn btn-warning" onClick={() => this.useLatLong()}>Create thumbnail from lat/long</button>
            </div>
          </div>
          <div className="col-sm-6">
            <div className="mb-2"><a href={`https://www.openstreetmap.org/#map=16/${this.state.latitude}/${this.state.longitude}`} target="_blank">{thumbnail}</a></div>
            {clearThumbnailButton}
          </div>
        </div>
      </div>
    )
  }

  render() {
    let warning
    if (this.state.thumbAllowed === false) {
      warning = (
        <div className="alert alert-danger">You cannot use the map with an incomplete address.</div>
      )
    }

    return (
      <div>
        <h2>Map</h2>
        {warning}
        <h3>Current address - {this.state.fullAddress}</h3>
        <hr/> {this.accessTokenForm()}
        <hr/> {this.thumbnailForm()}
      </div>
    )
  }
}
Map.propTypes = {
  settings: PropTypes.object,
  update: PropTypes.func,
  saveAccessToken: PropTypes.func,
  errors: PropTypes.object,
}

Map.defaultProps = {}

export default Map
