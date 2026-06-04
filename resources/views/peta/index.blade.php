@extends('layouts.app')

@section('title', 'Peta Interaktif Puskesmas Sleman')

@section('content')

{{-- ── SIDEBAR ── --}}
<aside class="sidebar">

    <div class="sidebar-section">
        <div class="sidebar-title"><i class="fa-solid fa-chart-bar"></i> Rekapitulasi <span id="sidePeriodeLabel" style="margin-left:auto;font-size:.6rem;color:var(--accent);font-family:'IBM Plex Mono',monospace;"></span></div>
        <div class="kategori-grid">
            <div class="kategori-card oranye-card" onclick="filterByCategory('merah')">
                <span class="dot"></span><span class="num" id="k-oranye">{{ $statistik['rendah'] }}</span>
                <div class="label">Belum Tercapai</div>
                <div style="font-size:.58rem;color:var(--text-muted);margin-top:2px;"><60%</div>
            </div>
            <div class="kategori-card kuning-card" onclick="filterByCategory('kuning')">
                <span class="dot"></span><span class="num" id="k-kuning">{{ $statistik['sedang'] }}</span>
                <div class="label">Cukup Tercapai</div>
                <div style="font-size:.58rem;color:var(--text-muted);margin-top:2px;">60-80%</div>
            </div>
            <div class="kategori-card hijau-card" onclick="filterByCategory('hijau')">
                <span class="dot"></span><span class="num" id="k-hijau">{{ $statistik['tinggi'] }}</span>
                <div class="label">Tercapai</div>
                <div style="font-size:.58rem;color:var(--text-muted);margin-top:2px;">>80%</div>
            </div>
        </div>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-title"><i class="fa-solid fa-magnifying-glass"></i> Cari Puskesmas</div>
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" id="searchInput" placeholder="Nama atau kecamatan..." oninput="filterList(this.value)">
        </div>
    </div>

    <div class="sidebar-section" style="border:none;padding-bottom:.25rem;">
        <div class="sidebar-title">
            <i class="fa-solid fa-list"></i> Daftar Puskesmas
            <span id="listCount" style="margin-left:auto;background:var(--bg-card2);padding:.1rem .4rem;border-radius:4px;font-family:'IBM Plex Mono',monospace;font-size:.65rem;"></span>
        </div>
    </div>

    <div class="puskesmas-list" id="puskesmasList">
        <div style="text-align:center;padding:2rem;color:var(--text-muted);font-size:.78rem;">
            <i class="fa-solid fa-spinner fa-spin"></i> Memuat data...
        </div>
    </div>

</aside>

{{-- ── MAP AREA ── --}}
<div class="map-container">
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
        <div class="loading-text" id="loadingText">Memuat peta wilayah...</div>
    </div>

    <div id="map"></div>

    <div class="map-legend">
        <div class="legend-title"><i class="fa-solid fa-palette"></i> Capaian (%)</div>
        <div class="legend-item"><div class="legend-color" style="background:#e74c3c"></div><span><60% <span style="color:var(--text-muted);font-size:.62rem;">(Belum Tercapai)</span></span></div>
        <div class="legend-item"><div class="legend-color" style="background:#f1c40f"></div><span>60-80% <span style="color:var(--text-muted);font-size:.62rem;">(Cukup Tercapai)</span></span></div>
        <div class="legend-item" style="margin-bottom:0"><div class="legend-color" style="background:#27ae60"></div><span>>80% <span style="color:var(--text-muted);font-size:.62rem;">(Tercapai)</span></span></div>
    </div>

    <div class="map-info-panel" id="infoPanel">
        <div class="info-panel-header">
            <div class="info-panel-name" id="infoPanelName">—</div>
            <button class="info-close" onclick="closeInfoPanel()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="info-pct-display">
            <div class="pct-circle" id="infoPanelPct">—%</div>
            <div><span class="info-status-badge" id="infoPanelStatus">—</span></div>
        </div>
        <div class="pct-bar" style="height:4px;margin:.5rem 0">
            <div class="pct-fill" id="infoPanelBar" style="width:0%"></div>
        </div>
        <div style="height:.5rem;"></div>
        <div class="info-row"><span class="k">Kecamatan</span>   <span class="v" id="infoPanelKec">—</span></div>
        <div class="info-row"><span class="k">Penduduk</span>     <span class="v" id="infoPanelPenduduk">—</span></div>
        <div class="info-row"><span class="k">Tercapai</span>     <span class="v" id="infoPanelTercapai">—</span></div>
        <div class="info-row"><span class="k">Capaian</span>      <span class="v" id="infoPanelCapaian">—</span></div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ─── Config ──────────────────────────────────────────────────────────────────
