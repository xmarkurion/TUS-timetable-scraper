import { expect, Locator, Page } from "@playwright/test";
import { Context } from "vm";

import { TablePage } from "./timetable.page";
import { FileProcessor } from "../utils/fileProcessor.utils";

export class TimeTable{
    www: string;
    button: Locator;
    secondStep: Locator;
    courseLocator: Locator;
    weekSelectLocator: Locator;
    buttonShowTheTable: Locator;

    public constructor(
        public courseName: string,
        private page: Page,
        private context: Context,
    ){
        this.www = "https://timetables.midlands.tus.ie/2425/default.aspx"
        this.button = page.getByRole('button', { name: 'Student' });
        this.secondStep = page.getByRole('link', { name: 'Student Set - by Name' });
        this.courseLocator = page.locator('select').nth(1);
        this.weekSelectLocator = this.page.locator('select').nth(2);
        this.buttonShowTheTable = this.page.getByRole('button', { name: 'View Timetable' });
    }

    private async visit(){
        await this.page.goto(this.www)
    }

    public async start(){
        await this.visit()
        await this.button.click();
        await this. secondStep.click();

        await this.courseLocator.selectOption(this.courseName);
        await this.weekSelectLocator.selectOption('4;5;6;7;8;9;10;11;12;13;14;15');
        await this.page.getByLabel('List Layout').check();
        await this.buttonShowTheTable.click();

        // Await for the new page to load.
        const [newPage] = await Promise.all([
            this.context.waitForEvent('page')
        ])
        await newPage.waitForLoadState();

        const tablePage = new TablePage(newPage)
        // await tablePage.start();

        const table = await tablePage.timeTable()
        
        //close new page and save data
        const handy = new FileProcessor()
        const file = JSON.stringify(table)
        await handy.saveToFile('TimeTablesJson', this.courseName+'.json', file);
        console.log("Saved....")
    }
}