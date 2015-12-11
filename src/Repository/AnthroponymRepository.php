<?php

namespace Phamily\Framework\Repository;

use Phamily\Framework\Model\AnthroponymInterface;
use Phamily\Framework\Model\Anthroponym;

/**
 *
 * @author samizdam
 *
 */
class AnthroponymRepository extends AbstractRepository implements AnthroponymRepositoryInterface
{
    /**
     *
     * @var string
     */
    protected $tableName = 'anthroponym';

    /**
     *
     * @var array
     */
    protected $primaryKey = [
        'type',
        'value',
    ];

    /**
     *
     * (non-PHPdoc)
     * @see \Phamily\Framework\Repository\AnthroponymRepositoryInterface::save()
     *
     */
    public function save(AnthroponymInterface $anthroponym)
    {
        $exists = $this->checkAnthroponymExists($anthroponym);

        $row = $this->getRowGatewayInstance();
        $row->populate($this->extractData($anthroponym), $exists);

        $this->checkTypeExists($anthroponym->getType());

        $row->save();

        return $anthroponym->populate($row);
    }

    /**
     *
     *
     * @param AnthroponymInterface $anthroponym
     * @return array
     */
    protected function extractData(AnthroponymInterface $anthroponym)
    {
        $data = [
            'type' => $anthroponym->getType(),
            'value' => $anthroponym->getValue(),
        ];
        if ($anthroponym->getId() !== null) {
            $data['id'] = $anthroponym->getId();
        }

        return $data;
    }

    /**
     *
     *
     * @param AnthroponymInterface $anthroponym
     * @return bool
     */
    protected function checkAnthroponymExists(AnthroponymInterface &$anthroponym)
    {
        $tableGateway = $this->createTableGateway($this->tableName);
        $resultSet = $tableGateway->select([
            'type' => $anthroponym->getType(),
            'value' => $anthroponym->getValue(),
        ]);
        if ($resultSet->count()) {
            $anthroponym->populate($resultSet->current());
        }

        return (bool) $resultSet->count();
    }

    /**
     *
     *
     * @param string $type
     * @return bool
     */
    protected function checkTypeExists($type)
    {
        $tableGateway = $this->createTableGateway('anthroponym_type');
        $typeData = [
            'anthroponym_type' => $type,
        ];
        $resultSet = $tableGateway->select($typeData);
        if ($resultSet->count()) {
            return true;
        } else {
            $tableGateway->insert($typeData);
        }
    }

    /**
     *
     * (non-PHPdoc)
     * @see \Phamily\Framework\Repository\AnthroponymRepositoryInterface::delete()
     *
     */
    public function delete(AnthroponymInterface $anthroponym)
    {
        $tableGateway = $this->createTableGateway($this->tableName);
        $tableGateway->delete([
            'type' => $anthroponym->getType(),
            'value' => $anthroponym->getValue(),
        ]);
    }

    /**
     *
     * (non-PHPdoc)
     * @see \Phamily\Framework\Repository\AnthroponymRepositoryInterface::getByType()
     *
     */
    public function getByType($type)
    {
        $tableGateway = $this->createTableGateway('anthroponym');
        $resultSet = $tableGateway->select([
            'type' => $type,
        ]);
        // if($resultSet->count() > 0){
        $array = [];
        foreach ($resultSet as $row) {
            $anthroponym = new Anthroponym($row['type'], $row['value']);
            $array[] = $anthroponym->populate($row);
        }

        // }
        return $array;
    }
}
