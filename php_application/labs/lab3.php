<?php
        include '../includes/header.php';
?>
    <div class="container">
        <div class="lab">
            <h1>Konfiguracja i wykonywanie połączeń między centralami Asterisk (konfiguracja SIP Trunk – z rejestracją i bez rejestracji)</h1>
            </br>
            <h3>Cele:</h3>
            <ul class="list-group">
                <li class="list-group-item">Konfiguracja punktu styku (SIP Trunk) między centralami Asterisk;</li>
                <li class="list-group-item">Przypisanie numeracji i konfiguracja planu dzwonienia;</li>
                <li class="list-group-item">Wykonanie połączenia inicjowanego z terminala z centrali nr 1 do terminala w centrali nr 2 (i odwrotnie);</li>
                <li class="list-group-item">Konfiguracja SIP Trunk na podstawie rejestracji jednej centrali w drugiej oraz wykonanie połączeń pomiędzy tymi centralami;</li>
            </ul>
            </br>
            <h3>Wprowadzenie:</h3>
            <p>SIP Trunk to tzw. wiązka łączy, dla której sygnalizacja wykonywana jest w protokole SIP. W tym zadaniu nauczysz się konfiguracji SIP Trunk w trybach: z rejestracją i bez z rejestracji. Dzięki temu będziesz miał możliwość zadzwonienia z terminala z jednej centrali do terminala w drugiej centrali. W celu poprawnego wykonania zadania, należy odpowiednio skonfigurować pliki sip.conf oraz extensions.conf. Na początku potrzebne będzie sklonowanie istniejącej maszyny. Wykonuj poniższe zadania zgodnie ze wskazówkami.</p>
        </div>
        <div class="container">
            <br>
            <?php if ($_SESSION['hint']==1){ ?>
                <input type="button" class="btn btn-outline-secondary" onclick="window.open('/hints/hint3.php', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=700,height=700')" value="Pokaż podpowiedzi">
            <?php }?>
            <br>
            </br>
            <h3>ZADANIE 1: KONFIGURACJA DWÓCH CENTRAL (SIP Trunk bez rejestracji)</h3>
            <p><strong>Krok 1:</strong> W Virtualboxie poprzez kliknięcie PPM na aktualną maszynę wybierz opcję „sklonuj”. Doda się klon aktualnej maszyny, abyśmy nie musieli konfigurować nowego systemu od nowa.</p>
            <p><strong>Krok 2:</strong> Poprzez komendę „ifconfig” w terminalu, odczytaj adresy IP poszczególnych maszyn.</p>
            <p><strong>Krok 3:</strong> W pliku <strong>sip.conf</strong> na dwóch maszynach dodaj poniższy wpis:</p>
            <p>[asterisk2]</p>
            <p>type=peer (rodzaj wpisu; w tym przypadku peer, czyli kolejna centrala)</p>
            <p>host=adresIP drugiej maszyny</p>
            <p>context=from-asterisk2  (context, który znajduje się w pliku extensions.conf zawierający tablice przekazywania połączeń)</p>
            <p>allow=ulaw,alaw (rodzaj używanych kodeków w połączeniach)</p>
            <p>insecure=port,invite (ignoruje numery portów oraz autentykację w zaproszeniu do połączenia SIP)</p>
            <p>fromuser=asterisk2 (użytkownik, który przekazuje połączenie do drugiej centrali)</p>
        </div>
        <div class="container">
            <h3>ZADANIE 2: NUMERACJA ORAZ WYKONANIE POŁĄCZEŃ (SIP Trunk bez rejestracji)</h3>
            <p><strong>Krok 1:</strong> W maszynie nr 1 w pliku extensions.conf dodaj poniższy wpis:</p>
            <p>[from-internal]</p>
            <p>exten=>_1XXX,1,dial(SIP/zoiper,20)</p>
            <p>exten=>_2XXX,1,dial(SIP/asterisk2/_2XXX,20)</p>
            <p>[from-asterisk2]</p>
            <p>exten=>_2XXX,1,dial(SIP/blink,20)</p>
            <p>exten=>_1XXX,1,dial(SIP/zoiper,20)</p>
            <p><strong>Krok 2:</strong> W maszynie nr 2 w pliku <strong>extensions.conf</strong> dodaj poniższy wpis:</p>
            <p>[from-internal]</p>
            <p>exten=>_1XXX,1,dial(SIP/asterisk2/_1XXX,20)</p>
            <p>exten=>_2XXX,1,dial(SIP/blink,20)</p>
            <p>[from-asterisk2]</p>
            <p>exten=>_1XXX,1,dial(SIP/zoiper,20)</p>
            <p>exten=>_2XXX,1,dial(SIP/blink,20)</p>
            <p><strong>Krok 3:</strong> W CLI Asteriska wykonaj komendy <strong>sip reload</strong> oraz <strong>dialplan reload</strong></p>
            <p><strong>Krok 4:</strong> Wykonaj połączenie z Zoipera (z jednego adresu IP) do Blinka (drugi adres IP). Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 5:</strong> Wykonaj połączenie odwrotne do tego w Kroku 4. </p>
            <p>Numery możesz wybrać losowo. Po wpisaniu dowolnego 4-cyfrowego numeru zaczynającego się od 1 dodzwonimy się do centrali pierwszej, a dzwoniąc na numer, który rozpoczyna się od 2 dodzwonimy się do centrali drugiej.</p>
            <p><strong>Krok 6:</strong> Wykonaj sprawozdanie w którym opiszesz konfigurację powyższych kroków. Do sprawozdania dołącz pliki sip.conf i extensions.conf oraz wykres MSC dla zestawianego połączenia składając w jeden wykres wszystkie części tj. wykresy dotyczące: terminal1 – centrala1, centrala1 – centrala2, centrala2 – terminal2. Dołącz również generowane automatycznie wyniki zadania wspomaganego aplikacją(analiza) i wyniki Quizu.</p>
        </div>
        <div class="container">
            <h3>ZADANIE 3: KONFIGURACJA DWÓCH CENTRALI (SIP Trunk z rejestracją)</h3>
            <p><strong>Krok 1:</strong> W pliku <strong>sip.conf</strong> na maszynie nr 1 wprowadź poniższe wartości. </p>
            <p>[general]</p>
            <p>register=>warszawa:welcome@192.168.31.204/paryz  (nazwiemy dwie centrale Warszawa oraz Paryż).</p>
            <p>[paryz]</p>
            <p>type=friend  (jednostka, która wysyła i wykonuje połączenia (peer+user)</p>
            <p>secret=12345</p>
            <p>context=paryz_incoming  (odwołanie do dialplanu)</p>
            <p>host=dynamic</p>
            <p>disallow=all</p>
            <p>allow=ulaw</p>
            <p>[1000]</p>
            <p>type=friend</p>
            <p>host=dynamic</p>
            <p>secret=12345</p>
            <p>context=phones</p>
            <p><strong>Krok 2:</strong> W pliku <strong>sip.conf</strong> na maszynie nr 2 wprowadź poniższe wartości. </p>
            <p>[general]</p>
            <p>register=>paryz:welcome@192.168.31.203/warszawa</p>
            <p>[warszawa]</p>
            <p>type=friend</p>
            <p>secret=12345</p>
            <p>context=warszawa_incoming</p>
            <p>host=dynamic</p>
            <p>disallow=all</p>
            <p>allow=ulaw</p>
            <p>[1000]</p>
            <p>type=friend</p>
            <p>host=dynamic</p>
            <p>secret=12345</p>
            <p>context=phones</p>
            <p><strong>Krok 3:</strong> W pliku <strong>extensions.conf</strong> na maszynie nr 1 wprowadź poniższe wartości dla różnych sekcji. </p>
            <p>[globals]</p>
            <p>[general]</p>
            <p>autofallthrough=yes</p>
            <p>[default]</p>
            <p>[incoming_calls]</p>
            <p>[phones]</p>
            <p>include=>internal</p>
            <p>include=>remote</p>
            <p>[internal]</p>
            <p>exten=>_2XXX,1,NoOp()</p>
            <p>exten=>_2XXX,n,Dial(SIP/${EXTEN},30)</p>
            <p>exten=>_2XXX,n,Playback()</p>
            <p>exten=>_2XXX,n,Hangup()</p>
            <p>[remote]</p>
            <p>exten=>_1XXX,1,NoOp()</p>
            <p>exten=>_1XXX,n,Dial(SIP/paryz/${EXTEN})</p>
            <p>exten=>_1XXX.n.Hangup()</p>
            <p>[paryz_incoming]</p>
            <p>include=>internal</p>
            <p><strong>Krok 4:</strong> W pliku <strong>extensions.conf</strong> na maszynie nr 2 wprowadź poniższe wartości dla różnych sekcji.</p>
            <p>[globals]</p>
            <p>[general]</p>
            <p>autofallthrough=yes</p>
            <p>[default]</p>
            <p>[incoming_calls]</p>
            <p>[phones]</p>
            <p>include=>internal</p>
            <p>include=>remote</p>
            <p>[internal]</p>
            <p>exten=>_1XXX,1,NoOp()</p>
            <p>exten=>_1XXX,n,Dial(SIP/${EXTEN},30)</p>
            <p>exten=>_1XXX,n,Playback()</p>
            <p>exten=>_1XXX,n,Hangup()</p>
            <p>[remote]</p>
            <p>exten=>_2XXX,1,NoOp()</p>
            <p>exten=>_2XXX,n,Dial(SIP/warszawa/${EXTEN})</p>
            <p>exten=>_2XXX.n.Hangup()</p>
            <p>[warszawa_incoming]</p>
            <p>include=>internal</p>
            <p><strong>Krok 5:</strong> Zarejestruj konto 1000 oraz 1001 w aplikacji Zoiper. Zrób zrzut ekranu potwierdzający rejestrację central (polecenie <strong>sip show peers</strong> w CLI Asteriska) oraz terminali. Przechwyć ruch rejestracji konta 1000 programem Wireshark.</p>
            <p><strong>Krok 6:</strong> Wykonaj połączenie z konta 1000 do konta 1001. Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 7:</strong> Wykonaj sprawozdanie w którym opiszesz konfigurację powyższych kroków. Do sprawozdania dołącz pliki sip.conf i extensions.conf (z dwóch maszyn), wykresy MSC dla kroków 5 i 6 oraz pliki .pcap z przechwyconego ruchu. Opisz za co odpowiadają nagłówki REGISTER, 200 OK, INVITE, ACK, 180 RINGING. Dołącz również generowane automatycznie wyniki Quizu.</p>
        </div>
        <hr>
        <div class="container">
            <h3>Baza wiedzy problemów:</h3>
            <br>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <select name="problem" id="problem" class="custom-select">
                <option value="0">Wybierz problem poniżej i sprawdź rozwiązanie</option>
                <option value="1">Podczas próby połączenia z kontem 1001 pojawia się błąd „SIP 488 – Not acceptable here”.</option>
                <option value="2">Mimo wpisania prawidłowo wszystkich rzeczy do pliku sip.conf i extensions.conf nie mogę się dodzwonić do drugiej centrali. </option>
            </select>
            <br>
            <br>
            <div id="val1" class="hidden" style="display: none;">
                <p><strong>Rozwiązanie:</strong> W konfiguracji terminala Zoiper musisz zadeklarować brakujące kodeki do realizacji połączeń (nasze centrale obsługują ulaw i alaw).</p>
            </div>
            <div id="val2" class="hidden" style="display: none;">
                <p><strong>Rozwiązanie:</strong> Upewnij się, że wpisałeś prawidłowy adres IP w pliku sip.conf. Na maszynie nr 1 trzeba wpisać adres IP maszyny numer 2 i odwrotnie.</p>
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
                    <input type="hidden" name="lab" value="3">
                    <input type="hidden" name="number" value="9">
                </div>
            </form>
        </div>
        <hr>
        <div class="quiz">
            <h3>Quiz:</h3>
            <a href="../question.php?n=11&l=3" class="btn btn-outline-secondary" role="button">Rozpocznij quiz!</a>
        </div>
        <?php }?>
    </div>

<?php
    require_once '../includes/footer.php';
?>