<?php

namespace App;

class Validator
{
    public function __construct()
    {
    }
    public function validateUrl(string $url): true
    {
        $validator = new \Valitron\Validator(['url' => $url]);
        $validator->rules([
            'url' => ['url'],
            'lengthMax' => [
                ['url', 255]
            ]
        ]);
        if ($validator->validate()) {
            return true;
        }
        throw new \Exception('Некорректный URL');
    }
}