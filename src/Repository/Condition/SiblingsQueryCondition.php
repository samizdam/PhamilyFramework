<?php

namespace Phamily\Framework\Repository\Condition;

use Phamily\Framework\KinshipAwareInterface;
use Phamily\Framework\GenderAwareInterface;
use Phamily\Framework\Util\BitmaskTrait;
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
        $this->fatherId = $personaData['father_id'];
        $this->motherId = $personaData['mother_id'];
    }

    public function getPredicate($degreesOfKinship = self::SIBLINGS)
    {
        $siblingCondition = new Where();
        $personaId = $this->personaId;
        $fatherId = $this->fatherId;
        $motherId = $this->motherId;

        if ($this->isFlagSet($degreesOfKinship, self::BROTHER)) {
            $where = (new Where())->equalTo('father_id', $fatherId)
                ->equalTo('mother_id', $motherId)
                ->equalTo('gender', self::GENDER_MALE)
                ->notEqualTo('id', $personaId);

            $siblingCondition->orPredicate($where);
        }

        if ($this->isFlagSet($degreesOfKinship, self::SISTER)) {
            $where = (new Where())->equalTo('father_id', $fatherId)
                ->equalTo('mother_id', $motherId)
                ->equalTo('gender', self::GENDER_FEMALE)
                ->notEqualTo('id', $personaId);

            $siblingCondition->orPredicate($where);
        }

        if ($this->isFlagSet($degreesOfKinship, self::HALF_BROTHER_PATERNAL)) {
            $where = (new Where())->equalTo('father_id', $fatherId)
                ->equalTo('gender', self::GENDER_MALE)
                ->notEqualTo('id', $personaId);

            $where->andPredicate((new Where())->notEqualTo('mother_id', $motherId)
                ->orPredicate((new Where())->isNull('mother_id')));

            $siblingCondition->orPredicate($where);
        }

        if ($this->isFlagSet($degreesOfKinship, self::HALF_BROTHER_MATERNAL)) {
            $where = (new Where())->equalTo('mother_id', $motherId)
                ->equalTo('gender', self::GENDER_MALE)
                ->notEqualTo('id', $personaId);

            $where->andPredicate((new Where())->notEqualTo('father_id', $fatherId)
                ->orPredicate((new Where())->isNull('father_id')));

            $siblingCondition->orPredicate($where);
        }

        if ($this->isFlagSet($degreesOfKinship, self::HALF_SISTER_PATERNAL)) {
            $where = (new Where())->equalTo('father_id', $fatherId)
                ->equalTo('gender', self::GENDER_FEMALE)
                ->notEqualTo('id', $personaId);

            $where->andPredicate((new Where())->notEqualTo('mother_id', $motherId)
                ->orPredicate((new Where())->isNull('mother_id')));

            $siblingCondition->orPredicate($where);
        }

        if ($this->isFlagSet($degreesOfKinship, self::HALF_SISTER_MATERNAL)) {
            $where = (new Where())->equalTo('mother_id', $motherId)
                ->equalTo('gender', self::GENDER_FEMALE)
                ->notEqualTo('id', $personaId);

            $where->andPredicate((new Where())->notEqualTo('father_id', $fatherId)
                ->orPredicate((new Where())->isNull('father_id')));

            $siblingCondition->orPredicate($where);
        }

        return $siblingCondition;
    }
}
