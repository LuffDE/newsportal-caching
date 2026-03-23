import api from "../axiosInstance.ts";
import type {Article} from "../../models/article.ts";

export default async function fetchArticle(id: Readonly<Partial<{ id: string }>>): Promise<Article> {
    const res = await api.get<Article>('/article/' + id.id);
    return res.data;
}