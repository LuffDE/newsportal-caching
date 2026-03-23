import type {Article} from "../../models/article.ts";
import PopularDetail from "../Popular/PopularDetail.tsx";


interface RecommendedArticlesProps {
    featuredArticles: Article[]
    headline?: string;
}


export default function RecommendedPopularNews(articles: Readonly<RecommendedArticlesProps>) {
    const featuredNews = articles.featuredArticles;
    const headline = articles.headline ? articles.headline.charAt(0).toUpperCase() + articles.headline.slice(1) : "Empfohlene Nachrichten";
    return (
        <div className="max-w-7xl mx-auto px-4 py-8">
            <h2 className="text-xl font-bold border-l-4 border-blue-500 pl-2 mb-6 text-gray-900 dark:text-white">
                {headline}
            </h2>
            <div className="flex flex-col space-y-6">
                {featuredNews.map((news, index) => (
                    <PopularDetail article={news} index={index} key={news.id}/>
                ))}
            </div>
        </div>
    );
}
