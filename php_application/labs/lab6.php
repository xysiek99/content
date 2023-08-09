<?php
        include '../includes/header.php';
?>
    <div class="container">
        <div class="lab">
            <h1>Rekordy CDR (Call Detail Record)</h1>
            </br>
            <h3>Cele:</h3>
            <ul class="list-group">
                <li class="list-group-item">Wykonanie połączeń i opisanie zebranych danych CDR;</li>
                <li class="list-group-item">Zmiana konfiguracji zbieranych danych CDR;</li>
            </ul>
            </br>
            <h3>Wprowadzenie:</h3>
            <p>Rekordy CDR są tworzone po każdym połączeniu i służą do rozliczania/taryfikacji połączeń. W tym ćwiczeniu nauczysz się jak interpretować dane zebrane w rekordzie CDR oraz jak skonfigurować zakres zbieranych danych, w tym danych dotyczących jakości połączenia, a następnie wykorzystać je w E-modelu przy kalkulacji oceny jakościowej połączenia.</p>
        </div>
        <div class="container">
            <br>
            <?php if ($_SESSION['hint']==1){ ?>
                <input type="button" class="btn btn-outline-secondary" onclick="window.open('/hints/hint6.php', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=700,height=700')" value="Pokaż podpowiedzi">
            <?php }?>
            <br>
            </br>
            <h3>ZADANIE 1: KONFIGURACJA POŁĄCZENIA I OPIS DANYCH CDR</h3>
            <p><strong>Krok 1:</strong> W pliku <strong>extensions.conf</strong> wykonaj modyfikację numeracji. Wprowadź poniższe linie:</p>
            <p>[from-internal]</p>
            <p>exten=>7000,1,Gosub(stdexten,s,1(SIP/zoiperinternal,${EXTEN}))</p>
            <p>exten=>7001,1,Gosub(stdexten,s,1(SIP/blinkinternal,${EXTEN}))</p>
            <p><strong>Krok 2:</strong> W celu uruchomienia rozliczania połączeń zmień plik <strong>/etc/asterisk/cdr_custom.conf</strong> poprzez usunięcia komentarzy w sekcji [mappings].</p>
            <p><strong>Krok 3:</strong> Edytuj funkcję [stdexten] w pliku <strong>extensions.conf</strong></p>
            <p>exten=>s,1,Verbose(0,Caller ID=${CALLERID(num)})  -  włączenie logowania</p>
            <p>exten=>s,n,Dial(${ARG1},20,tT)  -  Dial: dzwonienie do określonego numeru(w zależności od arg)</p>
            <p>exten=>s,n,goto(${DIALSTATUS})</p>
            <p>exten=>s,n,hangup()</p>
            <p>exten=>s,n(BUSY),voicemail(${ARG2},b)</p>
            <p>exten=>s,n,hangup()</p>
            <p>exten=>s,n(NOANSWER),voicemail(${ARG2},u)</p>
            <p>exten=>s,n,hangup()</p>
            <p>exten=>s,n(CANCEL),hangup()</p>
            <p>exten=>s,n(CHANUNAVAIL),hangup()</p>
            <p>exten=>s,n(CONGESTION),hangup()</p>
            <p>exten=>h,1,Set(CDR(QOS)=${CHANNEL(rtpqos,audio,all)})</p>
            <p>exten=>h,n,Set(RTCP_data=${CHANNEL(rtpqos,audio,all)})</p>
            <p>exten=>h,n,NoOp(RTCP Values: ${RTCP_data})</p>
            <p>W zależności od zmiennej $DIALSTATUS Asterisk udaje się do odpowiedniej sekcji. Następnie jeśli zostanie wywołany Hangup, definiujemy czym jest CDR(QOS).</p>
            <p>Zmienna Channel:</p>
            <p>rtpqos – dane dotyczące jakości usług rtp qos;</p>
            <p>Audio – dane dotyczące audio;</p>
            <p>All – włączone wszystko co jest dostępne;</p>
            <p><strong>Krok 4:</strong> W CLI Asteriska wykonaj dwa przeładowania: <strong>core restart now</strong> oraz <strong>dialplan reload.</strong></p>
            <p><strong>Krok 5:</strong> Wykonaj połączenie z Zoipera do Blinka (numer 7001). W pliku CDR (/var/log/asterisk/cdr-custom) odczytaj informacje o wykonanym połączeniu.</p>
        </div>
        <div class="container">
            <h3>ZADANIE 2: ZMIANA KONFIGURACJI ZBIERANYCH DANYCH CDR</h3>
            <p><strong>Krok 1:</strong> Wykorzystaj SIP Trunk używany podczas LAB3. Plik <strong>sip.conf</strong> wgraj do odpowiednich maszyn.</p>
            <p><strong>Krok 2:</strong> W maszynie nr 1 dodaj poniższy kod w pliku <strong>extensions.conf:</strong></p>
            <p>[stdexten]</p>
            <p>exten=>s,1,Verbose(0,caller ID= ${CALLERID(num)})</p>
            <p>exten=>s,n,Dial(${ARG1},20,tT)</p>
            <p>exten=>s,n,goto(${DIALSTATUS})</p>
            <p>exten=>s,n,hangup()</p>
            <p>exten=>s,n(BUSY),voicemail(${ARG2},b)</p>
            <p>exten=>s,n(NOANSWER),voicemail(${ARG2},u)</p>
            <p>exten=>s,n,hangup()</p>
            <p>exten=>s,n(CANCEL),hangup()</p>
            <p>exten=>s,n(CHANUNAVAIL),hangup()</p>
            <p>exten=>s,n(CONGESTION),hangup()</p>
            <p>exten=>h,1,Set(CDR(QOS)=${CHANNEL(rtpqos,audio,all)})</p>
            <p>exten=>h,n,Set(RTCP_data=${CHANNEL(rtpqos,audio,all)})</p>
            <p>exten=>h,n,NoOp(RTCP Values: ${RTCP_data})</p>
            <p>[from-asterisk2]</p>
            <p>exten=>_2XZN,1,Gosub(stdexten,s,1(SIP/${EXTEN}@asterisk2))</p>
            <p>exten=>1234,1,Gosub(stdexten,s,1(SIP/zoiper,${EXTEN}))</p>
            <p><strong>Krok 3:</strong> W maszynie nr 2 dodaj poniższy kod w pliku <strong>extensions.conf</strong>:</p>
            <p>[stdexten]</p>
            <p>exten=>s,1,Dial(${ARG1},20,tT)</p>
            <p>exten=>s,n,Goto(${DIALSTATUS})</p>
            <p>exten=>s,n,hangup()</p>
            <p>exten=>s,n(BUSY),voicemail(${ARG2},b)</p>
            <p>exten=>s,n,hangup()</p>
            <p>exten=>s,n(NOANSWER),voicemail(${ARG2},u)</p>
            <p>exten=>s,n,hangup()</p>
            <p>exten=>s,n(CANCEL),hangup()</p>
            <p>exten=>s,n(CHANUNAVAIL),hangup()</p>
            <p>exten=>s,n(CONGESTION),hangup()</p>
            <p>[from-asterisk]</p>
            <p>exten=>_1XZN,1,Dial(SIP/${EXTEN}@asterisk)</p>
            <p>exten=>_1XZN,n,Hangup()</p>
            <p>exten=>2345,1,Dial(SIP/blink)</p>
            <p>exten=>2345,n,Hangup()</p>
            <p><strong>Krok 4:</strong> Przeanalizuj dane QOS i umieść opis w sprawozdaniu.</p>
        </div>
        <div class="container">
            <h3>ZADANIE 3: SPRAWOZDANIE</h3>
            <p>Wykonaj sprawozdanie z powyższej pracy. Opisz zebrane dane CDR odnosząc się do typu i wartości. Dołącz do niego również generowane automatycznie wyniki Quizu</p>
        </div>
        <hr>
        <div class="container">
            <h3>Baza wiedzy problemów:</h3>
            <br>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <select name="problem" id="problem" class="custom-select">
                <option value="0">Wybierz problem poniżej i sprawdź rozwiązanie</option>
                <option value="1">Po użyciu komendy core restart now Asterisk nie działa prawidłowo.</option>
            </select>
            <br>
            <br>
            <div id="val1" class="hidden" style="display: none;">
                <p><strong>Rozwiązanie:</strong> Po restarcie Asteriska włącz CLI, a następnie wpisz komendę <strong>module load chan_sip.so</strong></p>
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
        <div class="quiz">
            <h3>Quiz:</h3>
            <a href="../question.php?n=26&l=6" class="btn btn-outline-secondary" role="button">Rozpocznij quiz!</a>
        </div>
        <?php }?>
    </div>

<?php
    require_once '../includes/footer.php';
?>