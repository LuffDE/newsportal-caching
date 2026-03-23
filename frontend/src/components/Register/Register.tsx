import {ThemeProvider} from "../../services/ThemeProvider.tsx";
import Header from "../Header/Header.tsx";
import Footer from "../Footer/Footer.tsx";
import React, {useState} from "react";
import register from "../../api/user/register.ts";
import login from "../../api/user/login.ts";

export default function Register() {
    const [newsType, setNewsType] = useState<string>("")
    const [error, setError] = useState<string|null>(null);
    const [email, setEmail] = useState<string>("");
    const [password, setPassword] = useState<string>("");
    const [password2, setPassword2] = useState<string>("");
    const [firstName, setFirstName] = useState<string|null>();
    const [lastName, setLastName] = useState<string|null>();
    const [birthDate, setBirthDate] = useState<string|null>();


    const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        if (password !== password2) {
            setError("Passwort stimmt nicht überein");
            return;
        }
        const success = await register({
            email: email,
            password: password,
            firstName: firstName ?? null,
            lastName: lastName ?? null,
            dateOfBirth: birthDate ?? null,
        });

        if (success) {
            setError(null);
            await login(email, password);
            window.location.replace(
                "/"
            )
        }
        else {
            setError("Registrierung fehlgeschlagen");
        }
    }

    return (
        <ThemeProvider>
            <Header newsType={newsType} setNewsType={setNewsType}/>
            <main>
                <section
                    className="flex flex-col items-center justify-center min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300"
                >
                    <h1
                        className="text-4xl font-bold text-center text-gray-800 dark:text-white mb-4"
                    >Registrierung</h1>
                    <p className="text-center text-gray-600 dark:text-gray-400 mb-4">
                        Hier kann ein Infotext mit Verlinkungen zu den rechtlich vorgeschriebenen Unterseiten stehen.
                    </p>
                    {error && (
                        <div className="mb-4 text-red-500">
                            {error}
                        </div>
                    )}
                    <form
                        onSubmit={handleSubmit}
                        className="flex flex-col w-200"
                    >
                        <input
                            type="email"
                            placeholder="E-Mail"
                            onChange={(e) => setEmail(e.target.value)}
                            required={true}
                            className="mb-4 rounded-md border px-3 py-2 outline-none focus:ring bg-white mt-4 dark:bg-gray-800 dark:text-white dark:border-gray-700"
                        />
                        <input
                            type="password"
                            placeholder="Passwort"
                            onChange={(e) => setPassword(e.target.value)}
                            required={true}
                            className="mb-4 rounded-md border px-3 py-2 outline-none focus:ring bg-white mt-4 dark:bg-gray-800 dark:text-white dark:border-gray-700"
                        />
                        <input
                            type="password"
                            placeholder="Passwort wiederholen"
                            onChange={(e) => setPassword2(e.target.value)}
                            required={true}
                            className="mb-4 rounded-md border px-3 py-2 outline-none focus:ring bg-white mt-4 dark:bg-gray-800 dark:text-white dark:border-gray-700"
                        />
                        <input
                            type="text"
                            placeholder="Vorname"
                            onChange={(e) => setFirstName(e.target.value)}
                            required={true}
                            className="mb-4 rounded-md border px-3 py-2 outline-none focus:ring bg-white mt-4 dark:bg-gray-800 dark:text-white dark:border-gray-700"
                        />
                        <input
                            type="text"
                            placeholder="Nachname"
                            onChange={(e) => setLastName(e.target.value)}
                            required={true}
                            className="mb-4 rounded-md border px-3 py-2 outline-none focus:ring bg-white mt-4 dark:bg-gray-800 dark:text-white dark:border-gray-700"
                        />
                        <input
                            type={"date"}
                            placeholder="Geburtsdatum"
                            onChange={(e) => setBirthDate(e.target.value)}
                            required={true}
                            className="mb-4 rounded-md border px-3 py-2 outline-none focus:ring bg-white mt-4 dark:bg-gray-800 dark:text-white dark:border-gray-700"
                        />
                        <input
                            type="submit"
                            value="Registrieren"
                            className="mb-4 rounded-md border px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white mt-4 dark:bg-gray-800 dark:text-white dark:border-gray-700"
                        />
                    </form>
                </section>
            </main>
            <Footer newsType={newsType} setNewsType={setNewsType}/>
        </ThemeProvider>
    )
}