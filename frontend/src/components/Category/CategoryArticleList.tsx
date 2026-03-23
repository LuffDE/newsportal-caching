import {useParams} from "react-router-dom";
import getArticlesByCategory from "../../api/article/category.ts";
import {useEffect, useState} from "react";
import type {Article} from "../../models/article.ts";
import Header from "../Header/Header.tsx";
import Footer from "../Footer/Footer.tsx";
import {ThemeProvider} from "../../services/ThemeProvider.tsx";
import RecommendedPopularNews from "../ArticleDetail/RecommendedPopularNews.tsx";

export default function CategoryArticleList() {
    const category = useParams<{category: string}>();
    const [newsType, setNewsType] = useState(category.category ?? "")
    const [articles, setArticles] = useState<Article[]>([])

    useEffect(() => {
        if (articles.length > 0 && category.category === articles[0].category) return;
        const fetchArticles = async () => {
            const res = await getArticlesByCategory(category.category);
            setArticles(res);
        }
        fetchArticles().then();
    })

    return (
        <ThemeProvider>
            <div
                className="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300"
            >
                <Header newsType={newsType} setNewsType={setNewsType}/>
                <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <RecommendedPopularNews featuredArticles={articles} headline={category.category}/>
                </main>
                <Footer newsType={newsType} setNewsType={setNewsType}/>
            </div>
        </ThemeProvider>
    )

}