<template>
    <div>
        <input v-model.trim="value" type="text" placeholder="Причина" class="input-cell"/>
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
                    property: "reason",
                    value: newValue
                }

                this.$store.commit("setProperty", payload);
            }
        },
    }
</script>