const URL_GEOJSON = '{{ route("api.puskesmas.geojson") }}';
const URL_LIST    = '{{ route("api.puskesmas.list") }}';
const URL_PERIODE = '{{ route("api.puskesmas.periode") }}';

const NAMA_BULAN = ['','Januari','Februari','Maret','April','Mei','Juni',
                    'Juli','Agustus','September','Oktober','November','Desember'];

// State aktif
let activeBulan  = {{ $bulan }};
let activeTahun  = {{ $tahun }};
let bulanList    = @json($bulanList);
let allListData  = [];
let activeFilter = null;

// ─── Leaflet init ────────────────────────────────────────────────────────────
const map = L.map('map', { center: [-7.7200, 110.3550], zoom: 12, zoomControl: false });
L.control.zoom({ position: 'bottomleft' }).addTo(map);
L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
    attribution: '© OpenStreetMap contributors © CARTO',
    subdomains: 'abcd', maxZoom: 20,
}).addTo(map);

let geojsonLayer = null;

// ─── Helpers ─────────────────────────────────────────────────────────────────
function getColor(pct) {
    if (pct <= 60) return '#e74c3c';
    if (pct <= 80) return '#f1c40f';
    return '#27ae60';
}
function getStatusColors(status) {
    const m = {
        'Belum Tercapai': ['rgba(230,126,34,.2)', '#e67e22'],
        'Cukup Tercapai': ['rgba(241,196,15,.2)', '#f1c40f'],
        'Tercapai':       ['rgba(39,174,96,.2)',  '#27ae60'],
    };
    return m[status] || ['#222','#fff'];
}

function styleFeature(feature) {
    const col = getColor(feature.properties.persentase_capaian);
    return { fillColor: col, fillOpacity: .42, color: col, weight: 1.5, opacity: .9 };
}
function styleHighlight(feature) {
    const col = getColor(feature.properties.persentase_capaian);
    return { fillColor: col, fillOpacity: .68, color: '#fff', weight: 2.5, opacity: 1 };
}

// ─── Popup HTML ───────────────────────────────────────────────────────────────
function buildPopup(props) {
    const col  = getColor(props.persentase_capaian);
    const pct  = parseFloat(props.persentase_capaian).toFixed(1);
    const pddk = Number(props.jumlah_kk_total).toLocaleString('id-ID');
    const capaian = Number(props.jumlah_tercapai).toLocaleString('id-ID');
    const [sbg, stxt] = getStatusColors(props.status_kategori);
    return `
        <div class="popup-inner">
            <div class="popup-title">${props.nama_puskesmas}</div>
            <div class="popup-row"><span class="pk">Kecamatan</span><span class="pv">${props.kecamatan}</span></div>
            <div class="popup-row"><span class="pk">Penduduk</span><span class="pv">${pddk} jiwa</span></div>
            <div class="popup-row"><span class="pk">Tercapai</span><span class="pv">${capaian} jiwa</span></div>
            <div class="popup-row"><span class="pk">Capaian</span><span class="pv" style="color:${col};font-size:.88rem">${pct}%</span></div>
            <div class="popup-pct-bar"><div class="popup-pct-fill" style="width:${pct}%;background:${col}"></div></div>
            <span class="popup-status" style="background:${sbg};color:${stxt}">${props.status_kategori}</span>
            <div style="margin-top:.45rem;font-size:.6rem;color:var(--text-muted);">
                <i class="fa-regular fa-calendar-days"></i> ${NAMA_BULAN[activeBulan]} ${activeTahun}
            </div>
        </div>`;
}

// ─── Info panel ───────────────────────────────────────────────────────────────
function openInfoPanel(props) {
    const col = getColor(props.persentase_capaian);
    const pct = parseFloat(props.persentase_capaian).toFixed(1);
    const [sbg, stxt] = getStatusColors(props.status_kategori);

    document.getElementById('infoPanelName').textContent     = props.nama_puskesmas;
    document.getElementById('infoPanelPct').textContent      = pct + '%';
    document.getElementById('infoPanelPct').style.color      = col;
    document.getElementById('infoPanelStatus').textContent   = props.status_kategori;
    document.getElementById('infoPanelStatus').style.background = sbg;
    document.getElementById('infoPanelStatus').style.color      = stxt;
    document.getElementById('infoPanelBar').style.width      = pct + '%';
    document.getElementById('infoPanelBar').style.background = col;
    document.getElementById('infoPanelKec').textContent      = props.kecamatan;
    document.getElementById('infoPanelPenduduk').textContent = Number(props.jumlah_kk_total).toLocaleString('id-ID') + ' jiwa';
    document.getElementById('infoPanelTercapai').textContent = Number(props.jumlah_tercapai).toLocaleString('id-ID') + ' jiwa';
    document.getElementById('infoPanelCapaian').textContent  = pct + '%';
    document.getElementById('infoPanelCapaian').style.color  = col;
    document.getElementById('infoPanel').classList.add('visible');
}
function closeInfoPanel() {
    document.getElementById('infoPanel').classList.remove('visible');
    if (geojsonLayer) geojsonLayer.resetStyle();
    document.querySelectorAll('.pkm-item').forEach(el => el.classList.remove('active'));
}

