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

    static function save(object $file): bool{
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

        return $ftp->upload($ftp_path, $file->source, 'binary', 0);
    }
    
    static function lastError(): ?string{
        return self::$error;
    }
}