"use strict"
export default function localeRedirect() {
    let lang = localStorage.getItem('lang');

    if(!lang) {
        if(navigator.languages.some((item) => item === 'uk' || item === 'uk-UA' || item === 'ru' || item === 'ru-RU')) {
            lang = 'uk';
        } else {
            lang = 'en';
        }
        localStorage.setItem('lang', lang);
    }
    
    document.location.replace(`/pulse/${lang}`);
}