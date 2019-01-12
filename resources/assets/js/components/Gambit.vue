<template>
    <div>
        <button v-on:click="clear_and_populate()">Clear and populate</button>
        <button v-on:click="populate()">Populate</button>
        <button v-on:click="clear()">Clear</button>

        <div class="row">
            <div class="col-lg-6 spaced" v-for="device in this.$store.state.devices">
                <div class="card">
                    {{ device }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');
        },

        methods: {
            clear() {
                this.$store.commit('clear');
            },
            clear_and_populate() {
                this.$store.commit('clear');
                this.$store.commit('populate');
            },
            populate() {
                this.$store.commit('populate');
            }
        }
    }
</script>
