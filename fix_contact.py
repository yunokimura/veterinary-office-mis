import re

with open('resources/views/announcements/edit.blade.php') as f:
    content = f.read()

# Replace the contact_number input to add maxlength and oninput
old_pattern = r'name="contact_number"[^>]+placeholder="Enter contact number"'
new_replacement = 'name="contact_number" value="{{ old(\'contact_number\', $announcement->contact_number) }}" maxlength="11" oninput="validateContactNumber(this)" placeholder="Enter contact number"'

content = re.sub(old_pattern, new_replacement, content)

with open('resources/views/announcements/edit.blade.php', 'w') as f:
    f.write(content)

print('Fixed contact_number input')
