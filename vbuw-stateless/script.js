const qs = (sel) => document.querySelector(sel);
const makeEl = (tag, className) => {
  const el = document.createElement(tag);
  if (className) el.className = className;
  return el;
};

const inputList = qs('#inputList');
const fieldsList = qs('#fieldsList');
const statusEl = qs('#status');
const s627Section = qs('#s627Section');
const defaultDocType = (document.body && document.body.dataset.documentType) ? document.body.dataset.documentType : 's627';

const addInputBtn = document.getElementById('addInput');
const addFieldBtn = document.getElementById('addField');
const downloadBtn = document.getElementById('downloadJson');
const generatePdfBtn = document.getElementById('generatePdf');
const uploadInput = document.getElementById('uploadJson');
const docTypeSelect = document.getElementById('documentType');
const openModalBtn = document.getElementById('openDownloadModal');
const confirmDownloadBtn = document.getElementById('confirmDownload');
const cancelDownloadBtn = document.getElementById('cancelDownload');
const closeModalBtn = document.getElementById('closeModal');
const modalEl = document.getElementById('downloadModal');
const variantInputs = document.querySelectorAll('input[name="s627Variant"]');
const s460ModalEl = document.getElementById('s460Modal');
const s460DaysInput = document.getElementById('s460_days');
const s460StartInput = document.getElementById('s460_startDatum');
const s460SwapInput = document.getElementById('s460_swap');
const confirmS460DownloadBtn = document.getElementById('confirmS460Download');
const cancelS460DownloadBtn = document.getElementById('cancelS460Download');
const closeS460ModalBtn = document.getElementById('closeS460Modal');
const s460List = document.getElementById('s460List');
const addS460RowBtn = document.getElementById('addS460Row');
['s627_aanvangDatum', 's627_eindDatum'].forEach((id) => {
  const el = document.getElementById(id);
  if (el) {
    el.addEventListener('input', () => {
      const v = normalizeDateString(el.value);
      if (v) el.value = v;
    });
    el.addEventListener('blur', () => {
      const v = normalizeDateString(el.value);
      if (v) el.value = v;
    });
  }
});
['s627_aanvangUur', 's627_eindUur'].forEach((id) => {
  const el = document.getElementById(id);
  if (el) {
    el.addEventListener('input', () => {
      if (shouldNormalizeTimeOnInput(el.value)) {
        const v = normalizeTimeString(el.value);
        if (v) el.value = v;
      }
    });
    el.addEventListener('blur', () => {
      const v = normalizeTimeString(el.value);
      if (v) el.value = v;
    });
  }
});
if (s460StartInput) {
  s460StartInput.addEventListener('input', () => {
    s460StartInput.value = formatDateProgressive(s460StartInput.value);
  });
  s460StartInput.addEventListener('blur', () => {
    const v = normalizeDateString(s460StartInput.value);
    if (v) s460StartInput.value = v;
  });
}
if (s460DaysInput) {
  s460DaysInput.addEventListener('blur', () => {
    s460DaysInput.value = clampDaysS460(s460DaysInput.value);
  });
}

if (addInputBtn) addInputBtn.addEventListener('click', () => addInputRow());
if (addFieldBtn) addFieldBtn.addEventListener('click', () => addFieldRow());
if (downloadBtn) downloadBtn.addEventListener('click', downloadJson);
if (generatePdfBtn) {
  generatePdfBtn.addEventListener('click', () => {
    const type = docTypeSelect ? docTypeSelect.value : defaultDocType;
    if (type === 's460' && s460ModalEl) {
      openS460Modal();
    } else {
      handleGeneratePdf();
    }
  });
}
if (uploadInput) uploadInput.addEventListener('change', handleUpload);
if (docTypeSelect) docTypeSelect.addEventListener('change', toggleSections);
if (openModalBtn) openModalBtn.addEventListener('click', openModal);
if (confirmDownloadBtn) confirmDownloadBtn.addEventListener('click', () => { closeModal(); handleGeneratePdf(); });
if (cancelDownloadBtn) cancelDownloadBtn.addEventListener('click', closeModal);
if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
variantInputs.forEach((el) => el.addEventListener('change', () => {}));
if (confirmS460DownloadBtn) confirmS460DownloadBtn.addEventListener('click', () => {
  if (s460DaysInput) s460DaysInput.value = clampDaysS460(s460DaysInput.value);
  closeS460Modal();
  handleGeneratePdf();
});
if (cancelS460DownloadBtn) cancelS460DownloadBtn.addEventListener('click', closeS460Modal);
if (closeS460ModalBtn) closeS460ModalBtn.addEventListener('click', closeS460Modal);
if (addS460RowBtn) addS460RowBtn.addEventListener('click', () => addS460Row());

