<?php declare(strict_types=1);

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
     * @var string Config file name.
     */
    public const CONFIG_FILE_NAME = 'poker-rankr';

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
            throw new ConfigFileNotFoundException('Config file not found!');
        }

        $this->config = new Repository(require $config_file);
    }

    /**
     * Returns a config path depending on the context
     *
     * @return  mixed|string
     */
    private function configurationPath()
    {
        // Default config location
        $config_path = __DIR__;

        // Check if this laravel specific function `config_path()` exist (means this package is used inside
        // a laravel framework). If so then try to load the laravel config file if exists.
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
