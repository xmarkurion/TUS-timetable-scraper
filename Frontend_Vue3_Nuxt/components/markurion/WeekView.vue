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

import Break from '../../components/markurion/Break.vue'
import useTableTool from '@/composables/tableTool'
import type { ParsedContent } from '@nuxt/content';

// Data should be parsed json file with week content
const props = defineProps<{
    data: any,
    courseCode: string
}>()

const showLive = ref(false)

// const dataSource = await queryContent('devices').findOne()
const { data, dayOff,currentDay } = useTableTool(props.data)

</script>

<template>
  <div class="main" v-if="!showLive">
    <div class="header" @click.stop="showLive = !showLive">
        <Card>
          <CardHeader>
            <CardTitle> Now Playing {{ currentDay }}</CardTitle>
            <CardDescription>Click to see live what's now what's next.</CardDescription>
          </CardHeader>
        </Card>
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
  </div>
  </div>

  <div v-else>
    <MarkurionLiveUpdate :data="data" @back-btn="showLive = !showLive"/>
  </div>
</template>

<style scoped>
.header{
  display: flex;
  justify-content: center;
  :hover{
    cursor: pointer
  }
}

.main{
  padding: 10px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

</style>