// ─── Load GeoJSON ─────────────────────────────────────────────────────────────
async function loadGeoJSON(showLoading = true) {
    if (showLoading) showLoader('Memuat data ' + NAMA_BULAN[activeBulan] + ' ' + activeTahun + '...');

    try {
        const res  = await fetch(`${URL_GEOJSON}?bulan=${activeBulan}&tahun=${activeTahun}`);
        if (!res.ok) {
            throw new Error('Gagal memuat GeoJSON: ' + res.status);
        }

        const data = await res.json();

        if (geojsonLayer) { map.removeLayer(geojsonLayer); geojsonLayer = null; }

        geojsonLayer = L.geoJSON(data, {
            style: styleFeature,
            onEachFeature: (feature, layer) => {
                const p = feature.properties;
                layer.bindTooltip(
                    `<b>${p.nama_puskesmas}</b><br>${p.kecamatan}`,
                    { direction: 'top', offset: [0, -6], opacity: 0.9 }
                );
                layer.bindPopup(buildPopup(feature.properties), { maxWidth: 280 });
                layer.on('click', () => {
                    openInfoPanel(feature.properties);
                    highlightListItem(feature.properties.id);
                    map.fitBounds(layer.getBounds(), { padding: [60, 60], maxZoom: 16 });
                });
                layer.on('mouseover', () => layer.setStyle(styleHighlight(feature)));
                layer.on('mouseout', () => geojsonLayer.resetStyle(layer));
            }
        }).addTo(map);

        if (showLoading && geojsonLayer.getLayers().length > 0) {
            map.fitBounds(geojsonLayer.getBounds(), { padding: [20, 20] });
        }
    } catch (error) {
        console.error(error);
        alert('Gagal memuat data peta. Silakan coba lagi.');
    } finally {
        if (showLoading) hideLoader();
    }
}

// ─── Load sidebar list ────────────────────────────────────────────────────────
async function loadList() {
    const res = await fetch(`${URL_LIST}?bulan=${activeBulan}&tahun=${activeTahun}`);
    allListData = await res.json();
    renderList(allListData);
    updateSidebarPeriode();
}

function renderList(data) {
    document.getElementById('listCount').textContent = data.length;
    const container = document.getElementById('puskesmasList');
    if (!data.length) {
        container.innerHTML = `<div style="text-align:center;padding:2rem;color:var(--text-muted);font-size:.78rem;"><i class="fa-solid fa-magnifying-glass" style="font-size:1.4rem;opacity:.35;display:block;margin-bottom:.5rem"></i>Tidak ditemukan</div>`;
        return;
    }
    container.innerHTML = data.map(p => `
        <div class="pkm-item" id="pkm-item-${p.id}" onclick="selectPuskesmas(${p.id})">
            <div class="pkm-color-bar" style="background:${p.warna}"></div>
            <div class="pkm-info">
                <div class="pkm-name">${p.nama_puskesmas}</div>
                <div class="pkm-sub">
                    <span>${p.kecamatan}</span><span>·</span>
                    <span>${p.jumlah_kk_total} jiwa</span>
                </div>
                <div class="pct-bar">
                    <div class="pct-fill" style="width:${p.persentase_capaian}%;background:${p.warna}"></div>
                </div>
            </div>
            <div class="pkm-pct" style="color:${p.warna}">${parseFloat(p.persentase_capaian).toFixed(1)}%</div>
        </div>`).join('');
}

function highlightListItem(id) {
    document.querySelectorAll('.pkm-item').forEach(el => el.classList.remove('active'));
    const item = document.getElementById('pkm-item-' + id);
    if (item) { item.classList.add('active'); item.scrollIntoView({ behavior: 'smooth', block: 'nearest' }); }
}

function selectPuskesmas(id) {
    if (!geojsonLayer) return;
    geojsonLayer.eachLayer(layer => {
        if (layer.feature && layer.feature.properties.id === id) {
            layer.openPopup();
            openInfoPanel(layer.feature.properties);
            highlightListItem(id);
            map.fitBounds(layer.getBounds(), { padding: [60, 60], maxZoom: 16 });
        }
    });
}

