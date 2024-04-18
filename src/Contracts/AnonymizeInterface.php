<?php

namespace will2therich\LaravelModelAnonymizer\Contracts;

interface AnonymizeInterface
{
    public static function anonymize(\Illuminate\Database\Eloquent\Model $model);

}