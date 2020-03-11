<template>
    <div id="schedule" class="schedule">
        <div class="previous arrow" @click="previousDay"><img src="../assets/back.svg" alt=""></div>
        <div class="next arrow" @click="nextDay"><img src="../assets/right.svg" alt=""></div>
        <Day v-for="(day, key) in data" :day-number="key" :data="day" :key="key" v-if="key == selectedDay"></Day>
    </div>
</template>

<script>
    import axios from 'axios';
    import Day from "./Day";
    import moment from "moment";

    export default {
        name: "Schedule",
        components: {Day},
        data() {
            return {
                data: null,
                selectedDay: moment().weekday(),
            }
        },
        mounted() {
            console.log(moment().weekday());
            axios.get('/api').then(result => {
                this.data = result.data;
            })
        },
        methods: {
            previousDay() {
                if (this.selectedDay > 0) {
                    this.selectedDay -= 1;
                }
            },
            nextDay() {
                if (this.selectedDay < 4) {
                    this.selectedDay += 1;
                }
            }
        }
    }
</script>
<style scoped lang="scss">
    .schedule {
        position: relative;
        .arrow {
            width: 30px;
            cursor: pointer;
            position: absolute;
            img {
                width: 100%
            }
            &.previous {
                left: 0;
                padding-left: 22vw;
            }
            &.next {
                right: 0;
                padding-right: 22vw;
            }
        }
    }
</style>