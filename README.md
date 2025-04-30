Willkommen bei ConDB, einer mobilen Anwendung für Inventarverwaltung, Bestellhistorie und Messeverkauf.

📋 Voraussetzungen
Damit du die App lokal auf deinem Rechner starten kannst, benötigst du folgende Tools:

Node.js (empfohlen Version 18 oder höher)
npm (in Node.js enthalten)
Android Studio (aktuelle Version empfohlen)
Capacitor CLI (installiert sich automatisch über npm)
Ein Android-Emulator oder echtes Android-Gerät mit API 33 oder höher

⚙️ Projekt aufsetzen
1. Repository klonen
git clone https://github.com/CryptozXIII/ConDB.git
cd ConDB

2. Abhängigkeiten installieren
npm install

3. Android-Projekt initialisieren
Nur beim ersten Mal notwendig:
npx cap add android

🔄 Entwicklung und Synchronisierung
Workflow bei Änderungen:
Wenn du Änderungen an HTML, CSS oder JavaScript machst, dann:

npx cap sync

Damit werden die aktuellen Web-Dateien (www/) ins Android-Projekt kopiert.

▶️ App starten
1. Starte deinen Emulator oder schließe ein Android-Gerät an.
2. Öffne das Projekt in Android Studio:

npx cap open android

3.In Android Studio:
Projekt synchronisieren (falls nötig)
Dein Gerät auswählen (Emulator oder reales Gerät)
Den grünen Play-Button (Run) klicken


📦 Speichertechnologie
ConDB verwendet Capacitor Preferences zur lokalen Speicherung.
Alle Daten wie Inventar, Bestellungen und Einstellungen werden offline auf dem Gerät gespeichert.
Keine Internetverbindung notwendig.

📋 Verwendete Technologien
HTML5 + CSS3 + Vanilla JavaScript
Capacitor v7
Android Studio / Emulator

⚠️ Wichtige Hinweise
Änderungen an den Web-Dateien (HTML, CSS, JS) erfordern immer ein neues npx cap sync und anschließend einen neuen Build.
Beim ersten Start kann Android nach Berechtigungen (z. B. Speicherzugriff) fragen – bitte erlauben.
Die Anwendung funktioniert komplett offline, alle Daten sind lokal auf dem Gerät.

🧹 Struktur und .gitignore
Im Projekt ist eine .gitignore enthalten, die folgende Dateien und Ordner ausschließt:
node_modules/
android/build/
android/app/build/
capacitor.config.json
.DS_Store (macOS)
Thumbs.db (Windows)
.idea/ (JetBrains IDEs)
*.log (Logdateien)
inventar_export.json (exportierte JSON-Dateien)

📬 Kontakt
Bei Fragen, Problemen oder Vorschlägen:
GitHub Issues erstellen oder direkt eine Nachricht an CryptozXIII senden.

✅ Schnellstart Checkliste
 Node.js und npm installiert
 Android Studio installiert
 Repository geklont
 npm install ausgeführt
 npx cap add android ausgeführt
 npx cap sync nach Änderungen
 App in Android Studio gestartet
 Emulator oder Gerät eingerichtet

🚀 Viel Erfolg und Spaß mit ConDB!
