<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
//    ファイル名の桁数
    const FILENAME_LENGTH = 12;

    // public function __construct(array $attributes = [])
    // {
    //     parent::__construct($attributes);
    //
    //     if (! array_get($this->attributes, 'filename')) {
    //         $this->getRandomFileName();
    //     }
    // }

    /**
     * ランダムなファイルネームを生成する
     * @return string
     */
    public function getRandomFileName()
    {
        $characters = array_merge(
            range(0, 9), range('a', 'z'),
            range('A', 'Z'), ['-', '_']
        );

        $length = count($characters);

        $rand_filename = "";

        for ($i = 0; $i < self::FILENAME_LENGTH; $i++) {
            $rand_filename .= $characters[random_int(0, $length - 1)];
        }

        return $rand_filename;
    }
}
