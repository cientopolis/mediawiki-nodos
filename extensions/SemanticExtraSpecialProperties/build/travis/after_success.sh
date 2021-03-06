#! /bin/bash

set -x

originalDirectory=$(pwd)

if [ "$TYPE" == "coverage" ]
then
	wget https://scrutinizer-ci.com/ocular.phar
	php ocular.phar code-coverage:upload --format=php-clover $originalDirectory/build/coverage.clover
fi