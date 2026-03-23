export function isLoggedIn() {
    if (localStorage.getItem("access_token") !== null && localStorage.getItem("refresh_token") !== null) {
        return true;
    }
    return false;
}
