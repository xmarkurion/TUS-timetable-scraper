<script setup>
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'

const props = defineProps({
    data:{
        type: Object,
        required: true
    }
})

const staff = computed(()=>{
  return props.data.Staff.split(";")
})


</script>

<template>
    <Card>
        <CardHeader>
          <CardTitle>{{ data.Activity }} |  {{ data.Room.split(" ")[1] }} </CardTitle>
          <CardDescription>
            <div class="desc">
              <div>
                <p v-for="person in staff">{{ person }}</p>
              </div>
             <div>
              {{ data.Type }} ... {{ data.Room.split(" ")[0] }} 
             </div>
            </div>
          </CardDescription>
        </CardHeader>
        <CardContent>
          <div class="desc">
            <div> {{ data.Start }} - {{ data.End }}</div>
            <div>{{ data.Duration }} hours </div>
          </div>
        </CardContent>
      </Card>
</template>

<style scoped>
.desc{
    display: flex;
    justify-content: space-between;
  }
</style>