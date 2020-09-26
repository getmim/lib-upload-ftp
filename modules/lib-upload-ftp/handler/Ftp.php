<?php
/**
 * File media ftp handler
 * @package lib-upload-ftp
 * @version 0.0.1
 */

namespace LibUploadFtp\Handler;

use LibFtp\Library\Connect;
use LibUploadFtp\Keeper\Ftp as _Ftp;

class Ftp implements \LibMedia\Iface\Handler
{
    static function getPath(string $url): ?string{
        $config = \Mim::$app->config->libUploadFtp;
        $host = $config->url;
        $host_len = strlen($host);

        if(substr($url, 0, $host_len) != $host)
            return null;
        return substr($url, $host_len);
    }

    static function getLocalPath(string $path): ?string{
        $config = \Mim::$app->config->libUploadFtp;
        $copts  = $config->connection ?? null; 
        if(!$copts)
            trigger_error('No FTP connection for file upload found');

        $copts->server = (array)$copts->server;
        $copts->user = (array)$copts->user;

        $copts = (array)$copts;

        $ftp_path = $config->base ?? '';
        $ftp_path.= '/' . $path;

        $ftp = new Connect($copts);
        if($ftp->getError())
            return null;

        $local_path = tempnam(sys_get_temp_dir(), 'mim-lib-upload-ftp');

        $ftp->download($ftp_path, $local_path, 'binary', 0);
        return $local_path;
    }

    static function isLazySizer(string $path, int $width=null, int $height=null, string $compress=null): ?string{
        return null;
    }

    static function upload(string $local, string $name): ?string{
        return _Ftp::save((object)[
            'target' => $name,
            'source' => $local
        ]);
    }
}