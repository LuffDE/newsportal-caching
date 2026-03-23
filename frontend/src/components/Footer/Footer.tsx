import { Link } from "react-router-dom";
import logo from "../../assets/logo-white.svg";
import type {HeaderProps} from "../Header/headerProps.ts";

const Footer = ({newsType, setNewsType}: HeaderProps) => {
    const handleNavClick = (type: string) => {
        setNewsType(type);
    };

    const getLinkClassNames = (type: string) => {
        return `block py-2 pr-4 pl-3 rounded md:p-0 ${
            newsType === type
                ? `text-blue-500} dark:text-blue-500`
                : `text-gray-800 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white`
        }`;
    };

    return (
        <footer className="bg-slate-800 dark:bg-gray-800 text-white py-12 px-6">
            <div className="container mx-auto">
                <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div className="space-y-4">
                        <div className="flex items-center space-x-2">
                            <div className="h-10 w-10">
                                <img src={logo} alt="logo" />
                            </div>
                            <h2 className="text-2xl font-bold">Newsportal Caching</h2>
                        </div>
                        <p className="text-sm">© 2025</p>

                        <div className="mt-4">
                            <h3 className="text-lg font-semibold mb-4">Social Media</h3>
                            <div className="flex space-x-4">
                                <Link
                                    to="https://youtube.com"
                                    className="hover:text-blue-400"
                                    aria-label="YouTube Link"
                                    target="_blank"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        strokeWidth="2"
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        className="lucide lucide-youtube"
                                    >
                                        <path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17" />
                                        <path d="m10 15 5-3-5-3z" />
                                    </svg>
                                </Link>
                                <Link
                                    to="https://instagram.com"
                                    className="hover:text-blue-400"
                                    aria-label="Instagram Link"
                                    target="_blank"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        strokeWidth="2"
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        className="lucide lucide-instagram"
                                    >
                                        <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                        <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                                    </svg>
                                </Link>
                                <Link
                                    to="https://facebook.com"
                                    className="hover:text-blue-400"
                                    aria-label="Facebook Link"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        strokeWidth="2"
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        className="lucide lucide-facebook"
                                    >
                                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                                    </svg>
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 className="text-lg font-semibold mb-4">Suchen</h3>
                        <ul className="space-y-2">
                            {[
                                "News",
                                "Unterhaltung",
                                "Technologie",
                                "Wirtschaft",
                                "Sport",
                                "National",
                                "International",
                            ].map((type) => (
                                <li key={type}>
                                    <Link
                                        to={`#${type}`}
                                        onClick={() => handleNavClick(type)}
                                        className={getLinkClassNames(type)}
                                    >
                                        {type.charAt(0).toUpperCase() + type.slice(1)}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </div>

                    <div>
                        <h3 className="text-lg font-semibold mb-4">Hilfe</h3>
                        <ul className="space-y-2">
                            <li>
                                <Link to="/contact" className="hover:text-blue-400">
                                    Kontakt
                                </Link>
                            </li>
                            <li>
                                <Link to="/agb" className="hover:text-blue-400">
                                    Allgemeine Geschäftsbedingungen
                                </Link>
                            </li>
                            <li>
                                <Link to="/impressum" className="hover:text-blue-400">
                                    Impressum
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h3 className="text-lg font-semibold mb-4">
                            Die neuesten Nachrichten im Newsletter
                        </h3>
                        <div className="flex">
                            <input
                                type="email"
                                placeholder="Ihre E-Mail Adresse"
                                className="px-4 py-2 rounded-l-md text-gray-800 dark:text-white dark:bg-gray-700 w-full"
                            />
                            <button
                                className="bg-blue-500 px-4 py-2 rounded-r-md hover:bg-blue-600"
                                id="anmelden"
                                aria-label="anmelden"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    className="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    );
};

export default Footer;