function addInputRow(data = {}) {
  const row = makeEl('div', 'item');
  const name = makeEl('input');
  name.placeholder = 'name (bv. baanvak)';
  name.value = data.name || '';
  const value = makeEl('input');
  value.placeholder = 'value';
  value.value = data.value || '';
  const align = makeEl('select');
  ['(single)', 'left', 'right', 'center'].forEach((opt) => {
    const o = document.createElement('option');
    o.value = opt === '(single)' ? '' : opt;
    o.textContent = opt;
    if (o.value === (data.align || '')) o.selected = true;
    align.appendChild(o);
  });
  const remove = makeEl('button', 'remove');
  remove.textContent = 'X';
  remove.onclick = () => row.remove();

  row.append(name, value, align, remove);
  inputList.appendChild(row);
}

function addFieldRow(data = {}) {
  const row = makeEl('div', 'item');
  const key = makeEl('input');
  key.placeholder = 'veld (bv. onderstation)';
  key.value = data.key || '';
  const value = makeEl('input');
  value.placeholder = 'waarde';
  value.value = data.value || '';
  const filler = makeEl('div'); // spacer
  const remove = makeEl('button', 'remove');
  remove.textContent = 'X';
  remove.onclick = () => row.remove();
  row.append(key, value, filler, remove);
  fieldsList.appendChild(row);
}

function clampDays(n) {
  const num = parseInt(n, 10);
  if (isNaN(num) || num <= 0) return 1;
  if (num > 7) return 7;
  return num;
}
function clampDaysS460(n) {
  const num = parseInt(n, 10);
  if (isNaN(num) || num <= 0) return 1;
  if (num > 8) return 8;
  return num;
}

function addS460Row(data = {}) {
  if (!s460List) return;
  const row = makeEl('div', 's460-inline-row');
  const input = makeEl('input');
  input.placeholder = 'Melding';
  input.value = data.value || '';
  const toggle = makeEl('div', 'pill-toggle');
  const left = makeEl('button', 'pill');
  left.type = 'button';
  left.textContent = 'verz';
  left.dataset.value = 'verz';
  const right = makeEl('button', 'pill');
  right.type = 'button';
  right.textContent = 'ontv';
  right.dataset.value = 'ontv';
  const setActive = (val) => {
    [left, right].forEach((btn) => btn.classList.toggle('active', btn.dataset.value === val));
  };
  left.addEventListener('click', () => setActive('verz'));
  right.addEventListener('click', () => setActive('ontv'));
  toggle.append(left, right);
  setActive(data.role || 'verz');
  const remove = makeEl('button', 'remove');
  remove.textContent = 'X';
  remove.onclick = () => row.remove();
  row.append(input, toggle, remove);
  s460List.appendChild(row);
}

