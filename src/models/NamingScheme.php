<?php
namespace phamily\framework\models;

/**
 *
 *
 * $config = [
 * 'formName' => [
 * 'anthroponymTypeName' => [
 * 'require' => boolean,
 * 'multiple' => boolean,
 * 'formula' => callable
 * ]
 * ]
 * ];
 * If configuration contains single form, that will be use by default.
 * If configuration contains many forms, without default, first will be use as default.
 *
 * 'anthroponymTypeName' contains validation rules for one anthroponym.
 * Order from anthroponym enumeration will be using for representation full name.
 * By default require and multiple is false.
 * 'formula' can contains callable expression for computing anthroponym value from Person and him relatives.
 * 
 * @example // get full modern Russian name for persona, based on father.
 *          $config = [
 *          'fio' => [
 *          'surname' => [
 *          'require' => true,
 *          'multiple' => true,
 *          'formula' => function(PersonaInterface $persona){
 *          $father = $persona->getFather();
 *          return isset($father) ? $father->getName('surname') : null;
 *          },
 *          'personalName' => [
 *          'require' => true,
 *          'multiple' => false,
 *          ],
 *          'patronym' => [
 *          'require' => true,
 *          'multiple' => false,
 *          'formula' => function(PersonaInterface){
 *          $father = $persona->getFather();
 *          $patronimSuffix = ($persona->getGender() === $persona::GENDER_FEMALE) ? 'ovna' : 'ovich';
 *          return isset($father) ? $father->getName('personalName') . $patronimSuffix : null;
 *          },
 *          ],
 *          ],
 *          ]
 *          ];
 *         
 *          for Petr, son of Ivan Ivanov, we get result: Ivanov Petr Ivanovich.
 *         
 *         
 * @author samizdam
 *        
 */
class NamingScheme implements NamingSchemeInterface
{

    protected $config;

    protected $type;

    public function __construct($type, array $config)
    {
        $this->setConfig($config);
        $this->setType($type);
    }

    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getType()
    {
        return $this->type;
    }

    public function hasForm($formName)
    {
        return isset($this->config[$formName]);
    }

    public function build(NameCollectionInterface $names, $formName = self::DEFAULT_FORM)
    {
        $formConfig = $this->config[$formName];
        $schemeOrder = array_keys($formConfig);
        $result = '';
        foreach ($formConfig as $anthroponymType => $rules) {
            $result .= $names->offsetGet($anthroponymType) . ' ';
        }
        return trim($result);
    }
}