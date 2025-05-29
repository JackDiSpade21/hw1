DROP TABLE IF EXISTS concerto;
DROP TABLE IF EXISTS biglietto;
DROP TABLE IF EXISTS Ricevuta;
DROP TABLE IF EXISTS Scaletta;
DROP TABLE IF EXISTS Canzone;
DROP TABLE IF EXISTS Posto;
DROP TABLE IF EXISTS Evento;
DROP TABLE IF EXISTS Utente;
DROP TABLE IF EXISTS Artista;

CREATE TABLE IF NOT EXISTS ARTISTA(
	ID INT,
	Nome VARCHAR(40),
	Categoria VARCHAR(40),
	Genere VARCHAR(40),
	Hero VARCHAR(1000),
	Descrizione VARCHAR(1000),
	Img VARCHAR(1000),
	
	PRIMARY KEY(ID)
);

CREATE TABLE IF NOT EXISTS utente(
	Mail VARCHAR(40),
	Nome VARCHAR(40) NOT NULL,
	Cognome VARCHAR(40) NOT NULL,
	Psw VARCHAR(400) NOT NULL,
	Tel VARCHAR(40) NOT NULL,
	Nascita DATE NOT NULL,
	Luogo VARCHAR(40),
	Newsletter BOOL,
	
	PRIMARY KEY(Mail)
);

INSERT INTO utente VALUES
('demo@web.it', 'demo', 'demo', '$2y$10$TOCXZkNGwI0.mSeRYjMj1OoCjYf.5MjezKBvsDYw4w7vASZPV.EZq', '+393323333333', '2025-11-15', NULL, FALSE);

CREATE TABLE IF NOT EXISTS Evento(
	ID INT,
	Nome VARCHAR(300),
	Luogo VARCHAR(300),
	DataEvento DATE,
	Ora TIME,
	Nazionale BOOL,
	Artista INT,
	
	PRIMARY KEY(ID),
	FOREIGN KEY(Artista) REFERENCES Artista(ID)
);

CREATE TABLE IF NOT EXISTS Posto(
	ID INT,
	Nome VARCHAR(40),
	Costo FLOAT,
	Des VARCHAR(40),
	Capacita INT,
	Evento INT,
	
	PRIMARY KEY(ID),
	FOREIGN KEY(Evento) REFERENCES Evento(ID)
);

CREATE TABLE IF NOT EXISTS Canzone(
	Nome VARCHAR(40),
	
	PRIMARY KEY(Nome)
);

CREATE TABLE IF NOT EXISTS Scaletta(
	ID INT,
	Nome VARCHAR(40),
	Artista INT,
	
	PRIMARY KEY(ID),
	FOREIGN KEY(Artista) REFERENCES Artista(ID)
);

CREATE TABLE if NOT EXISTS Ricevuta(
	ID INT,
	Totale FLOAT,
	Quantita INT,
	Acquisto DATE,
	Evento INT,
	Utente VARCHAR(40),
	Informazioni VARCHAR(400),

	PRIMARY KEY(ID),
	FOREIGN KEY(Evento) REFERENCES Evento(ID),
	FOREIGN KEY(Utente) REFERENCES Utente(Mail)
);

CREATE TABLE IF NOT EXISTS Biglietto(
	ID INT,
	Codice VARCHAR(40),
	Stato INT,
	Tipo INT,
	Evento INT,
	Ricevuta INT,
	
	PRIMARY KEY(ID),
	FOREIGN KEY(Tipo) REFERENCES Posto(ID),
	FOREIGN KEY(Evento) REFERENCES Evento(ID),
	FOREIGN KEY(Ricevuta) REFERENCES Ricevuta(ID)
);

CREATE TABLE IF NOT EXISTS Concerto(
	Scaletta INT,
	Canzone VARCHAR(40),
	
	PRIMARY KEY(Scaletta, Canzone),
	FOREIGN KEY(Scaletta) REFERENCES Scaletta(ID),
	FOREIGN KEY(Canzone) REFERENCES Canzone(Nome)
);

