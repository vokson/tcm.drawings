<template>
    <div>
        <input v-model.trim="value" type="text" placeholder="Имя (eng)" class="input-cell"/>
    </div>
</template>

<script>
    module.exports = {
        data: function () {
            return {
                value: '',
            }
        },

        watch: {
            // whenever value changes, this function will run
            value: function (newValue) {

                let payload = {
                    property: "english_title",
                    value: newValue
                }

                this.$store.commit("setProperty", payload);
            }
        },


    }
</script>