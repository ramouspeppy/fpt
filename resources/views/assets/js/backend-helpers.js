import {
    initDatetimePicker
} from './helpers/my-datetimepicker';
// tinymce
import {
    myTinyMce,
    myTinyMceLite
} from './helpers/my-tinymce';
window.$.myTinyMce = myTinyMce;
window.$.myTinyMceLite = myTinyMceLite;


export {
    initDatetimePicker,
    myTinyMce,
    myTinyMceLite
};
