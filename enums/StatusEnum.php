<?php

namespace app\enums;

enum StatusEnum: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case APPROVED = 'approved';
    case DECLINED = 'declined';
}
