import os
import re

controllers_dir = '/home/luis/Html/tcc5/src/Controller'

for root, dirs, files in os.walk(controllers_dir):
    for file in files:
        if file.endswith('.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()
            
            # Replace @property \Cake\ORM\Query with @property \Cake\ORM\Table
            # using regex to only target property docblock lines
            pattern = r'(\*\s*@property\s+)\\Cake\\ORM\\Query(\s+\$\w+)'
            new_content = re.sub(pattern, r'\1\\Cake\\ORM\\Table\2', content)
            
            if new_content != content:
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                print(f"Updated Query annotations in {file}")
