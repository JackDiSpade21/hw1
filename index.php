<html>
<head>
    <title>Ticketmaster | Biglietti Ufficiali per Concerti, Festival, Arte e Teatro</title>
    <link rel="icon" type="image/x-icon" href="./favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./styles/homepage.css">
    <script src="./scripts/nav.js" defer></script>
    <script src="./scripts/footer.js" defer></script>
    <script src="./scripts/menu.js" defer></script>
    <script src="./scripts/homepage.js" defer></script>
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
        <div id="info">
            <a href="#">Blog</a>
            <a href="#">Newsletter</a>
            <a href="#">B2B</a>
            <a href="#">FAQ</a>
            <div id="paypal"></div>
        </div>
    </header>
    <nav>
        <div id="left-navbar">
            <div id="mobile-menu">
                <img src="./icons/menu.png">
            </div>
            <a href="#" class="logo">
                <img src="./icons/logo.png">
            </a>
            <div id="navigation">
                <div id="Musica" class="nav-button nav-b-hover">Musica</div>
                <div id="Festival" class="nav-button nav-b-hover">Festival</div>
                <div id="Arte" class="nav-button nav-b-hover">Arte & Teatro</div>
                <div id="Sport" class="nav-button nav-b-hover">Sport</div>
                <div id="Tempo" class="nav-button nav-b-hover">Tempo libero</div>
                <div id="Altro" class="nav-button nav-b-hover">Altro</div>
            </div>
        </div>
        <div id="functions">
            <div id="webbar" class="searchbar">
                <input type="text" placeholder="Artista, Evento o Località"></input>
                <div id="sbutton"><img id="search" src="./icons/search.png"></img></div>
            </div>
            <a id="login" href="./login.html"><img id="person" src="./icons/person.png"><p>Accedi/Registrati</p></a>
        </div>

        <div id="modal-nav-desktop" class="hidden">
            <div id="nav-sidebar" class="hidden">
                <div id="other-music" class="other-navigation other-buttons">
                    <p>Musica</p>
                    <img src="./icons/freccia.png">
                </div>
                <div id="other-festival" class="other-navigation other-buttons">
                    <p>Festival</p>
                    <img src="./icons/freccia.png">
                </div>
                <div id="other-art" class="other-navigation other-buttons">
                    <p>Arte & Teatro</p>
                    <img src="./icons/freccia.png">
                </div>
                <div id="other-sport" class="other-navigation other-buttons">
                    <p>Sport</p>
                    <img src="./icons/freccia.png">
                </div>
                <div id="other-tempo" class="other-navigation other-buttons other-active">
                    <p>Tempo Libero</p>
                    <img src="./icons/freccia.png">
                </div>
            </div>

            <div id="nav-box-wrapper">
                
            </div>
        </div>
    </nav>

    <div id="barwrapper">
        <div id="mobilebar" class="searchbar">
            <input type="text" placeholder="Artista, Evento o Località"></input>
            <div id="sbutton"><img id="search" src="./icons/search.png"></img></div>
        </div>
    </div>

    <section id="hero">
        <div id="heroblur"></div>   
        <div id="description">
            <h3></h3>
            <p></p>
            <a>Biglietti</a>
        </div>       
    </section>

    <section id="mobile-menu-nav" class="hidden">
        <div id="menutop">
            <div class="menu-item">
                <a href="./index.html" class="logo">
                    <img src="./icons/logo.png">
                </a>
                <div id="close-button"><img src="./icons/cross.png"></div>
            </div>
            <div id="dividermobile-top"><div></div></div>

            <div class="menu-item menu-hoverable">
                <h3>MUSICA</h2>
                <img src="./icons/freccia.png">
            </div>
            <div class="menu-item menu-hoverable">
                <h3>FESTIVAL</h2>
                <img src="./icons/freccia.png">
            </div>
            <div class="menu-item menu-hoverable">
                <h3>ARTE & TEATRO</h2>
                <img src="./icons/freccia.png">
            </div>
            <div class="menu-item menu-hoverable">
                <h3>SPORT</h2>
                <img src="./icons/freccia.png">
            </div>
            <div class="menu-item menu-hoverable">
                <h3>TEMPO LIBERO</h2>
                <img src="./icons/freccia.png">
            </div>
        </div>

        <div id="menubottom">
            <div class="menu-item">
                <a href="#">Blog</a>
            </div>
            <div id="dividermobile" ><div></div></div>
            <div class="menu-item">
                <a href="#">Newsletter</a>
            </div>
            <div id="dividermobile"><div></div></div>
            <div class="menu-item">
                <a href="#">B2B</a>
            </div>
            <div id="dividermobile"><div></div></div>
            <div class="menu-item">
                <a href="#">FAQ</a>
            </div>
            
            <div class="menu-item">
                <img id="paypalmobile" src="./icons/paypalmobile.png">
            </div>
        </div>
    </section>

    <section id="main">
        <div id="content">

            <div id="main-cards">

            </div>

            <div id="featured">
                <div id="scroll-arrow" class="sc-feat-right"></div>
                <h1>Biglietti più richiesti</h1>
                <div id="most-wanted">
                    
                </div>
            </div>

            <div id="scopri">
                <div id="scroll-arrow" class="sc-dis-right"></div>
                <h1>Scopri</h1>
                <div id="discover">
                    
                </div>
            </div>

        </div>
        <div id="side">
            <h1>consigliati</h1>
            <div id="sidebar">                
                <a class="card sidebar" href="#">
                    <div id="holder">
                        <img class="big-card" src="./cards/BigliettiVipmedium2.webp"></img>
                        <div class="overlay">
                            <div class="tsov"></div>
                            <div class="solidov"><img src="./icons/freccia.png"></img></div>
                        </div>
                    </div>
                    <h3>Biglietti VIP</h3>
                </a>
                <a href="#" class="card sidebar">
                    <div id="holder">
                        <img class="big-card" src="./cards/RapMaster2023_medium.webp"></img>
                        <div class="overlay">
                            <div class="tsov"></div>
                            <div class="solidov"><img src="./icons/freccia.png"></img></div>
                        </div>
                    </div>
                    <h3>RapMaster</h3>
                </a>
                <a href="#" class="card sidebar">
                    <div id="holder">
                        <img class="big-card" src="./cards/PopMaster2023_medium.webp"></img>
                        <div class="overlay">
                            <div class="tsov"></div>
                            <div class="solidov"><img src="./icons/freccia.png"></img></div>
                        </div>
                    </div>
                    <h3>Popmaster</h3>
                </a>
                <a href="#" class="card sidebar">
                    <div id="holder">
                        <img class="big-card" src="./cards/IndieMaster2023_medium.webp"></img>
                        <div class="overlay">
                            <div class="tsov"></div>
                            <div class="solidov"><img src="./icons/freccia.png"></img></div>
                        </div>
                    </div>
                    <h3>Indiemaster</h3>
                </a>
            </div>
        </div>
    </section>

    <footer>
        <div id="footer">
            <div id="promo">
                <a href="./index.html" class="logo">
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
