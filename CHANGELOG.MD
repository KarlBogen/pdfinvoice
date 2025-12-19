UNRELEASED




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