INSERT INTO ARTISTA (ID, Nome, Categoria, Genere, Hero, Descrizione, Img) VALUES
(1, 'Jason Derulo', 'Musica', 'Pop', 'Cantante e ballerino', '<strong>Artista pop internazionale</strong>.<br>Conosciuto per le sue hit di successo e le sue performance energiche.<br>Ha collaborato con numerosi artisti di fama mondiale.<br>Le sue canzoni sono spesso in cima alle classifiche.<br>Un vero showman capace di coinvolgere il pubblico.', 'https://s1.ticketm.net/dam/a/525/748c52e1-70b7-4f51-8814-f18584dea525_SOURCE'),
(2, 'Metallica', 'Musica', 'Heavy Metal', 'Leggenda del metal', '<strong>Pionieri dell’heavy metal</strong>.<br>Band iconica con una carriera pluridecennale.<br>Hanno rivoluzionato il genere con album storici.<br>Le loro esibizioni live sono leggendarie.<br>Un punto di riferimento per generazioni di musicisti.', 'https://s1.ticketm.net/dam/a/6bf/4d98a9bf-2443-4152-8137-143cfa25a6bf_SOURCE'),
(3, 'Marco Mengoni', 'Musica', 'Pop', 'Voce potente', '<strong>Cantante italiano vincitore di Sanremo</strong>.<br>Apprezzato per la sua voce unica e le sue emozionanti interpretazioni.<br>Ha pubblicato numerosi album di successo.<br>È uno degli artisti più amati in Italia.<br>Le sue canzoni raccontano storie profonde e personali.', 'https://s1.ticketm.net/dam/c/4f2/0109888a-61b5-4525-8432-b026ef04f4f2_105631_TABLET_LANDSCAPE_LARGE_16_9.jpg'),
(4, 'Bad Bunny', 'Musica', 'Reggaeton', 'Hitmaker globale', '<strong>Cantante urbano di fama mondiale</strong>.<br>Ha portato il reggaeton a nuovi livelli di popolarità.<br>Le sue collaborazioni sono sempre tra le più attese.<br>Innovatore nello stile e nella produzione musicale.<br>Un’icona della musica latina contemporanea.', 'https://s1.ticketm.net/dam/a/598/144e8308-c5a1-4f38-b913-e38d9d02f598_TABLET_LANDSCAPE_LARGE_16_9.jpg'),
(5, 'Isabel LaRosa', 'Musica', 'Indie Pop', 'Emergente', '<strong>Cantautrice alternativa in crescita</strong>.<br>Si distingue per il suo stile unico e originale.<br>Le sue canzoni esplorano temi profondi e attuali.<br>Sta conquistando sempre più pubblico internazionale.<br>Promessa della scena indie pop mondiale.', 'https://s1.ticketm.net/dam/a/30f/b7cf0b9d-6adb-4dfd-983e-da683831830f_TABLET_LANDSCAPE_LARGE_16_9.jpg'),
(6, 'Karan Aujla', 'Musica', 'Punjabi Hip-Hop', 'Stella del rap', '<strong>Artista di riferimento per la musica urbana indiana</strong>.<br>Ha rivoluzionato il panorama hip-hop punjabi.<br>Le sue liriche sono apprezzate per profondità e originalità.<br>Collabora con i migliori produttori del settore.<br>Un punto di riferimento per le nuove generazioni.', 'https://s1.ticketm.net/dam/a/ff8/56347471-1aa1-4466-9d09-70de8d20bff8_SOURCE'),
(7, 'Vasco Rossi', 'Musica', 'Rock', 'Il re del rock italiano', '<strong>Cantautore e rocker iconico in Italia</strong>.<br>Ha segnato la storia della musica italiana con i suoi brani.<br>Le sue esibizioni live sono eventi imperdibili.<br>Testi profondi e carisma inconfondibile.<br>Un simbolo della libertà e della ribellione.', 'https://s1.ticketm.net/dam/c/fbc/b293c0ad-c904-4215-bc59-8d7f2414dfbc_106141_TABLET_LANDSCAPE_LARGE_16_9.jpg'),
(8, 'WØM FEST', 'Musica', 'Festival', 'Evento musicale', '<strong>Festival musicale innovativo</strong>.<br>Ospita artisti internazionali di grande rilievo.<br>Un’esperienza unica per gli amanti della musica.<br>Atmosfera coinvolgente e organizzazione impeccabile.<br>Un appuntamento imperdibile per il pubblico.', 'https://s1.ticketm.net/dam/c/ab4/6367448e-7474-4650-bd2d-02a8f7166ab4_106161_TABLET_LANDSCAPE_LARGE_16_9.jpg'),
(9, 'Lady Gaga', 'Musica', 'Pop', 'Regina del pop', '<strong>Artista e performer rivoluzionaria</strong>.<br>Conosciuta per il suo stile unico e provocatorio.<br>Ha ridefinito i confini della musica pop.<br>Le sue performance sono veri spettacoli visivi.<br>Un’icona di creatività e innovazione.', 'https://s1.ticketm.net/dam/a/a10/bfebdc5b-8708-4687-a8a3-30cfcdc09a10_SOURCE'),
(10, 'Don Toliver', 'Musica', 'Hip-Hop', 'Voce unica', '<strong>Rapper e cantante con uno stile distintivo</strong>.<br>Ha conquistato il pubblico con la sua voce particolare.<br>Le sue produzioni sono sempre innovative.<br>Collabora con i migliori artisti della scena hip-hop.<br>Un talento in continua ascesa.', 'https://s1.ticketm.net/dam/a/82a/39b5de9b-ae0c-4cd9-8ccb-4234e05cf82a_TABLET_LANDSCAPE_LARGE_16_9.jpg'),
(11, 'Nayt', 'Musica', 'Rap', 'Rapper italiano', '<strong>Artista emergente nel panorama rap italiano</strong>.<br>Apprezzato per la profondità dei suoi testi.<br>Ha saputo distinguersi per originalità e talento.<br>Le sue canzoni raccontano storie di vita reale.<br>Un nome in forte crescita nella scena musicale.', 'https://s1.ticketm.net/dam/c/80b/f3cd8d24-c3ae-4fa0-b4bc-1ba99f9b380b_106091_TABLET_LANDSCAPE_LARGE_16_9.jpg'),
(12, 'The Who', 'Musica', 'Rock', 'Leggende del rock', '<strong>Storica band britannica con impatto globale</strong>.<br>Hanno influenzato generazioni di musicisti.<br>Le loro canzoni sono veri inni del rock.<br>Concerti memorabili e carisma senza tempo.<br>Un pilastro della storia della musica.', 'https://s1.ticketm.net/dam/a/764/9121132f-c59a-4589-a4fb-6bee486c3764_SOURCE'),
(13, 'Alessandro Cattelan', 'Arte e teatro', 'Intrattenimento', 'Presentatore e showman', '<strong>Personaggio televisivo e conduttore italiano</strong>.<br>Conosciuto per la sua simpatia e professionalità.<br>Ha condotto programmi di grande successo.<br>Capace di coinvolgere pubblico di tutte le età.<br>Un volto amato della TV italiana.', 'https://s1.ticketm.net/dam/c/07d/fda8c807-42eb-4b81-9f16-f3a8367e107d_106371_TABLET_LANDSCAPE_LARGE_16_9.jpg'),
(14, 'Rauw Alejandro', 'Musica', 'Reggaeton', 'Innovatore del reggaeton', '<strong>Artista che sta ridefinendo la musica urbana</strong>.<br>Le sue hit sono tra le più ascoltate al mondo.<br>Stile unico e grande presenza scenica.<br>Collabora con i migliori artisti internazionali.<br>Un punto di riferimento per il reggaeton moderno.', 'https://s1.ticketm.net/dam/a/3d1/f6723cf8-cc68-49f7-88ce-edaaacd243d1_TABLET_LANDSCAPE_LARGE_16_9.jpg'),
(15, 'Nine Inch Nails', 'Musica', 'Industrial Rock', 'Rivoluzionari del rock', '<strong>Band iconica nel panorama alternative e industrial</strong>.<br>Hanno sperimentato nuovi suoni e tecniche.<br>Le loro performance sono intense e coinvolgenti.<br>Testi profondi e atmosfere oscure.<br>Un riferimento per la musica sperimentale.', 'https://s1.ticketm.net/dam/a/8ec/fc59ad2d-314b-4cd2-b840-cfc8370248ec_SOURCE'),
(16, 'OneRepublic', 'Musica', 'Pop Rock', 'Hitmaker globale', '<strong>Band pop rock con brani di successo</strong>.<br>Conosciuti per melodie accattivanti e testi emozionanti.<br>Hanno conquistato le classifiche mondiali.<br>Collaborazioni con artisti di fama internazionale.<br>Un gruppo amato da pubblico di tutte le età.', 'https://s1.ticketm.net/dam/a/a62/ba0a37d2-f25e-4c4a-ad50-9781b2a0ea62_SOURCE'),
(17, 'Alanis Morissette', 'Musica', 'Alternative Rock', 'Voce potente', '<strong>Cantautrice che ha segnato la musica alternative</strong>.<br>Le sue canzoni sono inni generazionali.<br>Apprezzata per la sincerità e l’intensità dei testi.<br>Ha influenzato molte artiste contemporanee.<br>Un’icona della musica anni ’90 e oltre.', 'https://s1.ticketm.net/dam/a/aad/75092028-7b55-4ee4-b877-2d58d0f6faad_TABLET_LANDSCAPE_LARGE_16_9.jpg'),
(18, 'Jamiroquai', 'Musica', 'Funk', 'Innovatori del funk', '<strong>Band che ha rivoluzionato il funk e l’elettronica</strong>.<br>Stile inconfondibile e groove irresistibile.<br>Hanno portato il funk nelle classifiche pop.<br>Performance live sempre spettacolari.<br>Un mix unico di generi e influenze.', 'https://s1.ticketm.net/dam/a/d75/15e92894-3277-472b-8097-386d58be9d75_608041_TABLET_LANDSCAPE_LARGE_16_9.jpg'),
(19, 'Sting', 'Musica', 'Rock', 'Icona musicale', '<strong>Cantautore britannico con una carriera straordinaria</strong>.<br>Ha scritto alcune delle canzoni più celebri di sempre.<br>Apprezzato per la sua versatilità e talento.<br>Ha collaborato con artisti di ogni genere.<br>Un vero ambasciatore della musica nel mondo.', 'https://s1.ticketm.net/dam/a/422/94a31c60-9966-4582-b197-4c5a504d8422_TABLET_LANDSCAPE_LARGE_16_9.jpg'),
(20, 'Robbie Williams', 'Musica', 'Pop', 'Showman assoluto', '<strong>Ex membro dei Take That con una carriera solista incredibile</strong>.<br>Conosciuto per la sua energia e ironia.<br>Ha pubblicato numerosi album di successo.<br>Le sue performance sono sempre spettacolari.<br>Un artista amato in tutto il mondo.', 'https://s1.ticketm.net/dam/a/903/b21ede51-fdec-46cd-95d0-95aea4d04903_SOURCE'),
(21, 'Tate McRae', 'Musica', 'Pop', 'Cantautrice e ballerina', '<strong>Giovane artista pop con grande talento</strong>.<br>Ha conquistato il pubblico con la sua voce e le sue coreografie.<br>Le sue canzoni raccontano emozioni autentiche.<br>Sta rapidamente scalando le classifiche internazionali.<br>Un futuro brillante davanti a sé.', 'https://s1.ticketm.net/dam/a/8dc/5b6cd42e-0897-4e9e-95ff-3aeca18148dc_TABLET_LANDSCAPE_LARGE_16_9.jpg'),
(22, 'Big Time Rush', 'Musica', 'Pop', 'Boy band amata', '<strong>Gruppo pop che ha conquistato il pubblico giovane</strong>.<br>Conosciuti per le loro canzoni orecchiabili e divertenti.<br>Protagonisti di una serie TV di successo.<br>Hanno una fanbase affezionata in tutto il mondo.<br>Un fenomeno della cultura pop moderna.', 'https://s1.ticketm.net/dam/a/11e/830785d3-cbda-41f0-8d6c-b1483266911e_SOURCE'),
(23, 'Kendrick Lamar', 'Musica', 'Hip-Hop', 'Genio del rap', '<strong>Rapper influente con testi profondi e narrativi</strong>.<br>Ha vinto numerosi premi internazionali.<br>Le sue canzoni affrontano temi sociali e politici.<br>Considerato uno dei migliori lyricist della sua generazione.<br>Un punto di riferimento per la cultura hip-hop.', 'https://s1.ticketm.net/dam/a/f7c/00abe3c8-7939-4399-8f3c-a65c89fb9f7c_TABLET_LANDSCAPE_LARGE_16_9.jpg'),
(24, 'ZZZ', 'Musica', 'Rock', 'Band alternativa', '<strong>Gruppo musicale emergente con sonorità innovative</strong>.<br>Si distingue per la sperimentazione e la creatività.<br>Le loro performance sono sempre sorprendenti.<br>Stanno guadagnando attenzione nella scena rock.<br>Un nome da tenere d’occhio per il futuro.', 'https://s1.ticketm.net/dam/c/fbc/b293c0ad-c904-4215-bc59-8d7f2414dfbc_106141_TABLET_LANDSCAPE_LARGE_16_9.jpg'),
(25, 'Stray Kids', 'Musica', 'K-Pop', 'Idol globali', '<strong>Gruppo K-pop che ha conquistato fan in tutto il mondo</strong>.<br>Conosciuti per le loro coreografie spettacolari.<br>Le loro canzoni sono sempre in cima alle classifiche.<br>Uniscono diversi generi musicali con grande originalità.<br>Un fenomeno globale della musica pop.', 'https://s1.ticketm.net/dam/a/328/ec0a213f-d159-468d-a463-d5dd988f3328_SOURCE'),
(26, 'RÜFÜS DU SOL', 'Musica', 'Elettronica', 'Innovatori della musica elettronica', '<strong>Trio australiano con sonorità uniche</strong>.<br>Hanno ridefinito il panorama della musica elettronica.<br>Le loro produzioni sono apprezzate in tutto il mondo.<br>Performance live coinvolgenti e suggestive.<br>Un punto di riferimento per gli amanti del genere.', 'https://s1.ticketm.net/dam/a/404/1d8668b5-4925-4633-8230-d1f69db4a404_SOURCE'),
(27, 'Simply Red', 'Musica', 'Soul Pop', 'Icona musicale', '<strong>Band britannica famosa per i suoi brani emotivi</strong>.<br>Hanno segnato la storia del soul pop.<br>Le loro canzoni sono colonne sonore di molte generazioni.<br>Voce inconfondibile e melodie indimenticabili.<br>Un gruppo che ha lasciato il segno nella musica.', 'https://s1.ticketm.net/dam/a/079/1792f2b8-dba8-41ce-ba87-b98e8d6d7079_TABLET_LANDSCAPE_LARGE_16_9.jpg'),
(28, 'Imagine Dragons', 'Musica', 'Alternative Rock', 'Band di successo', '<strong>Gruppo pop rock con hit internazionali</strong>.<br>Conosciuti per la loro energia e creatività.<br><br>Le loro canzoni sono tra le più ascoltate al mondo.<br>Hanno saputo rinnovarsi album dopo album.<br><br>Un punto di riferimento per la musica contemporanea.', 'https://s1.ticketm.net/dam/a/e8c/5265b9d2-a06c-4dc8-a432-a8dd9d042e8c_TABLET_LANDSCAPE_LARGE_16_9.jpg');

