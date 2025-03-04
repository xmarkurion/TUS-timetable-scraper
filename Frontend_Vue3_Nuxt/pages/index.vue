<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { ChevronRight } from 'lucide-vue-next'
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import {type CourseTypeLocal, useCourses} from '~/data/courses';
import SuperSpinner from '~/components/markurion/SuperSpinner.vue';
import SearchComponent from "~/components/markurion/Search.vue";
import {ref} from "vue";

// Query all active courses
const { status, courses_data } = await useCourses();

//---------- Search helpers
const originalCourses = ref<CourseTypeLocal[]>(courses_data.value.active);
const filteredCourses = ref<CourseTypeLocal[]>(courses_data.value.active);

const updateFilteredCourses = (courses: CourseTypeLocal[]) => {
  filteredCourses.value = courses;
};
//--------- End of search helpers

// should return time in format day/month/year hour:minute
const fixTime = (timestamp: string): string => {
  const date = new Date(timestamp);
  return `${date.getDate()}/${date.getMonth()}/${date.getFullYear()}`;
}

</script>

<template>
<div v-if="status==='idle' || status==='pending'">
  <SuperSpinner :enabled="true"/>
</div>

<div v-if="status==='error'">
  I can only see the sky. Please try again later.
</div>

<div v-else>
  <SearchComponent :courses="originalCourses" @update:filteredCourses="updateFilteredCourses" />

  <Table>
    <TableCaption>A list of time tables.</TableCaption>
    <TableHeader>
      <TableRow>
        <TableHead class="w-[100px] text-right">
          Course short code
        </TableHead>
        <TableHead>Details</TableHead>
        <TableHead>Updated at</TableHead>
        <TableHead class="text-right">
          Action
        </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>

      <TableRow v-for="course in filteredCourses">
        <TableCell class="font-medium">
          {{ course.code }}
        </TableCell>

        <TableCell>
          <NuxtLink :to="{name: 'universal-code', params: {code: course.code } }">
          {{ course.description }}
          </NuxtLink>
        </TableCell>

        <TableCell class="text-right">{{ fixTime(course.updated_at) }}</TableCell>
        <TableCell class="text-right">
          <NuxtLink :to="{name: 'universal-code', params: {code: course.code } }">
            <Button variant="outline" size="icon">
              <ChevronRight class="w-4 h-4" />
            </Button>
          </NuxtLink>
        </TableCell>
      </TableRow>
    </TableBody>
  </Table>
</div>


<div class="bottom-0 left-0 right-0 p-1 bg-white border-t border-gray-200 flex justify-center p-4">
    <NuxtLink to="/request">
      <Button variant="outline" size="sm">
        Request to add a new course
      </Button>
    </NuxtLink>
  </div>
</template>
