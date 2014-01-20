DROP TABLE if exists Participe;
DROP TABLE if exists Appartient;
DROP TABLE if exists Notification;
DROP TABLE if exists Evenement;
DROP TABLE if exists Groupe;
DROP TABLE if exists Utilisateur; 


CREATE TABLE Utilisateur(
	idUtilisateur int not null auto_increment,
	nomUtilisateur varchar(20),
	prenomUtilisateur varchar(20),
	loginUtilisateur char(30),
	password varchar(15),
	PRIMARY KEY(idUtilisateur)
)engine=InnoDB;
	
CREATE TABLE Groupe(
	idGroupe int not null auto_increment,
	libelleGroupe char(40),
	PRIMARY KEY(idGroupe)
)engine=InnoDB;
	
CREATE TABLE Evenement(
	idEvenement int not null auto_increment,
	libelleEvenement char(50),
	description char(200),
	dateEvenement date,
	heureDebut varchar(5),
	heureFin varchar(5),
	idCreateur int not null,
	idGroupe int not null,
	PRIMARY KEY(idEvenement),
	CONSTRAINT fk_createur FOREIGN KEY(idCreateur) REFERENCES Utilisateur(idUtilisateur),
	CONSTRAINT fk_groupe FOREIGN KEY(idGroupe) REFERENCES Groupe(idGroupe)
)engine=InnoDB;

CREATE TABLE Notification(
	idNotification int not null auto_increment,
	titre varchar(20),
	contenu char(100),
	expediteur varchar(20),
	lu boolean,
	idUtilisateur int not null,
	PRIMARY KEY(idNotification),
	CONSTRAINT fk_utilisateur FOREIGN KEY(idUtilisateur) REFERENCES Utilisateur(idUtilisateur)
)engine=InnoDB;

CREATE TABLE Participe(
	idUtilisateur int not null,
	idEvenement int not null,
	PRIMARY KEY(idUtilisateur,idEvenement),
	CONSTRAINT fk_utilisateur2 FOREIGN KEY(idUtilisateur) REFERENCES Utilisateur(idUtilisateur),
	CONSTRAINT fk_evenement FOREIGN KEY(idEvenement) REFERENCES Evenement(idEvenement)
)engine=InnoDB;

CREATE TABLE Appartient(
	idUtilisateur int not null,
	idGroupe int not null,
	PRIMARY KEY(idUtilisateur,idGroupe),
	CONSTRAINT fk_utilisateur3 FOREIGN KEY(idUtilisateur) REFERENCES Utilisateur(idUtilisateur),
	CONSTRAINT fk_groupe1 FOREIGN KEY(idGroupe) REFERENCES Groupe(idGroupe)
)engine=InnoDB;

INSERT INTO Utilisateur values(null,"Leclerc","Thomas","tleclerc",PASSWORD("quenelle"));
INSERT INTO Utilisateur values(null,"Petracca","Charlélie","cpetracca",PASSWORD("quenelle"));
INSERT INTO Utilisateur values(null,"Jean","user1","cpetracca",PASSWORD("quenelle"));
INSERT INTO Utilisateur values(null,"Jean","user2","cpetracca",PASSWORD("quenelle"));
INSERT INTO Utilisateur values(null,"Jean","user3","cpetracca",PASSWORD("quenelle"));

INSERT INTO Groupe values(null,"Groupe test");
INSERT INTO Groupe values(null,"Groupe test 2");

INSERT INTO Appartient values(1,1);
INSERT INTO Appartient values(2,1);
INSERT INTO Appartient values(3,2);
INSERT INTO Appartient values(4,2);
INSERT INTO Appartient values(5,2);	

INSERT INTO Evenement values(null, "Conférence", "Rassemblement autour du thème dressage de poneys", "25-05-2014", "13:30:00", "16:00:00", 1, 1); 
INSERT INTO Evenement values(null, "Spectacle", "spectacle de rue, avec cracheurs de feu et dompteurs d\'ours sauvages de malaisie", "10-10-2014", "18:00:00", "22:00:00", 3, 2); 

INSERT INTO Participe values(1, 1);
INSERT INTO Participe values(2, 1);
INSERT INTO Participe values(4, 2);
INSERT INTO Participe values(5, 2);
	
