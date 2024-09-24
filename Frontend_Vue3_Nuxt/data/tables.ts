type requestType = {
    course: string;
    timetable: WeekType[];
}

type WeekType = {
    Monday: Activity[];
    Tuesday: Activity[];
    Wednesday: Activity[];
    Thursday: Activity[];
    Friday: Activity[];
}

export type Activity = {
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
export async function getTable(code: string) {
    const { status, data:table } = await useFetch<requestType>(
        `http://localhost:8000/api/timetable?code=${code}`,
         { 
            lazy: false, 
            server: false 
        }
    );
    return { status, table };

}

