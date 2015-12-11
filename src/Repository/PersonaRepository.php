<?php
namespace Phamily\Framework\Repository;

use Phamily\Framework\Model\PersonaInterface;
use Zend\Db\TableGateway\TableGateway;
use Phamily\Framework\Model\Persona;
use Phamily\Framework\Repository\exceptions\NotFoundException;
use Phamily\Framework\Util\BitmaskTrait;
use Phamily\Framework\Repository\conditions\SiblingsQueryCondition;
use Zend\Db\TableGateway\Feature\SequenceFeature;
use Zend\Db\Adapter\AdapterInterface;

/**
 * TODO this class is too big and need refactoring.
 *
 * @author samizdam
 *
 */
class PersonaRepository extends AbstractRepository implements PersonaRepositoryInterface
{
    use BitmaskTrait;

    /**
     *
     * @var string
     */
    protected $tableName = 'persona';

    /**
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     *
     * @var PersonaIdentityMapInterface
     */
    protected $cache;

    /**
     *
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        parent::__construct($adapter);
        $this->cache = new PersonaIdentityMap();
    }

    /**
     *
     * (non-PHPdoc)
     *
     * @see \Phamily\Framework\Repository\PersonaRepositoryInterface::save()
     *
     */
    public function save(PersonaInterface $persona)
    {
        /*
         * TODO extract to method?
         * save parents before
         */
        if ($persona->hasFather() && $this->notSaved($persona->getFather())) {
            $this->save($persona->getFather());
        }
        if ($persona->hasMother() && $this->notSaved($persona->getMother())) {
            $this->save($persona->getMother());
        }

        /*
         *
         * save persona
         */
        $rowData = $this->extractData($persona);

        if ($this->notSaved($persona)) {
            $ai = new SequenceFeature($this->primaryKey, 'persona_id_seq');
            $tgw = $this->createTableGateway($this->tableName, $ai);

            $rowData['created_at'] = date('Y-m-d H:i:s');
            $tgw->insert($rowData);
            $rowData = $tgw->select([
                'id' => $tgw->getLastInsertValue()
            ])
                ->current();
        } else {
            $row = $this->getRowGatewayInstance();
            $row->populate($rowData, true);
            $row->save();
            $rowData = $row->toArray();
        }

        $persona->populate($rowData);
        // $row->populate($this->extractData($persona), !$this->notSaved($persona));

        /*
         * TODO extract to method?
         * save names
         */
        $anthroponymRepo = $this->factory(AnthroponymRepository::class);
        foreach ($persona->getNames() as $name) {
            $anthroponymRepo->save($name);
            $relationTableGateway = new TableGateway('persona_has_name', $this->adapter);
            $relationRowData = [
                'persona_id' => $persona->getId(),
                'name_id' => $name->getId()
            ];
            $relationTableGateway->insert($relationRowData);
        }

        /*
         * save spouse relation
         */
        $spouseRelationTableGateway = $this->createTableGateway('spouse_relationship');
        foreach ($persona->getSpouses() as $spouse) {
            if ($this->notSaved($spouse)) {
                $this->save($spouse);
            }
            list ($husband, $wife) = $this->normalizeSpousePair($persona, $spouse);
            $data = [
                'husband_id' => $husband->getId(),
                'wife_id' => $wife->getId()
            ];
            $spouseRelationTableGateway->insert($data);
        }

        /*
         * TODO extract to method?
         * save childs after
         */
        if (count($persona->getChildren())) {
            foreach ($persona->getChildren() as $child) {
                if ($this->notSaved($child)) {
                    $this->save($child);
                }
            }
        }

        return $persona;
    }

    /**
     *
     * @param PersonaInterface $persona
     * @param PersonaInterface $spouse
     *
     * @return array($husband, $wife)
     */
    protected function normalizeSpousePair(PersonaInterface $persona, PersonaInterface $spouse)
    {
        return ($persona->getGender() === PersonaInterface::GENDER_MALE) ? [
            $persona,
            $spouse
        ] : [
            $spouse,
            $persona
        ];
    }

    /**
     *
     *
     * @param PersonaInterface $persona
     * @return bool
     */
    protected function notSaved(PersonaInterface $persona)
    {
        return $persona->getId() === null;
    }

    /**
     *
     * (non-PHPdoc)
     *
     * @see \Phamily\Framework\Repository\PersonaRepositoryInterface::getPersonaById()
     *
     * @throws NotFoundException
     */
    public function getPersonaById($id, $fetchWithOptions = self::WITHOUT_KINSHIP)
    {
        $options = $fetchWithOptions;

        if ($this->cache->has($id)) {
            $persona = $this->cache->getObject($id);
            $data = $this->cache->getData($id);
            if ($this->cache->getOptions($id) === $options) {
                return $persona;
            }
        } else {
            $tableGateway = new TableGateway($this->tableName, $this->adapter);
            $resultSet = $tableGateway->select([
                'id' => $id
            ]);

            if ($resultSet->count()) {
                $data = $resultSet->current();
                $persona = (new Persona())->populate($data);

                if (! $this->cache->has($id)) {
                    $this->cache->add($persona, $data, $options);
                }
            }
        }

        if (empty($persona)) {
            throw new NotFoundException("Persona with id {$id} not found");
        }

        if ($this->isFlagSet($options, self::SPOUSES)) {
            $this->fetchSpouses($persona, $data, $options);
        }

        if ($this->isFlagSet($options, self::PARENTS)) {
            $this->fetchParents($persona, $data, $options);
        }

        if ($this->isFlagSet($options, self::CHILDREN) && $persona->getGender() !== $persona::GENDER_UNDEFINED) {
            $this->fetchChildren($persona, $data, $options);
        }

        return $persona;
    }

