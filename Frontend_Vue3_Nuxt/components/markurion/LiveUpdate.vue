<script setup>
import { computed } from 'vue'
import { useNow } from '@vueuse/core'
import Lecture from '@/components/markurion/Lecture'

const props = defineProps(['courseCode'])

const data = await queryContent(props.courseCode).findOne()
// Get the current date and time reactively
// const now = useNow({ interval: 60000 }) // Update every minute

const now = useNow() // Update every minute
// const now = ref(new Date(1726017817000))

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
                <div>
                  Up Next
                </div>
                <div class="pt-2">
                  <Lecture :data="todayActivities[upcomingActivity.key + 1]"/>
                </div>
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
              Go Home and read something, knowledge is all you need.
            </div>
            <div class="pt-2 text-center">
              “Wherever you go, there you are.”
              <span class="quote">Thomas à Kempi</span>
            </div>
            <video autoplay playsinline muted loop width="400px" class="video">  
              <source src="/images/vid.webm" type="video/webm" >  
              Sorry, your browser doesn't support HTML5 video.  
            </video> 
          </div>
    </div>
  </div>
</template>

<style scoped>
html, body {
  margin: 0;
  padding: 0;
  background-color: black; /* Set background color to black */
  color: white; /* Optional: Set text color to white for better contrast */
  height: 100%;
}

.time {
    display: flex;
    justify-content: center;
    align-items: center;
    border: 2px darkcyan solid;
    width: 120px;
}

.info{
    display: flex;
    flex-direction: row;
    justify-content: center;
    padding: 10px;
}

.borderr{
  border: 5px white dotted;
  padding: 10px;
}

.video {
  display: flex;
  align-items: center;
  justify-content: baseline;
  animation: zoomInOut 5s infinite; /* Apply the zoom-in and zoom-out animation */
}

.main {
  background-color: black; /* Set background color to black */
  color: white; /* Optional: Set text color to white for better contrast */
  min-height: 100vh; /* Ensure the main container takes up the full height of the viewport */
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
}

@keyframes zoomInOut {
  0%, 100% {
    transform: scale(1); /* Initial and final state: no scaling */
  }
  50% {
    transform: scale(0.8); /* Midpoint: zoom in */
  }
}

.quote{
  font-size: 5px;
}

</style>