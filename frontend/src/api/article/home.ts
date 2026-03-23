import api from "../axiosInstance.ts";
import type {ArticlesResponse} from "../../models/articlesResponse.ts";
import type {Article} from "../../models/article.ts";

let articlesPromise: Promise<ArticlesResponse>|null = null;

async function fetchArticles(): Promise<ArticlesResponse> {
    const res = await api.get<ArticlesResponse>('/articles');
    return res.data;
}

async function getArticles(): Promise<ArticlesResponse> {
    articlesPromise ??= fetchArticles();
    return articlesPromise;
}

export async function getFeatured(): Promise<Article[]> {
    const { featured } = await getArticles();
    return featured;
}

export async function getAll(): Promise<Article[]> {
    const { all } = await getArticles();
    return all;
}