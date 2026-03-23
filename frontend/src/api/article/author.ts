import api from "../axiosInstance.ts";
import type {Article} from "../../models/article.ts";

let articlesPromise: Promise<Article[]>|null = null;

async function fetchByAuthor(author: string|undefined): Promise<Article[]> {
    const res = await api.get<Article[]>('/articles/author/' + encodeURIComponent(author?.toLowerCase() ?? ""));
    return res.data;
}

async function getArticles(author: string|undefined): Promise<Article[]> {
    articlesPromise ??= fetchByAuthor(author);
    return articlesPromise;
}

export default async function getArticlesByAuthor(author: string|undefined): Promise<Article[]> {
    return await getArticles(author);
}
