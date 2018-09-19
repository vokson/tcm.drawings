<template>
    <div class="header">
        <table class="table">
            <tr>
                <td class="menu-cell">
                    <div class="dropright">

                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Меню
                        </button>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                            <a v-on:click="search" class="dropdown-item" href="#">Искать</a>

                            <div class="form-check">
                                <input type="checkbox" v-model="toggle" true-value="1" false-value="0"
                                       id="last-rev-checkbox">
                                <label for="last-rev-checkbox">Только последние ревизии?</label>
                            </div>

                            <div class="dropdown-divider"></div>

                            <a v-on:click="zip" class="dropdown-item" href="#" value="pdf">
                                Скачать все *.pdf
                            </a>

                            <a v-on:click="zip" class="dropdown-item" href="#"
                               value="native">Скачать все в редактируемом формате
                            </a>

                            <div class="dropdown-divider"></div>

                            <a v-on:click="maxRevUpdate" class="dropdown-item" href="#">
                                <span class="badge badge-pill badge-danger">НЕ ТРОГАТЬ</span>
                                Обновить базу с последними ревизиями
                            </a>

                            <a v-on:click="importJson" class="dropdown-item" href="#">
                                <span class="badge badge-pill badge-danger">НЕ ТРОГАТЬ</span>
                                Импортировать *.json файлы
                                <span class="badge badge-pill badge-warning">{{jsonCount}}</span>
                            </a>

                            <a v-on:click="databaseBackup" class="dropdown-item" href="#">
                                <span class="badge badge-pill badge-danger">НЕ ТРОГАТЬ</span>
                                Резервная копия базы данных
                            </a>

                            <div class="dropdown-divider"></div>

                            <div class="form-check">
                                <input type="checkbox"  v-model="checkedItems" id="column-visibility-1" value="nipigaz_code">
                                <label for="column-visibility-1">No. НИПИГАЗ</label>
                            </div>

                            <div class="form-check">
                                <input type="checkbox"  v-model="checkedItems" id="column-visibility-2" value="tcm_code">
                                <label for="column-visibility-2">No. TCM</label>
                            </div>

                            <div class="form-check">
                                <input type="checkbox"  v-model="checkedItems" id="column-visibility-3" value="issued_at">
                                <label for="column-visibility-3">Date</label>
                            </div>

                            <div class="form-check">
                                <input type="checkbox"  v-model="checkedItems" id="column-visibility-4" value="transmittal">
                                <label for="column-visibility-4">Transmittal</label>
                            </div>

                            <div class="form-check">
                                <input type="checkbox"  v-model="checkedItems" id="column-visibility-5" value="class">
                                <label for="column-visibility-5">Class</label>
                            </div>

                            <div class="form-check">
                                <input type="checkbox"  v-model="checkedItems" id="column-visibility-6" value="revision">
                                <label for="column-visibility-6">Revision</label>
                            </div>

                            <div class="form-check">
                                <input type="checkbox"  v-model="checkedItems" id="column-visibility-7" value="reason">
                                <label for="column-visibility-7">Reason</label>
                            </div>

                            <div class="form-check">
                                <input type="checkbox"  v-model="checkedItems" id="column-visibility-8" value="english_title">
                                <label for="column-visibility-8">English Title</label>
                            </div>

                            <div class="form-check">
                                <input type="checkbox"  v-model="checkedItems" id="column-visibility-9" value="russian_title">
                                <label for="column-visibility-9">Russian Title</label>
                            </div>
                        </div>

                    </div>
                </td>
                <td>

                    <div class="info-label"> {{ info }} </div>
                </td>
            </tr>
        </table>


    </div>

</template>

<script>
    module.exports = {

        beforeCreate: function () {
            this.$store.dispatch('getCookie');
        },

        created: function () {
            this.toggle = this.$store.state.only_last_rev;
        },

        data: function () {
            return {
                toggle: "0",
                checkedItems: [
                    'nipigaz_code',
//                    'tcm_code',
                    'transmittal',
                    'issued_at',
                    'revision',
//                    'class',
//                    'reason',
                    'english_title',
//                    'russian_title'
                ],
            }
        },

        methods: {
            zip: function (event) {
                this.$store.commit("setProperty", {property: "typeOfFiles", value: event.target.getAttribute('value')});
                this.$store.dispatch('zip');
            },

            search: function (event) {
                this.$store.dispatch('search');
            },

            maxRevUpdate: function (event) {
                window.location.href = '/service/max_rev';
            },

            importJson: function (event) {
                window.location.href = '/service/import_json';
            },

            databaseBackup: function (event) {
                window.location.href = '/service/database_backup';
            },

        },

        watch: {
            toggle: function (newValue) {
                this.$store.commit("setProperty", {property: "only_last_rev", value: parseInt(newValue)});
            },

            checkedItems: function (arrayOfCheckedItems) {

                this.$store.commit("setProperty", {property: "itemsToBeShown", value: arrayOfCheckedItems});

            },


        },

        computed: {
            info: function () {
                return this.$store.state.information;
            },

            jsonCount: function () {
                return this.$store.state.countOfJson;
            },
        }


    }
</script>