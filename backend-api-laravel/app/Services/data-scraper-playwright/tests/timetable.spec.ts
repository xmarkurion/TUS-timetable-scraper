import { test } from '@playwright/test';
import { TimeTable } from '../pages/login.page';
// @ts-ignore
import * as data from '../../data-scraper-playwright/data/course.json';

type CourseType = {
    course: string;
}

test('To get proper timetable', async ({ page, context }) => {
    const course:CourseType = data;
    console.log("Running table scrape for: " + data.course + "\n");

   const table = new TimeTable(data.course, data.course, page, context);
   await table.start();
});
