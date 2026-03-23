<?php

namespace App\Types;

enum StoryType: string
{
    case NEWS = 'news';
    case ARTICLE = 'article';
    case VIDEO = 'video';
    case AUDIO = 'audio';
}
