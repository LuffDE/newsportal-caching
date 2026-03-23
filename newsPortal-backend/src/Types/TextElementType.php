<?php

namespace App\Types;

enum TextElementType: string
{
    case PARAGRAPH = 'PARAGRAPH';
    case HEADING = 'HEADING';
    case QUOTE = 'QUOTE';
}
