<?php

namespace Phamily\Framework\Model;

use Phamily\Framework\ValueObject\DateTime;
use Phamily\tests\UnitTest;
use Phamily\Framework\Model\exceptions\LogicException;

/**
 * @author samizdam
 */
class PersonaTest extends UnitTest
{

    public function testConstructWithGender()
    {
        $persona = new Persona(Persona::GENDER_MALE);
        $this->assertEquals(Persona::GENDER_MALE, $persona->getGender());
        $this->setExpectedException(LogicException::class);
        $persona->setGender(Persona::GENDER_FEMALE);
    }

    public function testConstructWithNames()
    {
        $nameType = 'firstName';
        $nameValue = 'Vasya';
        $persona = new Persona(null, [
            $nameType => $nameValue,
        ]);
        $this->assertEquals($nameValue, $persona->getName($nameType));
    }

    public function testValidConstructWithParents()
    {
        $male = Persona::GENDER_MALE;
        $female = Persona::GENDER_FEMALE;
        $father = new Persona($male);
        $mother = new Persona($female);

        $persona = new Persona(Persona::GENDER_UNDEFINED, [], $father, $mother);
        $this->assertEquals($father, $persona->getFather());
        $this->assertEquals($mother, $persona->getMother());
    }

    public function testInvalidConstructWithParents()
    {
        $male = Persona::GENDER_MALE;
        $father = new Persona($male);

        $this->setExpectedException(LogicException::class);
        $persona = new Persona(Persona::GENDER_UNDEFINED, [], $father, $father);

        $this->assertEmpty($persona->getMother());
    }

    public function testFatherFemaleException()
    {
        $father = new Persona(Persona::GENDER_FEMALE);

        $this->setExpectedException(LogicException::class, null);
        $son = new Persona(Persona::GENDER_MALE);
        $son->setFather($father);
    }

    public function testPersonaFullName()
    {
        $persona = new Persona(Persona::GENDER_MALE, [
            'surname' => 'Ivanov',
            'firstName' => 'Ivan',
            'patronym' => 'Ivanovich',
        ]);
        $schemeConfig = [
            'default' => [
                'surname' => [],
                'firstName' => [],
                'patronym' => [],
            ],
        ];
        $scheme = new NamingScheme('fio', $schemeConfig);
        $this->assertEquals('Ivanov Ivan Ivanovich', $persona->getFullName($scheme));
    }

    public function testDateOfBirthFormating()
    {
        $persona = new Persona();

        $persona->setDateOfBirth(new DateTime());

        $format = 'Y-m-d';

        $this->assertEquals(date($format), $persona->getDateOfBirth($format));
    }

    public function testDateOfDeathFormating()
    {
        $persona = new Persona();

        $persona->setDateOfDeath(new DateTime());

        $format = 'Y-m-d';

        $this->assertEquals(date($format), $persona->getDateOfDeath($format));
    }

    public function testDeathBeforeBirthException()
    {
        $persona = new Persona();
        $persona->setDateOfBirth(new DateTime('2001-01-01'));
        $this->setExpectedException(LogicException::class);
        $persona->setDateOfDeath(new DateTime('2000-01-01'));
    }

    public function testBirthAfterDeathException()
    {
        $persona = new Persona();
        $persona->setDateOfDeath(new DateTime('2000-01-01'));
        $this->setExpectedException(LogicException::class);
        $persona->setDateOfBirth(new DateTime('2001-01-01'));
    }

    public function testChildsForParents()
    {
        $persona = new Persona();
        $father = new Persona(Persona::GENDER_MALE);

        $persona->setFather($father);

        $this->assertContains($persona, $father->getChildren());

        $mother = new Persona(Persona::GENDER_FEMALE);
        $persona->setMother($mother);
        $this->assertContains($persona, $mother->getChildren());
    }

    public function testParentsForChild()
    {
        $persona = new Persona();
        $father = new Persona(Persona::GENDER_MALE);

        $father->addChild($persona);

        $this->assertEquals($father, $persona->getFather());

        $mother = new Persona(Persona::GENDER_FEMALE);
        $mother->addChild($persona);
        $this->assertEquals($mother, $persona->getMother());
    }

    public function testAddSpouseSuccess()
    {
        $husband = new Persona(Persona::GENDER_MALE);
        $wife = new Persona(Persona::GENDER_FEMALE);

        $husband->addSpouse($wife);

        $this->assertContains($wife, $husband->getSpouses());
    }

    public function testSpouseReflectionRelationshit()
    {
        $husband = new Persona(Persona::GENDER_MALE);
        $wife = new Persona(Persona::GENDER_FEMALE);

        $husband->addSpouse($wife);

        $this->assertContains($husband, $wife->getSpouses());
    }
}
