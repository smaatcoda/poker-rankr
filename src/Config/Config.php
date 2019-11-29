<?php

namespace SmaatCoda\PokerRankr\Config;

use Illuminate\Config\Repository;
use SmaatCoda\PokerRankr\Exceptions\ConfigFileNotFoundException;

/**
 * Class Config
 *
 * @package SmaatCoda\PokerRankr\Config
 */
class Config
{

    /**
     * Config file name
     */
    CONST CONFIG_FILE_NAME = 'poker-rankr';

    /**
     * @var  Repository
     */
    private $config;

    /**
     * Config constructor.
     *
     * @throws ConfigFileNotFoundException
     */
    public function __construct()
    {
        $configPath = $this->configurationPath();

        $config_file = $configPath . '/' . self::CONFIG_FILE_NAME . '.php';

        if (!file_exists($config_file)) {
            throw new ConfigFileNotFoundException();
        }

        $this->config = new Repository(require $config_file);
    }

    /**
     * return the correct config directory path
     *
     * @return  mixed|string
     */
    private function configurationPath()
    {
        // the config file of the package directory
        $config_path = __DIR__;

        // check if this laravel specific function `config_path()` exist (means this package is used inside
        // a laravel framework). If so then load then try to load the laravel config file if it exist.
        if (function_exists('config_path') && file_exists(config_path() . '/' . self::CONFIG_FILE_NAME . '.php')) {
            $config_path = config_path();
        }

        return $config_path;
    }

    /**
     * @param $key
     *
     * @return  mixed
     */
    public function get($key)
    {
        return $this->config->get($key);
    }
}
