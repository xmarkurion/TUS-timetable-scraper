
import { ref } from 'vue';

export type CourseTypeLocal = {
  id: number;
  code: string;
  description: string;
  active: boolean;
  created_at: string;
  updated_at: string;
};

export type CourseTypeActive = {
    active: CourseTypeLocal[];
}

export type CourseTypeAll = {
  courses: CourseTypeLocal[];
}

export async function useCourses() {
  const { status, data } = await useFetch<CourseTypeActive>('http://localhost:8000/api/courses/active', { lazy: false });
  const courses_data = ref<CourseTypeActive>(data.value || { active: [] });

  return { status, courses_data };
}

export async function useAllCourses() {
  const { status, data } = await useFetch<CourseTypeAll>('http://localhost:8000/api/courses', { lazy: false });
  const courses_data = ref<CourseTypeAll>(data.value || { courses: [] });
  return { status, courses_data };
}


export function toLowerCasePro(course: CourseTypeLocal): CourseTypeLocal {
  return {
    ...course,
    code: course.code.toLowerCase(),
    description: course.description.toLowerCase(),
  };
}