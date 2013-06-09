BEGIN TRANSACTION;
CREATE TABLE Ville (
	Nom VARCHAR(20),
	CP VARCHAR(7), 
	Zone_h TIME WITH TIME ZONE, 
	PRIMARY KEY (nom_ville,CP)
);
CREATE TYPE typev AS ENUM ('Avenue','Rue','Impasse','Boulevard');
CREATE SEQUENCE IdPers START 1;
CREATE TABLE Personne (
	Id INTEGER,
	Nom VARCHAR(20),
	Prenom VARCHAR(20),
	Rum_tel VARCHAR(20),
	Rue TEXT,
	CP VARCHAR(7),
	Num_Rue INTEGER,
	Type_Rue typev,
	Ville VARCHAR(20),
	FOREIGN KEY (Ville, CP) REFERENCES Ville(Nom, CP),
	PRIMARY KEY(Id),
	CONSTRAINT numtel_check CHECK (Num_tel ~ '^[0-9]{10,}$'::text));
CREATE TYPE typep AS ENUM ('Salarie','Aiguilleur','Guichetier','AiguilleurGuichetier');
CREATE TYPE typet AS ENUM ('Temps plein','Temps partiel');
CREATE TABLE Salarie (
	Id INTEGER PRIMARY KEY REFERENCES Personne(Id) ON DELETE CASCADE,
	Num_secu INTEGER UNIQUE NOT NULL,
	Duree_travail typet,
	Type typep
	);
CREATE TABLE Voyageur (
	Id INTEGER PRIMARY KEY REFERENCES Personne(Id) ON DELETE CASCADE
);
CREATE TABLE Gare (
	Nom VARCHAR(20),
	Ville VARCHAR(20),
	CP VARCHAR(7),
	Rue TEXT,
	Num_Rue INTEGER,
	Type_Voie typev,
	Tps_Plein_Min INTEGER,
	FOREIGN KEY(Ville,CP) REFERENCES Ville(Nom,CP) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY(Nom,Ville,CP));
CREATE TABLE SalarieGare (
	Id INTEGER REFERENCES Salarie(Id) ON DELETE CASCADE,
	Nom VARCHAR(15),
	Ville VARCHAR(20),
	CP VARCHAR(7),
	FOREIGN KEY (Nom,Ville,CP) REFERENCES Gare(Nom,Ville,CP) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY(Id,Nom,Ville,CP)
);
CREATE TYPE typei AS ENUM('Hotel','Agence de taxis');
CREATE TABLE Point_Interet(
	Num INTEGER PRIMARY KEY,
	Nom TEXT,
	Ville VARCHAR(20) NOT NULL,
	Rue TEXT,
	CP VARCHAR(7) NOT NULL,
	Num_Rue INTEGER,
	Type_Rue typev,
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
	Nom_Type VARCHAR(5) PRIMARY KEY,
	Nb_Prem INTEGER NOT NULL,
	Nb_Scnd INTEGER NOT NULL,
	Vitesse_Max INTEGER NOT NULL
);
CREATE TABLE Train(
	Num_Train INTEGER PRIMARY KEY,
	Type VARCHAR(5) NOT NULL REFERENCES Type_Train(Nom_Type) 
);
CREATE TABLE Trajet(
	Num INTEGER PRIMARY KEY,
	Gare_Depart VARCHAR(20) NOT NULL,
	Ville_Depart VARCHAR(20) NOT NULL,
	CP_Depart VARCHAR(7) NOT NULL,
	Gare_Arrivee VARCHAR(20) NOT NULL,
	Ville_Arrivee VARCHAR(20) NOT NULL,
	CP_Arrivee VARCHAR(7) NOT NULL,
	Date_Depart TIMESTAMP,
	Date_Arrivee TIMESTAMP,
	Num_Train INTEGER NOT NULL REFERENCES Train(Num),
	FOREIGN KEY (Gare_Depart,Ville_Depart,CP_Depart) REFERENCES Gare(Nom,Ville,CP) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (Gare_Arrivee,Ville_Arrivee,CP_Arrivee) REFERENCES Gare(Nom,Ville,CP) ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE TABLE Gare_Intermediaire(
	Num_Trajet INTEGER NOT NULL REFERENCES Trajet(Num) ON DELETE CASCADE,
	Gare_Arrivee VARCHAR(20) NOT NULL,
	Ville_Arrivee VARCHAR(20) NOT NULL,
	CP_Arrivee VARCHAR(7) NOT NULL,
	Horaire TIME,
	FOREIGN KEY (Gare_Arrivee,Ville_Arrivee,CP_Arrivee) REFERENCES Gare(Nom,Ville,CP) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY (Num_Trajet,Gare_Arrivee,Ville_Arrivee,CP_Arrivee)
);
CREATE TYPE payem AS ENUM('Espece','Cheque','Carte de Credit');
CREATE TABLE Billet(
	Num INTEGER PRIMARY KEY,
	Ville_Depart VARCHAR(20) NOT NULL,
	CP_Depart VARCHAR(7) NOT NULL,
	Ville_Arrivee VARCHAR(20) NOT NULL,
	CP_Arrivee VARCHAR(7) NOT NULL,
	Prix REAL,
	Moyen_Paiement payem,
	Internet BOOLEAN,
	Assurance BOOLEAN,
	Voyageur INTEGER NOT NULL REFERENCES Voyageur(Id),
	FOREIGN KEY (Ville_Depart,CP_Depart) REFERENCES Ville(Nom,CP) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (Ville_Arrivee,CP_Arrivee) REFERENCES Ville(Nom,CP) ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE TABLE Billet_Trajet(
	Num_Billet INTEGER NOT NULL REFERENCES Billet(Num) ON UPDATE CASCADE ON DELETE CASCADE,
	Num_Trajet INTEGER NOT NULL REFERENCES Trajet(Num) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY(Num_Billet,Num_Trajet)
);
CREATE TABLE Place_Voyageur(
	Num_Place INTEGER,
	Num_Trajet INTEGER REFERENCES Trajet(Num),
	Num_Billet INTEGER NOT NULL REFERENCES Billet(Num),
	PRIMARY KEY (Num_Place,Num_Trajet)
);
CREATE VIEW vSalarie
AS SELECT * FROM Personne P, Salarie S WHERE P.Id=S.Id;

CREATE VIEW vAiguilleur
AS SELECT * FROM vSalarie WHERE Type=Aiguilleur OR Type=AiguilleurGuichetier;

CREATE VIEW vGuichetier
AS SELECT * FROM vSalarie WHERE Type=Guichetier OR Type=AiguilleurGuichetier;

CREATE VIEW vAutreSalarie
AS SELECT * FROM vSalarie WHERE Type=Salarie;

CREATE VIEW vVoyageur
AS SELECT * FROM Personne P, Voyageur V WHERE P.Id=V.Id;

COMMIT;
