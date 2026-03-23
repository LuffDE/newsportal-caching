import {ThemeProvider} from "../../services/ThemeProvider.tsx";
import Header from "../Header/Header.tsx";
import Footer from "../Footer/Footer.tsx";
import {useState} from "react";
import ArticleDetail from "./ArticleDetail.tsx";

export default function ArticlePage() {
    const [newsType, setNewsType] = useState('test')

    return (
        <ThemeProvider>
            <div
                className="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300"
            >
                <Header newsType={newsType} setNewsType={setNewsType}/>
                <main>
                    <ArticleDetail />
                </main>
                <Footer newsType={newsType} setNewsType={setNewsType}/>
            </div>
        </ThemeProvider>
    )
}