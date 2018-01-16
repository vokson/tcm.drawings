var Vue = require('vue');
var Vuex = require('vuex');

Vue.use(Vuex)

var actions = require('./actions');
var getters = require('./getters');
var mutations = require('./mutations');

module.exports = new Vuex.Store({
    state: {
        nipigaz_code: '',
        tcm_code: '',
        class: '',
        reason: '',
        revision: '',
        english_title: '',
        russian_title: '',
        date_beg: '',
        date_end: '',
        transmittal: '',

        only_last_rev: 1,
        sortedByItem: "nipigaz_code",
        typeOfFiles: 'pdf',
        information: '',
        countOfJson: 0,
        isSearching: false,

        items: [],

        itemsToBeShown: [
            'nipigaz_code',
            'tcm_code',
            'transmittal',
            'issued_at',
            'revision',
            'class',
            'reason',
            'english_title',
            'russian_title'
        ],


    },
    actions,
    getters,
    mutations
})
;

