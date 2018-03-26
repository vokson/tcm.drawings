<template>
    <div>
        <input v-model.trim="value" type="text" placeholder="No. НИПИГАЗ" class="input-cell"/>
    </div>
</template>

<script>
    module.exports = {
        data: function () {
            return {
                value: '',
            }
        },

        computed: {
            stateValue() {
                return this.$store.state.nipigaz_code;
            },
        },

        watch: {
            // whenever value changes, this function will run
            value: function (newValue) {

                let payload = {
                    property: "nipigaz_code",
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