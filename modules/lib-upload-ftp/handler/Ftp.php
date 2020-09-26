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
    private static $last_local_file;

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

        $local_path = tempnam(sys_get_temp_dir(), 'mim-lib-upload-ftp-');

        if(!$ftp->download($ftp_path, $local_path, 'binary', 0))
            return null;

        self::$last_local_file = $local_path;

        return $local_path;
    }

    static function isLazySizer(string $path, int $width=null, int $height=null, string $compress=null): ?string{
        return null;
    }

    static function upload(string $local, string $name): ?string{
        if(self::$last_local_file && is_file(self::$last_local_file))
            unlink(self::$last_local_file);
        
        return _Ftp::save((object)[
            'target' => $name,
            'source' => $local
        ]);
    }
}