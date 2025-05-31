# Homework 1
Consegna del primo homework di Web Programming.

### Feature implementate:
- Caricamento dinamico e randomizzato (nel backend) delle entry della Homepage usando un'api in php (entry realizzate dinamicamente in javascript tramite fetch)
-  Pagina degli artisti realizzata in parte in backend (Hero, descrizioni, immagini, testi) ed in parte in frontend con chiamata ad un'api php (lista degli eventi dell'artista)
- API di Spotify wrappata in php che mostra le canzoni più popolari di un artista in un apposito box creato tramite fetch verso il backend
- Login/Register con validazione client-side e server-side ed inserimento nel database
- Pagina di ricerca realizzata con fetch ad api nel backend per recuperare eventi ed artisti nel database in modo dinamico, con pulsante "carica altro" se ci sono altre entry rimaste per quella query
- Acquisto dei biglietti con: caricamento dei posti e biglietti rimasti fatto in php e SQL con trigger, validazione server e client side dei dati di fatturazione, gestione di race condition realizzata con transazioni in SQL e revert dei biglietti acquistati in caso di fallimento di acquisto (questa in php)
- Possibilità di visualizzare i propri dati e ordini nella area personale. La visualizzione degli ordini è dinamica e realizzata tramite fetch (con pulsante "carica altro")
- Possibilità di visualizzare i biglietti associati agli ordini fatta in maniera dinamica tramite due fetch diverse, una che carica tutti i biglietti associati ad un ordine e un'altra che carica dei QR Codes che rappresentano il codice del biglietto (questa realizzata tramite una API gratuita wrappata lato server)