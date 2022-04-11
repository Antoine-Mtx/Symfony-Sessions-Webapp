

INSERT INTO `formation` (`id`, `intitule`, description) VALUES
	(1, 'Développeur web', '');
/*!40000 ALTER TABLE `formation` ENABLE KEYS */;


INSERT INTO `module_formation` (`id`, `categorie_id`, `intitule`, description) VALUES
	(1, 2, 'Word', ''),
	(2, 2, 'Powerpoint',''),
	(3, 1, 'Html/CSS',''),
	(4, 1, 'PhP',''),
	(5, 3, 'Anglais','');
/*!40000 ALTER TABLE `module_formation` ENABLE KEYS */;

INSERT INTO `programme` (`id`, `session_id`, `module_formation_id`, `nb_jours`) VALUES
	(1, 1, 1, 2),
	(2, 1, 2, 1),
	(3, 1, 3, 7),
	(4, 1, 4, 15),
	(5, 1, 5, 2);
/*!40000 ALTER TABLE `planifier` ENABLE KEYS */;

INSERT INTO `session` (`id`, `formateur_referent_id`, `formation_id`, `intitule`, `date_debut`, `date_fin`, `nb_places`) VALUES
	(1, 1, 1, 'DWWM1', '2022-01-24', '2022-07-29', 50);
/*!40000 ALTER TABLE `session` ENABLE KEYS */;

INSERT INTO `stagiaire_session` (`session_id`, `stagiaire_id`) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(1, 4);
