'use strict'
/* global $, captchaKey, grecaptcha, siteTitle */

const emailForm = () => {
  let timeOut
  
  $('.contact-offsite-email').click(()=>{
    $('#email-contact-modal').modal('hide')
  })
  
  const resetForm = () => {
    $('#email-contact-form').show()
    $('#contact-name').val('')
    $('#contact-email').val('')
    $('#contact-subject').val('')
    $('#contact-message').val('')
    $('#contact-form-error').hide()
    $('#contact-form-success').hide()
    $('#send-message').show()
    grecaptcha.reset()
    clearTimeout(timeOut)
  }
  
  const delayedClose = () => {
    timeOut = setTimeout(() => {
      $('#email-contact-modal').modal('hide')
      resetForm()
    }, 5000)
  }
  
  let emailAddress

  $('a[href^="mailto"]').click((e) => {
    e.preventDefault()
    const emailUri = e.currentTarget.href.replace(/^mailto:/, '')
    const otherInfo = emailUri.split('?')
    emailAddress = emailUri
    //let subject = 'Website contact: ' + siteTitle
    let subject = ''
    if (otherInfo[1] !== undefined) {
      emailAddress = otherInfo[0]
      const otherInfoStack = otherInfo[1].split('&')
      $.each(otherInfoStack, (index, value) => {
        const uriValue = value.split('=')
        if (uriValue[0] == 'subject') {
          subject = uriValue[1]
        }
      })
    }
    const offsiteSubject = `From ${siteTitle} website${subject.length > 0 ? ':' + subject : ''}`
    const googleEmail = `https://mail.google.com/mail/?view=cm&fs=1&to=${emailAddress}&su=${offsiteSubject}`
    const outlookEmail = `https://outlook.live.com/owa/#subject=${offsiteSubject}&to=${emailAddress}&path=%2fmail%2faction%2fcompose`
    const yahooEmail = `http://compose.mail.yahoo.com/?to=${emailAddress}&subj=${offsiteSubject}`

    $('#contact-to-address').text(emailAddress)
    $('#email-contact-modal').modal('show')
    $('#google-email-link').attr('href', googleEmail)
    $('#outlook-email-link').attr('href', outlookEmail)
    $('#yahoo-email-link').attr('href', yahooEmail)
    $('#local-email-link').attr('href', `mailto:${emailUri}`)
    $('#contact-subject').val(decodeURI(subject))
  })
  
  $('#send-message').click(() => {
    $('#send-message').hide()
    $('#contact-sending').show()
    const name = $('#contact-name').val()
    const email = $('#contact-email').val()
    const subject = $('#contact-subject').val()
    const message = $('#contact-message').val()
    
    if (name.length == 0 || email.length == 0 || subject.length == 0 || message.length == 0) {
      $('#send-message').show()
      $('#contact-sending').hide()
      $('#contact-form-error').show().text('Please complete all fields below.')
      return
    }

    $.ajax({
      url: './contact/',
      data: {
        name,
        email,
        subject,
        message,
        'toAddress': emailAddress,
        captchaKey
      },
      dataType: 'json',
      type: 'post',
      success: (data) => {
        if (data.success) {
          $('#contact-form-error').hide()
          $('#contact-form-success').show()
          $('#email-contact-form').hide()
          delayedClose()
        } else {
          $('#contact-form-error').show().text(data.message)
        }
      },
      error: () => {
        $('#contact-form-success').hide()
        $('#email-contact-form').hide()
        $('#contact-form-error').show().html('Sorry, an unrecoverable error occurred.')
        delayedClose()
      },
      complete: () => {
        $('#contact-sending').hide()
      }
    })
  })
  
  $('#email-contact-modal').on('hidden.bs.modal', () => {
    resetForm()
  })
}
emailForm()
