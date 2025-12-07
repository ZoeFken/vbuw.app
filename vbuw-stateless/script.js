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
const uploadInput = document.getElementById('uploadJson');
const docTypeSelect = document.getElementById('documentType');
const openModalBtn = document.getElementById('openDownloadModal');
const confirmDownloadBtn = document.getElementById('confirmDownload');
const cancelDownloadBtn = document.getElementById('cancelDownload');
const closeModalBtn = document.getElementById('closeModal');
const modalEl = document.getElementById('downloadModal');
const variantInputs = document.querySelectorAll('input[name="s627Variant"]');
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

if (addInputBtn) addInputBtn.addEventListener('click', () => addInputRow());
if (addFieldBtn) addFieldBtn.addEventListener('click', () => addFieldRow());
if (downloadBtn) downloadBtn.addEventListener('click', downloadJson);
if (uploadInput) uploadInput.addEventListener('change', handleUpload);
if (docTypeSelect) docTypeSelect.addEventListener('change', toggleSections);
if (openModalBtn) openModalBtn.addEventListener('click', openModal);
if (confirmDownloadBtn) confirmDownloadBtn.addEventListener('click', () => { closeModal(); handleGeneratePdf(); });
if (cancelDownloadBtn) cancelDownloadBtn.addEventListener('click', closeModal);
if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
variantInputs.forEach((el) => el.addEventListener('change', () => {}));

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

function buildPayload() {
  const payload = { documentType: docTypeSelect ? docTypeSelect.value : defaultDocType };
  const naamEl = qs('#documentNaam');
  if (naamEl && naamEl.value) payload.documentNaam = naamEl.value;
  const opEl = qs('#opgemaaktDoor');
  if (opEl && opEl.value) payload.opgemaaktDoor = opEl.value;

  const dagenEl = qs('#hoeveelDagen');
  payload.hoeveelDagen = dagenEl ? clampDays(dagenEl.value) : 1;

  const overdrachtEl = qs('#overdracht');
  payload.overdracht = overdrachtEl ? overdrachtEl.checked : false;

  const variantEl = document.querySelector('input[name="s627Variant"]:checked');
  if (variantEl) payload.s627Variant = variantEl.value;

  const startEl = qs('#startDatum');
  const eindEl = qs('#eindDatum');
  const aanvangEl = qs('#aanvangsDatum');
  if (startEl && startEl.value) payload.startDatum = startEl.value;
  if (eindEl && eindEl.value) payload.eindDatum = eindEl.value;
  if (aanvangEl && aanvangEl.value) payload.aanvangsDatum = aanvangEl.value;

  // inputs (s627/s505)
  const inputs = [];
  if (payload.documentType === 's627') {
    inputs.push(...collectS627Inputs());
    // Force duration/end/start consistency for S627
    const map = {};
    inputs.forEach((i) => { map[i.name] = i.value; });
    map.aanvangDatum = normalizeDateString(map.aanvangDatum);
    map.eindDatum = normalizeDateString(map.eindDatum);
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

  if (inputList) {
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
  try {
    if (payload.documentType === 's627') {
      if (!window.StatelessPdf || !window.StatelessPdf.renderS627) {
        setStatus('PDF generator niet beschikbaar');
        return;
      }
      await window.StatelessPdf.renderS627(payload);
      setStatus('PDF gegenereerd');
    } else {
      setStatus('PDF generatie voor dit type is nog niet geïmplementeerd');
    }
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
      list.push({ name, value: el.value });
    }
  });
  return list;
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
      el.value = explicit[name];
      return;
    }
    const found = inputs.find((i) => i.name === name);
    el.value = found ? (found.value || '') : '';
  });
}

// initial rows
if (inputList) addInputRow();
if (fieldsList) addFieldRow();
toggleSections();
