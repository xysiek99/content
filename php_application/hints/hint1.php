<?php
        include '../includes/hintheader.php';
?>
<div class="container">
	<div>
		<br>
		<h3>Pliki do pobrania:</h3>
		<a class="btn btn-primary" href="/files/Pliki - Lab1.rar" download>Pliki - Lab1.rar</a>
	</div>
	<hr>
	<div>
		<h2>ZADANIE 1</h2>
		<div>
			<p><strong>Po zainstalowaniu Ubuntu uruchom Terminal a następnie wprowadź kolejno poniższe komendy:</strong></p>
			<ul class="list-unstyled">
				<li>apt-get update</li>
				<li>apt-get install bison wget openssl libssl-dev libasound2-dev libc6-dev libxml2-dev libsqlite3-dev libnewt-dev libncurses5-dev zlib1g-dev gcc g++ make perl uuid-dev git subversion libjansson-dev unixodbc-dev unixodbc-bin unixodbc autoconf libedit-dev</li>
				<li>cd /usr/src</li>
				<li>wget <a target="_blank" href="http://downloads.asterisk.org/pub/telephony/asterisk/asterisk-17-current.tar.gz">http://downloads.asterisk.org/pub/telephony/asterisk/asterisk-17-current.tar.gz</a></li>
				<li>tar -xzvf asterisk-17-current.tar.gz</li>
				<li>cd [nazwa_katalogu z kodem źródłowym asterisk]</li>
				<li>./configure</li>
				<li>make</li>
				<li>make install</li>
				<li>make config</li>
				<li>make samples</li>
			</ul>
			<p><strong>Sprawdzenie czy Asterisk działa prawidłowo:</strong></p>
			<p>Asterisk -vvvvvvvvgc</p>
			<p><strong>Zatrzymanie procesu Asterisk:</strong></p>
			<p>cli>core stop now</p>
		</div>
		<div>
			<p><strong>Sprawdzenie czy Asterisk działa prawidłowo:</strong></p>
			<p><i>Asterisk -vvvvvvvvgc</i></p>
			<br>
			<p><strong>Zatrzymanie procesu Asterisk:</strong></p>
			<p><i>cli>core stop now</i></p>
		</div>
	</div>
	<hr>
	<div>
		<h2>ZADANIE 2 KROK 1</h2>
		<div>
			<img class="img-fluid" src="/img/lab1Zoiper3 2 konta.PNG">
			<p>Powyższy zrzut ekranu pokazuje konfigurację dwóch kont w pliku sip.conf</p>
		</div>
		<hr>
		<h2>ZADANIE 2: KROK 2 i 3</h2>
		<div>
			<img class="img-fluid" src="/img/lab1blink.PNG">
			<p>Przykładowa konfiguracja aplikacji Blink z rejestracją 3 kont, które wcześniej utworzyliśmy.</p>
		</div>
		<hr>
		<h2>ZADANIE 2: REJESTRACJA</h2>
		<div>
			<img class="img-fluid" src="/img/lab1zarejestrowanie.PNG">
			<p>Powyższy zrzut ekranu z programu Wireshark pokazuje sygnalizację SIP w procedurze rejestrowania użytkownika.</p>
		</div>
		<hr>
		<h2>ZADANIE 2: WYREJESTROWANIE</h2>
		<div>
			<img class="img-fluid" src="/img/lab1wyrejestrowanie.PNG">
			<p>Powyższy zrzut ekranu przestawia wyrejestrowanie konta. Wartość Expires musi równać się 0. W związku z tym, że wartość wynosi 0, pole Expires nie zostało uwzględnione w programu Wireshark.</p>
			<br>
			<img class="img-fluid" src="/img/lab1zrzut.png">
			<p>Zrzut ekranu z terminala Asteriska mówiący o zarejestrowaniu i wyrejestrowaniu kont.</p>
		</div>
		<hr>
	</div>
	<div>
		<h2>NAGŁÓWKI</h2>
		<div>
			<p><strong>Request-line </strong>– mówi o tym jaki rodzaj zapytania jest wykonywany</p>
			<p><strong>Przykład:</strong></p>
			<p>Request-Line: REGISTER sip:192.168.31.203;transport=UDP SIP/2.0</p>
			<br><br>
			<p><strong>Contact </strong>– podaje adresy SIP URL (jeden lub więcej) do wykorzystania przy bezpośrednim kierowaniu wiadomości do nadawcy.</p>
			<p><strong>Przykład: </strong></p>
			<p>Contact: <sip:zoiper@192.168.31.202:37399;rinstance=cab1772b3b41c022;transport=UDP></p>
			<br><br>
			<p><strong>From </strong>– pole wskazujące SIP URL nadawcy.</p>
			<p><strong>Przykład:</strong></p>
			<p>From: <sip:zoiper@192.168.31.203;transport=UDP>;tag=e6526e59</p>
			<br><br>
			<p><strong>To </strong>– wskazuje adresata sesji (SIP URL).</p>
			<p><strong>Przykład:</strong></p>
			<p>To: sip:zoiper@192.168.31.203;transport=UDP</p>
			<br><br>
			<p><strong>Expires </strong>– termin ważności wiadomości (w sekundach lub jako data i czas).</p>
			<p><strong>Przykład:</strong></p>
			<p>Expires: 3600</p>
			<br><br>
			<p><strong>Cseq </strong>– numer sekwencyjny wiadomości używany w celu rozróżnienia żądań w czasie sesji. Kolejne żądanie podczas sesji mają inkrementowany numer sekwencyjny. Licznik Cseq jest osobny dla każdej ze stron./p>
			<p><strong>Przykład:</strong></p>
			<p>CSeq: 1 REGISTER</p>
			<br><br>
		</div>
	</div>
</div>

<?php
    include '../includes/footer.php';
?>