<?php
namespace Phamily\Framework\Util;

/**
 *
 * @author samizdam
 *
 */
class DatabaseConfigAdapter
{

    /**
     * Convert Phinx env configuration to Zend Adapter configuration.
     *
     * @param array $config
     * @return array
     */
    public function adaptPhinxToZend(array $config)
    {
        return [
            'driver' => 'Pdo_Mysql',
            'host' => $config['host'],
            'port' => $config['port'],
//             'charset' => $config['charset'],
            'database' => $config['name'],
            'username' => $config['user'],
            'password' => $config['pass']
        ];
    }
}