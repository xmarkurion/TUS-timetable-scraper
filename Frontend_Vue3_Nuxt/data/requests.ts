// Function to get the CSRF token from the meta tag
// to return token visit /api/csrf-token and response will be "csrf_token" : "token_value"
import {ref} from "vue";

export async function getCsrfToken() {
    const { status, data } = await useFetch<any>('http://localhost:8000/api/csrf-token', { lazy: false });
    const token = ref<any>(data.value || null);
    return { status, token };
}

export async function sendCourseRequest(course_code: string) {
    try {
        // let csrfToken = await getCsrfToken();
        // const token = csrfToken.token.value.csrf_token;
        // console.log(token)
        const response = await fetch('http://localhost:8000/api/courses/request', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                // 'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ code: course_code })
        });
        if (!response.ok) {
            // console.error(`HTTP error! status: ${response.status}`);
            const errorText = await response.json();
            console.error('Error details:' + errorText.error);
            return { message: errorText.error};
        }
        const data: any = await response.json();
        return { message: data.message };
    } catch (error) {
        console.error('Fetch error:', error);
        return { message: 'error' };
    }
}