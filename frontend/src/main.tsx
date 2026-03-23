import {StrictMode} from 'react'
import {createRoot} from 'react-dom/client'
import './index.css'
import './App.css'
import App from './App.tsx'
import {createBrowserRouter, RouterProvider} from "react-router-dom";
import ArticlePage from "./components/ArticleDetail/ArticlePage.tsx";
import CategoryArticleList from "./components/Category/CategoryArticleList.tsx";
import Register from "./components/Register/Register.tsx";
import Author from "./components/Author/Author.tsx";

const router = createBrowserRouter([
    {path: '/', element: <App/>},
    {path: '/news/:id/:headline', element: <ArticlePage/>},
    {path: '/category/:category', element: <CategoryArticleList/>},
    {path: '/register', element: <Register/>},
    {path: '/author/:name', element: <Author/>}
])

createRoot(document.getElementById('root')!).render(
    <StrictMode>
        <RouterProvider router={router}/>
    </StrictMode>,
)
