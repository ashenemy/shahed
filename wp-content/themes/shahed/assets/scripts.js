document.addEventListener('DOMContentLoaded', () => {
    const closeCookieBtn  = document.getElementById('onetrust-accept-btn-handler');

    const cookieBlock =  document.getElementById('onetrust-consent-sdk');

    if (closeCookieBtn) {
        closeCookieBtn.addEventListener('click', () => {
            Cookies.set('cbsh', 'true', { expires: 9999 })



            if (cookieBlock) {
                cookieBlock.classList.add("hidden");
            }
        })

    }

    if (cookieBlock) {
        if (!Cookies.get('cbsh')) {
            cookieBlock.classList.remove("hidden");
        }
    }



    const forms = Array.from(document.querySelectorAll('.formzzz'));

    for (const form of forms) {
        form.addEventListener('submit', (event) => {
            event.preventDefault();


            setTimeout(() => {
                const errLabel = form.querySelector('.error-label');

                if (errLabel) {
                    errLabel.classList.remove('opacity-0');
                }
            }, 2000);

        })

        const formButton = form.querySelector('button[type="submit"]');

        if (formButton) {
            formButton.addEventListener('click', (event) => {
                const errLabel = form.querySelector('.error-label');

                if (errLabel) {
                    errLabel.classList.add('opacity-0');
                }
            })
        }
    }


    const facAccordion = document.querySelector('.faqs');

    if (facAccordion) {

        const faqs = Array.from(facAccordion.querySelectorAll('.faq-item'));

        for (const faq of faqs) {
            const faqTitle = faq.querySelector('.faq-title');
            if (faqTitle) {
                faq.addEventListener('click', (event) => {
                    event.preventDefault();

                    faq.classList.toggle('--open');
                })
            }


        }

    }


    const registrationForm = document.getElementById('registration-form');

    if (registrationForm) {
        const formBtn = registrationForm.querySelector('button[type="submit"]');

        const loginInput = document.getElementById('userName');
        const passwordInput = document.getElementById('password');




        if (formBtn && loginInput && passwordInput) {
            registrationForm.addEventListener('input', () => {
                registrationFormCheck(loginInput,passwordInput, formBtn)
            })
        }

        registrationForm.addEventListener('submit', (event) => {
            if (!registerFormIsReady(loginInput, passwordInput)) {
                event.preventDefault();
            }
        })
    }


    const paymentForm = document.getElementById('payment-form');

    if (paymentForm) {
        const formBtn = paymentForm.querySelector('button[type="submit"]');

        const cardNumber = document.getElementById('cardNumber');
        const cvvNumber = document.getElementById('cvvNumber');
        const expDate = document.getElementById('expDate');

        if (formBtn && cardNumber && cvvNumber && expDate) {
            paymentForm.addEventListener('input', () => {
                paymentFormCheck(cardNumber,cvvNumber,expDate, formBtn)
            })


            cvvNumber.addEventListener('input', () => {

                let value = cvvNumber.value.replace(/\D/g, ''); // удаляем все, кроме цифр

                cvvNumber.value= value.slice(0, 3);
            })

            cardNumber.addEventListener('input', () => {

                let value = cardNumber.value.replace(/\D/g, ''); // удаляем все, кроме цифр

                cardNumber.value= value.slice(0, 16);
            })


            expDate.addEventListener('input', () => {

                let value = expDate.value.replace(/\D/g, ''); // удаляем все, кроме цифр

                if (value.length >= 3) {
                    value = value.slice(0, 2) + '/' + value.slice(2);
                }

                expDate.value= value.slice(0, 5);
            })

            expDate.addEventListener('keydown', function (e) {
                if (
                    !(
                        (e.key >= '0' && e.key <= '9') || // цифры
                        e.key === 'Backspace' ||
                        e.key === 'ArrowLeft' ||
                        e.key === 'ArrowRight' ||
                        e.key === 'Tab'
                    )
                ) {
                    e.preventDefault();
                }
            });
        }

        paymentForm.addEventListener('submit', (event) => {
            if (!registerFormIsReady(cardNumber,cvvNumber,expDate)) {
                event.preventDefault();
            }
        })
    }


    function paymentFormCheck(cardNumber, cvvNumber, expDate, formBtn) {
        if (paymentFormIsReady(cardNumber, cvvNumber, expDate)) {
            formBtn.disabled = false;
            formBtn.classList.remove( '!bg-disableButtonLg', '!text-light-blue-2');
        } else {
            formBtn.disabled = true
            formBtn.classList.add( '!bg-disableButtonLg', '!text-light-blue-2');
        }

    }

    function registrationFormCheck(loginInput, passwordInput, formBtn) {
        if (registerFormIsReady(loginInput, passwordInput)) {
            formBtn.disabled = false;
            formBtn.classList.remove( '!bg-disableButtonLg', '!text-light-blue-2');
        } else {
            formBtn.disabled = true
            formBtn.classList.add( '!bg-disableButtonLg', '!text-light-blue-2');
        }

    }

    function registerFormIsReady(loginInput, passwordInput) {
        return loginInput.value !== '' && passwordInput.value !== '';
    }

    function paymentFormIsReady(cardNumber, cvvNumber, expDate) {
        return checkCardNumber(cardNumber.value) && checkCVV(cvvNumber.value)  && expDate.value !== '';
    }

    function checkCVV(cvvNumber) {
        return cvvNumber!=='' && cvvNumber.length === 3;
    }


    function checkCardNumber(cardNumber) {
        return cardNumber!=='' && cardNumber.length === 16;
    }
});