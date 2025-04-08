<?php

namespace App\Constants;

class FileInfo
{

    /*
    |--------------------------------------------------------------------------
    | File Information
    |--------------------------------------------------------------------------
    |
    | This class basically contain the path of files and size of images.
    | All information are stored as an array. Developer will be able to access
    | this info as method and property using FileManager class.
    |
    */

    public function fileInfo() {
        $data['default'] = [
            'path'      => 'assets/images/default.png',
        ];
        $data['extensions'] = [
            'path'      => 'assets/images/extensions',
            'size'      => '36x36',
        ];
        $data['errors'] = [
            'path'      => 'assets/images/errors',
            'size'      => '200x200',
        ];
        $data['extensions'] = [
            'path'      => 'assets/images/extensions',
            'size'      => '36x36',
        ];
        $data['userProfile'] = [
            'path'      => 'assets/front/images/profile',
            'size'      => '400x400',
        ];
        $data['homeImage'] = [
            'path'      => 'assets/front/images/home',
        ];
        $data['questionImage'] = [
            'path'      => 'assets/front/images/question',
        ];
        return $data;
	}

}
