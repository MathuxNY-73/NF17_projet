BEGIN TRANSACTION;

CREATE TABLE Ville (
	Nom VARCHAR(20),
	CP VARCHAR(7), 
	Zone_h INTEGER, 
	PRIMARY KEY (Nom,CP)
);

CREATE TABLE Personne (
	Id SERIAL PRIMARY KEY,
	Nom VARCHAR(20) NOT NULL,
	Prenom VARCHAR(20) NOT NULL,
	Num_tel VARCHAR(20) NOT NULL,
	Rue TEXT,
	CP VARCHAR(7),
	Ville VARCHAR(20),
	FOREIGN KEY (Ville, CP) REFERENCES Ville(Nom, CP),
	UNIQUE (Nom, Prenom, Num_tel)
);
	
CREATE TYPE typep AS ENUM ('Salarie','Aiguilleur','Guichetier','AiguilleurGuichetier');

CREATE TYPE typet AS ENUM ('Temps plein','Temps partiel');

CREATE TABLE Salarie (
	Id INTEGER PRIMARY KEY REFERENCES Personne(Id) ON DELETE CASCADE,
	Num_secu INTEGER UNIQUE NOT NULL,
	Duree_travail typet,
	Types typep
);

CREATE TABLE Voyageur (
	Id INTEGER PRIMARY KEY REFERENCES Personne(Id) ON DELETE CASCADE,
	Login VARCHAR(20) UNIQUE,
	Mdp VARCHAR(20)
);

CREATE TABLE Gare (
	Nom VARCHAR(20),
	Rue TEXT,
	CP VARCHAR(7),
	Ville VARCHAR(20),
	Tps_Plein_Min INTEGER,
	Num SERIAL UNIQUE NOT NULL,
	FOREIGN KEY(Ville,CP) REFERENCES Ville(Nom,CP) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY(Nom,Ville,CP)
);

CREATE TABLE Salarie_Gare (
	Id INTEGER REFERENCES Salarie(Id) ON DELETE CASCADE,
	Nom VARCHAR(15),
	CP VARCHAR(7),
	Ville VARCHAR(20),
	FOREIGN KEY (Nom,Ville,CP) REFERENCES Gare(Nom,Ville,CP) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY(Id,Nom,Ville,CP)
);

CREATE TYPE typei AS ENUM('Hotel','Agence de taxis');

