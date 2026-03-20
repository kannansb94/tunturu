import os
import re

base_dir = r"d:\XAMPP\htdocs\Tunturu\resources\views"
files_to_update = [
    r"welcome.blade.php",
    r"layouts\guest.blade.php",
    r"layouts\app.blade.php",
]

# regex to replace <script src="https://cdn.tailwindcss.com..."></script> and following <script> tailwind.config = ... </script>
# with @vite(...)

cdn_pattern = re.compile(
    r'<script\s+src="https://cdn\.tailwindcss\.com[^"]*"></script>\s*<script(?:[^>]*)>\s*tailwind\.config\s*=\s*\{.*?</script>',
    re.DOTALL
)

cdn_pattern2 = re.compile(
    r'<script\s+src="https://cdn\.tailwindcss\.com[^"]*"></script>\s*<script>\s*tailwind\.config\s*=\s*\{.*?</script>',
    re.DOTALL
)

vite_directive = "@vite(['resources/css/app.css', 'resources/js/app.js'])"

# Update non-library files
for filename in files_to_update:
    path = os.path.join(base_dir, filename)
    if os.path.exists(path):
        with open(path, "r", encoding="utf-8") as f:
            content = f.read()
        
        # Replace
        new_content = cdn_pattern.sub(vite_directive, content)
        new_content = cdn_pattern2.sub(vite_directive, new_content)
        
        with open(path, "w", encoding="utf-8") as f:
            f.write(new_content)
        print(f"Updated {filename}")

# Process library files with name replacement
lib_files = [
    r"library\show.blade.php",
    r"library\index.blade.php"
]

replacements = {
    'primary': 'lib-primary',
    'primary-hover': 'lib-primary-hover',
    'secondary': 'lib-secondary',
    'background-dark': 'lib-bg-dark',
    'surface-dark': 'lib-surf-dark',
    'surface-light': 'lib-surf-light',
}

# Pattern to catch things like text-primary, bg-background-dark, border-surface-light, etc.
# Also catches arbitrary modifiers like hover:bg-primary/50
class_pattern = re.compile(r'([a-zA-Z0-9:-]+-)(primary|primary-hover|secondary|background-dark|surface-dark|surface-light)(/[0-9]+)?\b')

def replace_lib_classes(match):
    prefix = match.group(1) # now includes the hyphen
    color = match.group(2)
    suffix = match.group(3) if match.group(3) else ""
    
    if color in replacements:
        return f"{prefix}{replacements[color]}{suffix}"
    return match.group(0)


for filename in lib_files:
    path = os.path.join(base_dir, filename)
    if os.path.exists(path):
        with open(path, "r", encoding="utf-8") as f:
            content = f.read()
            
        new_content = cdn_pattern.sub(vite_directive, content)
        new_content = cdn_pattern2.sub(vite_directive, new_content)
        
        # apply replacements
        new_content = class_pattern.sub(replace_lib_classes, new_content)
        
        # handle edge cases like just 'text-primary' 'bg-primary' etc are already caught since prefix will be 'text', 'bg' etc.
        # Check for bg-surface-dark etc.
        
        with open(path, "w", encoding="utf-8") as f:
            f.write(new_content)
        print(f"Updated {filename}")
