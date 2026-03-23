import type {Dispatch, SetStateAction} from "react";

export interface ThemeContextType {
    theme: string;
    setTheme: Dispatch<SetStateAction<string>>;
}