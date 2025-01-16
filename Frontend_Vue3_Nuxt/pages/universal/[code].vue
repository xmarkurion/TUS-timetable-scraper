<script setup lang="ts">
import { ref, onMounted } from 'vue';
import SuperSpinner from '~/components/markurion/SuperSpinner.vue';
import { getTable } from '~/data/tables';
import {jsonStringify} from "@nuxt/content/dist/runtime/utils/json";

const route = useRoute();
const code = route.params.code as string;
const status = ref('idle');
const table = ref(null);

onMounted(async () => {
  status.value = 'pending';
  const { status: fetchStatus, table: fetchTable } = await getTable(code);
  if (fetchStatus === 'success') {
    status.value = 'success';
    table.value = fetchTable;
  } else {
    status.value = 'error';
  }
});
</script>

<template>
  <div v-if="status === 'idle' || status === 'pending'">
    <SuperSpinner :enabled="true" />
  </div>

  <div v-if="status === 'success'">
    <MarkurionWeekView :data="table?.timetable" :courseCode="code" />
  </div>

  <div v-if="status === 'error'">
    <p>Error loading data. Please try again later.</p>
  </div>
</template>