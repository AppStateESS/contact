'use strict'
import React, {Component} from 'react'
import PropTypes from 'prop-types'
import SocialForm from './SocialForm'


class SocialIcons extends Component {
  constructor(props) {
    super(props)
    this.state = {
      currentTab: 'email'
    }
  }

  changeTab(e, tab) {
    e.preventDefault()
    this.props.clearMessage()
    this.setState({currentTab: tab})
  }

  render() {
    const {social, update} = this.props
    const icons = []

    for (let key in social) {
      let item = social[key]
      let cn = key === this.state.currentTab
        ? 'nav-link active'
        : 'nav-link'
      icons.push(
        <a href="#" className={cn} key={key} onClick={(e) => this.changeTab(e, key)}>
          <i className={item.icon}></i>&nbsp;{item.title}</a>
      )
    }
    return (
      <div className="row">
        <div className="col-sm-3">
          <div
            className="nav nav-pills flex-column"
            role="tablist"
            aria-orientation="vertical">{icons}</div>
        </div>
        <div className="col-sm-9">
          <SocialForm
            clearUrl={() => update('', this.state.currentTab)}
            saveUrl={() => this.props.saveSocial(this.state.currentTab)}
            social={this.props.social[this.state.currentTab]}
            update={(e) => update(e, this.state.currentTab)}/>
        </div>
      </div>
    )
  }
}

SocialIcons.propTypes = {
  social: PropTypes.object,
  update: PropTypes.func,
  saveSocial: PropTypes.func,
  clearMessage: PropTypes.func
}

SocialIcons.defaultProps = {}

export default SocialIcons
