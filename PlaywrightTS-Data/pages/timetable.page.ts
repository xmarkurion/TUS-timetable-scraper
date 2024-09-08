import { Locator, Page } from "@playwright/test";

export interface WeekInterface{
    Monday: Activity[];
    Tuesday: Activity[];
    Wednesday: Activity[];
    Thursday: Activity[];
    Friday: Activity[];
}

export interface Activity{
    Activity: string | null;
    Module: string | null;
    Type: string | null;
    Start: string | null;
    End: string | null;
    Duration: string | null;
    Weeks: string | null;
    Room: string | null;
    Staff: string | null;
    StudentGroup: string | null;
}

export class TablePage{
    private labelOne: Locator;
    private tablesLocator: Locator;


    public constructor(
        private page: Page
    ){
        this.labelOne  = page.locator(".labelone");
        this.tablesLocator = page.locator(".spreadsheet")
    }

    public async start(){
        this.extract();
    }
    
    public async timeTable(): Promise<WeekInterface>{
        return await this.extract()
    }

    private async extract(){
        const allDays = await this.labelOne.all();
        const daysArray = await Promise.all(allDays.map( async (label: Locator)=>{
            return await label.textContent();
        }));

        // All tables 
        const allTables = await this.tablesLocator.all();
        const tablesArray = await Promise.all( allTables.map( async (table: Locator) => {
            return await this.extractTableElement(table)
        }))

        const week: WeekInterface = {
            Monday: tablesArray[0],
            Tuesday: tablesArray[1],
            Wednesday: tablesArray[2],
            Thursday: tablesArray[3],
            Friday: tablesArray[4],
        }

        return week;
    }

    // All individual tr elements
    private async extractTableElement(table: Locator){
        const allTr = await table.locator('tr').all();
        const trArray = await Promise.all( allTr.slice(1).map( async (tr: Locator) => {
            return await this.extractTrElement(tr)
        }))

        return trArray
    }

    // All individual td elements
    private async extractTrElement(tr: Locator): Promise<Activity>{
        const allTd = await tr.locator("td").all()
        const tdArray = await Promise.all( allTd.map(async (data: Locator) => {
            return await data.textContent()
        }));

        return {
            Activity: tdArray[0],
            Module: tdArray[1],
            Type: tdArray[2],
            Start: tdArray[3],
            End: tdArray[4],
            Duration: tdArray[5],
            Weeks: tdArray[6],
            Room: tdArray[7],
            Staff: tdArray[8],
            StudentGroup: tdArray[9],
        }
    }

}