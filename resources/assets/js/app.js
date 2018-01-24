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
import VueTables from 'vue-tables-2';
import VueFormWizard from 'vue-form-wizard';
import ElementUI from 'element-ui';
import elementLocale from 'element-ui/lib/locale/lang/it';

/**
 * Importing custom components
 */
import UserSummary from './components/UserSummary';
import MobilityTracker from './components/MobilityTracker';
import AttachmentManager from './components/AttachmentManager';
import CountryForm from './components/CountryForm';
import UniversityBranchForm from './components/UniversityBranchForm';
import MobilityForm from './components/MobilityForm';
import BankAccountForm from './components/BankAccountForm';
import QueryMobilities from './components/QueryMobilities';

/**
 * Requiring minor plugins
 */
window.IBAN = require('iban');

/**
 * Injecting Vue dependencies
 */
window.Vue.use(VueTables.ClientTable);
Event = VueTables.Event;
window.Vue.use(VueFormWizard);
window.Vue.use(ElementUI, {locale: elementLocale});
window.Vue.use(require('vue-moment'));

window.Vue.component('user-summary', UserSummary);
window.Vue.component('mobility-tracker', MobilityTracker);
window.Vue.component('attachment-manager', AttachmentManager);
window.Vue.component('country-form', CountryForm);
window.Vue.component('university-branch-form', UniversityBranchForm);
window.Vue.component('mobility-form', MobilityForm);
window.Vue.component('bank-account-form', BankAccountForm);
window.Vue.component('query-mobilities', QueryMobilities);

/**
 * Requiring Vue VMs
 * FIXME maybe a more elegant way to assign different VMs to each page could be found
 */
require('./vue/vue-home');
require('./vue/vue-entry-user');
require('./vue/vue-view-allusers');
require('./vue/vue-view-user');
require('./vue/vue-approve-users');
require('./vue/vue-view-universities');
require('./vue/vue-query');