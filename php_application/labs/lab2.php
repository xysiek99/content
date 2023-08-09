<?php
        include '../includes/header.php';
?>
    <div class="container">
        <div class="lab">
            <h1>Konfiguracja i wykonywanie połączeń lokalnych (w ramach jednej centrali Asterisk)</h1>
            </br>
            <h3>Cele:</h3>
            <ul class="list-group">
                <li class="list-group-item">Konfiguracja dwóch kont SIP w centrali Asterisk;</li>
                <li class="list-group-item">Konfiguracja dwóch różnych terminali SIP; </li>
                <li class="list-group-item">Rejestracja terminali;</li>
                <li class="list-group-item">Konfiguracja planu dzwonienia umożliwiająca zestawienie połączeń między terminalami w ramach jednej centrali Asterisk;</li>
                <li class="list-group-item">Analiza sygnalizacji wymienianej podczas zestawiania połączenia;</li>
                <li class="list-group-item">Zmiana konfiguracji tak, aby zestawić dwa kolejne połączenia z różnymi kodekami;</li>
            </ul>
            </br>
            <h3>Wprowadzenie:</h3>
            <p>Głównym celem tego ćwiczenia jest nauka konfigurowania połączeń między terminalami SIP, zarejestrowanymi w tej samej centrali Asterisk. Realizacja zadania wymaga odpowiednich zmian w plikach <strong>extensions.conf</strong> oraz <strong>sip.conf</strong>. W nazewnictwie Asterisk zapis zasad kierowania połączeniami to tzw. dialplan. W pliku extensions.conf wskazujemy context np. from-internal, który pozwala na powiązanie definicji kierowania połączeń z określonym zasobem. Powiązanie to odbywa się poprzez wskazanie nazwy sekcji jako wartość atrybutu „context” w pliku sip.conf.</p>
        </div>
        <div class="container">
            <br>
            <?php if ($_SESSION['hint']==1){ ?>
                <input type="button" class="btn btn-outline-secondary" onclick="window.open('/hints/hint2.php', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=700,height=700')" value="Pokaż podpowiedzi">
            <?php }?>
            <br>
            </br>
            <h3>ZADANIE 1: KONFIGURACJA KONT SIP ORAZ TERMINALI</h3>
            <p><strong>Krok 1:</strong> W centrali Asterisk, w pliku sip.conf dodaj dwa różne konta SIP (uczyłeś się tego w LAB1).</p>
            <p><strong>Krok 2:</strong> Dodaj dwa konta (utworzone w kroku 1) do dwóch różnych terminali SIP. Jedno konto zarejestruj w aplikacji Zoiper, a drugie konto na innej maszynie w aplikacji Blink.</p>
        </div>
        <div class="container">
            <h3>ZADANIE 2: KONFIGURACJA PLANU POŁĄCZEŃ ORAZ WYKONANIE POŁĄCZEŃ</h3>
            <p><strong>Krok 1:</strong> Na początku musimy utworzyć routing pomiędzy terminalami, tak aby można było wykonać między nimi połączenie. </p>
            <ul>
                <li>cd /etc/asterisk</li>
                <li>vi extensions.conf </li>
            </ul>
            <p>[from internal]</p>
            <p>exten=>6000,1,dial(SIP/zoiper,20)</p>
            <p>exten=>6001,1,dial(SIP/blink,20)</p>
            <p><strong>Krok 2:</strong> W pliku <strong>sip.conf</strong>  dopisz konfigurację z której terminale będą czerpały informacje na temat kierowania ruchem:</p>
            <p><italic>Context=from-internal</italic></p>
            <p><strong>Krok 3:</strong> Z poziomu CLI Asteriska wykonaj polecenie dialplan reload.</p>
            <p><strong>Krok 4:</strong> Spróbuj zadzwonić z terminala Zoiper na terminal Blink (numer 6001), a następnie odwrotnie (numer 6000).</p>
        </div>
        <div class="container">
            <h3>ZADANIE 3: ANALIZA RUCHU I SPRAWOZDANIE</h3>
            <p><strong>Krok 1:</strong> Przechwyć ruch podczas połączenia używając programu Wireshark. </p>
            <p><strong>Krok 2:</strong> Wykonaj sprawozdanie w którym umieścisz zrzuty ekranu z powyższej pracy. Opisz w nim informacje o:</p>
            <ul>
                <li>Wiadomościach SIP w których została przekazana oferta SDP;</li>
                <li>Identyfikatorach dialogów tworzących sesję (Call-ID);</li>
                <li>Adresach IP i numerach portów na których odbywa się wymiana mediów (z sekcji SDP);</li>
                <li>Wartościach występujących w sekcji opisu mediów SDP (kodeki i ich parametry).</li>
            </ul>
            <p>Do sprawozdania dołącz pliki .pcap z przechwyconego ruchu oraz generowane automatycznie wyniki Quizu.</p>
        </div>
        <div class="container">
            <h3>ZADANIE 4: UŻYCIE RÓŻNYCH KODEKÓW</h3>
            <p><strong>Krok 1:</strong> We wcześniejszym zadaniu użyliśmy tylko kodeka PCMU. Teraz spróbujemy użyć zarówno kodeka PCMU jak i PCMA. W ustawieniach aplikacji Zoiper włącz kodeki a-law oraz u-law, a w aplikacji Blink PCMU oraz PCMA.</p>
            <p><strong>Krok 2:</strong> W pliku sip.conf zmień wartość allow na poniższą:</p>
            <ul>
                <li>Allow = ulaw, alaw</li>
            </ul>
            <p>Po wprowadzeniu zmian przeładuj centralę Asteriska.</p>
            <p><strong>Krok 3:</strong> Sprawdź czy w przechwyconym ruchu Wireshark widać użycie kodeka PCMA.</p>
        </div>
        <hr>
        <div class="container">
            <h3>Baza wiedzy problemów:</h3>
            <br>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <select name="problem" id="problem" class="custom-select">
                <option value="0">Wybierz problem poniżej i sprawdź rozwiązanie</option>
                <option value="1">Mimo dodania [from-internal] w pliku extensions.conf nie mogę się dodzwonić do drugiego terminala.</option>
            </select>
            <br>
            <br>
            <div id="val1" class="hidden" style="display: none;">
                <p><strong>Rozwiązanie:</strong> Upewnij się, że w pliku extensions.conf dodałeś sekcję [from-internal] rozdzieloną myślnikiem. Jeśli nie dodasz myślnika nie będzie działać. Pamiętaj również o przeładowaniu Asterisk poleceniem dialplan reload.</p>
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
                    <input type="hidden" name="lab" value="2">
                    <input type="hidden" name="number" value="5">
                </div>
            </form>
        </div>
        <hr>
        <div class="quiz">
            <h3>Quiz:</h3>
            <a href="../question.php?n=6&l=2" class="btn btn-outline-secondary" role="button">Rozpocznij quiz!</a>
        </div>
        <?php }?>
    </div>

<?php
    require_once '../includes/footer.php';
?>