const pad2 = (n) => (n < 10 ? `0${n}` : `${n}`);
const formatDateDMY = (d) => `${pad2(d.getDate())}-${pad2(d.getMonth() + 1)}-${d.getFullYear()}`;
const parseDateTime = (dateStr, timeStr) => {
  if (!dateStr || !timeStr) return null;
  const parts = dateStr.includes('/') ? dateStr.split('/') : dateStr.split('-');
  if (parts.length !== 3) return null;
  let d, m, y;
  if (parts[0].length === 4) {
    [y, m, d] = parts.map((p) => parseInt(p, 10));
  } else {
    [d, m, y] = parts.map((p) => parseInt(p, 10));
  }
  const [hh, mm] = timeStr.split(':').map((p) => parseInt(p, 10));
  if (isNaN(hh) || isNaN(mm)) return null;
  const dt = new Date(y, (m || 1) - 1, d || 1, hh, mm, 0, 0);
  return isNaN(dt.getTime()) ? null : dt;
};
const formatDurationHM = (minutes) => {
  const h = Math.floor(minutes / 60);
  const m = minutes % 60;
  return `${pad2(h)}:${pad2(m)}`;
};
const normalizeTimeString = (val) => {
  if (!val) return null;
  const raw = val.toString().trim();
  if (!raw) return null;
  const normalizedSeparators = raw.replace(/\./g, ':').replace(/h/gi, ':').replace(/\s+/g, ' ').trim();
  const digitsOnly = normalizedSeparators.replace(/\D/g, '');
  let hours;
  let minutes;
  let suffix = null;

  const match = normalizedSeparators.match(/^(\d{1,2})(?::?(\d{2}))?\s*(am|pm)?$/i);
  if (match) {
    hours = parseInt(match[1], 10);
    minutes = parseInt(match[2] ?? '0', 10);
    suffix = match[3] ? match[3].toLowerCase() : null;
  } else if (/^\d{3}$/.test(digitsOnly)) {
    hours = parseInt(digitsOnly[0], 10);
    minutes = parseInt(digitsOnly.slice(1), 10);
  } else if (/^\d{4}$/.test(digitsOnly)) {
    hours = parseInt(digitsOnly.slice(0, 2), 10);
    minutes = parseInt(digitsOnly.slice(2), 10);
  } else {
    return null;
  }

  if (isNaN(hours) || isNaN(minutes) || minutes > 59) return null;
  if (suffix === 'pm' && hours < 12) hours += 12;
  if (suffix === 'am' && hours === 12) hours = 0;
  if (hours > 23) return null;
  return `${pad2(hours)}:${pad2(minutes)}`;
};
const shouldNormalizeTimeOnInput = (val) => {
  if (!val) return false;
  const raw = val.toString().trim();
  if (!raw) return false;
  if (raw.includes(':') || /am|pm/i.test(raw)) return true;
  const digits = raw.replace(/\D/g, '');
  return digits.length >= 3;
};
const normalizeDateString = (val) => {
  if (!val) return val;
  const digits = val.replace(/\D/g, '');
  if (digits.length === 8) {
    const d = digits.slice(0, 2);
    const m = digits.slice(2, 4);
    const y = digits.slice(4);
    return `${d}-${m}-${y}`;
  }
  if (val.includes('/')) return val.replace(/\//g, '-');
  return val;
};

const formatDateProgressive = (val) => {
  if (!val) return val;
  const digits = val.replace(/\D/g, '').slice(0, 8);
  if (digits.length <= 2) return digits;
  if (digits.length <= 4) return `${digits.slice(0, 2)}-${digits.slice(2)}`;
  return `${digits.slice(0, 2)}-${digits.slice(2, 4)}-${digits.slice(4)}`;
};

function buildPayload() {
  const payload = { documentType: docTypeSelect ? docTypeSelect.value : defaultDocType };
  const naamEl = qs('#documentNaam');
  if (naamEl && naamEl.value) payload.documentNaam = naamEl.value;
  const opEl = qs('#opgemaaktDoor');
  if (opEl && opEl.value) payload.opgemaaktDoor = opEl.value;

  const dagenEl = qs('#hoeveelDagen');
  if (dagenEl) {
    payload.hoeveelDagen = clampDays(dagenEl.value);
  } else if (s460DaysInput) {
    payload.hoeveelDagen = clampDaysS460(s460DaysInput.value);
  } else {
    payload.hoeveelDagen = 1;
  }

  const overdrachtEl = qs('#overdracht');
  payload.overdracht = overdrachtEl ? overdrachtEl.checked : false;

  const variantEl = document.querySelector('input[name="s627Variant"]:checked');
  if (variantEl) payload.s627Variant = variantEl.value;

  const startEl = qs('#startDatum');
  const eindEl = qs('#eindDatum');
  const aanvangEl = qs('#aanvangsDatum');
  const s460StartEl = s460StartInput;
  if (startEl && startEl.value) payload.startDatum = startEl.value;
  if (eindEl && eindEl.value) payload.eindDatum = eindEl.value;
  if (aanvangEl && aanvangEl.value) payload.aanvangsDatum = aanvangEl.value;
  if (s460StartEl && s460StartEl.value) payload.startDatum = normalizeDateString(s460StartEl.value);
  if (s460SwapInput) payload.s460Swap = !!s460SwapInput.checked;

  // inputs
  const inputs = [];
  if (payload.documentType === 's460') {
    const rows = collectS460Rows();
    // start op rij 2 als we een startdatum hebben, anders op rij 1
    let rowIndex = s460StartEl && s460StartEl.value ? 2 : 1;
    rows.forEach(({ value, role }) => {
      if (!value || rowIndex > 12) return;
      const isOntv = role === 'ontv';
      const name = isOntv ? `${rowIndex + 12}` : `${rowIndex}`;
      inputs.push({ name, value });
      rowIndex += 1;
    });
  }
  if (payload.documentType === 's627') {
    inputs.push(...collectS627Inputs());
    // Force duration/end/start consistency for S627
    const map = {};
    inputs.forEach((i) => { map[i.name] = i.value; });
    map.aanvangDatum = normalizeDateString(map.aanvangDatum);
    map.eindDatum = normalizeDateString(map.eindDatum);
    map.aanvangUur = normalizeTimeString(map.aanvangUur) || map.aanvangUur;
    map.eindUur = normalizeTimeString(map.eindUur) || map.eindUur;
    const startDt = parseDateTime(map.aanvangDatum, map.aanvangUur);
    const endDt = parseDateTime(map.eindDatum, map.eindUur);
    let duurStr = map.vermoedelijkeDuur;
    let duurMin = null;
    if (duurStr && duurStr.includes(':')) {
      const [h, m] = duurStr.split(':').map((p) => parseInt(p, 10));
      if (!isNaN(h) && !isNaN(m)) duurMin = h * 60 + m;
    }

    if (startDt && endDt) {
      const diffMin = Math.max(0, Math.round((endDt - startDt) / 60000));
      duurMin = diffMin;
    } else if (duurMin !== null) {
      if (startDt && !endDt) {
        const newEnd = new Date(startDt.getTime() + duurMin * 60000);
        map.eindDatum = formatDateDMY(newEnd);
        map.eindUur = `${pad2(newEnd.getHours())}:${pad2(newEnd.getMinutes())}`;
      } else if (endDt && !startDt) {
        const newStart = new Date(endDt.getTime() - duurMin * 60000);
        map.aanvangDatum = formatDateDMY(newStart);
        map.aanvangUur = `${pad2(newStart.getHours())}:${pad2(newStart.getMinutes())}`;
      }
    }
    if (duurMin !== null) {
      map.vermoedelijkeDuur = formatDurationHM(duurMin);
    }
    // write back map to inputs array and DOM
    inputs.length = 0;
    Object.entries(map).forEach(([name, value]) => {
      inputs.push({ name, value });
      const el = qs(`#s627_${name}`);
      if (el && value !== undefined) el.value = value;
    });
  }
  if (inputList) {
    inputList.querySelectorAll('.item').forEach((row) => {
      const [nameEl, valueEl, alignEl] = row.querySelectorAll('input, select');
      if (!nameEl.value && !valueEl.value) return;
      const entry = { name: nameEl.value, value: valueEl.value };
      if (alignEl.value) entry.align = alignEl.value;
      inputs.push(entry);
    });
  }
  if (inputs.length) payload.inputs = inputs;

  // velden (verdeler/s460)
  const velden = {};
  if (fieldsList) {
    fieldsList.querySelectorAll('.item').forEach((row) => {
      const [keyEl, valueEl] = row.querySelectorAll('input');
      if (!keyEl.value) return;
      velden[keyEl.value] = valueEl.value;
    });
  }
  if (Object.keys(velden).length) payload.velden = velden;

  return payload;
}

function downloadJson() {
  const payload = buildPayload();
  const blob = new Blob([JSON.stringify(payload, null, 2)], { type: 'application/json' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  const name = payload.documentNaam ? payload.documentNaam.replace(/\s+/g, '_') : payload.documentType;
  a.href = url;
  a.download = `${new Date().toISOString().slice(0,19).replace(/[:T]/g,'-')}.${name}.json`;
  a.click();
  URL.revokeObjectURL(url);
  setStatus('JSON gedownload');
}

function handleUpload(evt) {
  const file = evt.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = (e) => {
    try {
      const data = JSON.parse(e.target.result);
      fillForm(data);
      setStatus('JSON geladen');
    } catch (err) {
      setStatus('Ongeldige JSON');
    }
  };
  reader.readAsText(file);
}

function fillForm(data) {
  if (docTypeSelect) docTypeSelect.value = data.documentType || defaultDocType;
  const naamEl = qs('#documentNaam');
  if (naamEl) naamEl.value = data.documentNaam || '';
  const opEl = qs('#opgemaaktDoor');
  if (opEl) opEl.value = data.opgemaaktDoor || '';
  const dagenEl = qs('#hoeveelDagen');
  if (dagenEl) dagenEl.value = clampDays(data.hoeveelDagen || 1);
  const overdrachtEl = qs('#overdracht');
  if (overdrachtEl) overdrachtEl.checked = !!data.overdracht;
  const startEl = qs('#startDatum');
  if (startEl) startEl.value = data.startDatum || '';
  const eindEl = qs('#eindDatum');
  if (eindEl) eindEl.value = data.eindDatum || '';
  const aanvangEl = qs('#aanvangsDatum');
  if (aanvangEl) aanvangEl.value = data.aanvangsDatum || '';
  if (data.s627Variant) {
    const v = document.querySelector(`input[name="s627Variant"][value="${data.s627Variant}"]`);
    if (v) v.checked = true;
  }

  const docType = data.documentType || defaultDocType;
  if (docType === 's460' && s460List) {
    s460List.innerHTML = '';
    const rows = [];
    (data.inputs || []).forEach((item) => {
      const idx = parseInt(item.name, 10);
      if (!item.value || Number.isNaN(idx)) return;
      const rowNumber = idx <= 12 ? idx : idx - 12;
      if (rowNumber < 1 || rowNumber > 12) return;
      const role = idx > 12 ? 'ontv' : 'verz';
      rows.push({ rowNumber, value: item.value, role });
    });
    rows.sort((a, b) => a.rowNumber - b.rowNumber);
    const ordered = rows.map(({ value, role }) => ({ value, role }));
    if (ordered.length === 0) ordered.push({ value: '', role: 'verz' });
    ordered.forEach((row) => addS460Row(row));
  } else if (inputList) {
    inputList.innerHTML = '';
    (data.inputs || []).forEach(addInputRow);
  }
  if (data.documentType === 's627') {
    populateS627FromInputs(data.inputs || [], data.s627Fields || {});
  }

  if (fieldsList) {
    fieldsList.innerHTML = '';
    if (data.velden) {
      Object.entries(data.velden).forEach(([key, value]) => addFieldRow({ key, value }));
    }
  }

  toggleSections();
}

function setStatus(msg) {
  statusEl.textContent = msg;
  setTimeout(() => { statusEl.textContent = ''; }, 2500);
}

async function handleGeneratePdf() {
  const payload = buildPayload();
  const pdf = window.StatelessPdf;
  if (!pdf) {
    setStatus('PDF generator niet beschikbaar');
    return;
  }
  try {
    const type = payload.documentType;
    if (type === 's627' && pdf.renderS627) {
      await pdf.renderS627(payload);
    } else if (type === 's460' && pdf.renderS460) {
      await pdf.renderS460(payload);
    } else if (type === 's505' && pdf.renderS505) {
      await pdf.renderS505(payload);
    } else {
      setStatus('PDF generatie voor dit type is nog niet geimplementeerd');
      return;
    }
    setStatus('PDF gegenereerd');
  } catch (err) {
    console.error(err);
    setStatus('PDF generatie mislukt');
  }
}

function toggleSections() {
  const type = docTypeSelect ? docTypeSelect.value : defaultDocType;
  if (s627Section) s627Section.style.display = type === 's627' ? 'block' : 'none';
}

function openModal() {
  if (modalEl) modalEl.classList.add('show');
}

function closeModal() {
  if (modalEl) modalEl.classList.remove('show');
}

function openS460Modal() {
  if (s460ModalEl) s460ModalEl.classList.add('show');
}

function closeS460Modal() {
  if (s460ModalEl) s460ModalEl.classList.remove('show');
}

function collectS627Inputs() {
  const map = {
    ingediendDoor: '#s627_ingediendDoor',
    specialiteit: '#s627_specialiteit',
    aan: '#s627_aan',
    postWerf: '#s627_postWerf',
    station: '#s627_station',
    aanvraag: '#s627_aanvraag',
    vermoedelijkeDuur: '#s627_vermoedelijkeDuur',
    rubriek2aRms: '#s627_rubriekRms',
    rubriek2aAndere: '#s627_rubriekAndere',
    voltooiing: '#s627_voltooiing',
    aanvangDatum: '#s627_aanvangDatum',
    aanvangUur: '#s627_aanvangUur',
    eindDatum: '#s627_eindDatum',
    eindUur: '#s627_eindUur'
  };
  const list = [];
  Object.entries(map).forEach(([name, selector]) => {
    const el = qs(selector);
    if (el && el.value) {
      const val = (name === 'aanvangUur' || name === 'eindUur')
        ? normalizeTimeString(el.value) || el.value
        : el.value;
      list.push({ name, value: val });
    }
  });
  return list;
}

function collectS460Rows() {
  const rows = [];
  if (!s460List) return rows;
  s460List.querySelectorAll('.s460-inline-row').forEach((row) => {
    const input = row.querySelector('input');
    const active = row.querySelector('.pill.active');
    const role = active ? active.dataset.value : 'verz';
    const value = input ? input.value.trim() : '';
    if (value) rows.push({ value, role });
  });
  return rows;
}

function populateS627FromInputs(inputs, explicit) {
  // Prioriteit: explicit s627Fields map
  const fromExplicit = explicit && Object.keys(explicit).length > 0;
  const map = {
    ingediendDoor: '#s627_ingediendDoor',
    specialiteit: '#s627_specialiteit',
    aan: '#s627_aan',
    postWerf: '#s627_postWerf',
    station: '#s627_station',
    aanvraag: '#s627_aanvraag',
    vermoedelijkeDuur: '#s627_vermoedelijkeDuur',
    rubriek2aRms: '#s627_rubriekRms',
    rubriek2aAndere: '#s627_rubriekAndere',
    voltooiing: '#s627_voltooiing',
    aanvangDatum: '#s627_aanvangDatum',
    aanvangUur: '#s627_aanvangUur',
    eindDatum: '#s627_eindDatum',
    eindUur: '#s627_eindUur'
  };

  Object.entries(map).forEach(([name, selector]) => {
    const el = qs(selector);
    if (!el) return;
    if (fromExplicit && explicit[name] !== undefined) {
      const val = (name === 'aanvangUur' || name === 'eindUur')
        ? normalizeTimeString(explicit[name]) || explicit[name]
        : explicit[name];
      el.value = val;
      return;
    }
    const found = inputs.find((i) => i.name === name);
    if (found) {
      const val = (name === 'aanvangUur' || name === 'eindUur')
        ? normalizeTimeString(found.value) || found.value
        : found.value;
      el.value = val || '';
    } else {
      el.value = '';
    }
  });
}

// initial rows
if (inputList) addInputRow();
if (fieldsList) addFieldRow();
if (s460List) addS460Row();
toggleSections();
