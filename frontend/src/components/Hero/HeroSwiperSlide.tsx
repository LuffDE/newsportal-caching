import {Link} from "react-router-dom";
import {getImageUrl} from "../../api/image/requestImage.ts";
import type {Article} from "../../models/article.ts";

export default function HeroSwiperSlide({news}: Readonly<{ news: Article }>) {
    const newsLink = `/news/${news.id}/` + encodeURIComponent(`${news.headline?.slice(0,30)}`);
    return (
            <Link
                key={news.headline}
                to={newsLink}
            >
                <div
                    className="grid grid-cols-1 md:grid-cols-2 gap-6 items-center hover:bg-gray-100 dark:hover:bg-gray-800">
                    <div className="p-6">
                        <h2 className="text-2xl md:text-3xl font-medium mb-4 dark:text-white">
                            {news.headline}
                        </h2>
                        <p className="text-gray-700 dark:text-gray-300 mb-4">{news.kicker}</p>
                        <p className="text-gray-500 text-sm mb-4 flex items-center space-x-2">
                                        <span className="text-sm font-bold text-blue-500">
                                            {news.storyType.charAt(0).toUpperCase() + news.storyType.slice(1)}
                                        </span>
                            <span>•</span>

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                className="size-5"
                            >
                                <path
                                    d="M5.25 12a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H6a.75.75 0 0 1-.75-.75V12ZM6 13.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V14a.75.75 0 0 0-.75-.75H6ZM7.25 12a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H8a.75.75 0 0 1-.75-.75V12ZM8 13.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V14a.75.75 0 0 0-.75-.75H8ZM9.25 10a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H10a.75.75 0 0 1-.75-.75V10ZM10 11.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V12a.75.75 0 0 0-.75-.75H10ZM9.25 14a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H10a.75.75 0 0 1-.75-.75V14ZM12 9.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V10a.75.75 0 0 0-.75-.75H12ZM11.25 12a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H12a.75.75 0 0 1-.75-.75V12ZM12 13.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V14a.75.75 0 0 0-.75-.75H12ZM13.25 10a.75.75 0 0 1 .75-.75h.01a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75H14a.75.75 0 0 1-.75-.75V10ZM14 11.25a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 0 0 .75-.75V12a.75.75 0 0 0-.75-.75H14Z"/>
                                <path
                                    fillRule="evenodd"
                                    d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z"
                                    clipRule="evenodd"
                                />
                            </svg>

                            <span className="dark:text-gray-300">
                                            {new Date(news.publishingDate?.date ?? '').toLocaleDateString("de-DE", {
                                                day: "numeric",
                                                month: "long",
                                                year: "numeric",
                                            })}
                                        </span>
                        </p>
                            <span
                                className="text-blue-500 font-medium hover:underline flex items-center space-x-2"
                            >
                                Mehr lesen →
                            </span>
                    </div>
                    <div className="p-6 mb-4">
                        <img
                            src={getImageUrl(news.image)}
                            alt={news.image?.caption}
                            className="rounded-lg shadow-lg w-full aspect-video object-cover p-4"
                        />
                    </div>
                </div>
            </Link>
    )
}