INSERT INTO Canzone (Nome) VALUES 
('Sogno di Primavera'),
('Vento dell’Est'),
('Notte Stellata'),
('Cuore Ribelle'),
('Melodia Perduta'),
('Fuoco e Ghiaccio'),
('Onda Sonora'),
('Arcobaleno Sonoro'),
('Battito del Tempo'),
('Riflessi di Luna'),
('Giorni di Sole'),
('Strade Perdute'),
('Battiti nel Buio'),
('Oltre il Destino'),
('Note d’Argento'),
('Sussurri Notturni'),
('Riflessi Invernali'),
('Sogni di Carta'),
('Voci nel Vento'),
('Mistero dell’Anima');

INSERT INTO Scaletta (ID, Nome, Artista) VALUES 
(1, 'Hits del momento', 1), (2, 'Ballate Pop', 1), (3, 'Emozioni senza tempo', 2), (4, 'Metal Legends', 2),
(5, 'Classici moderni', 3), (6, 'Sanremo Nights', 3), (7, 'Notte magica', 4), (8, 'Reggaeton Party', 4),
(9, 'Sogni e realtà', 5), (10, 'Indie Vibes', 5), (11, 'Vibrazioni profonde', 6), (12, 'Punjabi Beats', 6),
(13, 'Viaggio musicale', 7), (14, 'Rock Italiano', 7), (15, 'Nuove frontiere', 8), (16, 'Festival Experience', 8),
(17, 'Luci e ombre', 9), (18, 'Pop Revolution', 9), (19, 'Anime in musica', 10), (20, 'Urban Nights', 10),
(21, 'Momenti Unici', 11), (22, 'Rap Italiano', 11), (23, 'Viaggio Sonoro', 12), (24, 'Rock History', 12),
(25, 'Oltre le Stelle', 13), (26, 'Showtime', 13), (27, 'Racconti Musicali', 14), (28, 'Reggaeton Innovation', 14),
(29, 'Atmosfere Magiche', 15), (30, 'Industrial Rock', 15), (31, 'Emozioni Pure', 16), (32, 'Pop Rock Hits', 16),
(33, 'Ritmi Travolgenti', 17), (34, 'Alternative Rock', 17), (35, 'Sogni e Melodie', 18), (36, 'Funk & Elettronica', 18),
(37, 'Echi dal Passato', 19), (38, 'Rock Classics', 19), (39, 'Melodie Senza Tempo', 20), (40, 'Pop Show', 20),
(41, 'Talento Pop', 21), (42, 'Dancefloor', 21), (43, 'Boy Band Hits', 22), (44, 'Pop Energy', 22),
(45, 'Rap Stories', 23), (46, 'Hip-Hop Vibes', 23), (47, 'Alternative Rock', 24), (48, 'Emerging Sounds', 24),
(49, 'K-Pop Power', 25), (50, 'Idol Night', 25), (51, 'Elettronica Live', 26), (52, 'Australian Vibes', 26),
(53, 'Soul Pop', 27), (54, 'British Soul', 27), (55, 'Alternative Hits', 28), (56, 'Pop Rock Night', 28);

