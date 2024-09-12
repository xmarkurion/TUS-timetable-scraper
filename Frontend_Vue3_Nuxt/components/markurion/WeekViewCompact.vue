<script setup>
import WeekView from '~/components/markurion/WeekView.vue';
import SuperSpinner from './SuperSpinner.vue';

// Here we are passing course code to our week View Component
const props = defineProps({
  courseCode: String
})
const data = ref(null)

onMounted(async ()=>{
  data.value = await queryContent(props.courseCode).findOne()
})

</script>

<template>
  <div v-if="!data">
    <SuperSpinner :enabled="true"/>
  </div>
  <div v-else>
    <WeekView :data="data" :courseCode="props.courseCode"/>
  </div>
</template>

<style scoped>
</style>