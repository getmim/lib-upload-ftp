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

        $url_file   = $url_base . '/' . $opt->file;

        $result = (object)[
            'none' => $url_file
        ];

        if(!$is_image)
            return $result;

        $result->size = (object)[
            'width'  => $media->width,
            'height' => $media->height
        ];
        $result->webp = $url_file . '.webp';

        if(!isset($opt->size))
            return $result;

        $t_width = $opt->size->width ?? null;
        $t_height= $opt->size->height ?? null;

        if(!$t_width)
            $t_width = ceil($media->width * $t_height / $media->height);
        if(!$t_height)
            $t_height = ceil($media->height * $t_width / $media->width);

        if($t_width == $media->width && $t_height == $media->height)
            return $result;

        $suffix   = '_' . $t_width . 'x' . $t_height;
        $url_file = preg_replace('!\.[a-zA-Z]+$!', $suffix . '$0', $url_file);

        $result->none = $url_file;
        $result->webp = $url_file . '.webp';

        return $result;
    }
}