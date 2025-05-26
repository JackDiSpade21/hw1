SELECT scaletta.Nome, concerto.Canzone FROM artista
JOIN scaletta ON artista.ID = scaletta.Artista
right JOIN concerto ON concerto.Scaletta = scaletta.ID
WHERE artista.ID = 28;