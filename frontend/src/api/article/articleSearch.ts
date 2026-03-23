import api from "../axiosInstance.ts";
import type {Article} from "../../models/article.ts";

export async function articleSearch(query: string, signal?: AbortSignal): Promise<Article[]> {
    if (!query.trim()) return [];

    const res = await api.get<Article[]>(`/article/search/${query}`, {signal: signal});
    if (!res.data) throw new Error("HTTP Error: " + res.status);
    return res.data;
}