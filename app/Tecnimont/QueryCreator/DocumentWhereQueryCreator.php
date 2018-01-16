<?php

namespace App\Tecnimont\QueryCreator;

class DocumentWhereQueryCreator extends WhereQueryCreator
{
    protected $columns = [
        ['nipigaz_code', 'like'],
        ['tcm_code', 'like'],
        ['revision', '='],
        ['class', '='],
        ['reason', 'like'],
        ['english_title', 'like'],
        ['russian_title', 'like'],
        ['date_beg', '>=', 'issued_at'],
        ['date_end', '<=', 'issued_at'],
        ['transmittal', 'like'],
    ];

    protected $nameOfTable = 'docs';

}