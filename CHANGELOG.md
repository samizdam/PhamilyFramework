# CHANGELOG 

## Список изменений проекта

## Unreleased
### Added
- Export data from mainstream formats in subj. 
- Support for SQLite. 
- Support for noSQL storages. 
- Import to some formats (xml, GEDCOM) and API for representations.
- Integration with Yii.   
- Search.

### Changed
- Separete Unit and Integration (DB) tests.  
- Extract Config Adapter to standalone package. 
- Use actual Vendor in namespace? Samizdam or FreeElephants.  

## 0.1.1 - 2015-12-12
### Added
- Library level Exceptions.

### Changed
- Exceptions hierarchy. 

## 0.1.0 - 2015-12-12
### Changed
- Rename exceptions packages with psr. 
- Rename conditions package with psr. 

## 0.0.9 - 2015-12-12
### Changed
- Rename PersonaService::getById() method to getPersonaById(). 
- Rename PersonaService::delete() method to deletePersona().
- Rename PersonaRepositoryCache classes (in-memory) to  PersonaIdentityMap. 

## 0.0.8 - 2015-12-12
### Added
- Integration with codeclimate. 

### Changed 
- Rename PersonaService::create() method to createPersona().  

## 0.0.7 - 2015-12-10
### Changed
- Move Bitmask trait to Util namespace.
- Move migrations execution from testing bootstrap to .travis config.   

## 0.0.6 - 2015-12-09
### Added
- Integration with Travis CI.

## 0.0.5 - 2015-12-08
### Changed
- Use UpperCamelCase in namespace for vendor and project.  
- Use migrations for create database schemas.
- Make tests runnable with different db-drivers.

## 0.0.4 - 2015-12-01
### Changed
- Update vendor dependencies. 
- Use UpperCamelCase and singular naming in namespaces: all classes are renamed. 

## 0.0.3 - 2015-11-25
### Changed
- Namespaces for tests. 
- Run tests from project root. 

## 0.0.2 - 2015-10-03
### Added
- FakeTrueValidator (SpounseValidatorInterface support only in this version). 
  
### Changed
- psr-2 autoformat. 

## 0.0.1 - 2015-10-02
### Added
- Current change log. 
- README created.  

### Fixed
- Composer updated.
 
