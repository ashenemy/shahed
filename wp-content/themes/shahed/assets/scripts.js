document.addEventListener('DOMContentLoaded', () => {
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
});