#!/bin/bash -v

# Run all the scripts to deal with a new schema.

# ./deleteuploads.sh
./extract-schema-and-fixture.sh
php ./doctrine generate-models-yaml
./fixmodels.sh
yes | php ./doctrine build-all-reload
