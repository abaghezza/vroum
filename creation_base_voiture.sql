--
-- base de donn�es: 'baseavion'
--
create database if not exists basevoiture default character set utf8 collate utf8_general_ci;
use basevoiture;
-- --------------------------------------------------------
-- creation des tables

set foreign_key_checks =0;

-- table moniteur
drop table if exists moniteur;
create table moniteur (
	mo_id int not null auto_increment primary key,
	mo_nom varchar(50) not null
)engine=innodb;

-- table client
drop table if exists client;
create table client (
	cl_id int not null auto_increment primary key,
	cl_nom varchar(50) not null
)engine=innodb;

-- table voiture
drop table if exists voiture;
create table voiture (
	vo_id int not null auto_increment primary key,
	vo_immatriculation varchar(10),
	vo_nom varchar(20) not null
)engine=innodb; 

-- table lecon
drop table if exists lecon;
create table lecon (
	le_id int not null auto_increment primary key,
	le_moniteur int not null,
	le_voiture int,
    le_heure_debut time not null,
    le_heure_fin time not null,
	le_date date not null
)engine=innodb; 

-- table plannifier
drop table if exists plannifier;
create table plannifier (
	pl_id int not null auto_increment primary key,
	pl_lecon int not null,
	pl_client int not null
)engine=innodb; 


-- contraintes
alter table lecon add constraint cs1 foreign key (le_moniteur) references moniteur(mo_id);
alter table lecon add constraint cs2 foreign key (le_voiture) references voiture(vo_id);
alter table plannifier add constraint cs3 foreign key (pl_lecon) references lecon(le_id);
alter table plannifier add constraint cs4 foreign key (pl_client) references client(cl_id);

set foreign_key_checks = 1;

-- jeu de données

