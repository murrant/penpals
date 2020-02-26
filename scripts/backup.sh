#!/bin/bash
FILE=/tmp/penpals.sql.xz
TOKEN=""

if [ -f "$FILE" ]; then
        mv -f "$FILE" "${FILE}.old"
else
        touch "${FILE}.old"
fi

mysqldump --skip-comments -u root penpals | xz > "$FILE"

if cmp -s "$FILE" "${FILE}.old"; then
        echo "No changes"
else
   curl -X POST https://content.dropboxapi.com/2/files/upload \
     --header "Authorization: Bearer ${TOKEN}" \
     --header "Dropbox-API-Arg: {\"path\": \"/penpals.sql.xz\", \"mode\": \"overwrite\"}" \
     --header "Content-Type: application/octet-stream" \
     --data-binary "@${FILE}"

        if [ $? -eq 0 ]; then
                echo "Backup success"
        else
                echo "Backup failed!"
        fi
fi
