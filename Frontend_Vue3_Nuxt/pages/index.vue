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
import { useCourses } from '~/data/courses';
import SuperSpinner from '~/components/markurion/SuperSpinner.vue';

const { status, courses } = await useCourses();

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

      <TableRow v-for="course in courses.active">
        <TableCell class="font-medium">
          {{ course.code }}
        </TableCell>
        <TableCell>{{ course.description }}</TableCell>
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
</template>