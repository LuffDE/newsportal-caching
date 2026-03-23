import {Link, useParams} from "react-router-dom";
import {useState, useEffect} from "react";
import fetchArticle from "../../api/article/article.ts";
import {getFeatured} from "../../api/article/home.ts";
import type {Article} from "../../models/article.ts";
import {getImageUrl} from "../../api/image/requestImage.ts";
import RecommendedPopularNews from "./RecommendedPopularNews.tsx";
import StoryLine from "./StoryLine/StoryLine.tsx";

export default function ArticleDetail() {
    const articleId = useParams<{ id: string }>();

    const [article, setArticle] = useState<Article | null>(null);
    const [featuredArticles, setFeaturedArticles] = useState<Article[]>([])

    useEffect(() => {
        const loadArticle = async () => {
            const response = await fetchArticle(articleId)
            setArticle(response)
        }
        loadArticle().then()

        const loadFeatured = async () => {
            const response = await getFeatured()
            setFeaturedArticles(response)
        }
        loadFeatured().then()
    }, [articleId])

    if (!article) return (
        <div className="flex items-center justify-center dark:text-gray-200">
            Artikel konnte nicht gefunden werden.
        </div>
    );

    return (
        <div className="max-w-7xl mx-auto px-4 py-20">
            <nav className="flex mb-8" aria-label="Breadcrumb">
                <ol className="inline-flex items-center space-x-2">
                    <li className="inline-flex items-center">
                        <Link
                            to="/"
                            className="text-gray-600 dark:text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 flex space-x-2 items-center"
                        >
                            <span>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 16 16"
                                    fill="currentColor"
                                    className="size-4"
                                >
                                    <path
                                    d="M8.543 2.232a.75.75 0 0 0-1.085 0l-5.25 5.5A.75.75 0 0 0 2.75 9H4v4a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 1 1 2 0v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V9h1.25a.75.75 0 0 0 .543-1.268l-5.25-5.5Z"/>
                                </svg>
                            </span>
                            <span>Startseite</span>
                        </Link>
                    </li>
                    <li className="flex items-center">
                        <span className="mx-2 text-gray-400 dark:text-gray-600">/</span>
                        <Link
                            to={"/category/" + article.category?.toLowerCase() + "/"}
                            className="text-gray-600 dark:text-gray-600 hover:text-blue-500 dark:hover:text-blue-400">

                            {article.category && article.category.charAt(0).toUpperCase() + article.category.slice(1)}
                        </Link>
                    </li>
                    <li className="flex items-center">
                        <span className="mx-2 text-gray-400 dark:text-gray-600">/</span>
                        <span className="text-gray-800 dark:text-gray-200">{article.headline}</span>
                    </li>
                </ol>
            </nav>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div className="lg:col-span-2">
                    <article>
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                            {article.headline}
                        </h1>
                        <div className="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
                <span className="text-sm font-bold text-blue-500 dark:text-blue-400">
                  {article.category &&
                      article.category.charAt(0).toUpperCase() +
                      article.category.slice(1)}
                </span>

                            <span>
                  <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 16 16"
                      fill="currentColor"
                      className="size-4"
                  >
                    <path
                        d="M5.75 7.5a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5ZM5 10.25a.75.75 0 1 1 1.5 0 .75.75 0 0 1-1.5 0ZM10.25 7.5a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5ZM7.25 8.25a.75.75 0 1 1 1.5 0 .75.75 0 0 1-1.5 0ZM8 9.5A.75.75 0 1 0 8 11a.75.75 0 0 0 0-1.5Z"/>
                    <path
                        fillRule="evenodd"
                        d="M4.75 1a.75.75 0 0 0-.75.75V3a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2V1.75a.75.75 0 0 0-1.5 0V3h-5V1.75A.75.75 0 0 0 4.75 1ZM3.5 7a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v4.5a1 1 0 0 1-1 1h-7a1 1 0 0 1-1-1V7Z"
                        clipRule="evenodd"
                    />
                  </svg>
                </span>
                            <span>
                  {new Date(article.publishingDate?.date ?? "").toLocaleDateString("de-DE", {
                      day: "numeric",
                      month: "long",
                      year: "numeric",
                  })}
                </span>
                            <span>
                                <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" className="size-4" fill="currentColor">
                                    <g id="SVGRepo_bgCarrier" strokeWidth="0"></g>
                                    <g id="SVGRepo_tracerCarrier" strokeLinecap="round" strokeLinejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M16 15.503A5.041 5.041 0 1 0 16 5.42a5.041 5.041 0 0 0 0 10.083zm0 2.215c-6.703 0-11 3.699-11 5.5v3.363h22v-3.363c0-2.178-4.068-5.5-11-5.5z"></path>
                                    </g>
                                </svg>
                            </span>
                            <span>
                                <Link
                                    to={"/author/" + article.author?.toLowerCase() + "/"}
                                    className="text-blue-500 dark:text-blue-400 hover:text-blue-600 dark:hover:text-blue-500">
                                    {article.author}
                                </Link>
                            </span>
                        </div>
                        <img
                            src={getImageUrl(article.image)}
                            alt="Alt Text"
                            className="w-full h-[400px] object-cover rounded-lg mb-6"
                        />
                        <p className="text-white">{article.kicker}</p>
                        <StoryLine article={article} />
                    </article>
                </div>

                <div className="lg:col-span-1 w-full">
                    <div className="max-w-sm">
                        <RecommendedPopularNews featuredArticles={featuredArticles} />
                    </div>
                </div>
            </div>
            {/* TODO <Comment/>*/}
        </div>
    );
}