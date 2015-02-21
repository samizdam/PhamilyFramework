<?php
namespace phamily\tests\traits;

use phamily\framework\GenderAwareInterface;
trait FullFamilyFixtureTrait{

	protected function createFullFamilyFixtures(){
		$male = GenderAwareInterface::GENDER_MALE;
		$female = GenderAwareInterface::GENDER_FEMALE;
	
		$fatherGrandPa = ['id' => 1, 'gender' => $male];
		$fatherGrandMa = ['id' => 2, 'gender' => $female];
	
	
		$father = ['id' => 3, 'gender' => $male, 'fatherId' => 1, 'motherId' => 2];
		$mother = ['id' => 4, 'gender' => $female];
	
		// son - is perfect example of Persona: 
		// have 3 child, 1 spouse, 1 full sibling (sister) and 2 half-siblings
		$son = ['id' => 5, 'gender' => $male, 'fatherId' => 3, 'motherId' => 4];
		$sonWife = ['id' => 6, 'gender' => $female];
		$daughter = ['id' => 7, 'gender' => $female, 'fatherId' => 3, 'motherId' => 4];
		$sonHalfBrotherOnFatherSide = ['id' => 8, 'gender' => $male, 'fatherId' => 3];
		$sonHalfSisterOnMotherSide = ['id' => 9, 'gender' => $female, 'motherId' => 4];
	
		$grandsonA = ['id' => 10, 'gender' => $male, 'fatherId' => 5, 'motherId' => 6];
		$grandsonB = ['id' => 11, 'gender' => $male, 'fatherId' => 5, 'motherId' => 6];
		$grandsonC = ['id' => 12, 'gender' => $male, 'fatherId' => 5, 'motherId' => 6];
	
	
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
		foreach ($fixtures as $row){
			$this->insertRowInTable($row, 'persona');
		}
	
		$relationships = [
		['husbandId' => $father['id'], 'wifeId' => $mother['id']],
		['husbandId' => $fatherGrandPa['id'], 'wifeId' => $fatherGrandMa['id']],
		['husbandId' => $son['id'], 'wifeId' => $sonWife['id']],
		];
		foreach ($relationships as $spousesRel){
			$this->insertRowInTable($spousesRel, 'spouse_relationship');
		}
	
		return $fixtures;
	}
	
	
}