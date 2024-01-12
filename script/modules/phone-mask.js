import 'jquery';
import 'jquery.maskedinput/src/jquery.maskedinput';

export const phoneMask = function () {
    $("input[name=telephone]").mask("+380 (99)-999-99-99");
}