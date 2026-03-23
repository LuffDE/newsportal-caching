import axios from "axios";

export const baseUrl = "http://localhost:80/api";
const api = axios.create({
    baseURL: baseUrl,
    headers: {
        "Content-Type": "application/json",
    },
});

function getAccessToken(): string | null {
    return localStorage.getItem("access_token");
}

function getRefreshToken(): string | null {
    return localStorage.getItem("refresh_token");
}

function isJwtExpired(token: string): boolean {
    try {
        const payload = JSON.parse(atob(token.split(".")[1]));
        const now = Math.floor(Date.now() / 1000);
        return payload.exp < now;
    } catch {
        return true;
    }
}

async function refreshAccessToken(): Promise<string | null> {
    const refreshToken = getRefreshToken();
    if (!refreshToken) return null;

    try {
        const response = await axios.post(baseUrl + "/token/refresh", {
            refresh_token: refreshToken,
        });

        const newToken = response.data.token;
        localStorage.setItem("access_token", newToken);
        return newToken;
    } catch (err) {
        console.warn("Token Refresh fehlgeschlagen:", err);
        return null;
    }
}

api.interceptors.request.use(
    async (config) => {
        let token = getAccessToken();

        if (token && isJwtExpired(token)) {
            token = await refreshAccessToken();
        }

        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }

        return config;
    },
    (error) => Promise.reject(error)
);

api.interceptors.response.use(
    (response) => response,
    async (error) => {
        return Promise.reject(error);
    }
);

export default api;
