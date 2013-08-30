BEGIN TRANSACTION;

--INSERTS POUR AVOIR UN PACKAGE DE DONNEES DE BASE	
INSERT INTO projet.Ville VALUES
	('Defaut', '00000', 0),
	('Compiegne', '60200', 0),
	('Paris', '75010', 0),
	('Strasbourg', '67000', 0),
	('Creil', '60100', 0),
	('Chantilly', '60500', 0),
	('Lyon', '69000', 0);
	
INSERT INTO projet.Personne VALUES (DEFAULT, 'Guichet', 'Guichet', 'Guichet', '', '00000', 'Defaut');
INSERT INTO projet.Personne VALUES (DEFAULT, 'Weibel', 'Anthony', '0678670106', '17 rue Winston Churchill', '60200', 'Compiegne');
INSERT INTO projet.Voyageur VALUES (1, 'Guichet', 'Guichet');
INSERT INTO projet.Voyageur VALUES (2, 'Tony67', 'tnttnt');

INSERT INTO projet.Gare VALUES
	('Compiegne', '3 place de la Gare', '60200', 'Compiegne', 1),
	('Gare du Nord', '18 rue de Dunkerque', '75010', 'Paris', 2),
	('Gare de l\'Est', 'Place du 11-Novembre-1918', '75010', 'Paris', 2),
	('Strasbourg', '20 place de la gare', '67000', 'Strasbourg', 2),
	('Creil', '2 rue de Picardie', '60100', 'Creil', 1),
	('Chantilly', '7 route de l\'Hippodrome', '60500', 'Chantilly', 1),
	('Lyon', '28 rue des Pommiers', '69000', 'Lyon', 3);
	
INSERT INTO Type_Train VALUES ('TGV', 3, 5, 574), ('TER', 1, 3, 160);
INSERT INTO Train VALUES (DEFAULT, 'TGV'), (DEFAULT, 'TGV'), (DEFAULT, 'TGV'), (DEFAULT, 'TER'), (DEFAULT, 'TER'), (DEFAULT, 'TER'), (DEFAULT, 'TER');

INSERT INTO projet.Point_Interet VALUES
	(DEFAULT, 'Hotel Kyriad', '7 place du Chateau', '60200', 'Compiegne', 'Hotel'),
	(DEFAULT, 'Hotel Ibis', '113 rue Charles de Gaulle', '75010', 'Paris', 'Hotel'),
	(DEFAULT, 'Taxi Durand', '2 rue St Felicien', '75010', 'Paris', 'Agence de taxis'),
	(DEFAULT, 'Hotel Richelieu', '77 place de la gare', '67000', 'Strasbourg', 'Hotel'),
	(DEFAULT, 'Hansi-Taxi', '23 route du Rhin', '67000', 'Strasbourg', 'Agence de taxis'),
	(DEFAULT, 'Taxi Maxim', '42 avenue du bateau', '60200', 'Compiegne', 'Agence de taxis'),
	(DEFAULT, 'Taxi du Lyon', '54 route des oiseaux', '69000', 'Lyon', 'Agence de taxis'),
	(DEFAULT, 'Hotel Mercure', '44 square de la mare Gaudry', '69000', 'Lyon', 'Hotel');

INSERT INTO projet.Gare_Interet VALUES
	(1, 'Compiegne', 'Compiegne', '60200'),
	(2, 'Gare du Nord', 'Paris', '75010'),
	(3, 'Gare de l\'Est', 'Paris', '75010'),
	(4, 'Strasbourg', 'Strasbourg', '67000'),
	(5, 'Strasbourg', 'Strasbourg', '67000'),
	(6, 'Compiegne', 'Compiegne', '60200'),
	(7, 'Lyon', 'Lyon', '69000'),
	(8, 'Lyon', 'Lyon', '69000');
	
INSERT INTO projet.Trajet VALUES (DEFAULT, 'Compiegne', 'Compiegne', '60200', 'Gare du Nord', 'Paris', '75010', '2013-06-15 12:00', '2013-06-15 12:45', 4, 8.78, 5.50);
INSERT INTO projet.Trajet VALUES (DEFAULT, 'Gare du Nord', 'Paris', '75010', 'Strasbourg', 'Strasbourg', '67000', '2013-06-15 13:02', '2013-06-15 15:09', 1, 80.32, 60.32);

INSERT INTO projet.Trajet VALUES (DEFAULT, 'Gare du Nord', 'Paris', '75010', 'Lyon', 'Lyon', '69000', '2013-12-24 13:02', '2013-12-24 16:09', 1, 92.89, 67.69);
INSERT INTO projet.Trajet VALUES (DEFAULT, 'Gare du Nord', 'Paris', '75010', 'Lyon', 'Lyon', '69000', '2013-12-24 14:02', '2013-12-24 17:09', 2, 92.89, 67.69);
INSERT INTO projet.Trajet VALUES (DEFAULT, 'Gare du Nord', 'Paris', '75010', 'Lyon', 'Lyon', '69000', '2013-12-24 15:02', '2013-12-24 18:09', 3, 92.89, 67.69);

INSERT INTO projet.Trajet VALUES (DEFAULT, 'Compiegne', 'Compiegne', '60200', 'Gare du Nord', 'Paris', '75010', '2013-12-24 11:19', '2013-12-24 11:59', 4, 8.78, 5.50);
INSERT INTO projet.Trajet VALUES (DEFAULT, 'Compiegne', 'Compiegne', '60200', 'Gare du Nord', 'Paris', '75010', '2013-12-24 12:05', '2013-12-24 12:45', 5, 8.78, 5.50);
INSERT INTO projet.Trajet VALUES (DEFAULT, 'Compiegne', 'Compiegne', '60200', 'Gare du Nord', 'Paris', '75010', '2013-12-24 12:22', '2013-12-24 13:02', 6, 8.78, 5.50);

COMMIT;