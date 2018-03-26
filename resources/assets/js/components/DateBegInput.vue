<template>
    <div>
        <input v-model.trim="value" type="text" placeholder="От" v-bind:class="{ 'bg-danger': hasError }" class="input-cell"/>
    </div>
</template>

<script>
    module.exports = {
        data: function () {
            return {
                value: '',
                hasError: false
            }
        },

        methods: {
            isDateFormatValid: function (dateString) {
                // Check if Date in MM.DD.YYYY format
                var arr = dateString.split('.');

                if (arr.length == 3) {
                    if (
                        arr[0].length > 0 && arr[0].length < 3 &&
                        arr[1].length > 0 && arr[1].length < 3 &&
                        arr[2].length == 4
                    ) {
                        let day = parseInt(arr[0]);
                        let month = parseInt(arr[1]);
                        let year = parseInt(arr[2]);

                        if (
                            day >= 1 && day <= 31 &&
                            month >= 1 && month <= 12 &&
                            year >= 1970 && year <= 2070
                        ) {
                            return true;
                        }
                    }
                }

                return false;
            }
        },

        computed: {
            stateValue() {
                return this.$store.state.date_beg;
            },
        },

        watch: {
            // whenever value changes, this function will run
            value: function (newValue) {

                this.hasError = !this.isDateFormatValid(newValue);

                let value = '';
                if (!this.hasError) {value = newValue};

                this.$store.commit("setProperty", {property: "date_beg", value: value});
            },

            stateValue: function (newValue) {
                this.value = newValue;
            }
        },


    }
</script>