import React, { useState } from "react";
import {Link} from "react-router-dom";
import login from "../../api/user/login.ts";

type LoginProps = {
    toggle: () => void;
};

const Login: React.FC<LoginProps> = ({ toggle }) => {
    const [username, setUsername] = useState<string>("");
    const [password, setPassword] = useState<string>("");
    const [error, setError] = useState<string|null>(null);

    const handleLogin = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        const success = await login(username, password);
        if (success) {
            toggle();
        }
        else {
            setError("Login fehlgeschlagen");
        }
    };

    return (
        <dialog className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 m-auto">
            <div className="w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl">
                <h2 className="mb-4 text-xl font-semibold">Login</h2>
                {error && (
                    <div className="mb-4 text-red-500">
                        {error}
                    </div>
                )}
                <form onSubmit={handleLogin} className="space-y-4">
                    <label className="block">
                        <span className="mb-1 block text-sm">E-Mail</span>
                        <input
                            type="email"
                            value={username}
                            onChange={(e) => setUsername(e.target.value)}
                            className="w-full rounded-md border px-3 py-2 outline-none focus:ring"
                            required
                            autoComplete={"email"}
                            autoFocus
                        />
                    </label>
                    <label className="block">
                        <span className="mb-1 block text-sm">Passwort</span>
                        <input
                            type="password"
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                            className="w-full rounded-md border px-3 py-2 outline-none focus:ring"
                            required
                        />
                    </label>
                    <div className="mt-6 flex items-center justify-end gap-2">
                        <button
                            type="button"
                            onClick={toggle}
                            className="rounded-md border px-4 py-2 hover:bg-gray-200"
                        >
                            Schließen
                        </button>
                        <button
                            type="submit"
                            className="rounded-md bg-blue-500 hover:bg-blue-600 px-4 py-2 text-white"
                        >
                            Login
                        </button>
                        <Link
                            to="/register">
                            <button
                                type="button"
                                className="rounded-md border px-4 py-2 bg-green-700 hover:bg-green-800 text-white"
                            >
                                Registrieren
                            </button>
                        </Link>
                    </div>
                </form>
            </div>
        </dialog>
    );
};

export default Login;
