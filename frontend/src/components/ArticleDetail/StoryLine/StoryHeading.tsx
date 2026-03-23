import type {TextContent} from "./TextContent.ts";

export default function StoryHeading(content: Readonly<TextContent>) {
    return (
        <div className="prose dark:prose-invert max-w-none mt-[1rem]">
            <h3 className="text-gray-700 dark:text-gray-300 leading-relaxed">
                {content.content}
            </h3>
        </div>
    );
}