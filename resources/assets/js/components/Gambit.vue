<template>
    <div>
        <button v-if="this.$store.state.paused" v-on:click="runOnce()">
            Run once
        </button>
        <button v-if="this.$store.state.paused" v-on:click="play()">
            Play (will update every {{ this.$store.state.intervalValue / 1000 }} seconds)
        </button>
        <button v-if="!this.$store.state.paused" v-on:click="pause()">
            Pause
        </button>

        <div class="row">
            <div class="col-lg-6 spaced" v-for="device in this.$store.state.devices">
                <div class="card">
                    <h2>{{ device.name }}</h2>
                    <i>{{ device.model }}</i>&nbsp;[{{ device.datetime }}]
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
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');
        },

        methods: {
            play() {
                this.$store.commit('play');
            },
            pause() {
                this.$store.commit('pause');
            },

            runOnce() {
                this.$store.commit('clear');
                this.$store.commit('populate');
            },
        }
    }
</script>
