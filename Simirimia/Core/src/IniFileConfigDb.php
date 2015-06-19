<?php

namespace Simirimia\Core;

use Exception;
use InvalidArgumentException;

class IniFileConfigDb implements Config, DatabaseConfig
{

    /**
     * @var bool
     */
    private $isSetupMode;

    /**
     * @var string
     */
    private $db_dsn;

    /**
     * @var string
     */
    private $db_user;

    /**
     * @var string
     */
    private $db_password;

    /**
     * @var string
     */
    private $log_path;

    /**
     * @param $folderPath
     * @return Config
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public static function fromIniFilesInFolder( $folderPath )
    {
        if ( !is_string($folderPath) ) {
            throw new InvalidArgumentException( 'Param $folderPath needs to be a string' );
        }

        if ( !file_exists( $folderPath . '/config_global.ini.php' ) || !is_readable( $folderPath . '/config_global.ini.php' ) ) {
            throw new Exception( 'global config file not readable' );
        }

        if ( !file_exists( $folderPath . '/config_local.ini.php' ) || !is_readable( $folderPath . '/config_local.ini.php' ) ) {
            throw new Exception( 'local config file not readable' );
        }


        $config = parse_ini_file( $folderPath . '/config_global.ini.php' );
        $config = array_merge( $config, parse_ini_file( $folderPath . '/config_local.ini.php' ) );
        $config['isSetupMode'] = file_exists( $folderPath . '/setup_in_progress___remove_me' );

        return new static( $config );
    }

    /**
     * @param array $config
     */
    public function __construct( array $config )
    {
        foreach( $config as $entry => $value ) {
            if ( property_exists( $this, $entry )  ) {
                $this->{$entry} = (string)$value;
            }
        }
    }

    /**
     * @return string
     */
    public function getLogFilePath()
    {
        return $this->log_path;
    }

    /**
     * @return string
     */
    public function getDatabaseUser()
    {
        return $this->db_user;
    }

    /**
     * @return string
     */
    public function getDatabasePassword()
    {
        return $this->db_password;
    }

    /**
     * @return string
     */
    public function getDatabaseDsn()
    {
        return $this->db_dsn;
    }

    /**
     * @return bool
     */
    public function isSetupMode()
    {
        return $this->isSetupMode;
    }
}