INSERT INTO Concerto (Scaletta, Canzone) VALUES
(1, 'Sogno di Primavera'), (1, 'Vento dell’Est'), (1, 'Notte Stellata'), (1, 'Cuore Ribelle'), (1, 'Melodia Perduta'),
(2, 'Fuoco e Ghiaccio'), (2, 'Onda Sonora'), (2, 'Arcobaleno Sonoro'), (2, 'Battito del Tempo'), (2, 'Riflessi di Luna'),
(3, 'Giorni di Sole'), (3, 'Strade Perdute'), (3, 'Battiti nel Buio'), (3, 'Oltre il Destino'), (3, 'Note d’Argento'),
(4, 'Sussurri Notturni'), (4, 'Riflessi Invernali'), (4, 'Sogni di Carta'), (4, 'Voci nel Vento'), (4, 'Mistero dell’Anima'),
(5, 'Notte Stellata'), (5, 'Cuore Ribelle'), (5, 'Melodia Perduta'), (5, 'Fuoco e Ghiaccio'), (5, 'Onda Sonora'),
(6, 'Arcobaleno Sonoro'), (6, 'Battito del Tempo'), (6, 'Riflessi di Luna'), (6, 'Giorni di Sole'), (6, 'Strade Perdute'),
(7, 'Battiti nel Buio'), (7, 'Oltre il Destino'), (7, 'Note d’Argento'), (7, 'Sussurri Notturni'), (7, 'Riflessi Invernali'),
(8, 'Sogni di Carta'), (8, 'Voci nel Vento'), (8, 'Mistero dell’Anima'), (8, 'Sogno di Primavera'), (8, 'Vento dell’Est'),
(9, 'Notte Stellata'), (9, 'Cuore Ribelle'), (9, 'Melodia Perduta'), (9, 'Fuoco e Ghiaccio'), (9, 'Onda Sonora'),
(10, 'Arcobaleno Sonoro'), (10, 'Battito del Tempo'), (10, 'Riflessi di Luna'), (10, 'Giorni di Sole'), (10, 'Strade Perdute'),
(11, 'Battiti nel Buio'), (11, 'Oltre il Destino'), (11, 'Note d’Argento'), (11, 'Sussurri Notturni'), (11, 'Riflessi Invernali'),
(12, 'Sogni di Carta'), (12, 'Voci nel Vento'), (12, 'Mistero dell’Anima'), (12, 'Sogno di Primavera'), (12, 'Vento dell’Est'),
(13, 'Notte Stellata'), (13, 'Cuore Ribelle'), (13, 'Melodia Perduta'), (13, 'Fuoco e Ghiaccio'), (13, 'Onda Sonora'),
(14, 'Arcobaleno Sonoro'), (14, 'Battito del Tempo'), (14, 'Riflessi di Luna'), (14, 'Giorni di Sole'), (14, 'Strade Perdute'),
(15, 'Battiti nel Buio'), (15, 'Oltre il Destino'), (15, 'Note d’Argento'), (15, 'Sussurri Notturni'), (15, 'Riflessi Invernali'),
(16, 'Sogni di Carta'), (16, 'Voci nel Vento'), (16, 'Mistero dell’Anima'), (16, 'Sogno di Primavera'), (16, 'Vento dell’Est'),
(17, 'Notte Stellata'), (17, 'Cuore Ribelle'), (17, 'Melodia Perduta'), (17, 'Fuoco e Ghiaccio'), (17, 'Onda Sonora'),
(18, 'Arcobaleno Sonoro'), (18, 'Battito del Tempo'), (18, 'Riflessi di Luna'), (18, 'Giorni di Sole'), (18, 'Strade Perdute'),
(19, 'Battiti nel Buio'), (19, 'Oltre il Destino'), (19, 'Note d’Argento'), (19, 'Sussurri Notturni'), (19, 'Riflessi Invernali'),
(20, 'Sogni di Carta'), (20, 'Voci nel Vento'), (20, 'Mistero dell’Anima'), (20, 'Sogno di Primavera'), (20, 'Vento dell’Est'),
(21, 'Notte Stellata'), (21, 'Cuore Ribelle'), (21, 'Melodia Perduta'),
(55, 'Fuoco e Ghiaccio'), (55, 'Cuore Ribelle'), (55, 'Melodia Perduta'), (55, 'Riflessi di Luna'), (55, 'Giorni di Sole'),
(56, 'Sogno di Primavera'), (56, 'Fuoco e Ghiaccio'), (56, 'Mistero dell’Anima'), (56, 'Voci nel Vento'), (56, 'Sogni di Carta');

