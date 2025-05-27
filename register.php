<html>
<head>
    <title>Registrati | Ticketmaster</title>
    <link rel="icon" type="image/x-icon" href="./favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./styles/auth.css">
    <script src="./scripts/footer.js" defer></script>
    <link rel="stylesheet" type="text/css" href="./styles/nav.css">
    <link rel="stylesheet" type="text/css" href="./styles/header.css">
    <link rel="stylesheet" type="text/css" href="./styles/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <div id="languages">
            <img id="flag"src="./icons/italy.png"></img>
            <a href="#">IT</a>
            <img src="./icons/lang.png"></img>
            <a href="#">IT</a>
        </div>
    </header>
    <nav class="nav-auth">
        <div id="left-navbar">
            <a href="./index.php" class="logo">
                <img src="./icons/logo.png">
            </a>
        </div>
    </nav>

    <section id="main">
        <form>
            <h2>Sei un nuovo utente</h2>
            <p class="margin-bottom">Già registrato?&nbsp;
                <a href="./login.php">Accedi</a>
            </p>
            <div class="input-container">
                <h4>Dati di autenticazione</h4>
                <p class="p-subtitle italic margin-bottom">Se non l'hai ancora fatto, ti ricordiamo che 
                    è necessario convalidare il tuo numero di cellulare utilizzando il codice di conferma 
                    OTP che ti verrà inviato tramite SMS
                </p>
                <div class="input-field">
                    <label>Cellulare *</label>
                    <div>
                        <select name="number-prefix" class="number-prefix">
                            <option value="39">IT +39</option>
                            <option value="1">US +1</option>
                            <option value="44">UK +44</option>
                            <option value="49">DE +49</option>
                            <option value="33">FR +33</option>
                            <option value="34">ES +34</option>
                        </select>
                        <input name="phone" required="required" value="" type="tel">
                    </div>
                </div>
                <h4>Dati di accesso</h4>
                <div class="input-grouped">
                    <div class="input-field">
                        <label>Email *</label>
                        <input name="email" required="required" value="" type="email">
                    </div>
                    <div class="input-field">
                        <label>Conferma Email *</label>
                        <input name="confirm-email" required="required" value="" type="email">
                    </div>
                </div>
                <p class="p-subtitle italic margin-bottom">La password deve essere lunga tra 8 e 32 caratteri, deve contenere almeno 
                    una lettera maiuscola, una lettera minuscola e un numero.
                </p>
                <div class="input-grouped">
                    <div class="input-field">
                        <label>Password *</label>
                        <input name="password" required="required" value="" type="password">
                    </div>
                    <div class="input-field">
                        <label>Conferma Password *</label>
                        <input name="confirm-password" required="required" value="" type="password">
                    </div>
                </div>
                <h4>I miei dati</h4>
                <div class="input-grouped">
                    <div class="input-field">
                        <label>Nome *</label>
                        <input name="name" required="required" value="" type="text">
                    </div>
                    <div class="input-field">
                        <label>Cognome *</label>
                        <input name="surname" required="required" value="" type="text">
                    </div>
                </div>
                <div class="input-grouped">
                    <div class="input-field">
                        <label>Data di nascita *</label>
                        <input name="birth" required="required" value="" type="date">
                    </div>
                    <div class="input-field">
                        <label>Luogo di nascita</label>
                        <input name="birth-place" value="" type="text">
                    </div>
                </div>
                <h4 class="margin-bottom">Newsletter</h4>                  
                <label class="margin-bottom">
                    <input type="checkbox" name="newsletter" value="newsletter"/>
                    Sì, desidero rimanere aggiornato sulle ultime news dei miei 
                    eventi preferiti. Presale, promozioni, nuovi show e tanto altro! 
                    (facoltativo)
                </label>
                <h4 class="margin-bottom">Informative utente</h4>
                <p class="margin-bottom">Ho preso visione e accetto
                    <a href="#">Informativa Privacy</a> *
                </p>
                <div class="input-grouped margin-bottom-double">
                    <label><input required="required" type="radio" name="privacy" value="agree_privacy"/>
                        Acconsento
                    </label>
                    <label><input required="required" type="radio" name="privacy" value="disagree_privacy"/>
                        Non acconsento
                    </label>
                </div>
                <p class="margin-bottom">Ho preso visione e accetto i
                    <a href="#">Termini e condizioni di servizio</a> *
                </p>
                <div class="input-grouped margin-bottom-double">
                    <label><input required="required" type="radio" name="terms" value="agree_terms"/>
                        Acconsento
                    </label>
                    <label><input required="required" type="radio" name="terms" value="disagree_terms"/>
                        Non acconsento
                    </label>
                </div>
                <input class="button-submit margin-bottom-double" value="Accetta e continua" name="submit_btn" type="submit">
            </div>
        </form>
    </section>

    <footer>
        <div id="footer">
            <div id="promo">
                <a href="/index.php" class="logo">
                    <img src="./icons/logo.png">
                </a>
                <p>Seguiteci</p>
                <div id="social">
                    <div class="app-icon"><img src="./social/facebook.png"></img></div>
                    <div class="app-icon"><img src="./social/instagram.png"></img></div>
                    <div class="app-icon"><img src="./social/blog.png"></img></div>
                    <div class="app-icon"><img src="./social/youtube.png"></img></div>
                    <div class="app-icon"><img src="./social/spotify.png"></img></div>
                    <div class="app-icon"><img src="./social/tiktok.png"></img></div>
                    <div class="app-icon"><img src="./social/linkedin.png"></img></div>
                </div>
                <p id="disclaimer">Ticketmaster Italia srl - Milano, Via Pietrasanta 14 - Partita IVA 09584690961 - REA MI 2100017</p>
            </div>
            <div id="collegamenti">

                <div id="divider" class="div-mobile"><div></div></div>

                <div class="elenco" data-cat="assistenza">
                <h3>Assistenza Clienti</h3>
                <div class="lista">                   
                    <a href="#">FAQ</a>
                    <a href="#">Termini e condizioni di vendita</a>
                    <a href="#">Termini e condizioni di utilizzo</a>
                    <a href="#">Diritto di recesso</a>
                    <a href="#">Eventi annullati o riprogrammati</a>
                    <a href="#">Rivendita biglietti</a>
                    <a href="#">Cambio Nominativo</a>
                    <a href="#">Metodi di consegna</a>
                    <a href="#">Metodi di pagamento</a>
                </div>
                <img id="footer-arrow" src="./icons/downarrow.png"></img>
                </div>

                <div class="mobilelist hidden" data-cat="assistenza">                   
                    <a href="#">FAQ</a>
                    <a href="#">Termini e condizioni di vendita</a>
                    <a href="#">Termini e condizioni di utilizzo</a>
                    <a href="#">Diritto di recesso</a>
                    <a href="#">Eventi annullati o riprogrammati</a>
                    <a href="#">Rivendita biglietti</a>
                    <a href="#">Cambio Nominativo</a>
                    <a href="#">Metodi di consegna</a>
                    <a href="#">Metodi di pagamento</a>
                </div>

                <div id="divider" class="div-mobile"><div></div></div>

                <div class="elenco" data-cat="guide">
                <h3>Guide Ticketmaster</h3>
                <div class="lista">               
                    <a href="#">Indiemaster</a>
                    <a href="#">Popmaster</a>
                    <a href="#">Festival Finder</a>
                    <a href="#">Guida eventi sportivi</a>
                    <a href="#">Guida Teatro</a>
                    <a href="#">Biglietti VIP</a>
                </div>
                <img id="footer-arrow" src="./icons/downarrow.png"></img>
                </div>

                <div class="mobilelist hidden" data-cat="guide">               
                    <a href="#">Indiemaster</a>
                    <a href="#">Popmaster</a>
                    <a href="#">Festival Finder</a>
                    <a href="#">Guida eventi sportivi</a>
                    <a href="#">Guida Teatro</a>
                    <a href="#">Biglietti VIP</a>
                </div>

                <div id="divider" class="div-mobile"><div></div></div>

                <div class="elenco" data-cat="network">
                <h3>Il nostro network</h3>
                <div class="lista">     
                    <a href="#">Ticketmaster nel mondo</a>
                    <a href="#">Live Nation</a>
                    <a href="#">PayPal</a>
                    <a href="#">Lavora con noi</a>
                </div>
                <img id="footer-arrow" src="./icons/downarrow.png"></img>
                </div>

                <div class="mobilelist hidden" data-cat="network">     
                    <a href="#">Ticketmaster nel mondo</a>
                    <a href="#">Live Nation</a>
                    <a href="#">PayPal</a>
                    <a href="#">Lavora con noi</a>
                </div>

                <div id="divider" class="div-mobile"><div></div></div>

                <div class="elenco" data-cat="b2b">
                <h3>B2B</h3>
                <div class="lista">
                    <a href="#">Chi Siamo</a>
                    <a href="#">Artist Services</a>
                    <a href="#">Programma Affiliati</a>
                    <a href="#">Vendi i tuoi eventi con noi</a>
                </div>
                <img id="footer-arrow" src="./icons/downarrow.png"></img>
                </div>

                <div class="mobilelist hidden" data-cat="b2b">
                    <a href="#">Chi Siamo</a>
                    <a href="#">Artist Services</a>
                    <a href="#">Programma Affiliati</a>
                    <a href="#">Vendi i tuoi eventi con noi</a>
                </div>

                <div id="divider" class="div-mobile"><div></div></div>

            </div>

            </div>
        </div>

        <div id="divider" class="div-desktop"><div></div></div>

        <div id="legal">
            <div id="divider" class="div-mobile"><div></div></div>
            <div id="privacy">
                <a href="#">Informativa Privacy</a>
                <a class="middle" href="#">Cookies</a>
                <a href="#">Gestione dei Cookies</a>
            </div>
            <div id="copyright">
                <p>© 1999-2025 Ticketmaster. Tutti i diritti riservati.</p>
            </div>
        </div>
    </footer>
</body>
</html>        