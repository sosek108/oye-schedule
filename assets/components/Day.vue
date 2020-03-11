<template>
    <div class="day">
        <div class="day__name">{{name}}</div>
        <Course v-for="c,k in data" :course="c" :key="k"></Course>
    </div>
</template>

<script>
    import Course from "./Course";
    import moment from "moment";
    moment.locale('pl');
    export default {
        name: "Day",
        components: {Course},
        props: {
            dayNumber: null,
            data: {
                type: Array
            }
        },
        computed: {
            name() {
                switch (this.dayNumber) {
                    case 0:
                        return "Poniedziałek";
                    case 1:
                        return "Wtorek";
                    case 2:
                        return "Środa";
                    case 3:
                        return "Czwartek";
                    case 4:
                        return "Piątek";
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    .day {
        &__name {
            padding-top: 4px;
            font-weight: 800;
            font-size: 1.1em;
            text-transform: uppercase;
        }
    }
</style>