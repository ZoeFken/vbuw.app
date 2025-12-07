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
  const clampDaysGeneric = (n, max) => {
    const num = parseInt(n, 10);
    if (Number.isNaN(num) || num < 1) return 1;
    if (num > max) return max;
    return num;
  };

  const wrapText = (text, maxWidthPt, font, fontSize, maxLines) => {
    const lineHeight = fontSize * 1.15;
    const result = [];
    const segments = (text || '').split(/\n/);
    segments.forEach((seg, idx) => {
      const words = seg.trim() === '' ? [] : seg.split(/\s+/);
      if (words.length === 0) {
        result.push('');
      } else {
        let current = '';
        words.forEach((word) => {
          const tentative = current ? `${current} ${word}` : word;
          const w = font.widthOfTextAtSize(tentative, fontSize);
          if (w <= maxWidthPt) {
            current = tentative;
          } else {
            if (current) result.push(current);
            current = word;
          }
        });
        if (current) result.push(current);
      }
      if (idx < segments.length - 1) result.push(''); // preserve explicit newline
    });
    const limited = maxLines ? result.slice(0, maxLines) : result;
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

  const buildValueLookup = (payload) => {
    const map = {};
    (payload.inputs || []).forEach((item) => {
      if (!item || !item.name) return;
      map[item.name.toString().toLowerCase()] = item.value || '';
    });
    if (payload.velden) {
      Object.entries(payload.velden).forEach(([key, value]) => {
        if (!key) return;
        map[key.toString().toLowerCase()] = value || '';
      });
    }
    return map;
  };

  const renderGenericTemplate = async (template, payload, downloadName) => {
    const pdfBytes = await fetch(template.base).then((res) => res.arrayBuffer());
    const pdfDoc = await PDFDocument.load(pdfBytes);
    const font = await pdfDoc.embedFont(StandardFonts.HelveticaBold);
    const fontSize = template.fontSize || 8;
    const page = pdfDoc.getPage(0);
    const lookup = buildValueLookup(payload);
    const getVal = (name) => lookup[name.toString().toLowerCase()] || '';

    template.fields.forEach((field) => {
      const value = getVal(field.name);
      if (!value) return;
      if (field.type === 'textbox') {
        renderTextBox(page, field, value, font, fontSize);
      } else {
        renderTextField(page, field, value, font, fontSize);
      }
    });

    const bytes = await pdfDoc.save();
    const blob = new Blob([bytes], { type: 'application/pdf' });
    const a = document.createElement('a');
    const baseName = (downloadName || payload.documentNaam || payload.documentType || 'document').replace(/\s+/g, '_');
    a.href = URL.createObjectURL(blob);
    a.download = `${new Date().toISOString().slice(0,19).replace(/[:T]/g,'-')}.${baseName}.pdf`;
    a.click();
    URL.revokeObjectURL(a.href);
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

  const renderS460 = async (payload) => {
    const template = S460_TEMPLATE;
    const pdfBytes = await fetch(template.base).then((res) => res.arrayBuffer());
    const pdfDoc = await PDFDocument.load(pdfBytes);
    const fontBold = await pdfDoc.embedFont(StandardFonts.HelveticaBold);
    const fontRegular = await pdfDoc.embedFont(StandardFonts.Helvetica);
    const fontSize = template.fontSize || 8;
    const days = Math.max(1, Math.min(8, payload.hoeveelDagen || 1));
    const startDate = payload.startDatum || payload.aanvangDatum || '';
    const lookup = buildValueLookup(payload);
    const getVal = (name) => lookup[name.toString().toLowerCase()] || '';
    const swap = !!payload.s460Swap;

    for (let day = 0; day < days; day++) {
      const [page] = await pdfDoc.copyPages(pdfDoc, [0]);
      pdfDoc.addPage(page);
      template.fields.forEach((field) => {
        let sourceName = field.name;
        const num = parseInt(field.name, 10);
        if (swap && !Number.isNaN(num)) {
          if (num >= 1 && num <= 12) sourceName = `${num + 12}`;
          else if (num >= 13 && num <= 24) sourceName = `${num - 12}`;
        }
        let value = getVal(sourceName);
        const isDateField = field.name === '1';
        if (isDateField && startDate) {
          const dateVal = day > 0 ? incrementDate(startDate, day) : startDate;
          value = value ? `--- ${dateVal} ---\n${value}` : `--- ${dateVal} ---`;
        }
        if (!value) return;
        const fieldFontSize = (isDateField && startDate) ? fontSize + 4 : fontSize;
        const fieldFont = (isDateField && startDate) ? fontBold : fontRegular;
        if (field.type === 'textbox') {
          renderTextBox(page, field, value, fieldFont, fieldFontSize);
        } else {
          renderTextField(page, field, value, fieldFont, fieldFontSize);
        }
      });
    }

    pdfDoc.removePage(0);
    const bytes = await pdfDoc.save();
    const blob = new Blob([bytes], { type: 'application/pdf' });
    const a = document.createElement('a');
    const baseName = (payload.documentNaam || 'S460').replace(/\s+/g, '_');
    a.href = URL.createObjectURL(blob);
    a.download = `${new Date().toISOString().slice(0,19).replace(/[:T]/g,'-')}.${baseName}.pdf`;
    a.click();
    URL.revokeObjectURL(a.href);
  };
  const renderS505 = async (payload) => renderGenericTemplate(S505_TEMPLATE, payload, 'S505');
  const renderVerdeler = async (payload) => {
    const variant = payload.verdelerVariant || payload.verdelertype || 'verdeler';
    const days = variant === 'overdracht' ? 1 : clampDaysGeneric(payload.hoeveelDagen || 1, 7);
    const lookup = buildValueLookup(payload);
    const val = (key) => lookup[key.toString().toLowerCase()] || payload[key] || '';
    const docName = payload.documentNaam || payload.documentname || variant;
    const startDate = val('aanvangsdatum') || val('startdatum');
    const endDate = val('einddatum');
    const startTime = val('aanvangsuur');
    const endTime = val('einduur');
    const lijn = val('lijn');
    const spoor = val('spoor');
    const bnx = val('bnx');
    const tpo = val('tpo');
    const gevallen = val('gevallen');
    const uiterstePalen = val('uiterstePalen');
    const geplaatstePalen = val('geplaatstePalen');
    const fmt = (v, placeholder = '...') => (v && v.toString().trim() ? v : placeholder);
    const fmtOptional = (v) => (v && v.toString().trim() ? v : '');
    const shiftDate = (value, offset) => {
      if (!value) return value;
      if (!offset) return value;
      const dt = parseDate(value);
      if (!dt) return value;
      const copy = new Date(dt.getTime());
      copy.setDate(copy.getDate() + offset);
      return formatDate(copy);
    };

    const pdfDoc = await PDFDocument.create();
    const font = await pdfDoc.embedFont(StandardFonts.Helvetica);
    const bold = await pdfDoc.embedFont(StandardFonts.HelveticaBold);
    const pageSize = [mmToPt(210), mmToPt(297)];
    const headerFontSize = 10;
    const bodyFontSize = 10;
    const pad = 4;

    const colDefs = [
      { header: 'E934', w: mmToPt(18), align: 'center' },
      { header: 'Herkomst', w: mmToPt(26), align: 'center' },
      { header: 'Volledige tekst of onderwerp van de mededeling', w: mmToPt(115), align: 'left' },
      { header: 'Nr. Van de Correspondent', w: mmToPt(32), align: 'center' },
      { header: 'Bestemming', w: mmToPt(30), align: 'center' },
      { header: 'Uur', w: mmToPt(18), align: 'center' }
    ];
    const tableWidth = colDefs.reduce((sum, c) => sum + c.w, 0);

    const measureCellHeight = (text, width, isHeader = false) => {
      const useFont = isHeader ? bold : font;
      const { lines, lineHeight } = wrapText(text || '', width - pad * 2, useFont, bodyFontSize);
      return (lines.length || 1) * lineHeight + pad * 2;
    };

    const drawTable = (page, startY, headers, rows, offsetX) => {
      let y = startY;
      const { height } = page.getSize();
      const headerHeight = Math.max(...colDefs.map((c, idx) => measureCellHeight(headers[idx] || c.header, c.w, true)));
      let x = offsetX;
      colDefs.forEach((c, idx) => {
        const hText = headers[idx] || c.header;
        page.drawRectangle({ x, y: y - headerHeight, width: c.w, height: headerHeight, borderColor: rgb(0, 0, 0), borderWidth: 0.8 });
        const { lines, lineHeight } = wrapText(hText, c.w - pad * 2, bold, headerFontSize);
        const textBlockHeight = (lines.length || 1) * lineHeight;
        const baseY = y - ((headerHeight - textBlockHeight) / 2.5) - lineHeight; // center vertical
        lines.forEach((line, i) => {
          page.drawText(line, { x: x + pad, y: baseY - i * lineHeight, size: headerFontSize, font: bold, color: rgb(0, 0, 0) });
        });
        x += c.w;
      });
      y -= headerHeight;

      // body rows
      rows.forEach((row) => {
        const heights = row.map((cell, idx) => measureCellHeight(cell, colDefs[idx].w, false));
        const rowHeight = Math.max(...heights);
        let cx = offsetX;
        row.forEach((cell, idx) => {
          const col = colDefs[idx];
          page.drawRectangle({ x: cx, y: y - rowHeight, width: col.w, height: rowHeight, borderColor: rgb(0, 0, 0), borderWidth: 0.8 });
          const { lines, lineHeight } = wrapText(cell || '', col.w - pad * 2, font, bodyFontSize);
          const isCenter = col.align === 'center';
          const baseY = y - pad - lineHeight;
          lines.forEach((line, i) => {
            const textWidth = font.widthOfTextAtSize(line, bodyFontSize);
            let alignX = cx + pad;
            if (isCenter) alignX = cx + (col.w - textWidth) / 2;
            page.drawText(line, { x: alignX, y: baseY - i * lineHeight, size: bodyFontSize, font, color: rgb(0, 0, 0) });
          });
          cx += col.w;
        });
        y -= rowHeight;
      });
      return y;
    };

    for (let day = 0; day < days; day++) {
      const page = pdfDoc.addPage(pageSize);
      const { height } = page.getSize();
      const margin = mmToPt(18);
      const offsetX = Math.max(margin, (pageSize[0] - tableWidth) / 2);
      let y = height - margin;
      const dayStart = day === 0 ? startDate : shiftDate(startDate, day);
      const dayEnd = day === 0 ? endDate : shiftDate(endDate, day);

      const title = variant === 'overdracht' ? 'Overdracht Buitenspanningstelling' : 'Buitenspanningstelling';
      const titleWidth = bold.widthOfTextAtSize(title, 18);
      page.drawText(title, { x: (pageSize[0] - titleWidth) / 2, y, size: 18, font: bold, color: rgb(37 / 255, 83 / 255, 120 / 255) });
      y -= 26;

      // info strip (2 rijen, 3 kolommen)
      const infoCols = [
        { label: 'Lijn', value: fmt(lijn) },
        { label: 'Spoor', value: fmt(spoor) },
        { label: 'Datum', value: fmtOptional(dayEnd || endDate) }
      ];
      const infoRow2 = [
        { label: 'Datum', value: fmtOptional(dayStart || startDate) },
        { label: 'van', value: fmtOptional(startTime) },
        { label: 'Tot', value: fmtOptional(endTime) }
      ];
      const colSpacing = mmToPt(55);
      let infoX = margin;
      const drawInfoRow = (items) => {
        infoX = offsetX;
        items.forEach(({ label, value }) => {
          page.drawText(label, { x: infoX, y, size: 11, font: bold, color: rgb(0, 0, 0) });
          const vWidth = font.widthOfTextAtSize(value, 11);
          page.drawText(value, { x: infoX + mmToPt(18), y, size: 11, font, color: rgb(0, 0, 0) });
          infoX += colSpacing;
        });
      };
      drawInfoRow(infoCols);
      y -= 14;
      drawInfoRow(infoRow2);
      y -= 10;

      const headers = colDefs.map((c) => c.header);
      const rows = [];

      if (variant === 'verdeler') {
        rows.push(
          [
            '',
            'Bediende',
            `Ik vraag de buitenspanningstelling van de bovenleiding van de geval(len)\n${fmt(gevallen)}.\nVan lijn (station) ${fmt(lijn)}, spoor ${fmt(spoor)}.\nVoor werken voorzien in BNX nr ${fmt(bnx)}.\nEn in overeenstemming met FBSS nr ${fmt(tpo)}.`,
            '',
            'Verdeler',
            ''
          ]
        );
        rows.push(
          [
            '',
            'Verdeler',
            `Gevolg uw nr:\nDe spanning is verbroken op de bovenleiding (en de tegenfase feeder) van de geval(len)\n${fmt(gevallen)},\nvan lijn (station) ${fmt(lijn)}, spoor ${fmt(spoor)}.\nIk laat het plaatsen van de SSV's/UEG's toe in overeenstemming met FBSS nr ${fmt(tpo)}.\nEnkel de SSV's/UEG's, geplaatst conform de FBSS, zorgen voor een bescherming tegen de elektrische gevaren.`,
            '',
            'Bediende',
            ''
          ]
        );
        rows.push(
          ['', 'Bediende', `De SSV's/UEG's zijn geplaatst in overeenstemming met FBSS nr ${fmt(tpo)}.`, '', 'Verdeler', '']
        );
        rows.push(
          ['', 'Verdeler', `De buitenspanning is effectief, de werken voorzien in BNX nr ${fmt(bnx)} en in overeenstemming met FBSS nr ${fmt(tpo)} kunnen aangevangen worden op de lijn (station) ${fmt(lijn)}, spoor ${fmt(spoor)}. Tussen de geplaatste ssv's.`, '', 'Bediende', '']
        );
        rows.push(
          [
            '',
            'Bediende',
            `Ik laat toe om de bovenleiding van de geval(len)\n${fmt(gevallen)}\nLijn (station) ${fmt(lijn)}, spoor ${fmt(spoor)} terug onder spanning te stellen.\nDe SSV's zijn weggenomen, de bovenleiding wordt beschouwd(en) als zijnde onder spanning.`,
            '',
            'Verdeler',
            ''
          ]
        );
      } else {
        for (let idx = 1; idx <= 4; idx++) {
          rows.push(
            [
              '',
              'Bediende',
              `Ik sta af aan de opgeleide bediende.\nDe buitenspanningstelling van de bovenleiding van de lijn ${fmt(lijn)} de sporen ${fmt(spoor)}\nDit zijn de gevallen ${fmt(gevallen)}\nIngeschreven onder nr:\nDe spoorstaafverbindingen zijn geplaatst aan de bovenleidingspalen:\n${fmtOptional(geplaatstePalen)}`,
              '',
              'Verdeler',
              ''
            ]
          );
          rows.push(
            [
              '',
              'Bediende',
              `Ik neem over van de opgeleide bediende\nDe buitenspanningstelling van de bovenleiding van de lijn ${fmt(lijn)} de sporen ${fmt(spoor)}\nDit zijn de gevallen ${fmt(gevallen)}\nIngeschreven onder nr:\nDe spoorstaafverbindingen zijn geplaatst aan de bovenleidingspalen:\n${fmtOptional(geplaatstePalen)}`,
              '',
              'Verdeler',
              ''
            ]
          );
        }
      }

      y = drawTable(page, y, headers, rows, offsetX);
      y -= 10;

      // extra info footer
      const footerLines = [
        `Document: ${fmt(docName)}`,
        `TPO / FBSS: ${fmt(tpo)}    BNX: ${fmt(bnx)}    Lijn: ${fmt(lijn)}    Spoor: ${fmt(spoor)}`,
        `Aanvang: ${fmtOptional(dayStart)} ${fmtOptional(startTime)}    Einde: ${fmtOptional(dayEnd)} ${fmtOptional(endTime)}`,
        `Uiterste punten: ${fmtOptional(uiterstePalen)}    Geplaatste SSV: ${fmtOptional(geplaatstePalen)}`
      ];
      footerLines.forEach((line) => {
        if (!line.trim()) return;
        page.drawText(line, { x: margin, y, size: 9, font, color: rgb(0, 0, 0) });
        y -= 12;
      });
    }

    const bytes = await pdfDoc.save();
    const blob = new Blob([bytes], { type: 'application/pdf' });
    const a = document.createElement('a');
    const baseName = (docName || variant || 'verdeler').replace(/\s+/g, '_');
    a.href = URL.createObjectURL(blob);
    a.download = `${new Date().toISOString().slice(0,19).replace(/[:T]/g,'-')}.${baseName}.pdf`;
    a.click();
    URL.revokeObjectURL(a.href);
  };

  window.StatelessPdf = { renderS627, renderS460, renderS505, renderVerdeler, templates: { S627_TEMPLATE, S460_TEMPLATE, S505_TEMPLATE } };
})();
