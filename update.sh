#!/usr/bin/env bash

# Get the latest release information
LATEST_RELEASE=$(curl -L -s -H 'Accept: application/json' https://github.com/vrana/adminer/releases/latest)

# The releases are returned in the format {"id":3622206,"tag_name":"hello-1.0.0.11",...}, we have to extract the tag_name.
LATEST_VERSION=$(echo $LATEST_RELEASE | sed -e 's/.*"tag_name":"\([^"]*\)".*/\1/')

# Build URL for the latest php file
FILENAME="adminer-"${LATEST_VERSION#?}".php"
ARTIFACT_URL="https://github.com/vrana/adminer/releases/download/${LATEST_VERSION}/${FILENAME}"

# Make sure we support arrays
ARRAYTEST[0]='test' || (echo 'Failure: arrays are not supported in this version of bash' && exit 2)

# Define the plugins here
PLUGINS=(
  'dump-json'
  'dump-xml'
  'dump-zip'
  'foreign-system'
  'plugin'
)

# Actually download the new version files
echo "Updating adminer"
echo " -" ${LATEST_VERSION}
curl -Ls "${ARTIFACT_URL}" > ${FILENAME}

# Count of the plugins
count=0
while [ "x${PLUGINS[count]}" != "x" ]; do
  count=$(( $count + 1 ))
done

# Loop through them
echo "Updating plugins"
for i in $(seq 0 $(( $count - 1 )) ); do
  echo " -" $(basename ${PLUGINS[i]})
  if [[ ${PLUGINS[i]} == http* ]]; then
    curl -Ls "${PLUGINS[i]}" > plugins/$(basename ${PLUGINS[i]})
  else
    curl -Ls "https://raw.githubusercontent.com/vrana/adminer/${LATEST_VERSION}/plugins/${PLUGINS[i]}.php" > plugins/${PLUGINS[i]}.php
  fi
done

