<script setup lang="ts">
import SuperSpinner from '~/components/markurion/SuperSpinner.vue';

// get the code from the route params
const route = useRoute();
const code = route.params.code;

type requestType = {
    course: string;
    timetable: WeekType[];
}

type WeekType = {
    Monday: Activity[];
    Tuesday: Activity[];
    Wednesday: Activity[];
    Thursday: Activity[];
    Friday: Activity[];
}

type Activity = {
    Activity: string | null;
    Module: string | null;
    Type: string | null;
    Start: string | null;
    End: string | null;
    Duration: string | null;
    Weeks: string | null;
    Room: string | null;
    Staff: string | null;
    StudentGroup: string | null;
}

const { status, data:table } = useFetch<requestType>(`http://localhost:8000/api/timetable?code=${code}`, { lazy: false, server: false });

</script>

<template>
    <div v-if="status==='idle' || status==='pending'">
        <SuperSpinner :enabled="true"/>
    </div>

    <div v-if="status==='success'">
        {{ code }}
        {{ table }}
        <!-- <MarkurionWeekView :data="table?.timetable" :courseCode="code"/> -->
    </div> 
</template>