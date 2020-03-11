<template>
    <div class="course">
        <div class="course__name">{{ course.name }}</div>
        <div class="course__hour">{{ course.hour }}</div>
        <div class="course_trainer">{{course.trainer}}</div>
        <div class="course__level">{{level}}</div>
    </div>
</template>

<script>
    export default {
        name: "Course",
        props: {
            course: {
                type: Object
            }
        },
        computed: {
            level() {
                let level = this.course.level.substring(7);

                if (level.toLowerCase() === 'open') {
                    return 'OPEN'
                }

                return 'P' + this.course.level.substring(7);
            }
        }
    }
</script>

<style scoped lang="scss">
    .course {
        background-color: lighten(#1b9448, 3%);
        border-radius: 10px;
        margin: 10px;
        padding: 4px 0;
        position: relative;
        &__name {
            color: white;
            font-weight: 700;
        }
        &__level {
            position: absolute;
            bottom: 5px;
            left: 15px;
            font-size: 2em;
            font-weight: 800;
            color: lighten(#1b9448, 9%);
        }
    }
</style>