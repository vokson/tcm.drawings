<template>
    <div>
        <input v-model.trim="value" type="text" placeholder="No.TCM" class="input-cell"/>
    </div>
</template>

<script>
    module.exports = {
        data: function () {
            return {
                value: '',
            }
        },

        mounted: function () {
            this.value = this.stateValue;
        },

        computed: {
            stateValue() {
                return this.$store.state.tcm_code;
            },
        },

        watch: {
            // whenever value changes, this function will run
            value: function (newValue) {

                let payload = {
                    property: "tcm_code",
                    value: newValue
                }

                this.$store.commit("setProperty", payload);
            },

            stateValue: function (newValue) {
                this.value = newValue;
            }
        },


    }
</script>