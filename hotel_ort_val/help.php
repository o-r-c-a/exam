<?php $title='Hilfe';
include 'inc/head.php'; ?>

<!-- Hilfe-Seite -->
<body>
    <?php include 'inc/headerNav.php';?>
    <section>
        <div class="contentBackground">
            <h2 style = "margin-left: 0.5%">Häufig gestellte Fragen</h2>
            <ul style = "list-style-type: none">
                <li>
                    <h3>Wie ist die Website aufgebaut?</h3>
                    <p>Auf unserer Website können Sie unter <i>Zimmer</i> ein Apartment reservieren, <i>News</i>-Artikel lesen und Änderungen an ihrem <i>Profil</i> vornehmen.<br>
                    </p>
                </li>
                <li>
                    <h3>Wie registriere ich mich?</h3>
                    <p>Sie können sich unter <a href="register.php">Registrieren</a> ein Profil erstellen, mit welchem Sie sich im Anschluss einloggen können. <br>Dies ist
                    erforderlich damit Sie überhaupt ein Zimmer reservieren können. Auch die Profilverwaltung erfordert es, sich zu registrieren.
                    </p>
                </li>
                <li>
                    <h3>Wie ändere ich meine Stammdaten?</h3>
                    <p>Durch das Öffnen vom Link <a href="profileMain.php">Profil</a> sind Sie in der Lage, Ihre Stammdaten einzusehen und gegebenenfalls zu ändern.
                    </p>
                </li>
                <li>
                    <h3>Was mach ich wenn ich mein Passwort vergessen habe?</h3>
                    <p>In diesem Falle wenden Sie sich bitte an einen Administrator, welcher Ihnen ein neues Passwort zuweist.<br>
                        Falls Sie Ihr Passwort kennen und ändern möchten, können Sie dies unter <a href="profileChangePw.php">Profil/Passwort ändern</a> durchführen.
                    </p>
                </li>
                <li>
                    <h3>Wie reserviere ich ein Zimmer?</h3>
                    <p>Um eine Zimmerbuchung vorzunehmen müssen Sie unter <a href="reservationRooms.php">Zimmer</a>
                    ein verfügbares Zeitfenster auswählen, sich für ein Apartment Ihrer Wahl entscheiden und 
                    <br>sonstige Details auf der Folgeseite ausfüllen.</p>
                </li>
                <li>
                    <h3>Wo finde ich Neuigkeiten und News?</h3>
                    <p>Um stets am neuesten Stand zu bleiben können Sie unter <a href="newsMain.php">News</a> unsere aktuellsten Neuigkeiten lesen. 
                    In der Übersicht sehen Sie eine breite Auswahl an sehr interessant gestalteten Artikeln, die wir laufend updaten.</p>
                </li>
                <li>
                    <h3>Wo bekomme ich detaillierte Informationen zum Hotel Tschempern?</h3>
                    <p>Unter <a href="impressum.php">Impressum</a> finden Sie alle Details rund um unser Hotel.</p> <!-- Ortwin: impressum.php, nicht html-->
                </li>
                <li>
                    <h3>Mein Account ist deaktiviert. Was kann ich machen?</h3>
                    <p>Falls ihr Account deaktiviert wurde, haben Sie entweder gegen unsere Richtlinien verstoßen oder Sie wurden wegen jahrelanger Inaktivität deaktiviert.
                        <br>In diesem Fall wenden Sie sich bitte einen Administrator.
                    </p>
                </li>
                <li>
                    <h3>Wer hat diese Website erstellt?</h3>
                    <p>Für die Erstellung und Verwaltung der Website sind Valentin Fuchs und Ortwin Baldauf verantwortlich.</p>
                </li>
            </ul>
        </div>
    </section>
    <?php include 'inc/footer.php'; ?>
</body>

</html>