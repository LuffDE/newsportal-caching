import Login from "./Login.tsx";
import {useState} from "react";
import {isLoggedIn} from "../../services/User.ts";
import logout from "../../api/user/logout.ts";

export default function LoginButton() {
    const [seen, setSeen] = useState(false);

    function togglePopup() {
        setSeen(!seen);
    }

    function handleLogout() {
        logout();
        window.location.reload();
    }

    if (isLoggedIn()) {
        return (
            <div
                className="py-2 px-4 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition-colors duration-300 font-bold"
            >
                <button onClick={handleLogout}>Logout</button>
            </div>
        )
    }

    return (
        <div
            className="py-2 px-4 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition-colors duration-300 font-bold"
        >
            <button onClick={togglePopup}>Login</button>
            {seen ? <Login toggle={togglePopup} /> : null}
        </div>
    )
}