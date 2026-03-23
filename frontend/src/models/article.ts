import type {Image} from "./image.ts";
import type {Date} from "./date.ts";
import type {StoryLine} from "./storyLine.ts";

export interface Article {
    id?: number;
    storyType: string;
    headline?: string;
    image?: Image;
    kicker?: string;
    summary?: string;
    category?: string;
    author?: string;
    publishingDate?: Date;
    modificationDate?: Date;
    storyLine?: StoryLine;
}