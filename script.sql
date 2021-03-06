DROP TABLE if exists PARTICIPE;
DROP TABLE if exists APPARTIENT;
DROP TABLE if exists NOTIFICATION;
DROP TABLE if exists EVENEMENT;
DROP TABLE if exists GROUPE;
DROP TABLE if exists UTILISATEUR; 


CREATE TABLE UTILISATEUR(
	idUtilisateur int not null auto_increment,
	nomUtilisateur varchar(20),
	prenomUtilisateur varchar(20),
	loginUtilisateur char(30),
	password varchar(40),
	PRIMARY KEY(idUtilisateur)
)engine=InnoDB;
	
CREATE TABLE GROUPE(
	idGroupe int not null auto_increment,
	libelleGroupe char(40),
	PRIMARY KEY(idGroupe)
)engine=InnoDB;
	
CREATE TABLE EVENEMENT(
	id int(11) NOT NULL AUTO_INCREMENT,
	title varchar(255) COLLATE utf8_bin NOT NULL,
	start datetime NOT NULL,
	end datetime DEFAULT NULL,
	url varchar(255) COLLATE utf8_bin NOT NULL,
	allDay boolean NOT NULL DEFAULT false,
	description char(200),
	idCreateur int not null,
	idGroupe int not null,
	PRIMARY KEY(id),
	CONSTRAINT fk_createur FOREIGN KEY(idCreateur) REFERENCES UTILISATEUR(idUtilisateur),
	CONSTRAINT fk_groupe FOREIGN KEY(idGroupe) REFERENCES GROUPE(idGroupe)
)engine=InnoDB;

CREATE TABLE NOTIFICATION(
	idNotification int not null auto_increment,
	titre varchar(20),
	contenu char(100),
	expediteur varchar(20),
	lu boolean,
	idUtilisateur int not null,
	PRIMARY KEY(idNotification),
	CONSTRAINT fk_utilisateur FOREIGN KEY(idUtilisateur) REFERENCES UTILISATEUR(idUtilisateur)
)engine=InnoDB;

CREATE TABLE PARTICIPE(
	idUtilisateur int not null,
	idEvenement int not null,
	PRIMARY KEY(idUtilisateur,idEvenement),
	CONSTRAINT fk_utilisateur2 FOREIGN KEY(idUtilisateur) REFERENCES UTILISATEUR(idUtilisateur),
	CONSTRAINT fk_evenement FOREIGN KEY(idEvenement) REFERENCES EVENEMENT(id)
)engine=InnoDB;

CREATE TABLE APPARTIENT(
	idUtilisateur int not null,
	idGroupe int not null,
	PRIMARY KEY(idUtilisateur,idGroupe),
	CONSTRAINT fk_utilisateur3 FOREIGN KEY(idUtilisateur) REFERENCES UTILISATEUR(idUtilisateur),
	CONSTRAINT fk_groupe1 FOREIGN KEY(idGroupe) REFERENCES GROUPE(idGroupe)
)engine=InnoDB;

INSERT INTO UTILISATEUR values(null,"Leclerc","Thomas","tleclerc",sha1("quenelle"));
INSERT INTO UTILISATEUR values(null,"Petracca","Charlélie","cpetracc",sha1("quenelle"));
INSERT INTO UTILISATEUR values(null,"Jean","user1","user1",sha1("quenelle"));
INSERT INTO UTILISATEUR values(null,"Jean","user2","user2",sha1("quenelle"));
INSERT INTO UTILISATEUR values(null,"Jean","user3","user3",sha1("quenelle"));

INSERT INTO GROUPE values(null,"Groupe test");
INSERT INTO GROUPE values(null,"Groupe test 2");

INSERT INTO APPARTIENT values(1,1);
INSERT INTO APPARTIENT values(2,1);
INSERT INTO APPARTIENT values(3,2);
INSERT INTO APPARTIENT values(4,2);
INSERT INTO APPARTIENT values(5,2);	

INSERT INTO EVENEMENT values(null, "Conférence", "2014-01-10", "2014-01-10",'', false,"Rassemblement autour du thème dressage de poneys", 1, 1); 
INSERT INTO EVENEMENT values(null, "Spectacle","2014-10-10", "2014-10-10",'', true,"spectacle de rue, avec cracheurs de feu et dompteurs d\'ours sauvages de malaisie", 3, 2); 

INSERT INTO PARTICIPE values(1, 1);
INSERT INTO PARTICIPE values(2, 1);
INSERT INTO PARTICIPE values(4, 2);
INSERT INTO PARTICIPE values(5, 2);
	
