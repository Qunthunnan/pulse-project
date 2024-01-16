import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import {setLocale, LangWidget} from './modules/localeWidget';
import {modal} from './modules/modal';
import {phoneMask} from './modules/phone-mask';
import {scroll} from './modules/scroll';
import {catalogSlider} from './modules/slider';
import {tabs} from './modules/tabsCards';
import {cards} from './modules/toggleSlide';
import {validator} from './modules/validator';

setLocale();
const localeWidget = new LangWidget({
    uk: "Українська",
    en: "English"
});
catalogSlider();
tabs();
cards();
modal();
validator();
phoneMask();
scroll();