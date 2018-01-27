<template>
    <div>

        <table class="table table-striped table-bordered">
            <thead>

            <tr>
                <th v-if="showIssuedAt" v-on:click="setOrderBy" value="issued_at" scope="col" class="issued-at-column">
                    Date
                </th>
                <th v-if="showTransmittal" v-on:click="setOrderBy" value="transmittal" scope="col"
                    class="transmittal-column">
                    Transmittal
                </th>
                <th v-if="showNipigazCode" v-on:click="setOrderBy" value="nipigaz_code" scope="col"
                    class="nipigaz-code-column">
                    NIPIGAZ
                </th>
                <th v-if="showRevision" v-on:click="setOrderBy" value="revision" scope="col" class="revision-column">
                    Rev
                </th>
                <th v-if="showTcmCode" v-on:click="setOrderBy" value="tcm_code" scope="col" class="tcm-code-column">
                    TCM
                </th>
                <th v-if="showClass" v-on:click="setOrderBy" value="class" scope="col" class="class-column">
                    Class
                </th>
                <th v-if="showReason" v-on:click="setOrderBy" value="reason" scope="col" class="reason-column">
                    Reason
                </th>
                <th v-if="showEnglishTitle" v-on:click="setOrderBy" value="english_title" scope="col"
                    class="english-title-column">
                    English Title
                </th>
                <th v-if="showRussianTitle" v-on:click="setOrderBy" value="russian_title" scope="col"
                    class="russian-title-column">
                    Russian Title
                </th>
            </tr>

            </thead>
            <tbody>

            <tr v-on:keyup.13="search">
                <td v-if="showIssuedAt" class="issued-at-column input-cell">
                    <date-beg-input></date-beg-input>
                    <date-end-input></date-end-input>
                </td>
                <td v-if="showTransmittal" class="transmittal-column input-cell">
                    <transmittal-input></transmittal-input>
                </td>
                <td v-if="showNipigazCode" class="nipigaz-code-column input-cell">
                    <nipigaz-code-input></nipigaz-code-input>
                </td>
                <td v-if="showRevision" class="revision-column input-cell">
                    <revision-input></revision-input>
                </td>
                <td v-if="showTcmCode" class="tcm-code-column input-cell">
                    <tcm-code-input></tcm-code-input>
                </td>
                <td v-if="showClass" class="class-column input-cell">
                    <class-input></class-input>
                </td>
                <td v-if="showReason" class="reason-column input-cell">
                    <reason-input></reason-input>
                </td>
                <td v-if="showEnglishTitle" class="english-title-column input-cell">
                    <english-title-input></english-title-input>
                </td>
                <td v-if="showRussianTitle" class="russian-title-column input-cell">
                    <russian-title-input></russian-title-input>
                </td>
            </tr>

            <tr v-for="item in items">
                <td v-if="showIssuedAt" class="issued-at-column">{{ rusDateFormat(item.issued_at) }}</td>
                <td v-if="showTransmittal" class="transmittal-column">
                    <!--{{ item.transmittal }}-->
                    <a :href="'/transmittals/' + item.trans_id">{{ item.transmittal }}</a>
                </td>

                <td v-if="showNipigazCode" class="nipigaz-code-column" scope="row">
                    <div v-if="(item.pdf_file === '')">
                        {{item.nipigaz_code}}
                    </div>
                    <div v-else>
                        <a :href="'/docs/' + item.id + '/pdf'">{{item.nipigaz_code}}</a>
                    </div>
                </td>

                <td v-if="showRevision" class="revision-column">{{ item.revision }}</td>

                <td v-if="showTcmCode" class="tcm-code-column">
                    <div v-if="(item.native_file === '')">
                        {{item.tcm_code}}
                    </div>
                    <div v-else>
                        <a :href="'/docs/' + item.id + '/native'">{{item.tcm_code}}</a>
                    </div>
                </td>

                <td v-if="showClass" class="class-column">{{ item.class }}</td>
                <td v-if="showReason" class="reason-column">{{ item.reason }}</td>
                <td v-if="showEnglishTitle" class="english-title-column">{{ item.english_title }}</td>
                <td v-if="showRussianTitle" class="russian-title-column">{{ item.russian_title }}</td>
            </tr>
            </tbody>
        </table>
    </div>

</template>

<script>
    module.exports = {
        name: 'DocList',

        methods: {
            setOrderBy: function (event) {
                if (event) {
                    this.$store.commit("setSortedByItem", event.target.getAttribute('value'));
                }
            },

            search: function (event) {
                this.$store.dispatch('search');
            },

            rusDateFormat(timestamp) {
                let date = new Date(timestamp * 1000);

                let year = date.getFullYear();
                let month = date.getMonth() + 1;
                let day = date.getDate();

                return day + '.' + month + '.' + year;
            },

        },

        computed: {
            items() {
                return _.sortBy(this.$store.state.items, this.$store.state.sortedByItem);
            },

            showIssuedAt() {
                return this.$store.state.itemsToBeShown.includes('issued_at');
            },

            showTransmittal() {
                return this.$store.state.itemsToBeShown.includes('transmittal');
            },

            showNipigazCode() {
                return this.$store.state.itemsToBeShown.includes('nipigaz_code');
            },

            showRevision() {
                return this.$store.state.itemsToBeShown.includes('revision');
            },

            showTcmCode() {
                return this.$store.state.itemsToBeShown.includes('tcm_code');
            },

            showClass() {
                return this.$store.state.itemsToBeShown.includes('class');
            },

            showReason() {
                return this.$store.state.itemsToBeShown.includes('reason');
            },

            showEnglishTitle() {
                return this.$store.state.itemsToBeShown.includes('english_title');
            },

            showRussianTitle() {
                return this.$store.state.itemsToBeShown.includes('russian_title');
            },


        },
    }
</script>