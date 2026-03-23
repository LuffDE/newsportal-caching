import type {Article} from "../../../models/article.ts";
import StoryHeading from "./StoryHeading.tsx";
import StoryImage from "./StoryImage.tsx";
import StoryParagraph from "./StoryParagraph.tsx";
import StoryQuote from "./StoryQuote.tsx";
import React from "react";

export interface StoryLineProps {
    article: Article;
}


export default function StoryLine({ article }: Readonly<StoryLineProps>) {
    const news = article;
    if (!news.storyLine) return null;

    const components: React.ReactNode[] = [];
    const storyLine = news.storyLine;

    for (const key in storyLine) {
        const sorting = parseInt(key);
        const storyElement = storyLine[key];

        if (storyElement.type === "PARAGRAPH") {
            components[sorting] = (
                <StoryParagraph key={sorting} content={storyElement.content} />
            )
        } else if (storyElement.type === "HEADING") {
            components[sorting] = (
                <StoryHeading key={sorting} content={storyElement.content} />
            );
        } else if (storyElement.type === "PICTURE_STORY_ELEMENT") {
            components[sorting] = (
                <StoryImage key={sorting} image={storyElement.content} />
            );
        } else if (storyElement.type === "QUOTE") {
            components[sorting] = (
                <StoryQuote key={sorting} content={storyElement.content} />
            );
        }
    }

    return <>{components}</>;
}