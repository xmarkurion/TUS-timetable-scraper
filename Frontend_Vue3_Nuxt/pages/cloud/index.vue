<script setup lang="ts">
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs'
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import Lecture from '@/components/markurion/Lecture'
import Break from '../../components/markurion/Break.vue'

// Here we will use composable to show us the corect table.
import useTableTool from '@/composables/tableTool.ts'
const { data, dayOff,currentDay } = useTableTool('cloud')

</script>

<template>
  <div class="header">
    <NuxtLink :to="'/devices/live'">
      <Card>
        <CardHeader>
          <CardTitle> Now Playing {{ currentDay }}</CardTitle>
          <CardDescription>Click to see live what's now what's next.</CardDescription>
        </CardHeader>
      </Card>
    </NuxtLink>
  </div>

  <div class="main"> 
  <Tabs :default-value="currentDay" class="w-[400px]">
    <TabsList>
      <TabsTrigger value="Monday">
        Monday
      </TabsTrigger>
      <TabsTrigger value="Tuesday">
        Tuesday
      </TabsTrigger>
      
      <TabsTrigger value="Wednesday">
        Wednesday
      </TabsTrigger>

      <TabsTrigger value="Thursday">
        Thursday
      </TabsTrigger>

      <TabsTrigger value="Friday">
        Friday
      </TabsTrigger>

      <TabsTrigger v-if="dayOff" value="">
      </TabsTrigger>

    </TabsList>
    <TabsContent value="Monday">
      <Break :day="data.Monday"/>
    </TabsContent>

    <TabsContent value="Tuesday">
        <Break :day="data.Tuesday"/>
    </TabsContent>

    <TabsContent value="Wednesday">
        <Break :day="data.Wednesday"/>
    </TabsContent>
   
    <TabsContent value="Thursday">
        <Break :day="data.Thursday"/>
    </TabsContent>

    <TabsContent value="Friday">
        <Break :day="data.Friday"/>
    </TabsContent>
    <TabsContent v-if="dayOff" value="" >
      <div class="text-center pt-[50px]">Enjoy the weekend.</div>
  </TabsContent>


  </Tabs>

  <!-- {{ data }} -->
</div>
</template>

<style scoped>
.header{
  display: flex;
  justify-content: center;
}

.main{
  padding: 10px;
  display: flex;
  justify-content: center;
}

</style>