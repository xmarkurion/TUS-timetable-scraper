<script setup>
import useTableTool from '@/composables/tableTool.ts'
const dataSource = await queryContent('devices').findOne()
const { data, dayOff,currentDay } = useTableTool(dataSource)

const today = computed(()=>{
    // get a way to get day dynamic
    return data.Monday
})

 // Curent time
 const currentTime = computed(()=>{
        const today = new Date();
        // const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        // const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        // const dateTime = date +' '+ time;
        return today.getHours() + ":" + today.getMinutes();
})

</script>

<template>
    Live 
    {{ today }}
    <br>
    Time
    {{ currentTime }}

    
</template>