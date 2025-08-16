<?php

use App\Support\Crypt\Crypt;

if (!function_exists('getEnumValues')) {
    function getEnumValues(string $enum): array
    {
        return array_map(static function (object $value) {
            return $value->value;
        }, $enum::cases());
    }
}

if (!function_exists('getEnumKeys')) {
    function getEnumKeys(string $enum): array
    {
        return array_map(static function (object $value) {
            return $value->name;
        }, $enum::cases());
    }
}

if (!function_exists('xcrypt')) {
    function xcrypt(string $value): string
    {
        return new Crypt()->crypt($value);
    }
}

if (!function_exists('xdecrypt')) {
    function xdecrypt(string $value): string
    {
        return new Crypt()->decrypt($value);
    }
}

if (!function_exists('xcryptToUUIDv4')) {
    function xcryptToUUIDv4(string $value): string
    {
        return new Crypt()->cryptToUUIDv4($value);
    }
}

if (!function_exists('infoBinaryFile')) {
    function infoBinaryFile(string $content): object
    {
        $file = $content;
        $info = finfo_open();
        $mime = finfo_buffer($info, $file, FILEINFO_MIME_TYPE);
        $size = (int)ceil((strlen($content) * 3 / 4) / 1024);

        $ext = "bin";
        switch ($mime) {
            case 'audio/aac':
                $ext = '.aac';
                break;
            case 'application/x-abiword':
                $ext = '.abw';
                break;
            case 'application/x-freearc':
                $ext = '.arc';
                break;
            case 'image/avif':
                $ext = '.avif';
                break;
            case 'video/x-msvideo':
                $ext = '.avi';
                break;
            case 'application/vnd.amazon.ebook':
                $ext = '.azw';
                break;
            case 'application/octet-stream':
                $ext = '.bin';
                break;
            case 'image/bmp':
                $ext = '.bmp';
                break;
            case 'application/x-bzip':
                $ext = '.bz';
                break;
            case 'application/x-bzip2':
                $ext = '.bz2';
                break;
            case 'application/x-cdf':
                $ext = '.cda';
                break;
            case 'application/x-csh':
                $ext = '.csh';
                break;
            case 'text/css':
                $ext = '.css';
                break;
            case 'text/csv':
                $ext = '.csv';
                break;
            case 'application/msword':
                $ext = '.doc';
                break;
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                $ext = '.docx';
                break;
            case 'application/vnd.ms-fontobject':
                $ext = '.eot';
                break;
            case 'application/epub+zip':
                $ext = '.epub';
                break;
            case 'application/gzip':
                $ext = '.gz';
                break;
            case 'image/gif':
                $ext = '.gif';
                break;
            case 'text/html':
                $ext = '.html';
                break;
            case 'image/vnd.microsoft.icon':
                $ext = '.ico';
                break;
            case 'text/calendar':
                $ext = '.ics';
                break;
            case 'application/java-archive':
                $ext = '.jar';
                break;
            case 'image/jpeg':
                $ext = '.jpg';
                break;
            case 'text/javascript (Specifications: HTML and RFC 9239)':
                $ext = '.js';
                break;
            case 'application/json':
                $ext = '.json';
                break;
            case 'application/ld+json':
                $ext = '.jsonld';
                break;
            case 'audio/midi, audio/x-midi':
                $ext = '.mid';
                break;
            case 'text/javascript':
                $ext = '.mjs';
                break;
            case 'audio/mpeg':
                $ext = '.mp3';
                break;
            case 'video/mp4':
                $ext = '.mp4';
                break;
            case 'video/mpeg':
                $ext = '.mpeg';
                break;
            case 'application/vnd.apple.installer+xml':
                $ext = '.mpkg';
                break;
            case 'application/vnd.oasis.opendocument.presentation':
                $ext = '.odp';
                break;
            case 'application/vnd.oasis.opendocument.spreadsheet':
                $ext = '.ods';
                break;
            case 'application/vnd.oasis.opendocument.text':
                $ext = '.odt';
                break;
            case 'audio/ogg':
                $ext = '.oga';
                break;
            case 'video/ogg':
                $ext = '.ogv';
                break;
            case 'application/ogg':
                $ext = '.ogx';
                break;
            case 'audio/opus':
                $ext = '.opus';
                break;
            case 'font/otf':
                $ext = '.otf';
                break;
            case 'image/png':
                $ext = '.png';
                break;
            case 'application/pdf':
                $ext = '.pdf';
                break;
            case 'application/x-httpd-php':
                $ext = '.php';
                break;
            case 'application/vnd.ms-powerpoint':
                $ext = '.ppt';
                break;
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                $ext = '.pptx';
                break;
            case 'application/vnd.rar':
                $ext = '.rar';
                break;
            case 'application/rtf':
                $ext = '.rtf';
                break;
            case 'application/x-sh':
                $ext = '.sh';
                break;
            case 'image/svg+xml':
                $ext = '.svg';
                break;
            case 'application/x-tar':
                $ext = '.tar';
                break;
            case 'image/tiff':
                $ext = '.tif';
                break;
            case 'video/mp2t':
                $ext = '.ts';
                break;
            case 'font/ttf':
                $ext = '.ttf';
                break;
            case 'text/plain':
                $ext = '.txt';
                break;
            case 'application/vnd.visio':
                $ext = '.vsd';
                break;
            case 'audio/wav':
                $ext = '.wav';
                break;
            case 'audio/webm':
                $ext = '.weba';
                break;
            case 'video/webm':
                $ext = '.webm';
                break;
            case 'image/webp':
                $ext = '.webp';
                break;
            case 'font/woff':
                $ext = '.woff';
                break;
            case 'font/woff2':
                $ext = '.woff2';
                break;
            case 'application/xhtml+xml':
                $ext = '.xhtml';
                break;
            case 'application/vnd.ms-excel':
                $ext = '.xls';
                break;
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                $ext = '.xlsx';
                break;
            case 'application/xml':
                $ext = '.xml';
                break;
            case 'application/vnd.mozilla.xul+xml':
                $ext = '.xul';
                break;
            case 'application/zip':
                $ext = '.zip';
                break;
            case 'audio/3gpp':
            case 'video/3gpp':
                $ext = '.3gp';
                break;
            case 'audio/3gpp2':
            case 'video/3gpp2':
                $ext = '.3g2';
                break;
            case 'application/x-7z-compressed':
                $ext = '.7z';
                break;
        }

        return (object)[
            'mime'      => $mime,
            'extension' => $ext,
            'size'      => $size,
            'binary'    => $file,
            'base64'    => base64_encode($file),
            'sha256'    => hash('sha256', $file),
        ];
    }
}
