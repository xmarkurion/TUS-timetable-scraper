<script setup>
import Lecture from '@/components/markurion/Lecture'
const props = defineProps({
    day:{
        type: Object,
        required: true
    }
})

// Helper function to convert time string to minutes since midnight
const timeStringToMinutes = (timeString) => {
  const [hours, minutes] = timeString.split(':').map(Number)
  return hours * 60 + minutes
}

// Helper function to convert minutes since midnight to time string "HH:MM"
const minutesToTimeString = (minutes) => {
  const hours = Math.floor(minutes / 60)
  const mins = minutes % 60
  return `${String(hours).padStart(2, '0')}:${String(mins).padStart(2, '0')}`
}

// Computed property to calculate differences
const differences = computed(() => {
  return props.day.map((data, index) => {
    if (index === 0) return null
    const previousEnd = timeStringToMinutes(props.day[index - 1].End)
    const currentStart = timeStringToMinutes(data.Start)
    return {
      difference: currentStart - previousEnd,
      index
    }
  }).filter(diff => diff !== null)
})

</script>
<template>
    <div v-for="(data, index) in day" class="lec">
        <div v-if="index != 0"> 
            <div v-if="minutesToTimeString( differences[index - 1].difference ) !== '00:00'" class="break">
                {{minutesToTimeString( differences[index - 1].difference ) }} 
            </div> 
        </div>
        <Lecture :data="data" />
    </div>
</template>

<style scoped>
.break{
    display: flex;
    justify-content: center;
    padding-bottom: 5px;
}

.lec{
    padding-top: 5px;
  }
</style>