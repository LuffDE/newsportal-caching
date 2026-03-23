import * as React from "react";
import type {SetStateAction} from "react";

export interface HeaderProps {
    newsType: string;
    setNewsType: React.Dispatch<SetStateAction<string>>;
}