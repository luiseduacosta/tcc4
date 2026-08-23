import os
import re

controllers_dir = '/home/luis/Html/tcc5/src/Controller'

for root, dirs, files in os.walk(controllers_dir):
    for file in files:
        if file.endswith('.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()
            
            # Pattern to match two consecutive docblocks immediately preceding the class declaration
            pattern = r'(/\*\*.*?\*/)\s*(/\*\*.*?\*/)\s*class\s+(\w+)'
            match = re.search(pattern, content, re.DOTALL)
            
            if match:
                doc1 = match.group(1)
                doc2 = match.group(2)
                classname = match.group(3)
                
                # Extract inner content of doc1
                lines1 = doc1.strip().split('\n')[1:-1]
                # Extract inner content of doc2
                lines2 = doc2.strip().split('\n')[1:-1]
                
                # Merge lines and clean them up
                merged_lines = []
                # Keep non-empty and non-redundant lines
                seen = set()
                
                # Let's place description/general comments first, and @property/@method last
                desc_lines = []
                prop_lines = []
                
                for line in lines2 + lines1:
                    stripped = line.strip().lstrip('*').strip()
                    if not stripped:
                        continue
                    if stripped in seen:
                        continue
                    seen.add(stripped)
                    
                    if stripped.startswith('@property') or stripped.startswith('@method'):
                        prop_lines.append(line)
                    else:
                        desc_lines.append(line)
                
                # Reconstruct the single merged docblock
                new_doc = ['/**']
                for line in desc_lines:
                    new_doc.append(line)
                if desc_lines and prop_lines:
                    new_doc.append(' *')
                for line in prop_lines:
                    new_doc.append(line)
                new_doc.append(' */')
                
                new_doc_str = '\n'.join(new_doc)
                
                # Replace the match in the content
                span = match.span()
                new_content = content[:span[0]] + new_doc_str + '\nclass ' + classname + content[span[1]:]
                
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                print(f"Merged double docblocks in {file}")
