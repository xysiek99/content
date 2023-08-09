<?php
        include '../includes/header.php';
?>
    <div class="container">
        <div class="lab">
            <h1>Usługi dodatkowe (Music on Hold, Blind Call Transfer, Attended Call Transfer, Call Pickup)</h1>
            </br>
            <h3>Cele:</h3>
            <ul class="list-group">
                <li class="list-group-item">Konfiguracja usług dodatkowych Music on Hold, Blind Call Transfer, Attended Call Transfer, Call Pickup;</li>
                <li class="list-group-item">Wykonywanie połączeń z wykorzystaniem wyżej wymienionych usług dodatkowych;</li>
            </ul>
            </br>
            <h3>Wprowadzenie:</h3>
            <p>Usługi dodatkowe w sieciach telekomunikacyjnych są uzupełnieniem usług podstawowych. W tym zadaniu dowiesz się czym jest i jak skonfigurować Music on Hold (popularne granie na czekanie), Blind Call Transfer (przekazanie połączenia bez udziału recepcjonistki), Attended Call Transfer (przekazanie połączenia z udziałem recepcjonistki), Call Pickup (podjęcie połączenia przez dowolny terminal w grupie).</p>
        </div>
        <div class="container">
            <br>
            <?php if ($_SESSION['hint']==1){ ?>
                <input type="button" class="btn btn-outline-secondary" onclick="window.open('/hints/hint5.php', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=700,height=700')" value="Pokaż podpowiedzi">
            <?php }?>
            <br>
            </br>
            <h3>ZADANIE 1: KONFIGURACJA MUSIC ON HOLD</h3>
            <p><strong>Krok 1:</strong> W pliku <strong>extensions.conf</strong> dodaj poniższe wartości:</p>
            <p>[from-internal]</p>
            <p>exten=>8100,1,Answer()</p>
            <p>exten=>8100,n,MusiconHold(default,30)</p>
            <p><strong>Krok 2:</strong> W pliku <strong>musiconhold.conf</strong> dodaj poniższe wartości:</p>
            <ul>
                <li>vi /etc/asterisk/musiconhold.conf</li>
            </ul>
            <p>[default]</p>
            <p>mode = files  -  muzyka zapisana w plikach</p>
            <p>directory = moh  -  nazwa katalogu z plikami</p>
            <p><strong>Krok 3:</strong> Włącz przechwytywanie w programie Wireshark i wywołaj usługę w następujący sposób:</p>
            <ul>
                <ol>wybierając numer usługi MoH skonfigurowany w centrali (8100);</ol>
                <ol>wywołując akcję „wstrzymaj” (w Zoiperze lub Blinku) w trakcie trwającego połączenia;</ol>
                <ol>wybierając numer usługi MoH podczas trwającego połączenia;</ol>
            </ul>
            <p>Przeanalizuj przechwyconą sygnalizację SIP, SDP i media (RTP). Wykonaj wykres MSC ilustrujący wymianę wiadomości sygnalizacyjnych podczas scenariusza MoH. </p>
        </div>
        <div class="container">
            <h3>ZADANIE 2: KONFIGURACJA BLIND CALL TRANSFER</h3>
            <p><strong>Krok 1:</strong> Zainstaluj aplikację PhonerLite i zarejestruj terminal w centrali Asterisk.</p>
            <p><strong>Krok 2:</strong> Włącz przechwytywanie ruchu (Wireshark). Wywołaj plan rozmowy: A dzwoni do B. B odbiera przychodzące połączenie od A, na klawiaturze wybiera znak # i kolejno wprowadza numer docelowy do którego chce przekazać to połączenie (numer C). Przeanalizuj przechwyconą sygnalizację SIP, SDP i media (RTP). Wykonaj wykres MSC ilustrujący wymianę wiadomości sygnalizacyjnych podczas scenariusza BTC. Czy pojawiły się nowe pola SDP?</p>
            <p>A – PhonerLite dzwoni do Zopera (6000). Zoiper odbiera i wprowadza #6001 (numer Blinka). W terminalu Blink rozlega się dzwonek, Blink podnosi słuchawkę i zostaje zestawione połączenie między PhonerLite a Blink.</p>
        </div>
        <div class="container">
            <h3>ZADANIE 3: KONFIGURACJA ATTENDED CALL TRANSFER</h3>
            <p>Włącz przechwytywanie ruchu (Wireshark). A – PhonerLite dzwoni do Zoipera. Zoiper odbiera i wprowadza *2+(numer Blinka). W terminalu Blink rozlega się dzwonek, Blink podnosi słuchawkę i może z B (Zoiper) chęć przyjęcia połączenia od A (PhonerLite). Po potwierdzeniu Zoiper rozłącza się, a połączenie zostaje zestawione pomiędzy PhonerLite a Blinkiem. Przeanalizuj przechwyconą sygnalizację SIP, SDP i media (RTP). Wykonaj wykres MSC ilustrujący wymianę wiadomości sygnalizacyjnych podczas scenariusza ACT. Czy pojawiły się nowe pola SDP?</p>
        </div>
        <div class="container">
            <h3>ZADANIE 4: KONFIGURACJA CALL PICKUP</h3>
            <p><strong>Krok 1:</strong> W pliku <strong>features.conf</strong> wprowadź poniższą linię:</p>
            <ul>
                <li>vi /etc/asterisk/features.conf</li>
            </ul>
            <p>pickupexten = *8</p>
            <p><strong>Krok 2:</strong> W pliku <strong>sip.conf</strong> dodaj do istniejących terminali poniższe linie:</p>
            <p>callgroup=1</p>
            <p>pickupgroup=1</p>
            <p>directmedia=no</p>
            <p><strong>Krok 3:</strong> W CLI Asteriska wprowadź polecenia <strong>module reload features</strong> oraz <strong>sip reload.</strong></p>
            <p><strong>Krok 4:</strong> Włącz przechwytywanie ruchu (Wireshark). Z PhonerLite zadzwoń do Zoipera. Nie odbieraj połączenia, ale w Blinku wybierz numer *8. Przeanalizuj przechwyconą sygnalizację SIP, SDP i media (RTP). Wykonaj wykres MSC ilustrujący wymianę wiadomości sygnalizacyjnych podczas scenariusza Call Pickup. Czy pojawiły się nowe pola SDP?</p>
        </div>
        <div class="task">
            <h3>ZADANIE 5: SPRAWOZDANIE</h3>
            <p>Wykonaj sprawozdanie w którym umieścisz przebieg wykonania powyższych punktów. Dołącz do niego pliki .pcap oraz pliki konfiguracyjne. Dołącz również generowane automatycznie wyniki Quizu.</p>
        </div>
        <hr>
        <div class="container">
            <h3>Baza wiedzy problemów:</h3>
            <br>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <select name="problem" id="problem" class="custom-select">
                <option value="0">Wybierz problem poniżej i sprawdź rozwiązanie</option>
                <option value="1">Mimo wprowadzanych zmian w plikach sip.conf, extensions.conf, features.conf nie mogę wykonać połączeń z użyciem usług dodatkowych.</option>
                <option value="2">Próbując wykonać połączenie z usługą Blind Call Transfer nic się nie dzieje. Po wybraniu # i numeru pokazuje się błąd.</option>
            </select>
            <br>
            <br>
            <div id="val1" class="hidden" style="display: none;">
                <p><strong>Rozwiązanie:</strong> Upewnij się, że nie zrobiłeś żadnej literówki. Pamiętaj o przeładowaniu plików w CLI Asterisk.</p>
            </div>
            <div id="val2" class="hidden" style="display: none;">
                <p><strong>Rozwiązanie:</strong> Musisz wykonać połączenie według schematu. Tzn. zadzwonić z Phonerlite do Zoipera i w Zoiperze wybrać #numerBlinka. W innej kolejności nie będzie działało. </p>
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
        <div class="analysis">
            <h3>ANALIZA</h3>
            <form action="/analysis.php">
                <div>
                    <input type="submit" class="btn btn-outline-secondary" value="Sprawdź się">
                    <input type="hidden" name="lab" value="5">
                    <input type="hidden" name="number" value="17">
                </div>
            </form>
        </div>
        <hr>
        <div class="quiz">
            <h3>Quiz:</h3>
            <a href="../question.php?n=21&l=5" class="btn btn-outline-secondary" role="button">Rozpocznij quiz!</a>
        </div>
        <?php }?>
    </div>

<?php
    require_once '../includes/footer.php';
?>