INSERT INTO Evento (ID, Nome, Luogo, DataEvento, Ora, Nazionale, Artista) VALUES 
(1, 'Christmas Symphonic Night', 'Roma - Auditorium Parco della Musica', '2025-12-20', '21:00:00', TRUE, 1),
(2, 'Symphony of the Stars', 'Genova - Teatro Carlo Felice', '2025-11-15', '21:00:00', TRUE, 2),
(3, 'Piano Masterpieces', 'Vienna - Musikverein', '2025-06-10', '20:00:00', FALSE, 3),
(4, 'Opera in the Moonlight', 'Verona - Arena di Verona', '2025-07-10', '20:30:00', TRUE, 4),
(5, 'Disney Songs Gala', 'Parigi - Palais Garnier', '2025-12-05', '18:00:00', FALSE, 5),
(6, 'Rock Legends Reunion', 'Milano - Mediolanum Forum', '2025-09-10', '19:30:00', TRUE, 6),
(7, 'Indie Rock Showcase', 'Londra - O2 Arena', '2025-07-05', '20:00:00', FALSE, 7),
(8, '80s Revival Night', 'Los Angeles - Hollywood Bowl', '2025-10-05', '20:00:00', FALSE, 8),
(9, 'Garage Rock Explosion', 'Madrid - WiZink Center', '2025-05-22', '21:00:00', FALSE, 9),
(10, 'Grunge Forever', 'Seattle - Climate Pledge Arena', '2025-08-15', '19:30:00', FALSE, 10),
(11, 'Jazz & Wine Festival', 'Firenze - Piazza della Signoria', '2025-07-25', '18:00:00', TRUE, 11),
(12, 'Smooth Jazz Night', 'New Orleans - Preservation Hall', '2025-06-18', '20:00:00', FALSE, 12),
(13, 'Blues Heritage Show', 'Chicago - Buddy Guy’s Legends', '2025-10-12', '19:30:00', FALSE, 13),
(14, 'Saxophone Dreams', 'Milano - Blue Note', '2025-11-30', '22:00:00', TRUE, 14),
(15, 'Big Band Swing Night', 'New York - Birdland Jazz Club', '2025-09-15', '20:00:00', FALSE, 15),
(16, 'Latin Fever Dance Party', 'Madrid - Sala Riviera', '2025-09-20', '23:00:00', FALSE, 16),
(17, 'Reggae Summer Jam', 'Kingston - National Stadium', '2025-08-18', '19:00:00', FALSE, 17),
(18, 'Flamenco & Guitars', 'Barcellona - Gran Teatre del Liceu', '2025-07-29', '21:30:00', FALSE, 18),
(19, 'Celtic Harmony Festival', 'Dublino - The Olympia Theatre', '2025-09-12', '18:30:00', FALSE, 19),
(20, 'Folk & Traditions Festival', 'Bari - Castello Svevo', '2025-06-20', '17:00:00', TRUE, 20),
(21, 'Hip-Hop Underground Battle', 'New York - Madison Square Garden', '2025-08-28', '22:00:00', FALSE, 21),
(22, 'Rap Stars Night', 'Los Angeles - SoFi Stadium', '2025-10-09', '21:00:00', FALSE, 22),
(23, 'Urban Beats Explosion', 'Milano - Alcatraz', '2025-06-15', '23:30:00', TRUE, 23),
(24, 'Pop Icons Showcase', 'Tokyo - Tokyo Dome', '2025-09-20', '19:00:00', FALSE, 24),
(25, 'K-Pop World Tour', 'Seoul - Gocheok Sky Dome', '2025-07-05', '20:00:00', FALSE, 25),
(26, 'Metal Thunderstorm', 'Berlino - Mercedes-Benz Arena', '2025-09-30', '19:30:00', FALSE, 26),
(27, 'Punk Riot Night', 'Londra - Brixton Academy', '2025-06-24', '21:00:00', FALSE, 27),
(28, 'Hardcore Revolution', 'Torino - Teatro Concordia', '2025-08-20', '19:00:00', TRUE, 28),
(29, 'Alternative Rock Fusion', 'Sydney - Qudos Bank Arena', '2025-10-17', '20:00:00', FALSE, 1),
(30, 'Post-Rock Ambient Night', 'Amsterdam - Ziggo Dome', '2025-07-08', '22:30:00', FALSE, 2),
(31, 'Electronic Vibes Night', 'Napoli - Arena Flegrea', '2025-06-15', '22:00:00', TRUE, 3),
(32, 'House Nation Festival', 'Ibiza - Ushuaïa', '2025-08-12', '23:00:00', FALSE, 4),
(33, 'African Beats Celebration', 'Lagos - Eko Convention Center', '2025-07-21', '20:30:00', FALSE, 5),
(34, 'Bollywood Nights', 'Mumbai - NSCI Dome', '2025-09-02', '21:00:00', FALSE, 6),
(35, 'New Age & Chillout', 'Bali - Beach Festival Arena', '2025-08-28', '19:00:00', FALSE, 7),
(36, 'Gospel Celebration', 'Chicago - United Center', '2025-12-23', '20:30:00', FALSE, 8),
(37, 'Halloween Horror Rock Fest', 'Los Angeles - The Wiltern', '2025-10-31', '23:00:00', FALSE, 9),
(38, 'Midnight Classical Serenade', 'Venezia - Teatro La Fenice', '2025-06-11', '23:59:00', TRUE, 10),
(39, 'White Winter Jazz Night', 'Oslo - Sentrum Scene', '2025-12-10', '18:30:00', FALSE, 11),
(40, 'Summer Solstice Electronic Party', 'Reykjavik - Harpa Concert Hall', '2025-06-21', '22:00:00', FALSE, 12),
(41, 'Eurovision Celebration Night', 'Stoccolma - Friends Arena', '2025-05-15', '20:00:00', FALSE, 13),
(42, 'Sanremo Winners Night', 'Sanremo - Teatro Ariston', '2025-02-25', '21:00:00', TRUE, 14),
(43, 'Coachella Spotlight', 'California - Empire Polo Club', '2025-04-15', '18:00:00', FALSE, 15),
(44, 'Tomorrowland Experience', 'Belgio - Boom', '2025-07-22', '21:00:00', FALSE, 16),
(45, 'Montreux Jazz Festival', 'Svizzera - Montreux', '2025-07-10', '19:00:00', FALSE, 17),
(46, 'Live Acoustic Sunset', 'Barcellona - Park Güell', '2025-07-19', '19:00:00', FALSE, 18),
(47, 'Rock & Roll Revival', 'Las Vegas - T-Mobile Arena', '2025-06-25', '20:30:00', FALSE, 19),
(48, 'Deep House Lounge Night', 'Ibiza - Privilege', '2025-08-14', '23:30:00', FALSE, 20),
(49, 'Bolero & Tango Night', 'Buenos Aires - Teatro Colón', '2025-09-10', '21:00:00', FALSE, 21),
(50, 'Electro Future Sounds', 'Berlino - Berghain', '2025-07-08', '22:00:00', FALSE, 22),
(51, 'World Music Journey', 'Rio de Janeiro - Theatro Municipal', '2025-05-17', '18:00:00', FALSE, 23),
(52, 'Flamenco & Rhythms', 'Madrid - Teatro Flamenco', '2025-10-05', '20:00:00', FALSE, 24),
(53, 'Soul & R&B Night', 'New York - Apollo Theater', '2025-11-12', '20:30:00', FALSE, 25),
(54, 'Indie Pop Magic', 'Los Angeles - The Greek Theatre', '2025-08-26', '21:00:00', FALSE, 26),
(55, 'Symphonic Fantasy', 'Tokyo - Suntory Hall', '2025-12-20', '19:00:00', FALSE, 27),
(56, 'Synthwave Retro Party', 'Tokyo - Shibuya O-East', '2025-11-22', '22:00:00', FALSE, 28),
(57, 'Hip-Hop Legends Night', 'Roma - State Farm Arena', '2025-07-14', '20:30:00', TRUE, 28),
(58, 'Reggaeton Explosion', 'Bari - Hard Rock Stadium', '2025-06-30', '21:00:00', TRUE, 28),
(59, 'Nordic Folk Celebration', 'Copenaghen - Royal Arena', '2025-08-27', '19:00:00', FALSE, 28),
(60, 'Summer Beach House Festival', 'Sydney - Bondi Beach Arena', '2025-12-03', '23:00:00', FALSE, 9),
(61, 'Electronic Underground Session', 'Catania - Paradiso', '2025-09-12', '22:30:00', true, 9),
(62, 'Acoustic Guitar Masters', 'San Francisco - The Fillmore', '2025-10-05', '20:00:00', FALSE, 9),
(63, 'Psychedelic Trance Gathering', 'Goa - Hilltop Club', '2025-11-08', '23:30:00', FALSE, 3),
(64, 'Jazz Fusion Night', 'Toronto - Massey Hall', '2025-07-19', '19:00:00', FALSE, 4),
(65, 'Alternative Indie Dreamscape', 'Berlin - Columbiahalle', '2025-09-20', '20:00:00', FALSE, 5);

