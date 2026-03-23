import type {StoryElement} from "./storyElement.ts";

export interface StoryLine {
    [key: string]: StoryElement;
}