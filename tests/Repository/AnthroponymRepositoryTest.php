<?php

namespace Phamily\Framework\Repository;

use Phamily\Framework\Model\Anthroponym;
use Phamily\tests\DbTest;

/**
 * @author samizdam
 */
class AnthroponymRepositoryTest extends DbTest
{
    private $tableName = 'anthroponym';

    public function testSaveNewAnthroponym()
    {
        $type = 'firstName';
        $value = 'Vasya';
        $data = [
            'type' => $type,
            'value' => $value,
        ];

        $this->assertTableHasNotData($this->tableName, $data);

        $anthroponym = new Anthroponym($type, $value);
        $repository = $this->getRepository();

        $repository->save($anthroponym);

        $this->assertTableHasData($this->tableName, $data);
    }

    public function testGetExistingAnthroponym()
    {
        $fixtures = $this->prepareFixtures();
        $fixture = $fixtures[0];
        $repository = $this->getRepository();
        $antroponyms = $repository->getByType($fixture['type']);
        $this->assertEquals($fixture['value'], $antroponyms[0]->getValue());
    }

    public function testDeleteAnthroponym()
    {
        $fixtures = $this->prepareFixtures();
        $this->assertTableHasData($this->tableName, $fixtures[0]);

        $repository = $this->getRepository();
        $anthroponym = new Anthroponym($fixtures[0]['type'], $fixtures[0]['value']);
        $repository->delete($anthroponym);

        $this->assertTableHasNotData($this->tableName, $fixtures[0]);
    }

    public function testDublicateNames()
    {
        $fixtures = $this->prepareFixtures();
        $dubleAnthroponym = new Anthroponym($fixtures[0]['type'], $fixtures[0]['value']);
        $repository = $this->getRepository();
        $repository->save($dubleAnthroponym);
    }

    private function prepareFixtures()
    {
        $fixtures = [
            [
                'type' => 'firstName',
                'value' => 'Vasia',
            ],
        ];
        foreach ($fixtures as $rowData) {
            $this->insertRowInTable([
                'anthroponym_type' => $rowData['type'],
            ], 'anthroponym_type');
            $this->insertRowInTable($rowData, $this->tableName);
        }

        return $fixtures;
    }

    private function getRepository()
    {
        return new AnthroponymRepository($this->getDbAdapter());
    }
}
