BEGIN TRANSACTION;
CREATE TABLE Ville (
	nom_ville VARCHAR(20),
	CP VARCHAR(7), 
	zone_h TIME WITH TIME ZONE, 
	PRIMARY KEY (nom_ville,CP)
);
CREATE TYPE typev AS ENUM ('Avenue','Rue','Impasse','Boulevard');
CREATE SEQUENCE IdPers START 1;
CREATE TABLE Personne (
	Id INTEGER,
	Nom VARCHAR(10),
	Prenom VARCHAR(20),
	Num_tel VARCHAR(10),
	Rue TEXT,
	CP VARCHAR(7),
	Num_Rue INTEGER,
	Type_Rue typev,
	VilleP VARCHAR(20),
	FOREIGN KEY (CP,VilleP) REFERENCES Ville(nom_ville,CP),
	PRIMARY KEY(Id),
	CONSTRAINT numtel_check CHECK (Num_tel ~ '^[0-9]{10,}$'::text));
CREATE TYPE typep AS ENUM ('Salarie','Aiguilleur','Guichetier','AiguilleurGuichetier');
CREATE TYPE typet AS ENUM ('Temps Plein','Temps partiel');
CREATE TABLE Salarie (
	Id INTEGER PRIMARY KEY REFERENCES Personne(Id) ON DELETE CASCADE,
	Num_secu INTEGER UNIQUE NOT NULL,
	Duree_travail typet,
	type typep
	);
CREATE TABLE Voyageur (
	Id INTEGER PRIMARY KEY REFERENCES Personne(Id) ON DELETE CASCADE
);
CREATE TABLE Gare (
	Nom VARCHAR(15),
	Ville VARCHAR(20),
	CP VARCHAR(7),
	Rue TEXT,
	Num_Rue INTEGER,
	Type_Voie typev,
	Tps_Plein_min INTEGER,
	FOREIGN KEY(Ville,CP) REFERENCES Ville(nom_ville,CP) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY(Nom,Ville,CP));
CREATE TABLE SalarieGare (
	Id INTEGER REFERENCES Salarie(Id) ON DELETE CASCADE,
	Nom VARCHAR(15),
	Ville VARCHAR(20),
	CP VARCHAR(7),
	FOREIGN KEY (Nom,Ville,CP) REFERENCES Gare(Nom,Ville,CP) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY(Id,Nom,Ville,CP)
);
CREATE TYPE typei AS ENUM('Hôtel','Agence de taxis');
CREATE TABLE Point_Interet(
	Num_interet INTEGER PRIMARY KEY,
	Nom TEXT,
	Ville VARCHAR(20) NOT NULL,
	Rue TEXT,
	CP VARCHAR(7) NOT NULL,
	Num_Rue INTEGER,
	Type_Rue typev,
	Type_interet VARCHAR(10),
	FOREIGN KEY(Ville,CP) REFERENCES ville(nom_ville,CP) ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE TABLE Gare_Interet(
	Num_interet INTEGER REFERENCES Point_Interet,
	Nom VARCHAR(15) NOT NULL,
	VilleGare VARCHAR(20) NOT NULL,
	CPGare VARCHAR(7) NOT NULL,
	FOREIGN KEY (Nom,VilleGare,CPGare) REFERENCES Gare(Nom,Ville,CP) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY(Num_Interet,Nom,VilleGare,CPGare)
);
CREATE TABLE Type_Train(
	Nom_Type VARCHAR(5) PRIMARY KEY,
	Nb_Prem INTEGER,
	Nb_Scnd INTEGER,
	Vitesse_Max INTEGER
);
CREATE TABLE Train(
	Num_Train INTEGER PRIMARY KEY,
	Nom_Type VARCHAR(5) NOT NULL REFERENCES Type_Train(Nom_Type) 
);
CREATE TABLE Trajet(
	Num_Trajet INTEGER PRIMARY KEY,
	Gare_Depart VARCHAR(15) NOT NULL,
	Ville_Depart VARCHAR(20) NOT NULL,
	CP_Depart VARCHAR(7) NOT NULL,
	Gare_Arrivee VARCHAR(15) NOT NULL,
	Ville_Arrivee VARCHAR(20) NOT NULL,
	CP_Arrivee VARCHAR(7) NOT NULL,
	Date_Depart TIMESTAMP,
	Date_Arrivee TIMESTAMP,
	Num_Train INTEGER,
	FOREIGN KEY (Gare_Depart,Ville_Depart,CP_Depart) REFERENCES Gare(Nom,Ville,CP),
	FOREIGN KEY (Gare_Arrivee,Ville_Arrivee,CP_Arrivee) REFERENCES Gare(Nom,Ville,CP)
);
CREATE TABLE Gare_Intermediaire(
	Num_Trajet INTEGER NOT NULL REFERENCES Trajet ON DELETE CASCADE,
	Gare_Arrivee VARCHAR(15) NOT NULL,
	Ville_Arrivee VARCHAR(20) NOT NULL,
	CP_Arrivee VARCHAR(7) NOT NULL,
	Horaire TIME,
	FOREIGN KEY (Gare_Arrivee,Ville_Arrivee,CP_Arrivee) REFERENCES Gare(Nom,Ville,CP),
	PRIMARY KEY (Num_Trajet,Gare_Arrivee,Ville_Arrivee,CP_Arrivee)
);
CREATE TYPE payem AS ENUM('Espèce','Cheque','Carte de Crédit');
CREATE TABLE Billet(
	Num_Billet INTEGER PRIMARY KEY,
	Ville_Depart VARCHAR(20) NOT NULL,
	CP_Depart VARCHAR(7) NOT NULL,
	Ville_Arrivee VARCHAR(20) NOT NULL,
	CP_Arrivee VARCHAR(7) NOT NULL,
	Prix MONEY,
	Moyen_Paiement payem,
	Internet BOOLEAN,
	Assurance BOOLEAN,
	Id INTEGER NOT NULL REFERENCES Voyageur,
	FOREIGN KEY (Ville_Depart,CP_Depart) REFERENCES Ville(Nom_Ville,CP),
	FOREIGN KEY (Ville_Arrivee,CP_Arrivee) REFERENCES Ville(Nom_Ville,CP)
);
CREATE TABLE Billet_Trajet(
	Num_Billet INTEGER NOT NULL REFERENCES Billet ON UPDATE CASCADE ON DELETE CASCADE,
	Num_Trajet INTEGER NOT NULL REFERENCES Trajet,
	PRIMARY KEY(Num_Billet,Num_Trajet)
);
CREATE TABLE Place_Voyageur(
	Num_Place INTEGER,
	Num_Trajet INTEGER NOT NULL REFERENCES Trajet,
	Num_Billet INTEGER NOT NULL,
	PRIMARY KEY (Num_Place,Num_Trajet)
);
COMMIT;
