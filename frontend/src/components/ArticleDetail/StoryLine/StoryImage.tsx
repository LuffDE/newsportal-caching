import {getImageUrl} from "../../../api/image/requestImage.ts";
import type {Image} from "../../../models/image.ts";

export interface ImageContent {
    image: Image|undefined;
}

export default function StoryImage(image: Readonly<ImageContent>) {
    return (
        <div className="prose dark:prose-invert max-w-none my-[1rem]">
            <img src={getImageUrl(image.image)} alt="Alt Text" className="w-full h-[400px] object-cover rounded-lg mb-6"/>
        </div>
    )
}