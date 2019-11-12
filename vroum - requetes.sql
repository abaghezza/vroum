
-- 1. Créer une vue listant toutes les leçons avec le detail des données (client, moniteur, voiture)
create or replace view all_data as
select *
from client,moniteur,voiture,lecon, plannifier
where le_moniteur=mo_id and le_voiture=vo_id and pl_client=cl_id and pl_lecon=le_id;

-- 2. Afficher le nombre de leçons par client.
create or replace view nbleconbyclient as
select pl_client, count(pl_lecon) nblecon from plannifier group by pl_client;

-- 2a. Afficher les clients qui ont le plus de leçons
select * 
from nbleconbyclient
where nblecon=(select max(nblecon) from nbleconbyclient);

-- 3. Afficher le nombre de leçons par mois.
select month(le_date) mois, count(le_id) from lecon group by mois;

-- 4. Afficher le nombre de participants par leçon.
create or replace view nbclientbylecon as
select pl_lecon,count(pl_client) nb from plannifier group by pl_lecon;

-- 5. Afficher les leçons ayant le plus et le moins de participants.
select * 
from nbclientbylecon
where nb=(select max(nb) from nbclientbylecon) or nb=(select min(nb) from nbclientbylecon);

-- 6. Afficher le nombre total d'heure de cours par client.
select pl_client, sum(hour(timediff(le_heure_fin,le_heure_debut))) duree 
from lecon, plannifier 
where le_id=pl_lecon
group by pl_client
order by pl_client;

-- 7. Afficher le nombre d'heure de cours par mois et par moniteur.
select month(le_date) mois, le_moniteur, sum(hour(timediff(le_heure_fin,le_heure_debut))) heure
from lecon
group by mois,le_moniteur;

-- 7a. Afficher le nombre d'heure en moyenne par mois et par moniteur.
create or replace view heureparmoniteur as
select month(le_date) mois, le_moniteur, sum(hour(timediff(le_heure_fin,le_heure_debut))) heure
from lecon
group by mois,le_moniteur;

select avg(heure) moyenne
from heureparmoniteur;

-- 8. Afficher les moniteurs qui font le plus d'heures de cours par mois.
select mois,max(heure) 
from heureparmoniteur
group by mois;

-- 9. Afficher la liste des moniteurs disponibles entre deux datetime données.
t1="2019-12-01"
t2="2019-12-08"

select *
from lecon
where le_date<'2019-12-01' or le_date>'2019-12-08';

-- 9a. Afficher la liste des moniteurs non disponibles entre deux datetime données.
select *
from lecon
where le_date>='2019-12-01' and le_date<='2019-12-08';

-- 9a. Afficher la liste des moniteurs indisponibles pour une date donnée dans une plage horaire donnée.
date="2019-12-01"
h1='11:00:00'
h2='13:00:00'

select *
from lecon
where le_date='2019-12-01' and 
(   (le_heure_debut>=h1 and le_heure_debut<=h2) 
	or 
	(le_heure_fin>=h1 and le_heure_fin<=h2) 
	or
	(le_heure_debut<=h1 and le_heure_fin>=h2) 
)

select *
from lecon
where le_date='2019-12-01' and le_heure_debut<=h2 and le_heure_fin>=h1;


-- liste des moniteurs disponibles pour une date donnée dans une plage horaire donnée.
select *
from lecon
where le_date='2019-12-01' and (le_heure_debut>h2 or le_heure_fin<h1);


-- Le temps -----------------h1-----------h2--------------------------------------------------------------->
-- Le temps ----debut----fin--------------------------------------------------------------------->
-- Le temps ----------------------------------debut----fin---------------------------------------->

select *
from lecon
where le_date='2019-12-01' and 
(   (le_heure_debut>='11:00:00' and le_heure_debut<='13:00:00') 
	or 
	(le_heure_fin>='11:00:00' and le_heure_fin<='13:00:00') 
	or
	(le_heure_debut<='11:00:00' and le_heure_fin>='13:00:00') 
)

-- Le temps -------h1-----------h2--------------------------------------------------------------->
-- Le temps ----------debut---------------------------------------------------------------------->
-- Le temps -----------fin------------------------------------------------------------------->
-- Le temps -debut------------------fin-------------------------------------------------------->

-- 9.a Liste des leçons qui interferent avec l'interval t1 et t2

-- 10. Afficher la liste des voitures disponibles entre deux datetime données.

