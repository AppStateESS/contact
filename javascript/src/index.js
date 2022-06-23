'use strict'
import React from 'react'
import {createRoot} from 'react-dom/client'
import ContactForm from './ContactForm.jsx'

const container = document.getElementById('contact-form')
const root = createRoot(container)
root.render(<ContactForm settings={settings} />)