    /**
     *
     * (non-PHPdoc)
     * @see \Phamily\Framework\Repository\PersonaRepositoryInterface::getSiblings()
     *
     */
    public function getSiblings(PersonaInterface $persona, $degreeOfKinship = self::SIBLINGS)
    {
        $siblings = [];

        $personaData = $this->cache->getData($persona->getId());

        $siblingCondition = new SiblingsQueryCondition($personaData);
        $where = $siblingCondition->getPredicate($degreeOfKinship);

        $siblingRows = $this->createTableGateway($this->tableName)->select($where);

        foreach ($siblingRows as $row) {
            $siblings[] = $this->getPersonaById($row['id'], $degreeOfKinship);
        }

        return $siblings;
    }

    /**
     *
     *
     * @param PersonaInterface $persona
     * @param \ArrayAccess $data
     * @param int $options
     * @return return_type
     */
    protected function fetchChildren(PersonaInterface $persona, \ArrayAccess $data, $options)
    {
        $parentColumnName = ($persona->getGender() === $persona::GENDER_MALE) ? 'father_id' : 'mother_id';

        $childrenRows = $this->createTableGateway($this->tableName)->select([
            $parentColumnName => $persona->getId()
        ]);
        foreach ($childrenRows as $childRow) {
            $child = $this->getPersonaById($childRow['id'], $options);
            if (! $persona->getChildren()->contains($child)) {
                $persona->addChild($child);
            }
        }
    }

    /**
     *
     *
     * @param PersonaInterface $persona
     * @param \ArrayAccess $data
     * @param int $options
     * @return void
     */
    protected function fetchSpouses(PersonaInterface $persona, \ArrayAccess $data, $options)
    {
        $spouseRelationshipTableGateway = $this->createTableGateway('spouse_relationship');
        $spouseRelationsSet = [];
        if ($persona->getGender() === $persona::GENDER_MALE) {
            $spouseRelationsSet = $spouseRelationshipTableGateway->select([
                'husband_id' => $persona->getId()
            ]);
            foreach ($spouseRelationsSet as $spouseRelation) {
                $wifeId = $spouseRelation['wife_id'];
                $wife = $this->getPersonaById($wifeId, $options);
                if (! $persona->getSpouses()->contains($wife)) {
                    $persona->addSpouse($wife);
                }
            }
        } elseif ($persona->getGender() === $persona::GENDER_FEMALE) {
            $spouseRelationsSet = $spouseRelationshipTableGateway->select([
                'wife_id' => $persona->getId()
            ]);
            foreach ($spouseRelationsSet as $spouseRelation) {
                $husbandId = $spouseRelation['husband_id'];
                $husband = $this->getPersonaById($husbandId, $options);
                if (! $persona->getSpouses()->contains($husband)) {
                    $persona->addSpouse($husband);
                }
            }
        }
    }

    /**
     *
     *
     * @param PersonaInterface $persona
     * @param \ArrayAccess $data
     * @param int $options
     * @return void
     */
    protected function fetchParents(PersonaInterface $persona, \ArrayAccess $data, $options)
    {
        if ($fatherId = $data['father_id']) {
            $father = $this->getPersonaById($fatherId, $options);
            $persona->setFather($father);
        }
        if ($motherId = $data['mother_id']) {
            $mother = $this->getPersonaById($motherId, $options);
            $persona->setMother($mother);
        }
    }

    /**
     *
     *
     * @param PersonaInterface $persona
     * @return array
     */
    protected function extractData(PersonaInterface $persona)
    {
        $data = [
            'gender' => $persona->getGender(),
            'father_id' => $persona->hasFather() ? $persona->getFather()->getId() : null,
            'mother_id' => $persona->hasMother() ? $persona->getMother()->getId() : null
        ];
        if (! $this->notSaved($persona)) {
            $data['id'] = $persona->getId();
        }

        return $data;
    }

    /**
     *
     * (non-PHPdoc)
     * @see \Phamily\Framework\Repository\PersonaRepositoryInterface::delete()
     *
     */
    public function delete(PersonaInterface $persona)
    {
        /*
         * inlink with spouse
         */
        $spouseTableGateway = $this->createTableGateway('spouse_relationship');

        $spouseTableGateway->delete([
            'husband_id' => $persona->getId()
        ]);
        $spouseTableGateway->delete([
            'wife_id' => $persona->getId()
        ]);

        /*
         * unlink parent for existing childs
         */
        $table = $this->createTableGateway($this->tableName);
        $table->update([
            'father_id' => null
        ], [
            'father_id' => $persona->getId()
        ]);
        $table->update([
            'mother_id' => null
        ], [
            'mother_id' => $persona->getId()
        ]);

        /*
         * delete persona row
         */
        $row = $this->getRowGatewayInstance();
        $row->populate($this->extractData($persona), true);
        $row->delete();
    }
}
