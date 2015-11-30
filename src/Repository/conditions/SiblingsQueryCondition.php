<?php

namespace Phamily\Framework\Repository\conditions;

use Phamily\Framework\KinshipAwareInterface;
use Phamily\Framework\GenderAwareInterface;
use Phamily\Framework\traits\BitmaskTrait;
use Zend\Db\Sql\Where;

class SiblingsQueryCondition implements KinshipAwareInterface, GenderAwareInterface
{
    use BitmaskTrait;

    protected $personaId;

    protected $fatherId;

    protected $motherId;

    public function __construct($personaData)
    {
        $this->personaId = $personaData['id'];
        $this->fatherId = $personaData['fatherId'];
        $this->motherId = $personaData['motherId'];
    }

    public function getPredicate($degreesOfKinship = self::SIBLINGS)
    {
        $siblingCondition = new Where();
        $personaId = $this->personaId;
        $fatherId = $this->fatherId;
        $motherId = $this->motherId;

        if ($this->isFlagSet($degreesOfKinship, self::BROTHER)) {
            $where = (new Where())->equalTo('fatherId', $fatherId)
                ->equalTo('motherId', $motherId)
                ->equalTo('gender', self::GENDER_MALE)
                ->notEqualTo('id', $personaId);

            $siblingCondition->orPredicate($where);
        }

        if ($this->isFlagSet($degreesOfKinship, self::SISTER)) {
            $where = (new Where())->equalTo('fatherId', $fatherId)
                ->equalTo('motherId', $motherId)
                ->equalTo('gender', self::GENDER_FEMALE)
                ->notEqualTo('id', $personaId);

            $siblingCondition->orPredicate($where);
        }

        if ($this->isFlagSet($degreesOfKinship, self::HALF_BROTHER_PATERNAL)) {
            $where = (new Where())->equalTo('fatherId', $fatherId)
                ->equalTo('gender', self::GENDER_MALE)
                ->notEqualTo('id', $personaId);

            $where->andPredicate((new Where())->notEqualTo('motherId', $motherId)
                ->orPredicate((new Where())->isNull('motherId')));

            $siblingCondition->orPredicate($where);
        }

        if ($this->isFlagSet($degreesOfKinship, self::HALF_BROTHER_MATERNAL)) {
            $where = (new Where())->equalTo('motherId', $motherId)
                ->equalTo('gender', self::GENDER_MALE)
                ->notEqualTo('id', $personaId);

            $where->andPredicate((new Where())->notEqualTo('fatherId', $fatherId)
                ->orPredicate((new Where())->isNull('fatherId')));

            $siblingCondition->orPredicate($where);
        }

        if ($this->isFlagSet($degreesOfKinship, self::HALF_SISTER_PATERNAL)) {
            $where = (new Where())->equalTo('fatherId', $fatherId)
                ->equalTo('gender', self::GENDER_FEMALE)
                ->notEqualTo('id', $personaId);

            $where->andPredicate((new Where())->notEqualTo('motherId', $motherId)
                ->orPredicate((new Where())->isNull('motherId')));

            $siblingCondition->orPredicate($where);
        }

        if ($this->isFlagSet($degreesOfKinship, self::HALF_SISTER_MATERNAL)) {
            $where = (new Where())->equalTo('motherId', $motherId)
                ->equalTo('gender', self::GENDER_FEMALE)
                ->notEqualTo('id', $personaId);

            $where->andPredicate((new Where())->notEqualTo('fatherId', $fatherId)
                ->orPredicate((new Where())->isNull('fatherId')));

            $siblingCondition->orPredicate($where);
        }

        return $siblingCondition;
    }
}
