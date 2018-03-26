<template>
    <div>
        <input v-model.trim="value" type="text" placeholder="Имя (ru)" class="input-cell"/>
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
                return this.$store.state.russian_title;
            },
        },

        watch: {
            // whenever value changes, this function will run
            value: function (newValue) {

                let payload = {
                    property: "russian_title",
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