setTimeout(() => {
    new Promise(res => {
        const script = document.createElement('script')
        script.src = `https://www.google.com/recaptcha/api.js?render=${captcha["SITE_KEY"]}`
        script.async = true
        res(document.body.insertAdjacentElement('beforeEnd', script))
    }).then(() => {
        setTimeout(() => {
            grecaptcha.ready(function() {
                grecaptcha.execute(`${captcha["SITE_KEY"]}`, {action: 'homepage'})
                    .then(function(token) {
                        document.querySelector('input[name="recaptcha_token"]').value = token
                    })
            })
        }, 250)
    })
}, 2000)