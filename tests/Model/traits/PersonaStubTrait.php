<?php

namespace phamily\framework\Model\traits;

use phamily\framework\Model\PersonaInterface;

/**
 * @author samizdam
 */
trait PersonaStubTrait
{
    protected function createPersonaStub($gender = null, $dateOfBirth = null, $dateOfDeath = null)
    {
        $personaStub = $this->getMockBuilder(PersonaInterface::class)->getMock();
        if (isset($gender)) {
            $personaStub->method('getGender')->willReturn($gender);
        }

        $hasDateOfBirth = isset($dateOfBirth);
        if ($hasDateOfBirth) {
            $personaStub->method('getDateOfBirth')->willReturn($dateOfBirth);
        }
        $personaStub->method('hasDateOfBirth')->willReturn($hasDateOfBirth);

        $hasDateOfDeath = isset($dateOfDeath);
        if ($hasDateOfDeath) {
            $personaStub->method('getDateOfDeath')->willReturn($dateOfDeath);
        }
        $personaStub->method('hasDateOfDeath')->willReturn($hasDateOfDeath);

        return $personaStub;
    }
}
