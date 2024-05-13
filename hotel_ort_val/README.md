**************************
      SEMESTERPROJEKT
**************************

VON :

Ortwin Baldauf und Valentin Fuchs

ERKLÄRUNG :

In unserem Semesterprojekt haben wir eine Hotel-Website angelegt, mit der ein User Reservierungen vornehmen und einsehen bzw. News-Artikel lesen kann.
Für die meisten dieser Funktionalitäten ist ein User-Account erforderlich, der mittels Registrierung angelegt und durch Einloggen benutzt werden kann.
Im Anschluss dieser Erfordernisse kann ein User einen gewünschten Zeitraum und ein (je nach Vorhandensein) beliebiges Zimmer auswählen und dieses reservieren. 
Des Weiteren kann ein Standard-User auch seine Profildaten einsehen und manche davon (nicht alle!) gegebenfalls ändern. Außerdem kann ein User auch News-Artikel
unter dem Reiter "News" in der Übersicht anschauen und durch draufklicken lesen.

Zudem können Administratoren alle Benutzer auf der Datenbank einsehen, bearbeiten und auch inaktivieren, was zur Folge hat dass diese viele Funktionen nicht 
mehr benutzen können. Auch Reservierungen können durch einen Admin eingesehen und deren Status verändert werden (z.B. von "Neu (Ausstehend)" auf "Bestätigt" oder 
"Storniert setzen). Außerdem kann ein Admin neue Artikel inkl. Bild hinzufügen, gegebenfalls auch wieder Löschen. Die hinzugefügten
Bilder werden serverseitig verkleinert und als konstante Thumbnails angezeigt.

BENUTZUNG :

Wichtig zu beachten ist, dass die im .zip-Folder hinterlegte Datenbank miteingebunden werden muss, damit die Dateien ordnungsgemäß funktionieren und Datensätze abgerufen werden können.
Darüber hinaus ist wichtig, im XAMPP-Server unter php.ini die extension "gd" zu aktivieren (=auskommentieren), um das serverseitige Verkleinern
von Bildern zu ermöglichen. 
Andernfalls werden diese nicht verkleinert und mit ihrer Standardgröße eingespeichert.

Datenbank Import - SQL im Ordner 'dbStructure'
User mit Rechten für die DB anlegen:
      Name: hotelUser
      Passwort: TschempernFB


Testdaten:

Admin:
      Email: admin@gmail.com
      Passwort: 1234

      Email: artikel@gmail.com
      Passwort: 1234

User:
      Email: maxi1@gmx.com
      Passwort: maxi

      Email: susi1@gmx.com
      Passwort: susi