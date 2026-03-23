import type {Article} from "./article.ts";

export interface ArticlesResponse {
    featured: Article[];
    all: Article[];
}