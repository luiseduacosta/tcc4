import os
import re

directories = [
    '/home/luis/Html/tcc5/src',
    '/home/luis/Html/tcc5/templates',
    '/home/luis/Html/tcc5/tests'
]

replacements = [
    ('QuestionesTableTest', 'QuestoesTableTest'),
    ('QuestionesControllerTest', 'QuestoesControllerTest'),
    ('QuestionesFixture', 'QuestoesFixture'),
    ('QuestionesTable', 'QuestoesTable'),
    ('QuestionesController', 'QuestoesController'),
    ('QuestionesPolicy', 'QuestoesPolicy'),
    ('Questiones', 'Questoes'),
    ('questiones', 'questoes'),
    ('Questione', 'Questao'),
    ('questione', 'questao')
]

for directory in directories:
    for root, dirs, files in os.walk(directory):
        for file in files:
            if not file.endswith(('.php', '.json', '.xml', '.neon')):
                continue
            
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8', errors='ignore') as f:
                content = f.read()
            
            original_content = content
            for old, new in replacements:
                content = content.replace(old, new)
            
            if content != original_content:
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(content)
                print(f"Refactored: {filepath}")

print("Renaming finished successfully!")
