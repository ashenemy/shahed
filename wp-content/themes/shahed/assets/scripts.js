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

});