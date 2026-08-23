import os
import re

controllers_dir = '/home/luis/Html/tcc5/src/Controller'

for root, dirs, files in os.walk(controllers_dir):
    for file in files:
        if file.endswith('.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()
            
            # Replace \Cake\ORM\TableRegistry with \Cake\ORM\Table
            new_content = content.replace('\\Cake\\ORM\\TableRegistry', '\\Cake\\ORM\\Table')
            
            if new_content != content:
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                print(f"Updated annotations in {file}")