INSERT INTO Posto (ID, Nome, Costo, Des, Capacita, Evento) VALUES
(1, 'Biglietto Regular', 40.50, 'Poltrone normali.', 13, 1),
(2, 'Tribune', 35.00, 'Visibilità normale.', 17, 2),
(3, 'Biglietto', 50.00, 'Posti in piedi', 12, 3),
(4, 'Biglietto Regular', 45.50, 'Poltrone normali.', 18, 4),
(5, 'Tribune', 38.00, 'Visibilità normale.', 15, 5),
(6, 'Biglietto', 42.50, 'Posti in piedi', 19, 6),
(7, 'Biglietto Regular', 37.00, 'Poltrone normali.', 11, 7),
(8, 'Tribune', 55.50, 'Visibilità normale.', 16, 8),
(9, 'Biglietto', 41.00, 'Posti in piedi', 14, 9),
(10, 'Biglietto Regular', 44.50, 'Poltrone normali.', 20, 10),
(11, 'Tribune', 39.00, 'Visibilità normale.', 10, 11),
(12, 'Biglietto', 46.50, 'Posti in piedi', 17, 12),
(13, 'Biglietto Regular', 36.00, 'Poltrone normali.', 15, 13),
(14, 'Tribune', 48.50, 'Visibilità normale.', 18, 14),
(15, 'Biglietto', 43.00, 'Posti in piedi', 13, 15),
(16, 'Biglietto Regular', 47.50, 'Poltrone normali.', 19, 16),
(17, 'Tribune', 34.00, 'Visibilità normale.', 12, 17),
(18, 'Biglietto', 49.50, 'Posti in piedi', 16, 18),
(19, 'Biglietto Regular', 42.00, 'Poltrone normali.', 14, 19),
(20, 'Tribune', 45.50, 'Visibilità normale.', 20, 20),
(21, 'Biglietto', 38.00, 'Posti in piedi', 11, 21),
(22, 'Biglietto Regular', 50.50, 'Poltrone normali.', 18, 22),
(23, 'Tribune', 41.00, 'Visibilità normale.', 13, 23),
(24, 'Biglietto', 44.50, 'Posti in piedi', 17, 24),
(25, 'Biglietto Regular', 39.00, 'Poltrone normali.', 15, 25),
(26, 'Tribune', 46.50, 'Visibilità normale.', 19, 26),
(27, 'Biglietto', 36.00, 'Posti in piedi', 12, 27),
(29, 'Tribune', 43.00, 'Visibilità normale.', 14, 29),
(30, 'Biglietto', 47.50, 'Posti in piedi', 20, 30),
(31, 'Biglietto Regular', 34.00, 'Poltrone normali.', 13, 31),
(32, 'Tribune', 49.50, 'Visibilità normale.', 18, 32),
(33, 'Biglietto', 42.00, 'Posti in piedi', 16, 33),
(34, 'Biglietto Regular', 45.50, 'Poltrone normali.', 11, 34),
(35, 'Tribune', 38.00, 'Visibilità normale.', 19, 35),
(36, 'Biglietto', 50.50, 'Posti in piedi', 15, 36),
(37, 'Biglietto Regular', 41.00, 'Poltrone normali.', 12, 37),
(38, 'Tribune', 44.50, 'Visibilità normale.', 20, 38),
(39, 'Biglietto', 39.00, 'Posti in piedi', 18, 39),
(40, 'Biglietto Regular', 46.50, 'Poltrone normali.', 17, 40),
(41, 'Tribune', 36.00, 'Visibilità normale.', 14, 41),
(42, 'Biglietto', 48.50, 'Posti in piedi', 19, 42),
(43, 'Biglietto Regular', 43.00, 'Poltrone normali.', 13, 43),
(44, 'Tribune', 47.50, 'Visibilità normale.', 16, 44),
(45, 'Biglietto', 34.00, 'Posti in piedi', 18, 45),
(46, 'Biglietto Regular', 49.50, 'Poltrone normali.', 15, 46),
(47, 'Tribune', 42.00, 'Visibilità normale.', 20, 47),
(48, 'Biglietto', 45.50, 'Posti in piedi', 12, 48),
(49, 'Biglietto Regular', 38.00, 'Poltrone normali.', 17, 49),
(50, 'Tribune', 50.50, 'Visibilità normale.', 19, 50),
(51, 'Biglietto', 41.00, 'Posti in piedi', 14, 51),
(52, 'Biglietto Regular', 44.50, 'Poltrone normali.', 18, 52),
(53, 'Tribune', 39.00, 'Visibilità normale.', 13, 53),
(54, 'Biglietto', 46.50, 'Posti in piedi', 20, 54),
(55, 'Biglietto Regular', 36.00, 'Poltrone normali.', 15, 55),
(56, 'Tribune', 48.50, 'Visibilità normale.', 17, 56),
(57, 'Biglietto', 43.00, 'Posti in piedi', 19, 57),
(58, 'Biglietto Regular', 47.50, 'Poltrone normali.', 12, 58),
(59, 'Tribune', 34.00, 'Visibilità normale.', 16, 59),
(60, 'Biglietto', 49.50, 'Posti in piedi', 20, 60),
(61, 'Biglietto Regular', 42.00, 'Poltrone normali.', 13, 61),
(62, 'Tribune', 45.50, 'Visibilità normale.', 18, 62),
(63, 'Biglietto', 38.00, 'Posti in piedi', 15, 63),
(64, 'Biglietto Regular', 50.50, 'Poltrone normali.', 19, 64),
(65, 'Tribune', 41.00, 'Visibilità normale.', 14, 65),
(28, 'Biglietto VIP', 248.50, 'Poltrone migliori.', 3, 28),
(66, 'Biglietto Regular', 148.50, 'Poltrone normali.', 17, 28),
(67, 'Biglietto Economy', 64.50, 'Visibilità limitata.', 4, 28);