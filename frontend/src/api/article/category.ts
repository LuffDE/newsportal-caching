import api from "../axiosInstance.ts";
import type {Article} from "../../models/article.ts";

let articlesPromise: Promise<Article[]>|null = null;

async function fetchByCategory(category: string|undefined): Promise<Article[]>
{
    const res = await api.get<Article[]>('/articles/category/' + (category?.toLowerCase() ?? ""));
    return res.data;
}

async function getArticles(category: string|undefined): Promise<Article[]> {
    articlesPromise ??= fetchByCategory(category);
    return articlesPromise;
}

export default async function getArticlesByCategory(category: string|undefined) {
    return await getArticles(category);
}
