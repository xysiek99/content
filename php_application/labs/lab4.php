<?php
        include '../includes/header.php';
?>
    <div class="container">
        <div class="lab">
            <h1>Usługi dodatkowe (Auto Attendant, Interactive Voice Response, VoiceMail)</h1>
            </br>
            <h3>Cele:</h3>
            <ul class="list-group">
                <li class="list-group-item">Konfiguracja usług dodatkowych Auto Attendant, Interactive Voice Response, VoiceMail;</li>
                <li class="list-group-item">Wykonywanie połączeń z wykorzystaniem usług dodatkowych;</li>
            </ul>
            </br>
            <h3>Wprowadzenie:</h3>
            <p>Usługi dodatkowe w sieciach telekomunikacyjnych są uzupełnieniem usług podstawowych. W tym zadaniu dowiesz się czym jest i jak skonfigurować Auto Attendant (automatyczna sekretarka), IVR (interaktywna odpowiedź głosowa, która umożliwia ludziom interakcję z centralą PABX za pomocą cyfr wprowadzanych za pomocą klawiatury) oraz Voice Mail (poczta głosowa).</p>
            <p>Auto Attendant umożliwia automatyczne przekierowanie rozmówców na numer wewnętrzny bez interwencji fizycznej osoby.</p>
            <p>System IVR pobiera dane wejściowe, przetwarza je i zwraca wynik, natomiast system AA służy do kierowania połączeń.</p>
        </div>
        <div class="container">
            <br>
            <?php if ($_SESSION['hint']==1){ ?>
                <input type="button" class="btn btn-outline-secondary" onclick="window.open('/hints/hint4.php', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=700,height=700')" value="Pokaż podpowiedzi">
            <?php }?>
            <br>
            </br>
            <h3>ZADANIE 1: KONFIGURACJA AUTO ATTENDANT</h3>
            <p><strong>Krok 1:</strong> W pliku <strong>extensions.conf</strong> dodaj poniższe wartości:</p>
            <p>[from-internal]</p>
            <p>exten=>8,1,goto(aa,9999,1)  (definiuje co wydarzy się w momencie kiedy wybierzemy numer 8. W tym wypadku zostaniemy przekierowany do AA pod numer 9999).</p>
            <p>exten=>_4.,1,Record(menu2:gsm)</p>
            <p>exten=>_4.,n,wait(1)</p>
            <p>exten=>_4.,n,Playback(menu2)</p>
            <p>exten=>_4.,n,Hangup()</p>
            <p>[from-siptrunk]</p>
            <p>include=aa</p>
            <p>[aa]</p>
            <p>exten=>9999,1,answer()</p>
            <p>exten=>9999,n,background(menu2)</p>
            <p>exten=>9999,n,waitexten(10)</p>
            <p>exten=>9999,n,Dial(${OPERATOR})</p>
            <p>exten=>6000,1,Dial(SIP/zoiper)</p>
            <p>exten=>6000,1,Dial(SIP/blin)</p>
            <p>Ta część zadania jest odpowiedzialna za nagrywanie zapowiedzi głosowej. </p>
            <p>Pliki z nagraniem tworzy się w momencie wybrania numeru 4 oraz podania nazwy dla pliku dźwiękowego. W tym przypadku będzie to np. „4menu1”.</p>
            <p>Po zakończeniu nagrywania należy wybrać znak # i poczekać.</p>
            <p>W sekcji [aa] opisane są kroki jakie zostaną wykonane jeśli zostaniemy przekierowani na numer 9999(jak w powyższej konfiguracji). Na początku nasze przekierowanie zostanie odebrane, następnie zostanie odtworzona nagrana zapowiedź głosowa. Po odtworzeniu wiadomości będziemy mieli 10 sekund na wybranie opcji. Jeśli żadna opcja nie zostanie wybrana zostaniemy przekierowani do „operatora”. Jeśli wybierzemy numer zostaniemy przekierowani w tym wypadku do Zoipera (nr 6000) lub Blink (nr 6001).</p>
            <p><strong>Krok 2:</strong> W pliku <strong>sip.conf</strong> dodaj dwa konta wykorzystując wiedzę z poprzednich Laboratoriów.</p>
            <p><strong>Krok 3:</strong> Nagraj przykładową wiadomość głosową według instrukcji powyżej, a następnie przechwyć programem Wireshark wywołanie usługi Auto Attendant.</p>
        </div>
        <div class="container">
            <h3>ZADANIE 2: KONFIGURACJA INTERACTIVE VOICE RESPONSE</h3>
            <p><strong>Krok 1:</strong> W pliku <strong>extensions.conf</strong> dodaj poniższe wartości:</p>
            <p>[from-internal]</p>
            <p>exten=>7,1,goto(ivrsip,9999,1)  -  definiuje co wydarzy się w momencie kiedy wybierzemy numer 7. W tym wypadku zostaniemy przekierowani do IVR pod numer 9999.</p>
            <p>[from-siptrunk]</p>
            <p>include=ivrsip</p>
            <p>[ivrsip]</p>
            <p>exten=>9999,1,answer()</p>
            <p>exten=>9999,n,background(menu2)</p>
            <p>exten=>9999,n,waitexten(10)</p>
            <p>exten=>9999,n,Dial(${OPERATOR})</p>
            <p>exten=>1,1,dial(SIP/zoiper)</p>
            <p>exten=>2,1,dial(SIP/blink)</p>
            <p>exten=>6000,1,Dial(SIP/zoiper)</p>
            <p>exten=>6001,1,Dial(SIP/blink)</p>
            <p>W sekcji [ivrsip] opisane są kroki jakie zostaną wykonane jeśli zostaniemy przekierowani na numer 9999(jak w powyższej konfiguracji). Na początku nasze przekierowanie zostanie odebrane, następnie zostanie odtworzona nagrana zapowiedź głosowa. Po odtworzeniu wiadomości będziemy mieli 10 sekund na wybranie opcji. Jeśli żadna opcja nie zostanie wybrana zostaniemy przekierowani do „operatora”. Jeśli wybierzemy numer zostaniemy przekierowani w tym wypadku do Zoipera (nr 1 lub 6000) lub Blink (nr 2 lub 6001).</p>
            <p><strong>Krok 2:</strong> Plik <strong>sip.conf</strong> zostaje taki sam jak w poprzednim zadaniu.</p>
            <p><strong>Krok 3:</strong> Wykorzystaj wcześniej nagraną wiadomość głosową, a następnie przechwyć programem Wireshark wywołanie usługi Interactive Voice Response.</p>
        </div>
        <div class="container">
            <h3>ZADANIE 3: KONFIGURACJA VOICEMAIL</h3>
            <p><strong>Krok 1:</strong> W pliku <strong>extensions.conf</strong> dodaj poniższe wartości:</p>
            <p>[stdexten]</p>
            <p>exten=>s,1,Dial(${ARG1},20,tT) </p>
            <p>exten=>s,n,Goto(${DIALSTATUS})  -  litera n w miejscu priorytetu oznacza następy (next)</p>
            <p>exten=>s,n,hangup()</p>
            <p>exten=>s,n(BUSY),voicemail(${ARG2},b)  -  n(BUSY) oznacza, że nadaliśmy priorytetowi n etykietę BUSY i może wykorzystać w Goto</p>
            <p>exten=>s,n,hangup()</p>
            <p>exten=>s,n(NOANSWER),voicemail(${ARG2},u)</p>
            <p>exten=>s,n,hangup()</p>
            <p>exten=>s,n(CANCEL),nagup()</p>
            <p>exten=>s,n(CHANUNAVAIL),hangup()</p>
            <p>exten=>s,n(CONGESTION),hangup()</p>
            <p>[from-internal]</p>
            <p>exten=>6000,1,Gosub(stdexten,s,1(SIP/zoiper,${EXTEN}))  -  przekazanie argumentów ${ARG1} czyli SIP/zoiper oraz ${ARG2} czyli ${EXTEN}</p>
            <p>exten=>6001,1,Gosub(stdexten,s,1(SIP/blink(${EXTEN}))</p>
            <p>exten=>5,1,voicemailmain()  -  odsłuchanie poczty głosowej</p>
            <p><strong>Krok 2:</strong> W pliku <strong>voicemail.conf</strong> dodaj poniższe wartości:</p>
            <p>[general]</p>
            <p>Format=wav49|gsm|wav</p>
            <p>[default]</p>
            <p>6000=>6000, zoiper,root@localhost,,|attach=yes|delete=0  -  skrzynka numeru 6000 ma hasło 6000 i mail root@local.host</p>
            <p>6001=>6001, blink, root@localhost,,|attach=yes|delete=0  -  nagrania będą dołączane do wiadomości i nie będą kasowane</p>
            <p><strong>Krok 3:</strong> Przechwyć programem Wireshark wywołanie usługi VoiceMail.</p>
        </div>
        <div class="container">
            <h3>ZADANIE 4: SPRAWOZDANIE</h3>
            <p>Wykonaj sprawozdanie ze zrobionych powyższych zadań. Dołącz do niego zrzuty ekranu przechwyconego ruchu oraz dołącz pliki .pcap. Umieść w nim również wykresy MSC dla każdej przechwyconej usługi. Dołącz również generowane automatycznie wyniki Quizu.</p>
        </div>
        <hr>
        <div class="container">
            <h3>Baza wiedzy problemów:</h3>
            <br>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <select name="problem" id="problem" class="custom-select">
                <option value="0">Wybierz problem poniżej i sprawdź rozwiązanie</option>
                <option value="1">Mimo wprowadzanych zmian w plikach sip.conf, extensions.conf, features.conf nie mogę wykonać połączeń z użyciem usług dodatkowych.</option>
            </select>
            <br>
            <br>
            <div id="val1" class="hidden" style="display: none;">
                <p><strong>Rozwiązanie:</strong> Upewnij się, że nie zrobiłeś żadnej literówki. Pamiętaj o przeładowaniu plików w CLI Asterisk.</p>
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
                    <input type="hidden" name="lab" value="4">
                    <input type="hidden" name="number" value="13">
                </div>
            </form>
        </div>
        <hr>
        <div class="quiz">
            <h3>Quiz:</h3>
            <a href="../question.php?n=16&l=4" class="btn btn-outline-secondary" role="button">Rozpocznij quiz!</a>
        </div>
        <?php }?>
    </div>

<?php
    require_once '../includes/footer.php';
?>