import type {Article} from "../../models/article.ts";
import {Link} from "react-router-dom";
import {getImageUrl} from "../../api/image/requestImage.ts";

interface PopularDetailProps {
    article: Article;
    index: number;
}

export default function PopularDetail(info: Readonly<PopularDetailProps>) {
    const {article, index} = info;
    const newsLink = `/news/${article.id}/` + encodeURIComponent(`${article.headline?.slice(0,30)}`);
    return (
        <Link
            key={article.headline}
            to={newsLink}
            className="block hover:shadow-lg transition-shadow duration-200"
        >
            <div
                key={article.id}
                className="flex items-start space-x-4 dark:bg-gray-800 bg-white rounded-lg shadow-md overflow-hidden"
            >
                <div className="relative">
                    <img
                        src={getImageUrl(article.image)}
                        alt="Alt Text"
                        className="rounded-lg w-48 h-32 object-cover"
                    />
                    <span
                        className="absolute top-0 left-0 bg-blue-900 text-white text-sm w-6 h-6 rounded-full flex items-center justify-center">
                  {index + 1}
                </span>
                </div>
                <div className="flex-1">
                <span className="text-blue-500 text-sm font-medium hover:underline">
                  {article.category}
                </span>
                    <h3 className="text-sm font-semibold text-gray-800 dark:text-white leading-tight mt-1">
                        {article.headline}
                    </h3>
                    <div className="flex space-x-2 items-center inset-x-0 bottom-0 ">
                  <span className="text-sm font-bold text-blue-500">
                    {article.storyType.charAt(0).toUpperCase() + article.storyType.slice(1)}
                  </span>
                        <span>•</span>
                        <p className="text-xs text-gray-500 dark:text-gray-400">
                            {new Date(article.publishingDate?.date ?? "").toLocaleDateString("de-DE", {
                                day: "numeric",
                                month: "long",
                                year: "numeric",
                            })}
                        </p>
                    </div>
                </div>
            </div>
        </Link>
    )
}