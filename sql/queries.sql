SELECT scaletta.Nome, concerto.Canzone FROM artista
JOIN scaletta ON artista.ID = scaletta.Artista
right JOIN concerto ON concerto.Scaletta = scaletta.ID
WHERE artista.ID = 28;

SELECT nome, categoria FROM artista
WHERE artista.ID = 28;

SELECT * FROM evento
WHERE artista = 28;

SELECT artista.Nome, artista.Img FROM evento
JOIN artista ON evento.Artista = artista.ID
WHERE evento.ID = 28;

SELECT SUM(Capacita) AS Rimasti FROM posto
WHERE evento = 28;

SELECT ricevuta.ID, ricevuta.Totale, ricevuta.Quantita, ricevuta.Acquisto,
ricevuta.Evento, ricevuta.Informazioni, evento.Nome, evento.Luogo,
evento.DataEvento, evento.Ora, artista.Nome AS NomeArtista
FROM ricevuta JOIN evento ON ricevuta.Evento = evento.ID
JOIN artista ON evento.Artista = artista.ID
-- WHERE ricevuta.Utente = 'utente';

SELECT biglietto.ID, biglietto.Codice, biglietto.Stato, biglietto.Tipo,
biglietto.Evento
FROM ricevuta JOIN biglietto ON biglietto.Ricevuta = ricevuta.ID
-- WHERE biglietto.Ricevuta = RICEVUTA;

-- BuyTicket
DROP PROCEDURE IF EXISTS BuyTicket;
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS BuyTicket(
    IN Codice_in VARCHAR(40),
    IN evento_in INT,
    IN Tipo_in INT,
    IN Ricevuta_in INT
)
BEGIN
    DECLARE posti_rimasti INT DEFAULT 0;
    DECLARE ticket_id INT DEFAULT 0;
    START TRANSACTION;

    SELECT Capacita INTO posti_rimasti FROM POSTO
    WHERE Tipo_in = posto.ID;

    IF posti_rimasti <= 0 THEN
        ROLLBACK WORK;
        SELECT 0 AS Stato, NULL AS TicketID;
    END IF;

    SELECT IFNULL(MAX(ID), 0) + 1 INTO ticket_id FROM biglietto;

    INSERT INTO biglietto (ID, Codice, Stato, Tipo, Evento, Ricevuta)
    VALUES (ticket_id, Codice_in, 0, Tipo_in, evento_in, Ricevuta_in);

    SELECT 1 AS Stato, ticket_id AS TicketID;

    COMMIT WORK;
END //
DELIMITER ;

-- UpdatePostiDisponibili
DROP TRIGGER IF EXISTS UpdatePostiDisponibili;
DELIMITER //
CREATE TRIGGER IF NOT EXISTS UpdatePostiDisponibili
AFTER INSERT ON biglietto
FOR EACH ROW
BEGIN

	IF EXISTS(
		SELECT * FROM posto
		WHERE posto.Evento = NEW.Evento)
	THEN
		UPDATE posto
		SET Capacita = Capacita - 1
		WHERE NEW.Tipo = posto.ID;
	END IF;
	
END //
DELIMITER ;

DROP TRIGGER IF EXISTS RestorePostiDisponibili;
DELIMITER //
CREATE TRIGGER IF NOT EXISTS RestorePostiDisponibili
AFTER DELETE ON biglietto
FOR EACH ROW
BEGIN
    IF EXISTS (
        SELECT * FROM posto
        WHERE posto.Evento = OLD.Evento
    ) THEN
        UPDATE posto
        SET Capacita = Capacita + 1
        WHERE OLD.Tipo = posto.ID;
    END IF;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS CreateRicevuta;
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS CreateRicevuta(
    IN Totale_in FLOAT,
    IN Quantita_in INT,
    IN Evento_in INT,
    IN Utente_in VARCHAR(40),
    IN Informazioni_in VARCHAR(800)
)
BEGIN
    DECLARE ricevuta_id INT DEFAULT 0;
    START TRANSACTION;

    SELECT IFNULL(MAX(ID), 0) + 1 INTO ricevuta_id FROM Ricevuta;

    INSERT INTO Ricevuta (ID, Totale, Quantita, Acquisto, Evento, Utente, Informazioni)
    VALUES (ricevuta_id, Totale_in, Quantita_in, CURDATE(), Evento_in, Utente_in, Informazioni_in);

    SELECT 1 AS Stato, ricevuta_id AS RicevutaID;

    COMMIT WORK;
END //
DELIMITER ;