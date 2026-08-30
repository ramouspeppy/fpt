import "./bootstrap";

// put your lib here =========================

// Star
// import"bootstrap-star-rating/js/star-rating";
// import"bootstrap-star-rating/themes/krajee-fas/theme";

// // Dropzone
// window.Dropzone = import"../lib/dropzone/dropzone.min";
// then you need to disabled the autoDiscover behaviour here:

// Datatables
import DataTable from "datatables.net";

window.DataTable = DataTable;

import "datatables.net-select-bs4";
import "../lib/datatables-checkboxes/dataTables.checkboxes";

// sweetalert2
// import Swal from "sweetalert2";
// window.swal = Swal;

// import Chocolat from "chocolat";
// window.chocolat = Chocolat;

// selectric
// import'../lib/selectric/jquery.selectric';

// // jasny bootstrap
// import"../lib/jasny-bootstrap/js/jasny-bootstrap";

// // // select2
// import "select2";

// end lib

// app js
import "./backendApp/nicescroll";
import "./backendApp/stisla";
import "./backendApp/scripts";

// REFACTOR====================

// codemirror
// import $ from "jquery";
// import { myCodeMirror } from "./helpers/my-codemirror";
// window.$.myCodeMirror = myCodeMirror;

// tinymce
// import { myTinyMce, myTinyMceLite } from "./helpers/my-tinymce";
// window.$.myTinyMce = myTinyMce;
// window.$.myTinyMceLite = myTinyMceLite;

// import {
//     initDateTimePicker
// } from './helpers/my-datetimepicker';
// window.initDateTimePicker = initDateTimePicker;

// import { initSelect2 } from "./helpers/my-select2";
// import {
//     initSelectric
// } from './helpers/my-selectric';

// import {
//     autoInitSelects
// } from './helpers/auto-init';

// $(document).ready(() => {
//     autoInitSelects();
// });

import { autoInit } from "./helpers/auto-init";

document.addEventListener("DOMContentLoaded", () => {
    autoInit();
});

// my js
import "./backend";
