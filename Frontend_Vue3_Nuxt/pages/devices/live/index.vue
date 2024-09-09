<script setup>
import { computed } from 'vue'
import { useNow } from '@vueuse/core'
import Lecture from '@/components/markurion/Lecture'
const data = await queryContent('devices').findOne()

// Get the current day dynamically
const currentDayName = computed(() => {
  const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
  return days[new Date().getDay()]
})

// Get activities for the current day
const todayActivities = computed(() => {
  return data[currentDayName.value] || []
})


// Get the current time
const currentTime = computed(() => {
  const today = new Date()
  return today.getHours() + ":" + today.getMinutes()
})

// Compare current time with activity times
  const upcomingActivity = computed(() => {
  const now = new Date()
  const nowTime = now.getHours() * 60 + now.getMinutes()

  for (const activity of todayActivities.value) {
    const [startHour, startMinute] = activity.Start.split(':').map(Number)
    const [endHour, endMinute] = activity.End.split(':').map(Number)
    const startTime = startHour * 60 + startMinute
    const endTime = endHour * 60 + endMinute

    if (nowTime >= startTime && nowTime <= endTime) {
      const timeLeft = endTime - nowTime
      return { ...activity, status: 'ongoing', timeLeft }
    } else if (nowTime < startTime) {
        const timeTo = startTime - nowTime
      return { ...activity, status: 'upcoming', timeTo }
    }
  }

  return null
})

</script>

<template>
  <div>
    Live Time: {{ currentTime }}
    <div v-if="upcomingActivity">
      <div v-if="upcomingActivity.status === 'ongoing'">
        Current Activity: {{ upcomingActivity.Activity }}<br>
            <Lecture :data="upcomingActivity"/>
        Time Left: {{ upcomingActivity.timeLeft }} minutes
      </div>
      <div v-else>
        Upcoming Activity: {{ upcomingActivity.Activity }}<br>
         <Lecture :data="upcomingActivity"/>
        Starts at: {{ upcomingActivity.Start }} <br>
        Time left to start: {{  upcomingActivity.timeTo }} minutes
      </div>
    </div>
    <div v-else>
      No more activities for today.
    </div>
  </div>
</template>