require('./bootstrap');

import Vue from 'vue';
import store from './store/index.js';

//Глобальная регистрация компонентов, видны внутри любого компонента

// Vue.component('search-button', require('./components/SearchButton.vue'));
// Vue.component('pdf-zip-button', require('./components/PdfZipButton.vue'));
// Vue.component('native-zip-button', require('./components/NativeZipButton.vue'));
Vue.component('doc-list', require('./components/DocList.vue'));
Vue.component('drop-down-menu', require('./components/DropDownMenu.vue'));
// Vue.component('revision-checkbox', require('./components/RevisionCheckBox.vue'));

Vue.component('nipigaz-code-input', require('./components/NipigazCodeInput.vue'));
Vue.component('tcm-code-input', require('./components/TcmCodeInput.vue'));
Vue.component('transmittal-input', require('./components/TransmittalInput.vue'));
Vue.component('reason-input', require('./components/ReasonInput.vue'));
Vue.component('class-input', require('./components/ClassInput.vue'));
Vue.component('russian-title-input', require('./components/RussianTitleInput.vue'));
Vue.component('english-title-input', require('./components/EnglishTitleInput.vue'));
Vue.component('revision-input', require('./components/RevisionInput.vue'));
Vue.component('date-beg-input', require('./components/DateBegInput.vue'));
Vue.component('date-end-input', require('./components/DateEndInput.vue'));


const app = new Vue({
    el: '#app',
    store,
    // Локальная регистрация компонентов. Видны только внутри app
    components: {},
    created() {
        this.$store.dispatch('getCountOfJson')
    },
    template: `
    <div>
        <div class="container-fluid">
            <drop-down-menu></drop-down-menu>
        </div>
        <div class="container-fluid">
            <doc-list></doc-list>
        </div>
    </div>
  `
});