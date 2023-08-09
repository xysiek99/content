<?php
        include '../includes/header.php';
?>
    <div class="container">
        <div class="lab">
            <h1>Diagnozowanie problemów (troubleshooting)</h1>
            </br>
            <h3>Cele:</h3>
            <ul class="list-group">                
                <li class="list-group-item">Nauka zbierania i interpretacji logów systemowych;</li>
                <li class="list-group-item">Diagnozowanie problemów poprzez analizę logów i sygnalizacji SIP;</li>
            </ul>
            </br>
            <h3>Wprowadzenie:</h3>
            <p>Podczas pracy konfiguracyjnej mogą wystąpić problemy, które trzeba zdiagnozować. Typowo, rozwiązanie problemu wymaga zdefiniowania i odtworzenia problemu, zebrania logów i przechwycenia sygnalizacji SIP, przeanalizowania zebranych danych, postawienia hipotezy dotyczącej problemu, wykonania testów weryfikujacych hipotezę i wdrożenia rozwiązania.</p>
        </div>
        <div class="container">
            <br>
            <?php if ($_SESSION['hint']==1){ ?>
                <input type="button" class="btn btn-outline-secondary" onclick="window.open('/hints/hint7.php', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=700,height=700')" value="Pokaż podpowiedzi">
            <?php }?>
            <br>
            </br>
            <h3>ZADANIE 1: REJESTRACJA</h3>
            <p><strong>Krok 1:</strong> Stwórz problem polegający na braku konta w centrali. W tym celu dodaj w aplikacji Zoiper nieistniejące konto(brak konta w pliku sip.conf oraz extensions.conf). Przechwyć ruch programem Wireshark. </p>
            <p><strong>Krok 2:</strong> Rozwiąż powyższy problem i wykonaj ponowny test. Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 3:</strong> Stwórz problem polegający na wpisaniu niepoprawnego hasła konta centrali. W tym celu dodaj w aplikacji Zoiper istniejące konto, lecz ze złym hasłem. Przechwyć ruch programem Wireshark. </p>
            <p><strong>Krok 4:</strong> Rozwiąż powyższy problem i wykonaj ponowny test. Przechwyć ruch programem Wireshark.</p>
        </div>
        <div class="container">
            <h3>ZADANIE 2: LOKALNE POŁĄCZENIA</h3>
            <p><strong>Krok 1:</strong> Stwórz problem polegający na braku skonfigurowanego sposobu kierowania połączeń (brak routingu) np. brak komendy Dial dla ustalonej nazwy terminala lub numeru (przykładowo brak numeru 6003 i próba dzwonienia pod ten numer). Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 2:</strong> Rozwiąż powyższy problem i wykonaj ponowny test. Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 3:</strong> Zadzwoń do abonenta, który jest dodany w centrali jednak nie jest zarejestrowany w żadnym terminalu. Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 4:</strong> Rozwiąż powyższy problem i wykonaj ponowny test. Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 5:</strong> Ustaw w terminalu Zoiper kodek „alaw” a w terminalu Blink „PCMA”. Wytworzy się problem zestawienia połączenia z powodu niepasujących kodeków. Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 6:</strong> Rozwiąż powyższy problem i wykonaj ponowny test. Przechwyć ruch programem Wireshark.</p>
        </div>
        <div class="container">
            <h3>ZADANIE 3: SIP TRUNK</h3>
            <p><strong>Krok 1:</strong> Stwórz problem w którym w zestawionym połączeniu nie będzie słyszalności, tzn. nie przechodzi strumień mediów jednostronnie lub obustronnie (zablokuj porty strumieniów w Firewall’u). Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 2:</strong> Rozwiąż powyższy problem i wykonaj ponowny test. Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 3:</strong> Wykonaj błędną konfigurację rejestracji jednej centrali w drugiej (np. wpisz błędne adresy IP). Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 4:</strong> Rozwiąż powyższy problem i wykonaj ponowny test. Przechwyć ruch programem Wireshark.</p>
        </div>
        <div class="container">
            <h3>ZADANIE 4: USŁUGI AA, IVR, VOICEMAIL</h3>
            <p><strong>Krok 1:</strong> Stwórz problem polegający na błędnej konfiguracji kodów DTMF (np. w centrali Asterisk skonfiguruj SIP INFO, a w aplikacji softphone RFC2833). Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 2:</strong> Rozwiąż powyższy problem i wykonaj ponowny test. Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 3:</strong> Wykonaj niepoprawną realizację kodów podczas realizacji usług AA, IVR oraz Voicemail. Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 4:</strong> Rozwiąż powyższy problem i wykonaj ponowny test. Przechwyć ruch programem Wireshark.</p>
        </div>
        <div class="container">
            <h3>ZADANIE 5: USŁUGI MOH, ACT, BCT, CP</h3>
            <p><strong>Krok 1:</strong> Stwórz problem polegający na błędnej konfiguracji kodów DTMF (np. w centrali Asterisk skonfiguruj SIP INFO, a w aplikacji softphone RFC2833). Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 2:</strong> Rozwiąż powyższy problem i wykonaj ponowny test. Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 3:</strong> Wykonaj niepoprawną realizację kodów podczas realizacji jednej z usług np. Call PickUp. Przechwyć ruch programem Wireshark.</p>
            <p><strong>Krok 4:</strong> Rozwiąż powyższy problem i wykonaj ponowny test. Przechwyć ruch programem Wireshark.</p>
        </div>
        <div class="container">
            <h3>ZADANIE 6: REKORDY CDR</h3>
            <p><strong>Krok 1:</strong> W pliku /cdr_custom.conf pozostaw włączone komentarze dla linii [mapings]. Sprawdź czy dane podczas połączenia są nadal zbierane.</p>
            <p><strong>Krok 2:</strong> Rozwiąż powyższy problem i wykonaj ponowny test.</p>
        </div>
        <div class="container">
            <h3>ZADANIE 7: SPRAWOZDANIE</h3>
            <p>Wykonaj sprawozdanie w którym opiszesz problemową sytuację, podasz fragmenty logów i plików przechwyconych programem Wireshark, podasz sposób rozwiązania oraz efekty działania po wprowadzeniu korekt.</p>
        </div>
        <hr>
        <div class="container">
            <h3>Baza wiedzy problemów:</h3>
            <br>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <select name="problem" id="problem" class="custom-select">
                <option value="0">Wybierz problem poniżej i sprawdź rozwiązanie</option>
                <option value="1">Asterisk nie chce się uruchomić lub nie uruchomił się jeden z modułów.</option>
                <option value="2">Moduł nie został załadowany.</option>
            </select>
            <br>
            <br>
            <div id="val1" class="hidden" style="display: none;">
                <p><strong>Rozwiązanie:</strong> Sprawdź czy wszystkie moduły zostały uruchomione komendą <strong>asterisk -vvvc</strong></p>
            </div>
            <div id="val2" class="hidden" style="display: none;">
                <p><strong>Rozwiązanie:</strong> Jeśli Asterisk nie reaguje na pewne komendy np. sip show peers należy załadować moduł ręcznie komendą <strong>module load chan_sip.so</strong></p>
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
    </div>

<?php
    require_once '../includes/footer.php';
?>