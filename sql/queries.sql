SELECT scaletta.Nome, concerto.Canzone FROM artista
JOIN scaletta ON artista.ID = scaletta.Artista
right JOIN concerto ON concerto.Scaletta = scaletta.ID
WHERE artista.ID = 28;

SELECT nome, categoria FROM artista
WHERE artista.ID = 28;

SELECT * FROM evento
WHERE Artista = 28;

