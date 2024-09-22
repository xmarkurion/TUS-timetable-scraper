import { expect, Locator, Page } from "@playwright/test";
import { Context } from "vm";

import { TablePage } from "./timetable.page";
import { FileProcessor } from "../utils/fileProcessor.utils";

export class Courses{
    www: string;
    button: Locator;
    secondStep: Locator;
    courseLocator: Locator;
    weekSelectLocator: Locator;
    buttonShowTheTable: Locator;

    public constructor(
        private page: Page,
        private context: Context,
    ){
        this.www = "https://timetables.midlands.tus.ie/2425/default.aspx"
        this.button = page.getByRole('button', { name: 'Student' });
        this.secondStep = page.getByRole('link', { name: 'Student Set - by Name' });
        this.courseLocator = page.locator('select').nth(1);
    }

    private async visit(){
        await this.page.goto(this.www)
    }

    public async start(){
        await this.visit()
        await this.button.click();
        await this. secondStep.click();

        const allOptions = await this.courseLocator.locator('option').all()

        const optionArray = await Promise.all(allOptions.map( async (option: Locator)=>{
            return await option.textContent();
        }));

        const file = JSON.stringify(optionArray)
        console.log("DATA:START")
        console.log(file)
        console.log("DATA:END")
        // const handy = new FileProcessor()
        // await handy.saveToFile('', 'Available_courses.json', file);
        // console.log("File was saved to Available_courses.json")
    }
}
