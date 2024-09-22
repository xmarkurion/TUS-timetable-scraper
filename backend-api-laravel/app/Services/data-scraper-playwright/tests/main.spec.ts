import { test, expect } from '@playwright/test';
import { TimeTable } from '../pages/login.page';
import { Courses } from '../pages/courses.page';


test('Check avalible courses', async ({ page, context }) => {
  const table = new Courses(page, context);
  await table.start();
});

// test.only('Opens time table', async ({ page, context }) => {
//   const table = new TimeTable("AL_KMOBA_8_4", "devices", page, context);
//   await table.start();
// });

// test.only('Opens time table2', async ({ page, context }) => {
//   const table2 = new TimeTable("AL_KAICC_8_4", "cloud", page, context);
//   await table2.start();
// });

