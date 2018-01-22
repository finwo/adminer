#!/usr/bin/env bash

# Get the latest release information
LATEST_RELEASE=$(curl -L -s -H 'Accept: application/json' https://github.com/vrana/adminer/releases/latest)

# The releases are returned in the format {"id":3622206,"tag_name":"hello-1.0.0.11",...}, we have to extract the tag_name.
LATEST_VERSION=$(echo $LATEST_RELEASE | sed -e 's/.*"tag_name":"\([^"]*\)".*/\1/')

# Build URL for the latest php file
FILENAME="adminer-"${LATEST_VERSION#?}".php"
ARTIFACT_URL="https://github.com/vrana/adminer/releases/download/${LATEST_VERSION}/${FILENAME}"

# Actually download the new version
curl -L "${ARTIFACT_URL}" > ${FILENAME}

