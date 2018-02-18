module.exports = {

    search: ({commit, state}) => {

        if (state.isSearching == true) {
            commit("setProperty", {property: "information",
                value: 'Дождитесь результатов предыдущего запроса. Если зависло, обновите страницу..'});
            return;
        }

        commit("setProperty", {property: "isSearching", value: true});

        // dateString in "DD.MM.YYYY' format
        // dateString in "DD.MM.YYYY' format
        var convertToTimestamp = function (dateString) {

            let dmY = dateString.split('.');

            // YYYY-MM-DD (eg 1997-07-16)
            let isoDateString = dmY[2] + '-' + dmY[1] + '-' + dmY[0];

            return Math.floor(Date.parse(isoDateString) / 1000);
        };

        commit("setProperty", {property: "information", value: 'Поиск...'});

        axios.post('/api/docs/search', {
            nipigaz_code: state.nipigaz_code,
            tcm_code: state.tcm_code,
            revision: state.revision,
            class: state.class,
            reason: state.reason,
            english_title: state.english_title,
            russian_title: state.russian_title,
            date_beg: (state.date_beg === '') ? '' : convertToTimestamp(state.date_beg),
            date_end: (state.date_end === '') ? '' : convertToTimestamp(state.date_end),
            transmittal: state.transmittal,
            only_last_rev: state.only_last_rev
        })
            .then(function (response) {
                commit('setItems', response.data);
                commit("setProperty", {property: "isSearching", value: false});
                commit("setProperty", {property: "information", value: 'Найдено файлов: ' + response.data.length + 'шт.'});
            })
            .catch(function (error) {
                commit("setProperty", {property: "isSearching", value: false});
                commit("setProperty", {property: "information", value: error});
            });

    },

    zip: ({commit, state}) => {

        if (state.items.length == 0) {
            commit("setProperty", {property: "information", value: 'Список пуст !'});
            return;
        }

        let idList = [];

        state.items.forEach(function (element, index, array) {
            idList.push(element.id);
        });

        commit("setProperty", {property: "information", value: 'Формируем архив...'});

        axios.post('/api/docs/zip', {
            list: JSON.stringify(idList),
            typeOfFiles: state.typeOfFiles,
        })
            .then(function (response) {
                if (response.data !== "") {
                    commit("setProperty", {property: "information", value: 'Архив ' + response.data + ' готов.'});
                    window.location.href = 'storage/zip/' + response.data;
                } else {
                    commit("setProperty", {property: "information", value: 'Не удалось создать архив !!!'});
                }
            })
            .catch(function (error) {
                commit("setProperty", {property: "information", value: error});
            });

    },

    getCountOfJson: ({commit, state}) => {

        axios.post('/api/json_count', {
        })
            .then(function (response) {
                commit("setProperty", {property: "countOfJson", value: response.data});
            })
            .catch(function (error) {
                commit("setProperty", {property: "information", value: error});
            });

    },


};
