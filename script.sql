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
	

	
