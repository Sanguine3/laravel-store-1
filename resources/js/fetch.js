const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

async function handleResponse(response) {
    const data = await response.json().catch(() => null);
    if (!response.ok) {
        const error = data?.message || response.statusText;
        throw new Error(error);
    }
    return data;
}

export function get(url) {
    return fetch(url, {
        credentials: 'same-origin',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
    }).then(handleResponse);
}

export function post(url, body = {}) {
    return fetch(url, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify(body),
    }).then(handleResponse);
}

export function put(url, body = {}) {
    return fetch(url, {
        method: 'PUT',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify(body),
    }).then(handleResponse);
}

export function del(url) {
    return fetch(url, {
        method: 'DELETE',
        credentials: 'same-origin',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
    }).then(handleResponse);
} 