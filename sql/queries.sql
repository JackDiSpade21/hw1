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

-- BuyTicket
DROP PROCEDURE IF EXISTS BuyTicket;
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS BuyTicket(
IN Codice_in VARCHAR(40),
IN evento_in INT,
IN Tipo_in INT,
IN Utente_in VARCHAR(20))
BEGIN
	DECLARE posti_rimasti INT DEFAULT 0;
	DECLARE ticket_id INT DEFAULT 0;
START TRANSACTION;

	SELECT Capacita INTO posti_rimasti FROM POSTO
	WHERE Tipo_in = posto.ID;
	
	IF posti_rimasti <= 0 THEN
		ROLLBACK WORK;
		SELECT 0 AS Stato;
	END IF;
	
	SELECT MAX(ID) + 1 INTO ticket_id FROM biglietto;
	
	INSERT INTO biglietto (ID, Codice, Stato, Acquisto, Tipo, Evento, Utente)
	VALUES (ticket_id, Codice_in, 0, CURRENT_DATE(), Tipo_in, evento_in, Utente_in);

	SELECT 1 AS Stato;

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