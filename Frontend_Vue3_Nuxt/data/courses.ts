
import { ref } from 'vue';

type CourseTypeLocal = {
  id: number;
  code: string;
  description: string;
  active: boolean;
  created_at: string;
  updated_at: string;
};

type CourseTypeGlobal = {
  active: CourseTypeLocal[];
};

export async function useCourses() {
  const { status, data } = await useFetch<CourseTypeGlobal>('http://localhost:8000/api/courses/active', { lazy: false });
  const courses = ref<CourseTypeGlobal>(data.value || { active: [] });

  return { status, courses };
}