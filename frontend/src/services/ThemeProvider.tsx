import {type ReactNode, useEffect, useMemo, useState} from "react";
import {ThemeContext} from "./ThemeContext.tsx";

interface ThemeProviderProps {
    children: ReactNode;
}

export function ThemeProvider({children}: Readonly<ThemeProviderProps>) {
    const [theme, setTheme] = useState<string>(() => {
        if (typeof window !== "undefined") {
            const savedTheme = localStorage.getItem("theme");
            if (savedTheme) {
                return savedTheme;
            }
            return window.matchMedia("(prefers-color-scheme)").matches
                ? "dark"
                : "light";
        }
        return "light";
    });

    useEffect(() => {
        const root = window.document.documentElement;
        root.classList.remove("light", "dark");
        root.classList.add(theme);
        localStorage.setItem("theme", theme);
    }, [theme]);

    return (
        <ThemeContext.Provider value={useMemo(() => ({theme, setTheme}), [theme, setTheme])}>
            {children}
        </ThemeContext.Provider>
    );
}