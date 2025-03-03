
import { ref } from 'vue';

type CourseTypeLocal = {
  id: number;
  code: string;
  description: string;
  active: boolean;
  created_at: string;
  updated_at: string;
};

// type CourseTypeGlobal = {
//   active: CourseTypeLocal[];
// };

type CourseTypeActive = {
    active: CourseTypeLocal[];
}

export async function useCourses() {
  const { status, data } = await useFetch<CourseTypeActive>('http://localhost:8000/api/courses/active', { lazy: false });
  const courses = ref<CourseTypeActive>(data.value || { active: [] });

  return { status, courses };
}

export async function useAllCourses() {
  const { status, data } = await useFetch<CourseTypeGlobal>('http://localhost:8000/api/courses', { lazy: false });
  const courses = ref<CourseTypeLocal[]>(data.value || { courses: [] });

  return { status, courses };
}