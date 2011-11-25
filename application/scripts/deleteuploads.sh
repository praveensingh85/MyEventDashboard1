#!/bin/bash

# Delete uploaded files (e.g. images for profile photos)
#
# The database records the names of uploaded files.  So if we
# reload the database from a fixture, those names are lost, and
# new uploads are needed to make images available and correctly
# correlated with the accounts and logins.  So when reloading the
# database, it's probably a good idea to clean out the uploaded
# files.

appscriptsdir="`dirname $0`"
uploadsdir=$appscriptsdir/../../public/uploads

if [ -d $uploadsdir ] ; then
  find $uploadsdir -type f -a ! -name empty.txt | xargs -n 50 rm -f
else
  echo "*** Error *** Not a directory: '$uploadsdir'" 2>&1
  exit 1
fi;
