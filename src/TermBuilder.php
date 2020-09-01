<?php

namespace Webike\Laravel\Fulltext;

class TermBuilder
{
    /**
     * @param $search
     * @return mixed
     */
    public static function terms($search)
    {
        $wildcards = config('laravel-fulltext.enable_wildcards');

        // Remove every boolean operator (+, -, > <, ( ), ~, *, ", @distance) from the search query
        // else we will break the MySQL query.
        $search = trim(preg_replace('/[+\-><\(\)~*\"@]+/', ' ', $search));

        $terms = collect(preg_split('/[\s,]+/', $search));

        if ($wildcards === true) {
            $terms->transform(function ($term) {
                return $term.'*';
            });
        }

        return $terms;
    }
}
