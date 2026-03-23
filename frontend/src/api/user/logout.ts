export default function logout (): void {
    localStorage.removeItem("access_token");
    localStorage.removeItem("refresh_token");
}