<?php
/**
 * File media ftp handler
 * @package lib-upload-ftp
 * @version 0.0.1
 */

namespace LibUploadFtp\Handler;

use \claviska\SimpleImage;
use \LibCompress\Library\Compressor;
use \LibUpload\Model\Media;
use \LibUploadFtp\Model\MediaFtp;

class Ftp implements \LibMedia\Iface\Handler
{
    private static function compress(object $result): object{
        if(!module_exists('lib-compress'))
            return $result;
        return $result;
    }

    static function get(object $opt): ?object {
        $config = &\Mim::$app->config->libUploadFtp;
        $base = $config->base;

        $file_abs = $base . '/' . $opt->file;

        $media = Media::getOne(['path'=>$opt->file]);
        if(!$media)
            return null;

        $file_mime  = $media->mime;
        $url_base   = chop($config->url, '/');
        $is_image   = fnmatch('image/*', $file_mime);

        $result = (object)[
            'file' => $opt->file,
            'base' => $file_abs,
            'none' => $url_base . '/' . $opt->file
        ];

        deb('This feaure is not implemented');

        if(!$is_image)
            return self::compress($result);

        deb($result);
    }
}