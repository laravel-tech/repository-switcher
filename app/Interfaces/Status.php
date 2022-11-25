<?php
namespace App\Interfaces;

interface Status
{
    const STATUS_TRASHED    = 0;
    const STATUS_DRAFT      = 1;
    const STATUS_PENDING    = 2;
    const STATUS_SEO        = 3;
    const STATUS_REVIEW     = 4;
    const STATUS_SCHEDULED  = 5;
    const STATUS_PUBLISHED  = 6;
}
