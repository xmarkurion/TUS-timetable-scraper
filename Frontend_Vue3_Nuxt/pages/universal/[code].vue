<script setup lang="ts">
import SuperSpinner from '~/components/markurion/SuperSpinner.vue';
import { getTable } from '~/data/tables';
// get the code from the route params
const route = useRoute();
const code = route.params.code as string;
const { status, table } = await getTable(code);

</script>

<template>
    <div v-if="status==='idle' || status==='pending'">
        <SuperSpinner :enabled="true"/>
    </div>

    <div v-if="status==='success'">
        <MarkurionWeekView :data="table?.timetable" :courseCode="code"/>
    </div> 
</template>