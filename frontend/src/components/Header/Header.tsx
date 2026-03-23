import type {HeaderProps} from "./headerProps.ts";
import Nav from "../Nav/Nav.tsx"

export default function Header({newsType, setNewsType}: Readonly<HeaderProps>) {
    return (
        <header className="fixed top-0 z-50 w-full bg-white dark:bg-gray-900">
            <Nav newsType={newsType} setNewsType={setNewsType} />
        </header>
    )
}