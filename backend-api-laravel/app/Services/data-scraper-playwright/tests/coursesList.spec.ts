import { test } from '@playwright/test';
import { Courses } from '../pages/courses.page';

test('Check available courses', async ({ page, context }) => {
    const table = new Courses(page, context);
    await table.start();
  });
