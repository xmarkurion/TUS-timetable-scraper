<script setup>
import { computed } from 'vue'
import { useNow } from '@vueuse/core'
import Lecture from '@/components/markurion/Lecture'
const data = await queryContent('devices').findOne()

// Get the current date and time reactively
// const now = useNow({ interval: 60000 }) // Update every minute

const now = useNow() // Update every minute
// const now = ref(new Date(1726247448000))

// Format the current time as hh:mm:ss
const formattedTime = computed(() => {
  const hours = String(now.value.getHours()).padStart(2, '0')
  const minutes = String(now.value.getMinutes()).padStart(2, '0')
  const seconds = String(now.value.getSeconds()).padStart(2, '0')
  return {
    hm: `${hours}:${minutes}`,
    seconds,
  }
})

// Get the current day dynamically
const currentDayName = computed(() => {
  const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
  return days[now.value.getDay()]
})

// // Get activities for the current day
// const todayActivities = computed(() => {
//   return data[currentDayName.value] || []
// })

const amountOfTodayActivities = computed(()=>{
  return todayActivities.value.length
})

const todayActivities = computed(() => {
  return (data[currentDayName.value] || []).map((activity, index) => ({
    ...activity,
    key: index
  }))
})

// Get the current time
const currentTime = computed(() => {
  return now.value.getHours() + ":" + now.value.getMinutes()
})

// Compare current time with activity times
const upcomingActivity = computed(() => {
  const nowTime = now.value.getHours() * 60 + now.value.getMinutes()

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
  <div class="main">
    <div class="time">
        <span>{{ formattedTime.hm  }}</span>
        <span class="text-xs">:{{formattedTime.seconds}}</span>
    </div>
    <div class="info">
        <div v-if="upcomingActivity">
          
            <div v-if="upcomingActivity.status === 'ongoing'">
              <div class="py-2 text-center">
                Current Activity
              </div>
              <div class="borderr">
                <Lecture :data="upcomingActivity"/>
              </div>
              
              <div class="py-2 text-center">
                Time Left: {{ upcomingActivity.timeLeft }} minutes
              </div>

              <div class="py-2 text-center">
                <hr>
              </div>
              <div v-if="(upcomingActivity.key+1) !== amountOfTodayActivities" class="py-2 text-center">
                Next:
                <Lecture :data="todayActivities[upcomingActivity.key + 1]"/>
              </div>
            </div>

            <div v-else>
             <div class="py-2 text-center">
                Upcoming Activity
             </div>
              <Lecture :data="upcomingActivity"/>
              <div class="py-2 text-center">
                Starts at: {{ upcomingActivity.Start }} <br>
              </div>
              <div class="py-2 text-center">
                <hr>
              </div>
              <div class="py-2 text-center">
                Time left to start: {{ upcomingActivity.timeTo }} minutes
              </div>
            </div>
          </div>
          <div v-else>
            <div class="pt-2 text-center">
              No more activities for today.
            </div>
            <div class="pt-2 text-center">
              Go Home and enjoy the life before 9-5 lifestyle...
            </div>
          </div>
    </div>
  </div>
</template>

<style scoped>
.time {
    display: flex;
    justify-content: center;
    align-items: center;
    border: 2px darkcyan solid;
}

.info{
    display: flex;
    flex-direction: row;
    justify-content: center;
    padding: 10px;
}

.borderr{
  border: 2px seagreen dotted;
}


</style>