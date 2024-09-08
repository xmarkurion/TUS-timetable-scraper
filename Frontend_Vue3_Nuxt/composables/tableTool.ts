
import { useAsyncState } from "@vueuse/core"

export default function useTableTool(tableSource: string){
    
    // The old way still handy for reference
    // const data = await queryContent(tableSource).findOne()
    const { state: data } = useAsyncState(queryContent(tableSource).findOne(), null)

    // Helper function to capitalize the first letter of a string
    const capitalize = (str:string) => str.charAt(0).toUpperCase() + str.slice(1)
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']

    // Computed property to get the current day capitalized
    const currentDay = computed(() => {
    const today = new Date().getDay()
    if(today == 0 || today == 6){
        return ''
    }
    return capitalize(days[today])
    })

    const dayOff = computed(()=>{
    if (currentDay.value === ''){
        return true
    }
    return false
    });

    return {
        data,
        dayOff,
        currentDay
    }
}