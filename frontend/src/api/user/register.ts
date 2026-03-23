import api from "../axiosInstance.ts";

export interface RegisterInformation {
    email: string;
    password: string;
    firstName: string|null;
    lastName: string|null;
    dateOfBirth: string|null;
}

export default async function register(registerInformation: RegisterInformation): Promise<boolean> {
    return api.post('/register', registerInformation);
}