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
        <a href="./index.php" class="logo">
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
        <a id="login" <?php 
                if(isset($utente)){
                    echo "href='./profile.php'";
                } else {
                    echo "href='./login.php'";
                }
            ?>><img id="person" src="./icons/person.png">
            <p><?php 
                if(isset($utente)){
                    $nome = $utente['Nome'];
                    if(strlen($nome) > 14){
                        echo substr($nome, 0, 14) . "..";
                    } else {
                        echo $nome;
                    }
                } else {
                    echo "Accedi/Registrati";
                }
            ?></p>
        </a>
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