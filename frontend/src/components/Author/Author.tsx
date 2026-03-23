import {ThemeProvider} from "../../services/ThemeProvider.tsx";
import Header from "../Header/Header.tsx";
import {useEffect, useState} from "react";
import Footer from "../Footer/Footer.tsx";
import AuthorInfo from "./AuthorInfo.tsx";
import type {Article} from "../../models/article.ts";
import {useParams} from "react-router-dom";
import RecommendedPopularNews from "../ArticleDetail/RecommendedPopularNews.tsx";
import getArticlesByAuthor from "../../api/article/author.ts";

export default function Author() {
    const [newsType, setNewsType] = useState<string>('')
    const [articles, setArticles] = useState<Article[]>([])
    const author = useParams<{name: string}>()

    useEffect(() => {
        if (articles.length > 0 && author.name === articles[0].author) return;
        const fetchArticles = async () => {
            const res = await getArticlesByAuthor(author.name);
            console.log(res);
            setArticles(res);
        }
        fetchArticles().then();
    })

    return (
        <ThemeProvider>
            <Header newsType={newsType} setNewsType={setNewsType}/>
            <main className="mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-white dark:bg-gray-900 transition-colors duration-300">
                <div
                    className="max-w-7xl mx-auto px-4 py-20"
                >
                    <AuthorInfo/>
                    <RecommendedPopularNews featuredArticles={articles} headline={"Artikel von " + author.name}/>
                </div>
            </main>
            <Footer newsType={newsType} setNewsType={setNewsType}/>
        </ThemeProvider>
    )
}