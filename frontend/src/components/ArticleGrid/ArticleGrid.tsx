import type {Article} from "../../models/article.ts";
import React, {useEffect, useMemo, useRef, useState} from "react";
import ArticleBox from "./ArticleBox.tsx";
import useDebounceValue from "../../services/Debounce.ts";
import {articleSearch} from "../../api/article/articleSearch.ts";

interface ArticleGridProps {
    all: Article[];
}

export default function ArticleGrid(articles: Readonly<ArticleGridProps>) {
    const itemsPerPage = 8;
    const newsData = articles.all.slice(3);

    const [currentPage, setCurrentPage] = useState(1);
    const [searchKeyword, setSearchKeyword] = useState("");
    const [foundArticles, setFoundArticles] = useState<Article[]>([]);
    const debounceQuery = useDebounceValue(searchKeyword, 400);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState<null | string>(null);

    const cacheRef = useRef<Map<string, Article[]>>(new Map());
    const abortRef = useRef<AbortController | null>(null);
    const canSearch = useMemo(() => debounceQuery.trim().length > 2, [debounceQuery]);

    const totalItems = newsData.length || 0;
    const totalPages = Math.ceil(totalItems / itemsPerPage);

    useEffect(() => {
        if (!canSearch) {
            if (foundArticles.length === 0 && newsData.length > 0) {
                setFoundArticles(newsData);
            }
            setLoading(false);
            abortRef.current?.abort();
            return;
        }

        const cached = cacheRef.current.get(searchKeyword.trim());
        if (cached) {
            setFoundArticles(cached);
            setError(null);
            setLoading(false);
            abortRef.current?.abort();
            return;
        }

        setLoading(true);
        setError(null);

        abortRef.current?.abort();
        const controller = new AbortController();
        abortRef.current = controller;

        articleSearch(searchKeyword, controller.signal)
            .then((articles) => {
                cacheRef.current.set(searchKeyword.trim(), articles);
                setFoundArticles(articles);
            })
            .catch((err: unknown) => {
                if ((err as Error)?.name === "AbortError") return;
                setError((err as Error).message ?? "Unbekannter Fehler");
            })
            .finally(() => {
                if (!controller.signal.aborted) setLoading(false);
            });
        return () => controller.abort();
    }, [searchKeyword, canSearch, newsData]);

    if (!newsData.length)
        return (
            <div className="flex items-center justify-center">
                Keine Nachrichten gefunden.
            </div>
        );





    const handlePageChange = (page: number) => {
        if (page >= 1 && page <= totalPages) {
            setCurrentPage(page);
        }
    };

    const currentItems = foundArticles.slice(
        (currentPage - 1) * itemsPerPage,
        currentPage * itemsPerPage
    );

    const handleSearch = (e: React.ChangeEvent<HTMLInputElement>) => {
        setSearchKeyword(e.target.value);
        setCurrentPage(1);
    };

    return (
        <section className="max-w-7xl mx-auto px-4 py-8 dark:bg-gray-900">
            <div className="flex justify-between items-center mb-6">
                <h2 className="text-xl font-bold border-l-4 border-blue-500 pl-2 dark:text-white">
                    Vorgeschlagene Nachrichten
                </h2>
                <div className="relative">
                    <input
                        type="text"
                        value={searchKeyword}
                        onChange={handleSearch}
                        placeholder="Artikel suchen..."
                        className="border border-gray-300 dark:text-white dark:bg-gray-700 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                    <span className="absolute inset-y-0 right-4 flex items-center text-gray-400">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                strokeWidth="1.5"
                stroke="currentColor"
                className="size-6"
            >
              <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
              />
            </svg>
          </span>
                </div>
            </div>
            {loading && <p role="note" className="text-white">Suche läuft…</p>}
            {error && !loading && (
                <p role="alert" className="text-red-600">
                    Fehler: {error}
                </p>
            )}
            {!loading && !error && canSearch && foundArticles.length === 0 && (
                <p role="note" className="text-white">Keine Treffer für „{searchKeyword}“.</p>
            )}

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {currentItems?.map((news) => (
                    <ArticleBox article={news} key={news.id} />
                ))}
            </div>

            <div className="flex justify-between items-center mt-8 space-x-2">
                <div className="flex items-center">
                    <p className="text-sm font-medium text-gray-400">
                        Zeige {currentItems.length} von {totalItems} Nachrichten.
                    </p>
                </div>
                <div className="flex items-center justify-center">
                    <button
                        onClick={() => handlePageChange(currentPage - 1)}
                        disabled={currentPage === 1}
                        className="px-3 py-1 text-gray-600 hover:bg-gray-200 hover:text-blue-500 disabled:text-gray-400 dark:text-white dark:hover:text-white dark:hover:bg-gray-800 dark:disabled:text-gray-600"
                    >
                        ← Vorherige
                    </button>

                    {[...Array(totalPages)].map((_, index) => {
                        const pageNumber = index + 1;

                        if (
                            totalPages > 7 &&
                            pageNumber !== 1 &&
                            pageNumber !== totalPages &&
                            (pageNumber < currentPage - 1 || pageNumber > currentPage + 1)
                        ) {
                            if (pageNumber === 2 || pageNumber === totalPages - 1) {
                                return <span key={pageNumber}>...</span>;
                            }
                            return null;
                        }

                        return (
                            <button
                                key={pageNumber}
                                onClick={() => handlePageChange(pageNumber)}
                                className={`w-8 h-8 flex items-center justify-center rounded-md
                  ${
                                    currentPage === pageNumber
                                        ? "bg-blue-800 text-white dark:text-white dark:bg-gray-700"
                                        : "text-gray-600 hover:text-blue-500 hover:bg-gray-200 dark:text-gray-600 dark:hover:text-gray-600 dark:hover:bg-gray-200"
                                }`}
                            >
                                {pageNumber}
                            </button>
                        );
                    })}

                    <button
                        onClick={() => handlePageChange(currentPage + 1)}
                        disabled={currentPage === totalPages}
                        className="px-3 py-1 text-gray-600 hover:bg-gray-200 hover:text-blue-500 disabled:text-gray-400 dark:text-white dark:hover:text-white dark:hover:bg-gray-800 dark:disabled:text-gray-600"
                    >
                        Nächste →
                    </button>
                </div>
            </div>
        </section>
    );
}