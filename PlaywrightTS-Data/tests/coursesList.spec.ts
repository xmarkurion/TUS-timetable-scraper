import { test } from '@playwright/test';
import { Courses } from '../pages/courses.page';

test('Check avalible courses', async ({ page, context }) => {
    const table = new Courses(page, context);
    await table.start();
  });