// ─── Filter sidebar ───────────────────────────────────────────────────────────
function filterList(query) {
    activeFilter = null;
    document.querySelectorAll('.kategori-card').forEach(c => c.style.opacity = '1');
    const q = query.toLowerCase();
    renderList(allListData.filter(p =>
        p.nama_puskesmas.toLowerCase().includes(q) || p.kecamatan.toLowerCase().includes(q)
    ));
}

function filterByCategory(cat) {
    document.getElementById('searchInput').value = '';
    if (activeFilter === cat) {
        activeFilter = null;
        document.querySelectorAll('.kategori-card').forEach(c => c.style.opacity = '1');
        renderList(allListData);
        return;
    }
    activeFilter = cat;
    document.querySelectorAll('.kategori-card').forEach(c => c.style.opacity = '.45');
    document.querySelector('.' + cat + '-card').style.opacity = '1';
    const ranges = { merah:[0,25], oranye:[26,50], kuning:[51,75], hijau:[76,100] };
    const [lo, hi] = ranges[cat];
    renderList(allListData.filter(p => p.persentase_capaian >= lo && p.persentase_capaian <= hi));
}

// ─── Update stats setelah reload ─────────────────────────────────────────────
function updateStats(features) {
    const pcts = features.map(f => f.properties.persentase_capaian);
    const avg  = pcts.length ? (pcts.reduce((a,b)=>a+b,0)/pcts.length).toFixed(1) : 0;
    document.getElementById('statTotal').textContent = pcts.length;
    document.getElementById('statAvg').textContent   = avg + '%';
    document.getElementById('k-merah').textContent   = pcts.filter(p => p <= 25).length;
    document.getElementById('k-oranye').textContent  = pcts.filter(p => p > 25 && p <= 50).length;
    document.getElementById('k-kuning').textContent  = pcts.filter(p => p > 50 && p <= 75).length;
    document.getElementById('k-hijau').textContent   = pcts.filter(p => p > 75).length;
}

function updateSidebarPeriode() {
    document.getElementById('sidePeriodeLabel').textContent = NAMA_BULAN[activeBulan] + ' ' + activeTahun;
    document.getElementById('periodeActive').textContent    = NAMA_BULAN[activeBulan] + ' ' + activeTahun;
}

// ─── Periode controls ─────────────────────────────────────────────────────────
function onTahunChange(val) {
    activeTahun = parseInt(val);
    // Muat bulan yang tersedia untuk tahun baru
    fetch(`${URL_PERIODE}?tahun=${activeTahun}`)
        .then(r => r.json())
        .then(d => {
            bulanList = d.bulan_list;
            rebuildBulanSelect(bulanList);
            activeBulan = bulanList.includes(activeBulan) ? activeBulan : Math.max(...bulanList);
            document.getElementById('selectBulan').value = activeBulan;
            updateNavButtons();
            reloadData();
        });
}

function onBulanChange(val) {
    activeBulan = parseInt(val);
    updateNavButtons();
    reloadData();
}

function navigateBulan(dir) {
    const idx = bulanList.indexOf(activeBulan);
    const newIdx = idx + dir;
    if (newIdx < 0 || newIdx >= bulanList.length) return;
    activeBulan = bulanList[newIdx];
    document.getElementById('selectBulan').value = activeBulan;
    updateNavButtons();
    reloadData();
}

function updateNavButtons() {
    const idx = bulanList.indexOf(activeBulan);
    document.getElementById('btnPrev').disabled = (idx <= 0);
    document.getElementById('btnNext').disabled = (idx >= bulanList.length - 1);
}

function rebuildBulanSelect(list) {
    const sel = document.getElementById('selectBulan');
    sel.innerHTML = list.map(b => `<option value="${b}">${NAMA_BULAN[b]}</option>`).join('');
}

async function reloadData() {
    closeInfoPanel();
    activeFilter = null;
    document.querySelectorAll('.kategori-card').forEach(c => c.style.opacity='1');
    document.getElementById('searchInput').value = '';
    await Promise.all([ loadGeoJSON(true), loadList() ]);
}

// ─── Loader ───────────────────────────────────────────────────────────────────
function showLoader(msg) {
    document.getElementById('loadingText').textContent = msg || 'Memuat...';
    document.getElementById('loadingOverlay').classList.remove('hidden');
}
function hideLoader() { document.getElementById('loadingOverlay').classList.add('hidden'); }

// ─── Init ─────────────────────────────────────────────────────────────────────
updateNavButtons();
loadGeoJSON(true);
loadList();
</script>
@endpush
