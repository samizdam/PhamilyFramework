# About

[![Build Status](https://travis-ci.org/samizdam/PhamilyFramework.svg?branch=master)](https://travis-ci.org/samizdam/PhamilyFramework)
[![Code Climate](https://codeclimate.com/github/samizdam/PhamilyFramework/badges/gpa.svg)](https://codeclimate.com/github/samizdam/PhamilyFramework)
[![Test Coverage](https://codeclimate.com/github/samizdam/PhamilyFramework/badges/coverage.svg)](https://codeclimate.com/github/samizdam/PhamilyFramework/coverage)
[![Issue Count](https://codeclimate.com/github/samizdam/PhamilyFramework/badges/issue_count.svg)](https://codeclimate.com/github/samizdam/PhamilyFramework)

Framework for developing genealogic's tree. Under developing, with open source, not commercial, free for all issues use.

Complitable with:
	- php versions: 5.6 and 7.0.
	- MySQL and Postgres. 

# Install and Run

1. Clone this repo. 
2. Install composer dependencies. 
3. Copy phinx.yml.dist to phinx.yml and fix database connection params. 
4. Run vendor/bin/phinx migrate -e {YOUR_DB_ENV_ALIAS}

# For Run Units 

1. Copy phpunit.xml.dist to phpunit.xml
2. Set actual PHAMILY_TEST_ENV variable. 
3. Apply migration with phinx. 
4. Run phpunit tests/ 

# Author 

samizdam

# PS

Wellcome to Issues and Contributing!

Конструктивные предложения и Содействие приветствуются! 
 