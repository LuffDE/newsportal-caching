import type {TextContent} from "./TextContent.ts";

export default function StoryParagraph(content: Readonly<TextContent>) {
    return(
        <div className="prose dark:prose-invert max-w-none mt-[1rem]">
            <p className="text-gray-700 dark:text-gray-300 leading-relaxed">
                {content.content}
            </p>
        </div>
    );
}