// pdf-renderer.js
// Client-side PDF generatie met pdf-lib, zonder PHP/DB.

(() => {
  const { PDFDocument, StandardFonts, rgb } = window.PDFLib || {};
  if (!PDFDocument) {
    console.error('PDFLib niet geladen. Voeg pdf-lib toe via unpkg of lokaal bestand.');
    return;
  }

  const mmToPt = (mm) => (mm || 0) * 72 / 25.4;

  const parseDate = (val) => {
    if (!val) return null;
    const parts = val.includes('/') ? val.split('/') : val.split('-');
    if (parts.length !== 3) return null;
    // accepteer dd-mm-yyyy of yyyy-mm-dd
    let d, m, y;
    if (parts[0].length === 4) {
      [y, m, d] = parts.map((p) => parseInt(p, 10));
    } else {
      [d, m, y] = parts.map((p) => parseInt(p, 10));
    }
    const dt = new Date(y, (m || 1) - 1, d || 1);
    return isNaN(dt.getTime()) ? null : dt;
  };

  const formatDate = (date) => {
    const pad = (n) => (n < 10 ? `0${n}` : `${n}`);
    return `${pad(date.getDate())}-${pad(date.getMonth() + 1)}-${date.getFullYear()}`;
  };

  const incrementDate = (val, days) => {
    const dt = parseDate(val);
    if (!dt) return val;
    dt.setDate(dt.getDate() + days);
    return formatDate(dt);
  };

  const wrapText = (text, maxWidthPt, font, fontSize, maxLines) => {
    const words = (text || '').split(/\s+/);
    const lines = [];
    let current = '';
    const lineHeight = fontSize * 1.15;
    words.forEach((word) => {
      const tentative = current ? `${current} ${word}` : word;
      const w = font.widthOfTextAtSize(tentative, fontSize);
      if (w <= maxWidthPt) {
        current = tentative;
      } else {
        if (current) lines.push(current);
        current = word;
      }
    });
    if (current) lines.push(current);
    const limited = maxLines ? lines.slice(0, maxLines) : lines;
    return { lines: limited, lineHeight };
  };

  // Coords zijn opgeslagen als mm vanaf links (s627_y) en mm vanaf boven (s627_x) in CI3.
  // Coordinates: in CI3 SetXY($y, $x) -> stored columns sXXX_y = horizontal (left), sXXX_x = vertical (top).
  const toPageCoords = (field, pageHeightPt, fontSize) => {
    const xPt = mmToPt(field.left);
    const yTopPt = pageHeightPt - mmToPt(field.top);
    const yPt = yTopPt - (fontSize || 8);
    return { xPt, yPt };
  };

  const S627_TEMPLATE = {
    base: 'base/S627.pdf',
    fontSize: 8,
    fields: [
      { name: 'ingediendDoor', left: 40.5, top: 29.4, w: 48.0, h: 5.0, type: 'text' },
      { name: 'specialiteit', left: 109.0, top: 29.4, w: 38.0, h: 5.0, type: 'text' },
      { name: 'aan', left: 27.0, top: 34.6, w: 41.0, h: 5.0, type: 'text' },
      { name: 'aanvangDatum', left: 50.5, top: 84.7, w: 21.0, h: 5.0, type: 'text', dateIncrement: true },
      { name: 'aanvangUur', left: 78.0, top: 84.7, w: 20.0, h: 5.0, type: 'text' },
      { name: 'vermoedelijkeDuur', left: 125.5, top: 84.7, w: 21.0, h: 5.0, type: 'text' },
      { name: 'ingediendDoor', left: 174.0, top: 168.8, w: 40.0, h: 5.0, type: 'text', overdrachtClear: true },
      { name: 'post', left: 79.2, top: 34.6, w: 18.0, h: 5.0, type: 'text' },
      { name: 'station', left: 109.0, top: 34.6, w: 38.0, h: 5.0, type: 'text' },
      { name: 'aanvraag', left: 20.8, top: 45.0, w: 127.0, h: 39.7, type: 'textbox', align: 'left' },
      { name: 'rubriek2ARMS', left: 36.5, top: 119.0, w: 127.0, h: 39.7, type: 'textbox', align: 'left' },
      { name: 'rubriek2AAndere', left: 36.5, top: 142.0, w: 120.0, h: 25.0, type: 'textbox', align: 'left' },
      { name: 'rubriek5VVHW', left: 155.0, top: 149.0, w: 120.0, h: 17.0, type: 'textbox', align: 'left' }
    ]
  };

  // Posities uit backup/db/2025-12-06.sql (s460en)
  const S460_TEMPLATE = {
    base: 'base/S460.pdf',
    fontSize: 8,
    fields: [
      // 24 blokken met identieke maten; s460_name is nummer 1..24
      // y = mm vanaf boven, x = mm vanaf links
      { name: '1', left: 41.0, top: 20.0, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '2', left: 41.0, top: 41.0, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '3', left: 41.0, top: 62.5, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '4', left: 41.0, top: 83.7, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '5', left: 41.0, top: 105.0, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '6', left: 41.0, top: 126.3, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '7', left: 41.0, top: 166.5, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '8', left: 41.0, top: 187.2, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '9', left: 41.0, top: 208.5, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '10', left: 41.0, top: 229.5, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '11', left: 41.0, top: 250.7, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '12', left: 41.0, top: 272.0, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '13', left: 112.0, top: 20.0, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '14', left: 112.0, top: 41.0, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '15', left: 112.0, top: 62.5, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '16', left: 112.0, top: 83.7, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '17', left: 112.0, top: 105.0, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '18', left: 112.0, top: 126.3, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '19', left: 112.0, top: 166.5, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '20', left: 112.0, top: 187.2, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '21', left: 112.0, top: 208.5, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '22', left: 112.0, top: 229.5, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '23', left: 112.0, top: 250.7, w: 65.0, h: 18.0, type: 'textbox', align: 'left' },
      { name: '24', left: 112.0, top: 272.0, w: 65.0, h: 18.0, type: 'textbox', align: 'left' }
    ]
  };

  // Posities uit backup/db/2025-12-06.sql (s505en)
  const S505_TEMPLATE = {
    base: 'base/S505.pdf',
    fontSize: 8,
    fields: [
      { name: 'houderS627', left: 173.0, top: 42.0, w: 40.0, h: 5.0, type: 'text' },
      { name: 'verantwoordelijkeBss', left: 227.0, top: 42.0, w: 40.0, h: 5.0, type: 'text' },
      { name: 'gevallen_1', left: 50.0, top: 24.5, w: 135.0, h: 14.0, type: 'textbox', align: 'left' },
      { name: 'lijn1', left: 86.0, top: 36.0, w: 20.0, h: 5.0, type: 'text' },
      { name: 'spoor1', left: 86.0, top: 66.5, w: 20.0, h: 5.0, type: 'text' },
      { name: 'ap1', left: 86.0, top: 97.0, w: 20.0, h: 5.0, type: 'text' },
      { name: 'ap2', left: 86.0, top: 130.0, w: 20.0, h: 5.0, type: 'text' },
      { name: 'lijn2', left: 90.7, top: 36.0, w: 20.0, h: 5.0, type: 'text' },
      { name: 'spoor2', left: 90.7, top: 66.5, w: 20.0, h: 5.0, type: 'text' },
      { name: 'ap3', left: 90.7, top: 97.0, w: 20.0, h: 5.0, type: 'text' },
      { name: 'ap4', left: 90.7, top: 130.0, w: 20.0, h: 5.0, type: 'text' },
      { name: 'tpoBnx_1', left: 102.0, top: 24.5, w: 135.0, h: 5.0, type: 'textbox', align: 'left' },
      { name: 'eindDatum', left: 134.1, top: 101.0, w: 40.0, h: 5.0, type: 'text' },
      { name: 'eindUur', left: 134.1, top: 139.0, w: 40.0, h: 5.0, type: 'text' },
      { name: 'gevallen_2', left: 118.5, top: 24.5, w: 135.0, h: 10.0, type: 'textbox', align: 'left' },
      { name: 'tpoBnx_2', left: 39.2, top: 52.0, w: 135.0, h: 5.0, type: 'textbox', align: 'left' }
    ]
  };

  const renderTextField = (page, field, text, font, fontSize) => {
    const { width, height } = page.getSize();
    const { xPt, yPt } = toPageCoords(field, height, fontSize);
    page.drawText(text || '', {
      x: xPt,
      y: yPt,
      size: fontSize,
      font,
      color: rgb(0, 0, 0)
    });
  };

  const renderTextBox = (page, field, text, font, fontSize) => {
    const { width, height } = page.getSize();
    const { xPt, yPt } = toPageCoords(field, height, fontSize);
    const boxWidth = mmToPt(field.w || 0);
    const boxHeight = mmToPt(field.h || 0);
    const maxLines = boxHeight ? Math.floor(boxHeight / (fontSize * 1.15)) : undefined;
    const { lines, lineHeight } = wrapText(text || '', boxWidth, font, fontSize, maxLines);
    lines.forEach((line, idx) => {
      const yLine = yPt - (lineHeight * idx);
      page.drawText(line, {
        x: xPt,
        y: yLine,
        size: fontSize,
        font,
        color: rgb(0, 0, 0)
      });
    });
  };

  const renderS627 = async (payload) => {
    const variant = payload.s627Variant || 'S627';
    const baseMap = {
      'S627': 'base/S627.pdf',
      'S627-bis-lvhw': 'base/S627-bis-lvhw.pdf',
      'S627-bis-wl': 'base/S627-bis-wl.pdf'
    };
    const base = baseMap[variant] || baseMap['S627'];
    const template = { ...S627_TEMPLATE, base };
    const pdfBytes = await fetch(template.base).then((res) => res.arrayBuffer());
    const pdfDoc = await PDFDocument.load(pdfBytes);
    const font = await pdfDoc.embedFont(StandardFonts.HelveticaBold);
    const fontSize = template.fontSize || 8;
    const days = Math.max(1, payload.hoeveelDagen || 1);
    const inputMap = {};
    (payload.inputs || []).forEach((i) => { inputMap[i.name] = i.value; });
    // aliases from UI naming to DB naming
    const alias = {
      post: inputMap.postWerf,
      postWerf: inputMap.postWerf,
      rubriek2ARMS: inputMap.rubriek2aRms,
      rubriek2AAndere: inputMap.rubriek2aAndere,
      rubriek5VVHW: inputMap.voltooiing
    };
    const getVal = (name) => {
      if (inputMap[name] !== undefined) return inputMap[name];
      if (alias[name] !== undefined) return alias[name];
      return '';
    };
    const overdracht = !!payload.overdracht;

    for (let day = 0; day < days; day++) {
      const [page] = await pdfDoc.copyPages(pdfDoc, [0]);
      pdfDoc.addPage(page);
      template.fields.forEach((field, idx) => {
        if (variant !== 'S627' && (field.name === 'post' || field.name === 'station')) return;
        let value = getVal(field.name);
        if (field.overdrachtClear && overdracht) value = ' ';
        if (field.dateIncrement && day > 0 && value) {
          value = incrementDate(value, day);
        }
        if (!value) return;
        if (field.type === 'textbox') {
          renderTextBox(page, field, value, font, fontSize);
        } else {
          renderTextField(page, field, value, font, fontSize);
        }
      });
    }

    // verwijder de oorspronkelijke templatepagina (eerste) die we gekopieerd hebben
    pdfDoc.removePage(0);
    const bytes = await pdfDoc.save();
    const blob = new Blob([bytes], { type: 'application/pdf' });
    const a = document.createElement('a');
    const baseName = payload.documentNaam ? payload.documentNaam.replace(/\s+/g, '_') : variant;
    a.href = URL.createObjectURL(blob);
    a.download = `${new Date().toISOString().slice(0,19).replace(/[:T]/g,'-')}.${baseName}.pdf`;
    a.click();
    URL.revokeObjectURL(a.href);
  };

  window.StatelessPdf = { renderS627, templates: { S627_TEMPLATE, S460_TEMPLATE, S505_TEMPLATE } };
})();