CREATE TABLE Point_Interet(
	Num SERIAL PRIMARY KEY,
	Nom TEXT,
	Rue TEXT,
	CP VARCHAR(7) NOT NULL,
	Ville VARCHAR(20) NOT NULL,
	Type_Interet typei,
	FOREIGN KEY(Ville,CP) REFERENCES ville(Nom,CP) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Gare_Interet(
	Num_Interet INTEGER REFERENCES Point_Interet(Num) ON DELETE CASCADE,
	Gare VARCHAR(20) NOT NULL,
	VilleGare VARCHAR(20) NOT NULL,
	CPGare VARCHAR(7) NOT NULL,
	FOREIGN KEY (Gare,VilleGare,CPGare) REFERENCES Gare(Nom,Ville,CP) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY(Num_Interet,Gare,VilleGare,CPGare)
);

CREATE TABLE Type_Train(
	Nom_Type VARCHAR(20) PRIMARY KEY,
	Nb_Prem INTEGER NOT NULL,
	Nb_Scnd INTEGER NOT NULL,
	Vitesse_Max INTEGER NOT NULL
);

CREATE TABLE Train(
	Num SERIAL PRIMARY KEY,
	Typet VARCHAR(5) NOT NULL REFERENCES Type_Train(Nom_Type) 
);

CREATE TABLE Trajet(
	Num SERIAL PRIMARY KEY,
	Gare_Depart VARCHAR(20) NOT NULL,
	Ville_Depart VARCHAR(20) NOT NULL,
	CP_Depart VARCHAR(7) NOT NULL,
	Gare_Arrivee VARCHAR(20) NOT NULL,
	Ville_Arrivee VARCHAR(20) NOT NULL,
	CP_Arrivee VARCHAR(7) NOT NULL,
	Date_Depart TIMESTAMP,
	Date_Arrivee TIMESTAMP,
	Num_Train INTEGER NOT NULL REFERENCES Train(Num),
	Prix1 REAL,
	Prix2 REAL,
	FOREIGN KEY (Gare_Depart,Ville_Depart,CP_Depart) REFERENCES Gare(Nom,Ville,CP) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (Gare_Arrivee,Ville_Arrivee,CP_Arrivee) REFERENCES Gare(Nom,Ville,CP) ON UPDATE CASCADE ON DELETE CASCADE
);

/*
CREATE TABLE Gare_Intermediaire(
	Num_Trajet INTEGER NOT NULL REFERENCES Trajet(Num) ON DELETE CASCADE,
	Gare_Arrivee VARCHAR(20) NOT NULL,
	Ville_Arrivee VARCHAR(20) NOT NULL,
	CP_Arrivee VARCHAR(7) NOT NULL,
	Horaire TIME,
	FOREIGN KEY (Gare_Arrivee,Ville_Arrivee,CP_Arrivee) REFERENCES Gare(Nom,Ville,CP) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY (Num_Trajet,Gare_Arrivee,Ville_Arrivee,CP_Arrivee)
);
*/

CREATE TYPE payem AS ENUM('Espece','Cheque','Carte de Credit');

CREATE TABLE Billet(
	Num INTEGER,
	--Ville_Depart VARCHAR(20) NOT NULL,
	--CP_Depart VARCHAR(7) NOT NULL,
	--Ville_Arrivee VARCHAR(20) NOT NULL,
	--CP_Arrivee VARCHAR(7) NOT NULL,
	Prix REAL,
	Moyen_Paiement payem,
	Internet BOOLEAN,
	Assurance BOOLEAN,
	Voyageur INTEGER NOT NULL REFERENCES Voyageur(Id),
	Num_Trajet INTEGER REFERENCES Trajet(Num) ON UPDATE CASCADE ON DELETE CASCADE,
	Classe INTEGER,
	PRIMARY KEY (Num, Num_Trajet)
	--FOREIGN KEY (Ville_Depart,CP_Depart) REFERENCES Ville(Nom,CP) ON UPDATE CASCADE ON DELETE CASCADE,
	--FOREIGN KEY (Ville_Arrivee,CP_Arrivee) REFERENCES Ville(Nom,CP) ON UPDATE CASCADE ON DELETE CASCADE
);

/*
CREATE TABLE Billet_Trajet(
	Num_Billet INTEGER NOT NULL REFERENCES Billet(Num) ON UPDATE CASCADE ON DELETE CASCADE,
	Num_Trajet INTEGER NOT NULL REFERENCES Trajet(Num) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY(Num_Billet,Num_Trajet)
);

CREATE TABLE Place_Voyageur(
	Num_Place SERIAL, --PROBLEME A RESOUDRE!!!
	Num_Trajet INTEGER REFERENCES Trajet(Num),
	Num_Billet INTEGER NOT NULL REFERENCES Billet(Num),
	PRIMARY KEY (Num_Place,Num_Trajet)
);
*/

CREATE VIEW vSalarie
AS SELECT P.Id, P.Nom, P.Prenom, P.Num_tel, P.Rue, P.CP, P.Ville, S.Num_secu, S.Duree_travail, S.Types FROM projet.Personne P, projet.Salarie S WHERE P.Id=S.Id;

CREATE VIEW vAiguilleur
AS SELECT * FROM projet.vSalarie WHERE Types='Aiguilleur' OR Types='AiguilleurGuichetier';

CREATE VIEW vGuichetier
AS SELECT * FROM projet.vSalarie WHERE Types='Guichetier' OR Types='AiguilleurGuichetier';

CREATE VIEW vAutreSalarie
AS SELECT * FROM projet.vSalarie WHERE Types='Salarie';

CREATE VIEW vVoyageur
AS SELECT P.Id, P.Nom, P.Prenom, P.Num_tel, P.Rue, P.CP, P.Ville, V.Login, V.Mdp FROM projet.Personne P, projet.Voyageur V WHERE P.Id=V.Id;

CREATE FUNCTION insert_ville() RETURNS trigger AS $insert_ville$
BEGIN
	IF NEW.ville NOT IN (SELECT Nom FROM projet.Ville) THEN
		INSERT INTO projet.Ville VALUES (NEW.ville, NEW.CP, 0);
	END IF;
	RETURN NEW;
END;
$insert_ville$ LANGUAGE plpgsql;

CREATE TRIGGER insert_ville BEFORE INSERT ON Personne
	FOR EACH ROW EXECUTE PROCEDURE insert_ville();
	
CREATE TRIGGER update_ville BEFORE UPDATE ON Personne
	FOR EACH ROW EXECUTE PROCEDURE insert_ville();
	
COMMIT;
