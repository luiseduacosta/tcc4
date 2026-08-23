---
kind: business_term
name: Business Glossary
category: business_term
scope:
    - '**'
---

### Monografia
- Definition：A student thesis/research paper record in the system, modeled by `MonografiasTable`/`Monografia` entity, linked to a professor via `professor_id` (formerly `num_prof`) and to an area via `areamonografia`. Forms collect three banca (jury) member IDs (`banca1`, `banca2`, `banca3`) that are plain integer columns.
- Aliases：monografias、thesis、paper

### Banca
- Definition：The jury panel assigned to evaluate a monografia; stored as three integer foreign-key-like columns `banca1`, `banca2`, `banca3` referencing professor IDs. In templates they are rendered as selects pre-populated from the saved values.
- Aliases：banca1、banca2、banca3、jury

### Docente
- Definition：A faculty/professor entity (`DocentesTable`/`Professor` entity) who may serve as the primary supervisor of a monografia (`professor_id`) and/or as a banca member. The inverse relationship `hasMany('Monografias')` on `DocentesTable` uses `professor_id` as the foreign key.
- Aliases：professor、teacher、faculty

### TCC
- Definition：Trabalho de Conclusão de Curso (graduation thesis project). The app name `tcc5` and the `Tccestudantes` controller/entity indicate this is a TCC management system tracking students enrolled in their final project work.
- Aliases：tcc、trabalho de conclusão de curso
