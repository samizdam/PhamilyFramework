<?php

namespace phamily\framework\repositories;

use phamily\framework\models\AnthroponymInterface;
use phamily\framework\models\Anthroponym;

class AnthroponymRepository extends AbstractRepository implements AnthroponymRepositoryInterface
{
    protected $tableName = 'anthroponym';

    protected $primaryKey = [
        'type',
        'value',
    ];

    public function save(AnthroponymInterface $anthroponym)
    {
        $exists = $this->checkAnthroponymExists($anthroponym);

        $row = $this->getRowGatewayInstance();
        $row->populate($this->extractData($anthroponym), $exists);

        $this->checkTypeExists($anthroponym->getType());

        $row->save();

        return $anthroponym->populate($row);
    }

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

    public function delete(AnthroponymInterface $anthroponym)
    {
        $tableGateway = $this->createTableGateway($this->tableName);
        $tableGateway->delete([
            'type' => $anthroponym->getType(),
            'value' => $anthroponym->getValue(),
        ]);
    }

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
