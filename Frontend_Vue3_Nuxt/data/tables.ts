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
    try {
        const response = await fetch(`http://localhost:8000/api/timetable?code=${code}`, {
            headers: {
                'Content-Type': 'application/json'
            }
        });
        if (!response.ok) {
            console.error(`HTTP error! status: ${response.status}`);
            const errorText = await response.text();
            console.error('Error details:', errorText);
            return { status: 'error', table: null };
        }
        const data = await response.json();
        return { status: 'success', table: data };
    } catch (error) {
        console.error('Fetch error:', error);
        return { status: 'error', table: null };
    }
}
