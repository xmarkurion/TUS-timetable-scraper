<script setup lang="ts">
import {Search} from "lucide-vue-next";
import { toLowerCasePro } from "~/data/courses";
import type { CourseTypeLocal } from "~/data/courses";

import { ref, watch, defineProps, defineEmits } from 'vue';
import { Input } from '@/components/ui/input';

const props = defineProps<{
  courses: CourseTypeLocal[]
}>();

const emit = defineEmits<{
  (e: 'update:filteredCourses', value: CourseTypeLocal[]): void;
}>();

const searchQuery = ref('');

watch(searchQuery, (newQuery) => {
  if (!props.courses) {
    emit('update:filteredCourses', []);
  } else {
    const lowerCaseQuery = newQuery.toLowerCase();
    const regex = new RegExp(lowerCaseQuery, 'i');
    const filteredCourses = props.courses.filter((course: CourseTypeLocal) => {
      course = toLowerCasePro(course);
      return regex.test(course.code) || regex.test(course.description);
    });
    emit('update:filteredCourses', filteredCourses);
  }
});
</script>

<template>
  <div class="flex">
    <div class="p-2 relative w-full items-center">
      <Input v-model="searchQuery" id="id_search" name="name_search" type="text" placeholder="Search..." class="pl-10" />
      <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
        <Search class="text-muted-foreground" />
      </span>
    </div>
  </div>
</template>