import type {Image} from "./image.ts";

export type StoryElement =
    | {
    type: "HEADING" | "PARAGRAPH" | "QUOTE";
    content: string;
}
    | {
    type: "PICTURE_STORY_ELEMENT";
    content: Image;
};