DROP TABLE if exists PARTICIPE;
DROP TABLE if exists APPARTIENT;
DROP TABLE if exists NOTIFICATION;
DROP TABLE if exists EVENEMENT;
DROP TABLE if exists GROUPE;
DROP TABLE if exists UTILISATEUR; 


CREATE TABLE UTILISATEUR(
	idUTILISATEUR int not null auto_increment,
	nomUTILISATEUR varchar(20),
	prenomUTILISATEUR varchar(20),
	loginUTILISATEUR char(30),
	password varchar(15),
	PRIMARY KEY(idUTILISATEUR)
)engine=InnoDB;
	
CREATE TABLE GROUPE(
	idGROUPE int not null auto_increment,
	libelleGROUPE char(40),
	PRIMARY KEY(idGROUPE)
)engine=InnoDB;
	
CREATE TABLE EVENEMENT(
	idEVENEMENT int not null auto_increment,
	libelleEVENEMENT char(50),
	description char(200),
	dateEVENEMENT date,
	heureDebut varchar(5),
	heureFin varchar(5),
	idCreateur int not null,
	idGROUPE int not null,
	PRIMARY KEY(idEVENEMENT),
	CONSTRAINT fk_createur FOREIGN KEY(idCreateur) REFERENCES UTILISATEUR(idUTILISATEUR),
	CONSTRAINT fk_GROUPE FOREIGN KEY(idGROUPE) REFERENCES GROUPE(idGROUPE)
)engine=InnoDB;

CREATE TABLE NOTIFICATION(
	idNOTIFICATION int not null auto_increment,
	titre varchar(20),
	contenu char(100),
	expediteur varchar(20),
	lu boolean,
	idUTILISATEUR int not null,
	PRIMARY KEY(idNOTIFICATION),
	CONSTRAINT fk_UTILISATEUR FOREIGN KEY(idUTILISATEUR) REFERENCES UTILISATEUR(idUTILISATEUR)
)engine=InnoDB;

CREATE TABLE PARTICIPE(
	idUTILISATEUR int not null,
	idEVENEMENT int not null,
	PRIMARY KEY(idUTILISATEUR,idEVENEMENT),
	CONSTRAINT fk_UTILISATEUR2 FOREIGN KEY(idUTILISATEUR) REFERENCES UTILISATEUR(idUTILISATEUR),
	CONSTRAINT fk_EVENEMENT FOREIGN KEY(idEVENEMENT) REFERENCES EVENEMENT(idEVENEMENT)
)engine=InnoDB;

CREATE TABLE APPARTIENT(
	idUTILISATEUR int not null,
	idGROUPE int not null,
	PRIMARY KEY(idUTILISATEUR,idGROUPE),
	CONSTRAINT fk_UTILISATEUR3 FOREIGN KEY(idUTILISATEUR) REFERENCES UTILISATEUR(idUTILISATEUR),
	CONSTRAINT fk_GROUPE1 FOREIGN KEY(idGROUPE) REFERENCES GROUPE(idGROUPE)
)engine=InnoDB;

INSERT INTO UTILISATEUR values(null,"Leclerc","Thomas","tleclerc",sha1("quenelle"));
INSERT INTO UTILISATEUR values(null,"Petracca","Charlélie","cpetracca",PASSWORD("quenelle"));
INSERT INTO UTILISATEUR values(null,"Jean","user1","cpetracca",sha1("quenelle"));
INSERT INTO UTILISATEUR values(null,"Jean","user2","cpetracca",sha1("quenelle"));
INSERT INTO UTILISATEUR values(null,"Jean","user3","cpetracca",sha1("quenelle"));

INSERT INTO GROUPE values(null,"GROUPE test");
INSERT INTO GROUPE values(null,"GROUPE test 2");

INSERT INTO APPARTIENT values(1,1);
INSERT INTO APPARTIENT values(2,1);
INSERT INTO APPARTIENT values(3,2);
INSERT INTO APPARTIENT values(4,2);
INSERT INTO APPARTIENT values(5,2);	

INSERT INTO EVENEMENT values(null, "Conférence", "Rassemblement autour du thème dressage de poneys", "25-05-2014", "13:30:00", "16:00:00", 1, 1); 
INSERT INTO EVENEMENT values(null, "Spectacle", "spectacle de rue, avec cracheurs de feu et dompteurs d\'ours sauvages de malaisie", "10-10-2014", "18:00:00", "22:00:00", 3, 2); 

INSERT INTO PARTICIPE values(1, 1);
INSERT INTO PARTICIPE values(2, 1);
INSERT INTO PARTICIPE values(4, 2);
INSERT INTO PARTICIPE values(5, 2);
	
