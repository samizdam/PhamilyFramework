<?php

namespace Phamily\Framework\Util;

/**
 * @author samizdam
 */
class DatabaseConfigAdapter
{
    private $adapterToDriverMap = [
        'mysql' => 'Pdo_Mysql',
        'pgsql' => 'Pdo_Pgsql',
    ];

    /**
     * Convert Phinx env configuration to Zend Adapter configuration.
     *
     * @param array $config
     *
     * @return array
     */
    public function adaptPhinxToZend(array $config)
    {
        $optionalParams = [
            'port',
            'charset',
            'schema',
        ];
        $driver = $this->adapterToDriverMap[$config['adapter']];
        $params = [
            'driver' => $driver,
            'host' => $config['host'],
            'database' => $config['name'],
            'username' => $config['user'],
            'password' => $config['pass'],
        ];

        foreach ($optionalParams as $paramName) {
            if (array_key_exists($paramName, $config)) {
                $params[$paramName] = $config[$paramName];
            }
        }

        return $params;
    }
}
