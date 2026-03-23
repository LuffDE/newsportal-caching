import './App.css'
import Header from "./components/Header/Header.tsx";
import {getAll, getFeatured} from "./api/article/home.ts";
import {useEffect, useState} from "react";
import {ThemeProvider} from "./services/ThemeProvider.tsx";
import HeroSwiper from "./components/Hero/HeroSwiper.tsx";
import type {Article} from "./models/article.ts";
import Footer from "./components/Footer/Footer.tsx";
import PopularNews from "./components/Popular/PopularNews.tsx";
import ArticleGrid from "./components/ArticleGrid/ArticleGrid.tsx";

function App() {

    const [newsType, setNewsType] = useState('test')
    const [featuredArticles, setFeaturedArticles] = useState(Array<Article>)
    useEffect(() => {
        const fetchFeatured = async () => {
            const response = await getFeatured();
            setFeaturedArticles(response);
        }
        fetchFeatured().then();
    }, []);

    const [all, setAll] = useState(Array<Article>)
    useEffect(() => {
        const fetchAll = async () => {
            const response = await getAll();
            setAll(response);
        }
        fetchAll().then();
    }, []);

    return (
        <ThemeProvider>
            <div
                className="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300"
            >
                <Header newsType={newsType} setNewsType={setNewsType}/>
                <main>
                    <HeroSwiper featuredArticles={featuredArticles}/>
                    <PopularNews all={all}/>
                    <ArticleGrid all={all}/>
                </main>
                <Footer newsType={newsType} setNewsType={setNewsType}/>
            </div>
        </ThemeProvider>
    )
}

export default App
