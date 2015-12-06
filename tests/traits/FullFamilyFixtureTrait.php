<?php

namespace Phamily\tests\traits;

use Phamily\Framework\GenderAwareInterface;

/**
 * @author samizdam
 */
trait FullFamilyFixtureTrait
{
    /**
     * $fatherGrandPa |===============> $sonHalfBrotherOnFatherSide
     * \ /
     * |===> $father
     * / \
     * $fatherGrandMa |===============> $son
     * | \
     * | |=========> $grandsonA
     * | |
     * | |=========> $grandsonB
     * | |
     * | |=========> $grandsonC
     * | /
     * | $sonWife
     * |
     * |
     * |
     * |
     * |==============> $daughter
     * |
     * |
     * |
     * |
     * /
     * $mother|
     * \
     * |==============> $sonHalfSisterOnMotherSide.
     *
     * @return array
     */
    protected function createFullFamilyFixtures()
    {
        $male = GenderAwareInterface::GENDER_MALE;
        $female = GenderAwareInterface::GENDER_FEMALE;

        $fatherGrandPa = [
            'id' => 1,
            'gender' => $male,
        ];
        $fatherGrandMa = [
            'id' => 2,
            'gender' => $female,
        ];

        $father = [
            'id' => 3,
            'gender' => $male,
            'father_id' => 1,
            'mother_id' => 2,
        ];
        $mother = [
            'id' => 4,
            'gender' => $female,
        ];

        // son - is perfect example of Persona:
        // have 3 child, 1 spouse, 1 full sibling (sister) and 2 half-siblings
        $son = [
            'id' => 5,
            'gender' => $male,
            'father_id' => 3,
            'mother_id' => 4,
        ];
        $sonWife = [
            'id' => 6,
            'gender' => $female,
        ];
        $daughter = [
            'id' => 7,
            'gender' => $female,
            'father_id' => 3,
            'mother_id' => 4,
        ];
        $sonHalfBrotherOnFatherSide = [
            'id' => 8,
            'gender' => $male,
            'father_id' => 3,
        ];
        $sonHalfSisterOnMotherSide = [
            'id' => 9,
            'gender' => $female,
            'mother_id' => 4,
        ];

        $grandsonA = [
            'id' => 10,
            'gender' => $male,
            'father_id' => 5,
            'mother_id' => 6,
        ];
        $grandsonB = [
            'id' => 11,
            'gender' => $male,
            'father_id' => 5,
            'mother_id' => 6,
        ];
        $grandsonC = [
            'id' => 12,
            'gender' => $male,
            'father_id' => 5,
            'mother_id' => 6,
        ];

        $fixtures = [
            'fatherGnandPa' => $fatherGrandPa,
            'fatherGnandMa' => $fatherGrandMa,

            'father' => $father,
            'mother' => $mother,

            'son' => $son,
            'sonWife' => $sonWife,
            'daughter' => $daughter,

            'sonHalfBrotherOnFatherSide' => $sonHalfBrotherOnFatherSide,
            'sonHalfSisterOnMotherSide' => $sonHalfSisterOnMotherSide,

            'grandsonA' => $grandsonA,
            'grandsonB' => $grandsonB,
            'grandsonC' => $grandsonC,
        ];
        foreach ($fixtures as $row) {
            $this->insertRowInTable($row, 'persona');
        }

        $relationships = [
            [
                'husband_id' => $father['id'],
                'wife_id' => $mother['id'],
            ],
            [
                'husband_id' => $fatherGrandPa['id'],
                'wife_id' => $fatherGrandMa['id'],
            ],
            [
                'husband_id' => $son['id'],
                'wife_id' => $sonWife['id'],
            ],
        ];
        foreach ($relationships as $spousesRel) {
            $this->insertRowInTable($spousesRel, 'spouse_relationship');
        }

        return $fixtures;
    }
}
