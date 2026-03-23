import type {Article} from "../../models/article.ts";
import PopularDetail from "./PopularDetail.tsx";

interface PopularNewsProps {
    all: Article[]
}

export default function PopularNews(news: Readonly<PopularNewsProps>) {
    const {all} = news;
    const articles = all.slice(0, 3);
    if (!articles.length) return null;

    return (
        <div className="max-w-7xl mx-[auto] px-4 py-8 dark:bg-gray-900">
            <h2 className="text-xl font-bold border-l-4 border-blue-500 pl-2 mb-6 dark:text-white">
                Empfohlene Nachrichten
            </h2>
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {articles.map((currentArticle, index) => (
                        <PopularDetail article={currentArticle} index={index} key={currentArticle.id} />
                ))}
            </div>
        </div>
    );
}