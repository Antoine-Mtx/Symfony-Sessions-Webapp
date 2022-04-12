SELECT c.intitule, m.intitule
FROM programme p
INNER JOIN session s
ON p.session_id = s.id
INNER JOIN module_formation m
ON p.module_formation_id = m.id
INNER JOIN categorie c
ON c.id = m.categorie_id