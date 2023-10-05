import os
import re
import datetime

# Define the directory where the file is located
file_path = "/var/www/html/Abhishek/lms_laravel/storage/app/Laravel/2023-05-04-11-05-27.zip"

# Calculate the date one month ago from the current date
one_month_ago = datetime.datetime.now() - datetime.timedelta(days=30)

# Extract the datetime from the filename
filename = os.path.basename(file_path)
pattern = r"(\d{4}-\d{2}-\d{2}-\d{2}-\d{2}-\d{2})\.zip"
match = re.search(pattern, filename)

if match:
    file_date = datetime.datetime.strptime(match.group(1), "%Y-%m-%d-%H-%M-%S")
    if file_date <= one_month_ago:
        os.remove(file_path)
        print("Deleted: {}".format(file_path))
    else:
        print("File is not old enough to be deleted.")
else:
    print("File does not match the expected pattern.")
