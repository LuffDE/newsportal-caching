import type {Article} from "../../models/article.ts";
import {Link} from "react-router-dom";
import {getImageUrl} from "../../api/image/requestImage.ts";

interface ArticleBoxProps {
    article: Article;
}

export default function ArticleBox({article}: Readonly<ArticleBoxProps>) {
    const newsLink = `/news/${article.id}/` + encodeURIComponent(`${article.headline?.slice(0,30)}`);
    return (
        <Link
            key={article.id}
            to={newsLink}
            className="block hover:shadow-lg transition-shadow duration-200"
        >
            <div className="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden h-64 flex flex-col">
                <div className="w-full h-32 overflow-hidden">
                    <img
                        src={getImageUrl(article.image)}
                        alt="Alt Text"
                        className="w-full h-32 object-cover"
                    />
                </div>
                <div
                    className="p-4 flex flex-col grow ">
                    <h3 className="text-sm font-semibold text-gray-800 dark:text-white line-clamp-2 leading-tight">
                        {article.headline}
                    </h3>
                    <div
                        className="flex space-x-2 items-center mt-auto"
                    >
                        <span className="text-sm font-bold text-blue-500">
                            {article.category?.charAt(0).toUpperCase() ?? "" + article.category?.slice(1)}
                        </span>
                        <span>•</span>
                        <p
                            className="text-xs text-gray-500 dark:text-gray-400">
                            {
                                new Date(article.publishingDate?.date ?? "").toLocaleDateString("de-DE", {
                                    day: "numeric",
                                    month: "long",
                                    year: "numeric",
                                })
                            }
                        </p>
                    </div>
                </div>
            </div>
        </Link>
    );
}