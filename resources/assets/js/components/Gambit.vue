<template>
    <div>
        <div class="row">
            <div class="col-lg-6 spaced" v-for="device in this.$store.state.devices">
                <div class="card">
                    <h2>{{ device.name }}</h2>
                    <i>{{ device.model }}</i>
                    <hr>
                    <div v-for="data in device.data">
                        <h3>{{ data.name }}</h3>
                        {{ data.value }}<br>
                        <details>
                            <summary>binary</summary>
                            <pre>{{ data.binaryString }}</pre>
                        </details>
                    </div>
                    <hr>
                    <details>
                        <summary>raw</summary>
                        <pre>{{ device.rawData }}</pre>
                    </details>
                </div>
            </div>
        </div>

        <button v-on:click="clear_and_populate()">Clear and populate</button>
        <button v-on:click="populate()">Populate</button>
        <button v-on:click="clear()">Clear</button>
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
