import {createContext,} from "react";
import type {ThemeContextType} from "./themeContextType.ts";


export const ThemeContext = createContext<ThemeContextType>({theme: "dark", setTheme: () => {}});

