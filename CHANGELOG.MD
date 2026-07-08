UNRELEASED



1.0.3 [08.07.2026]
- Mail-Template für englische Sprache geändert
- Maildateien umbenannt um Konflikt mit PdfBillNext zu vermeiden
- String-Konvertierung, falls kein "UTF-8", hinzugefügt - siehe noRiddle https://www.modified-shop.org/forum/index.php?topic=44019.msg416429#msg416429
- Button "Bearbeiten" im Systemmodul hinzugefügt
- Drucken nicht möglich, wenn Passwortschutz eingeschaltet - behoben

1.0.2 [04.02.2026]
- neue Einstellmöglichkeit im Systemmodul - Rechnungsadresse statt Kundenadresse als Anschrift
- Anbindung zum Modul E-Rechnung von AGI geändert
- neue Einstellmöglichkeit im Systemmodul - Rechnung senden / herunterladen ohne iFrame

1.0.1 [19.12.2025]
- Update für Shopversion 3.2.0
- Verzeichnis "admin/invoice" war im Download nicht enthalten, das führte direkt zu einem Fatal Error - behoben
- opendir(/tmp/): Failed to open directory: Permission denied - behoben
- Undefined variable $request_type in File: includes/external/pdfinvoice/makePdf.php - behoben
- Button Rechnungsnummer entfernen, wenn "Bestellnummer als Rechnungsnummer" aktiviert ist
- In Datei "includes/external/pdfinvoice/makePdf.php" Funktion "auto_include" hinzugefügt,
  dadurch können alternative Templatedateien updatesicher eingebunden, oder Smarty-Variablen gesetzt werden

1.0.0 [30.11.2025]

- Übertragung der Dateien zu Github
