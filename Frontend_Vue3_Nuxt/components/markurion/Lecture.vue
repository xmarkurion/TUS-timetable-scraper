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


</script>

<template>
    <Card>
        <CardHeader>
          <CardTitle>{{ data.Activity }} |  {{ data.Room.split(" ")[1] }} </CardTitle>
          <CardDescription>
            <div class="desc">
              <div>
                {{ data.Type }} - {{ data.Staff }} 
              </div>
             <div>
              {{ data.Room.split(" ")[0] }} 
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