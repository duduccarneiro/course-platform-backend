<?php

namespace App\Enums;

enum VideoStatus : string
{
    case UPLOADED = 'uploaded';
    case PROCESSING = 'processing';
    case SUCCESSFUL = 'successful';
    case FAILED = 'failed';

    public function getName() : string{
        return match($this) {
            self::UPLOADED => 'Uploaded',
            self::PROCESSING => 'Processing',
            self::SUCCESSFUL => 'Successful',
            self::FAILED => 'Failed',
            default => 'Unknown status'
        };
    }
}
