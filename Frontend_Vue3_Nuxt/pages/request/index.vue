<script setup lang="ts">
import { CourseTypeLocal } from "~/data/courses";
import { Button } from '@/components/ui/button'
import { ChevronRight, Search } from 'lucide-vue-next'
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

const { status, courses } = await useAllCourses();
console.log(status,courses);
// search in courses by code or description
const search = (query: string) => {
  return courses.courses.filter((course: CourseTypeLocal[]) => {
    return course.code.includes(query) || course.description.includes(query);
  });
}

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
        <Input id="search" type="text" placeholder="Search..." class="pl-10" />
        <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
          <Search class="text-muted-foreground" />
        </span>
      </div>
    </div>

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
        <TableRow v-for="course in courses.courses">
          <TableCell class="font-medium">
            {{ course.code }}
          </TableCell>
          <TableCell>{{ course.description }}</TableCell>
          <TableCell class="text-right">{{ fixTime(course.updated_at) }}</TableCell>
          <TableCell class="text-right">
<!--            <NuxtLink :to="{name: 'universal-code', params: {code: course.code } }">-->
<!--              <Button variant="outline" size="icon">-->
<!--                <ChevronRight class="w-4 h-4" />-->
<!--              </Button>-->
<!--            </NuxtLink>-->
          </TableCell>
        </TableRow>
      </TableBody>
    </Table>
  </div>


  <div class="bottom-0 left-0 right-0 p-1 bg-white border-t border-gray-200 flex justify-center p-4">
    <NuxtLink to="/request">
      <Button variant="outline" size="sm">
        Admin Panel
      </Button>
    </NuxtLink>
  </div>
</template>
