/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./form-wizard');
require('./sidebar');

/**
 * Requiring the big ones
 */
window.Vue = require('vue');
window.IBAN = require('iban');
import VueTables from 'vue-tables-2';
import VueFormWizard from 'vue-form-wizard';
import ElementUI from 'element-ui';
import elementLocale from 'element-ui/lib/locale/lang/it';

/**
 * Injecting Vue dependencies
 */
window.Vue.use(VueTables.ClientTable);
Event = VueTables.Event;
window.Vue.use(VueFormWizard);
window.Vue.use(ElementUI, {locale: elementLocale});

/**
 * Requiring Vue VMs
 * FIXME maybe a more elegant way to assign different VMs to each page could be found
 */
require('./vue/vue-home');
require('./vue/vue-entry-user');
require('./vue/vue-view-allusers');
require('./vue/vue-view-user');
require('./vue/vue-entry-bank');
require('./vue/vue-entry-mobility');
require('./vue/vue-approve-users');