#!/bin/bash

# Get the current month and day
current_month=$(date "+%m")
current_day=$(date "+%d")

# Set the target month and day based on the current date
target_month="$current_month"
target_day="$current_day"

# Set the source directory
source_directory="/var/www/html/Abhishek/lms_laravel/storage/app/Laravel/"

# Get the latest .zip file in the source directory
latest_file=$(find "$source_directory" -maxdepth 1 -type f -name "*.zip" -printf "%T@ %p\n" | sort -n | tail -n 1 | cut -d' ' -f2-)

# Check if a new .zip file exists
if [ -n "$latest_file" ]; then
    echo "New .zip file found: $latest_file"

    # Generate the file name using the current date
    file_name="$(date "+%Y")-$target_month-$target_day-$(basename "$latest_file")"

    # Set the destination path on the remote server
    remote_server="root@192.168.1.90:/root/$file_name"

    # Set the password for the remote server
    password="xspl@2018"

    # Perform the file transfer using rsync with password authentication
    sshpass -p "$password" rsync -avz -e "ssh -o StrictHostKeyChecking=no" "$latest_file" "$remote_server"

    echo "File transfer completed."
else
    echo "No new .zip file found in the directory: $source_directory"
fi
