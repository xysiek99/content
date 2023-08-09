<?php
        include '../includes/header.php';
?>
        <div class="container">
            <div class="lab">
            <h1>Rejestracja terminali w centrali Asterisk</h1>
            <br/>
            <h3>Cele:</h3>
            <ul class="list-group">
                <li class="list-group-item">Konfiguracja centrali IP PABX;</li>
                <li class="list-group-item">Instalacja oraz konfiguracja terminali SIP (aplikacji softphone);</li>
                <li class="list-group-item">Konfiguracja dwóch kont SIP w centrali Asterisk do obsługi dwóch różnych terminali SIP;</li>
                <li class="list-group-item">Zarejestrowanie oraz późniejsze wyrejestrowanie terminali SIP w centrali Asterisk;</li>
                <li class="list-group-item">Analiza sygnalizacji podczas procedury rejestracji terminali;</li>
            </ul>
            <br/>        
            <h3>Wprowadzenie:</h3>
            <p>Głównym celem poniższego ćwiczenia jest konfiguracja centrali IP PABX oraz terminali SIP.</p>
            <p>Zadanie to nauczy Cię poprawnej konfiguracji terminali SIP (aplikacji softphone), kont SIP w centrali oraz przebiegu sygnalizacji podczas procedur rejestracji i wyrejestrowywania terminali SIP w centrali Asterisk.</p>
            <p>Pracę rozpocznij od zainstalowania systemu operacyjnego Linux Ubuntu 16.04 LTS lub 18.04 LTS. Następnie zainstaluj oprogramowanie Asterisk (wersja 15 dla Ubuntu 16.04 lub 16/17 dla Ubuntu 18.04). Dodatkowym oprogramowaniem, które będzie wykorzystywane jest Wireshark lub tshark.</p>
        </div>
        <div class="container">
            <br>
            <?php if ($_SESSION['hint']==1){ ?>
                <input type="button" class="btn btn-outline-secondary" onclick="window.open('/hints/hint1.php', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=700,height=700')" value="Pokaż podpowiedzi">
            <?php }?>
            <br>
            <br/>
            <h3>ZADANIE 1: KONFIGURACJA TERMINALI</h3>
            <p><strong>Krok 1:</strong> W pliku modules.conf usuń wpis chan_pjsip:</p>
            <ul>
                <li>cd /etc/asterisk</li>
                <li>vi modules.conf</li>
            </ul>
            <p><strong>Krok 2:</strong> Zmień nazwę pliku sip.conf na sip.conf .default</p>
            <ul>
                <li>cd /etc/asterisk</li>
                <li>mw sip.conf sip.conf.default</li>
            </ul>
            <p><strong>Krok 3:</strong> W pliku /etc/asterisk/sip.conf skonfiguruj opcje ogólne:</p>
            <p>Korzystając z edytora (np. vi) dodaj następujące linie:</p>
            <ul class="list-unstyled">
                <li>[general]</li>
                <li>udpbindaddr = 0.0.0.0:5060 ;port na którym nasłuchuje centrala Asterisk</li>
                <li>context = dummy</li>
                <li>disallow = all</li>
                <li>allow = ulaw ;charakterystyka kwantyzacji ulaw – kodeki</li>
                <li>alwaysauthreject=yes</li>
                <li>allowguest=no</li>
            </ul>
            <p><strong>Krok 4:</strong> Konfiguracja numerów terminali</p>
            <ul class="list-unstyled">
                <li>[zoiper] ;nazwa sekcji (może być dowolna alfanumeryczna)</li>
                <li>type=friend ;definiuje kierunek uwierzytelnienia</li>
                <li>secret=#supersecret# ;hasło</li>
                <li>host=dynamic ;nie ma stałego adresu IP</li>
                <li>qualify=yes ;sprawdza osiągalność drugiej strony </li>
                <li>directmedia=no  ;strumień mediów będzie przechodzić przez centralę IP PBX</li>
                <li>context=from-internal ;kontekst dla tego terminala - decyduje o powiązaniu z sekcją</li>
                <li>określającą sposób rutingu w pliku extensions.conf</li>
            </ul>
            <p><strong>Krok 5:</strong> Konfiguracja aplikacji Softphone – Zoiper</p>
            <p>Pobierz aplikację Zoiper3 ze strony: <a target="_blank" href="https://www.zoiper.com/en/voip-softphone/download/classic"> https://www.zoiper.com/en/voip-softphone/download/classic</a></p>
            <p>Po zainstalowaniu aplikacji przejdź do utworzenia konta – Settings -> Create New Account -> SIP.</p>
            <p>Loginem będzie utworzone wcześniej konto zoiper oraz adres IP maszyny tj. zoiper@adresIP</p>
            <p>Wszystkie ustawienia zaawansowane zostają takie jakie są domyślnie.</p>
        </div>
        <div class="container">
            <h3>ZADANIE 2: PRACA SAMODZIELNA</h3>
            <p><strong>Krok 1:</strong> Na podstawie Kroku 4 z Zadania 1 skonfiguruj dwa różne konta SIP w centrali Asterisk.</p>
            <p><strong>Krok 2:</strong> Skonfiguruj inny terminal SIP np. Blink lub Linphone (konfiguracja podobna do aplikacji Zoiper).</p>
            <p><strong>Krok 3:</strong> Zarejestruj oraz wyrejestruj każdy z dwóch terminali w centrali Asterisk, przechwyć ruch SIP w formacie pcap (np. Wireshark) podczas tych czynności oraz opisz znaczenie pól nagłówków wiadomości SIP związanych z rejestracją/wyrejestrowaniem (Request Line, Contact, From, To, Expires, Authorization, Cseq).</p>
            <p><strong>Krok 4:</strong> Zrób sprawozdanie (generowane automatycznie wyniki Quizu) w którym opiszesz wykonane zadania (łącznie z plikami pcap).</p>
        </div>
        <hr>
        <div class="container">
            <h3>Baza wiedzy problemów:</h3>
            <br>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <select name="problem" id="problem" class="custom-select">
                <option value="0">Wybierz problem poniżej i sprawdź rozwiązanie</option>
                <option value="1">Wireshark nie widzi sieci do skanowania lub wszystkie są zablokowane.</option>
                <option value="2">Mimo wprowadzonych zmian w pliku sip.conf nie mogę połączyć aplikacji softphone z Asterisk.</option>
            </select>
            <br>
            <br>
            <div id="val1" class="hidden" style="display: none;">
                <p><strong>Rozwiązanie:</strong> Zainstaluj program w Terminalu wpisując poniższe komendy:</p>
                <ul class="list-unstyled">
                <li>sudo apt-get install wireshark libcap2-bin</li>
                <li>sudo groupadd wireshark</li>
                <li>sudo usermod -a -G wireshark $USER</li>
                <li>sudo chgrp wireshark /usr/bin/dumpcap</li>
                <li>sudo chmod 755 /usr/bin/dumpcap</li>
                <li>sudo setcap cap_net_raw,cap_net_admin=eip /usr/bin/dumpcap</li>
            </ul>
            </div>
            <div id="val2" class="hidden" style="display: none;">
                <p><strong>Rozwiązanie:</strong> W terminalu wpisz poniższe komendy:</p>
                <ul class="list-unstyled">
                <li>sudo asterisk -vvvr</li>
                <li>module load chan_sip.so</li>
                <li>reload</li>
            </ul>
            </div>
            <script>
                $(function(){
                  $('#problem').on('change',function(){
                    $('.hidden').hide();
                    $('#val'+this.value).show();
                  });
                });
            </script>
        </div>
        <?php if (isset($_SESSION['sessionUser'])){ ?>
        <hr>
        <div class="container">
            <h3>ANALIZA</h3>
            <form action="/analysis.php">
                <div>
                    <input type="submit" class="btn btn-outline-secondary" value="Sprawdź się">
                    <input type="hidden" name="lab" value="1">
                    <input type="hidden" name="number" value="1">
                </div>
            </form>
        </div>
        <hr>
        <div class="container">
            <h3>Quiz:</h3>
            <a href="../question.php?n=1&l=1" class="btn btn-outline-secondary" role="button">Rozpocznij quiz!</a>
        </div>
        <?php }?>
    </div>
<?php
    include '../includes/footer.php';
?>