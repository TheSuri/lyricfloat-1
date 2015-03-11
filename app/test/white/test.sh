for f in *.php
do
	echo Running Test $f
	phpunit $f
	echo
done
