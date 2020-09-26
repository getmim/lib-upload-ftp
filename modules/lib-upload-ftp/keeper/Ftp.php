<?php
/**
 * File upload FTP keeper
 * @package lib-upload-ftp
 * @version 0.0.1
 */

namespace LibUploadFtp\Keeper;

use LibFtp\Library\Connect;

class Ftp implements \LibUpload\Iface\Keeper
{
    private static $error;

    static function getId(string $file): ?string{
        $config = \Mim::$app->config->libUploadFtp;
        $host = $config->url;
        $host_len = strlen($host);

        if(substr($file, 0, $host_len) != $host)
            return null;
        return substr($file, $host_len);
    }

    static function save(object $file): ?string{
        $config = \Mim::$app->config->libUploadFtp;
        $copts = $config->connection ?? null;
        if(!$copts)
            trigger_error('No FTP connection for file upload found');
        
        $copts->server = (array)$copts->server;
        $copts->user = (array)$copts->user;

        $copts = (array)$copts;

        $ftp = new Connect($copts);
        if($ftp->getError()){
            self::$error = $ftp->getError();
            return false;
        }

        $ftp_path = $config->base ?? '';
        $ftp_path.= '/' . $file->target;

        if(!$ftp->upload($ftp_path, $file->source, 'binary', 0))
            return self::$setError($ftp->getError());

        $final_url = $config->url . $file->target;

        return $final_url;
    }
    
    static function lastError(): ?string{
        return self::$error;
    }
}