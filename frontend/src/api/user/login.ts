import api from "../axiosInstance";
import type {Login} from "../../models/login.ts";


export default async function login(email: string , password: string): Promise<boolean|undefined> {
    return api.post<Login>("/login", {
        email: email,
        password: password
    }).then(res => {
        if (res.data.token && res.data.refresh_token) {
            localStorage.setItem('access_token', res.data.token);
            localStorage.setItem("refresh_token", res.data.refresh_token)
            return true;
        }
    }).catch(err => {
        console.log(err);
        return false;
    });
}