import {baseUrl} from "../axiosInstance.ts";
import type {Image} from "../../models/image.ts";

export function getImageUrl(image: Image|undefined) {
    if (!image) return "";
    if (!image.url) return baseUrl + "/image/media/not-found.jpg";
    return baseUrl + "/image" + image.url;
}