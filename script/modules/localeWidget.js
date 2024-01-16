"use strict"

export function setLocale() {
    const lang = document.documentElement.getAttribute('lang');
    if(localStorage.getItem('lang') !== lang) {
        localStorage.setItem('lang', lang);
    }
}

export class LangWidget {
    constructor(languages) {
        if(Object.keys(languages)) {
            this.languages = languages;
        } else {
            try {
                throw new Error('languages is not object or not defined');
            } catch (error) {
                console.Error(error);
            }
        }
        this.element = document.createElement('div');
        this.element.classList.add('locale_widget');
        let ulListLocales = document.createElement('ul');
        ulListLocales.classList.add('locale_widget__languages');
        for(let i = 0; i < Object.keys(this.languages).length; i++) {
            let language = document.createElement('li');
            language.setAttribute('lang', Object.keys(this.languages)[i])
            language.classList.add('locale_widget__locale');
            let link = document.createElement('a');
            link.setAttribute('href', `/pulse/${Object.keys(this.languages)[i]}`);
            link.textContent = Object.values(this.languages)[i];
            language.append(link);
            ulListLocales.append(language);
        }
        this.element.append(ulListLocales);
        this.closeBtn = document.createElement('button');
        this.closeBtn.classList.add('locale_widget__close');
        this.closeBtn.textContent = '✖';
        this.closeBtn.addEventListener('click', ()=>{
            this.element.remove();
        });
        this.element.append(this.closeBtn);

        document.body.append(this.element);
    }
}