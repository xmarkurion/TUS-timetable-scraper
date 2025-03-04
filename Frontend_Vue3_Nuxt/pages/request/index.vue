<script setup lang="ts">
import type { CourseTypeLocal, CourseTypeAll } from "~/data/courses";
import { toLowerCasePro } from "~/data/courses";
import { Button } from '@/components/ui/button'
import { ChevronRight, Search, DiamondPlus } from 'lucide-vue-next'
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import { useAllCourses } from '~/data/courses';
import SuperSpinner from '~/components/markurion/SuperSpinner.vue';
import { ref, watch, computed } from 'vue';
import NewRequest from "~/components/markurion/NewRequest.vue";

// Query all courses
const { status, courses_data } = await useAllCourses();

// Create a reactive property for the search input
const searchQuery = ref('');

// Computed property to filter courses based on searchQuery
const filteredCourses = ref<CourseTypeLocal[]>(courses_data.value.courses);

// Add a watcher to update the filteredCourses when the searchQuery changes
watch(searchQuery, (newQuery) => {
  if (!courses_data.value || !courses_data.value.courses) {
    filteredCourses.value = [];
  } else {
    const lowerCaseQuery = newQuery.toLowerCase();
    const regex = new RegExp(lowerCaseQuery, 'i');
    filteredCourses.value = courses_data.value.courses.filter((course: CourseTypeLocal) => {
      course = toLowerCasePro(course);
      return regex.test(course.code) || regex.test(course.description);
    });
  }
});

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
    <div class="flex">
      <div class="p-2 relative w-full items-center">
        <Input v-model="searchQuery" id="id_search" name="name_search" type="text" placeholder="Search..." class="pl-10" />
        <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
          <Search class="text-muted-foreground" />
        </span>
      </div>
    </div>

    <div class="p-4 border-spacing-1 border">
    <Table>
      <TableCaption>A list of time tables.</TableCaption>
      <TableHeader>
        <TableRow>
          <TableHead class="w-[100px] text-right">
            Course short code
          </TableHead>
          <TableHead>Details</TableHead>
          <TableHead class="text-right">
            Action
          </TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
<!--        <TableRow v-for="course in courses.courses">-->
          <TableRow v-for="course in filteredCourses" :key="course.id">
          <TableCell class="font-medium">
            {{ course.code }}
          </TableCell>
          <TableCell>{{ course.description }}</TableCell>
          <TableCell class="text-right">
            <NewRequest :course_code="course.code" :course_id="course.id"/>
          </TableCell>
        </TableRow>
      </TableBody>
    </Table>
    </div>

  </div>
</template>
