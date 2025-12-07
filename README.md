# Stateless web prototype (HTML/JS only)

Doel: documenten aanmaken zonder backend/DB. Vul velden in, download JSON om later opnieuw te gebruiken. Alles werkt op GitHub Pages (pure HTML/CSS/JS).

Bestanden:
- `index.html` - gecombineerde variant (alle types).
- `s627.html`, `s460.html`, `s505.html`, `verdeler.html` - losse pagina's per documenttype.
- `styles.css` - lichte styling.
- `script.js` - logica: payload opbouwen, dagen clampen, JSON export/import.

Wat het kan:
- Documenttype kiezen (index) of vaste pagina per type (s627/i427/s460/s505/verdeler).
- Algemene velden: documentNaam, opgemaaktDoor, hoeveelDagen, overdracht, datums (start/eind/aanvang).
- Dynamische inputlijst (name/value/align) voor s627/s505; key/value voor verdeler/s460; s627-specifieke velden aanwezig op s627-pagina.
- JSON export (download) en import (bestand uploaden) om het formulier te vullen.

Uit te breiden:
- PDF-generatie in de browser (bv. pdf-lib of jsPDF) door `buildPayload()` te hergebruiken.
- Validatie/schemas strikter maken.
