@extends('layouts.app')

@section('title', 'Peta Interaktif Puskesmas Sleman')

@section('content')

{{-- ── SIDEBAR ── --}}
<aside class="sidebar">

    <div class="sidebar-section">
        <div class="sidebar-title"><i class="fa-solid fa-chart-bar"></i> Rekapitulasi <span id="sidePeriodeLabel" style="margin-left:auto;font-size:.6rem;color:var(--accent);font-family:'IBM Plex Mono',monospace;"></span></div>
        <div class="kategori-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px;">
            <div class="kategori-card merah-card" onclick="filterByCategory('merah')" style="border-top: 3px solid #e74c3c;">
                <span class="dot"></span><span class="num" id="k-merah">0</span>
                <div class="label">Sangat Rendah</div>
                <div style="font-size:.58rem;color:var(--text-muted);margin-top:2px;">&lt;30%</div>
            </div>
            <div class="kategori-card oranye-card" onclick="filterByCategory('oranye')" style="border-top: 3px solid #e67e22;">
                <span class="dot"></span><span class="num" id="k-oranye">0</span>
                <div class="label">Rendah</div>
                <div style="font-size:.58rem;color:var(--text-muted);margin-top:2px;">30–49%</div>
            </div>
            <div class="kategori-card kuning-card" onclick="filterByCategory('kuning')" style="border-top: 3px solid #f1c40f;">
                <span class="dot"></span><span class="num" id="k-kuning">0</span>
                <div class="label">Sedang</div>
                <div style="font-size:.58rem;color:var(--text-muted);margin-top:2px;">50–69%</div>
            </div>
            <div class="kategori-card hijau-card" onclick="filterByCategory('hijau')" style="border-top: 3px solid #27ae60;">
                <span class="dot"></span><span class="num" id="k-hijau">0</span>
                <div class="label">Tinggi</div>
                <div style="font-size:.58rem;color:var(--text-muted);margin-top:2px;">&ge;70%</div>
            </div>
        </div>
    </div>
<!-- Search -->
    <div class="sidebar-section">
        <input
        type="text"
        id="searchInput"
        placeholder="Cari puskesmas..."
        onkeyup="filterList(this.value)"
        style="width:100%;padding:.7rem;border:1px solid #ddd;border-radius:8px;"
    >
</div>

<!-- Daftar Puskesmas -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <i class="fa-solid fa-hospital"></i>
            Daftar Puskesmas
            <span id="listCount" style="margin-left:auto;">0</span>
        </div>
        <div
        id="puskesmasList"
        style="
            height: calc(100vh - 355px);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding-right: 6px;
        ">
            </div>
        </div>
</aside>

{{-- ── MAP AREA ── --}}
<div class="map-container">
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
        <div class="loading-text" id="loadingText">Memuat peta wilayah...</div>
    </div>

    <div id="map" role="application" aria-label="Peta interaktif Puskesmas Sleman" tabindex="0" aria-describedby="mapDescription"></div>

    <div id="mapDescription" class="sr-only">Peta menunjukkan wilayah puskesmas di Kabupaten Sleman. Gunakan tombol pada toolbar untuk memperbesar, memperkecil, dan menggeser peta. Pilih puskesmas dari daftar untuk melihat detail.</div>

    <div class="map-controls" role="toolbar" aria-label="Kontrol peta">
        <button type="button" class="map-btn" id="btnZoomIn" aria-label="Perbesar peta">+</button>
        <button type="button" class="map-btn" id="btnZoomOut" aria-label="Perkecil peta">−</button>
        <button type="button" class="map-btn" id="btnPanUp" aria-label="Geser ke atas">↑</button>
        <button type="button" class="map-btn" id="btnPanDown" aria-label="Geser ke bawah">↓</button>
        <button type="button" class="map-btn" id="btnPanLeft" aria-label="Geser ke kiri">←</button>
        <button type="button" class="map-btn" id="btnPanRight" aria-label="Geser ke kanan">→</button>
    </div>

    <div id="mapStatus" aria-live="polite" class="sr-only">Peta siap.</div>

    <div class="map-legend">
        <div class="legend-title"><i class="fa-solid fa-palette"></i> Capaian (%)</div>
        <div class="legend-item"><div class="legend-color" style="background:#e74c3c"></div><span>&lt;30% <span style="color:var(--text-muted);font-size:.62rem;">(Sangat Rendah)</span></span></div>
        <div class="legend-item"><div class="legend-color" style="background:#e67e22"></div><span>30–49% <span style="color:var(--text-muted);font-size:.62rem;">(Rendah)</span></span></div>
        <div class="legend-item"><div class="legend-color" style="background:#f1c40f"></div><span>50–69% <span style="color:var(--text-muted);font-size:.62rem;">(Sedang)</span></span></div>
        <div class="legend-item" style="margin-bottom:0"><div class="legend-color" style="background:#27ae60"></div><span>&ge;70% <span style="color:var(--text-muted);font-size:.62rem;">(Tinggi)</span></span></div>
    </div>

    <div class="map-info-panel" id="infoPanel" role="region" aria-label="Detail puskesmas" tabindex="-1">
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
    if (pct < 30) return '#e74c3c';   // Sangat Rendah (Merah)
    if (pct < 50) return '#e67e22';   // Rendah (Oranye)
    if (pct < 70) return '#f1c40f';   // Sedang (Toska / Biru Laut)
    return '#27ae60';                 // Tinggi (Hijau)
}
function getStatusColors(status) {
    const m = {
        'Sangat Rendah': ['rgba(231,76,60,.2)',  '#e74c3c'],
        'Rendah':        ['rgba(230,126,34,.2)', '#e67e22'],
        'Sedang':        ['rgba(241,196,15,.2)', '#f1c40f'],
        'Tinggi':        ['rgba(39,174,96,.2)',  '#27ae60'],
    };
    return m[status] || ['#222','#fff'];
}

function styleFeature(feature) {
    const col = getColor(feature.properties.persentase_capaian);
    // tampilkan batas wilayah dengan warna kontras dan ketebalan sedang
    return {
        fillColor: col,
        fillOpacity: 0.28,
        color: '#2c3e50', // warna garis batas
        weight: 1.6,
        opacity: 0.95,
        lineJoin: 'round'
    };
}
function styleHighlight(feature) {
    const col = getColor(feature.properties.persentase_capaian);
    // ketika disorot, pertegas border agar terlihat jelas
    return {
        fillColor: col,
        fillOpacity: 0.68,
        color: '#000',
        weight: 3.0,
        opacity: 1,
        dashArray: ''
    };
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
    document.getElementById('mapStatus').textContent = props.nama_puskesmas + ', capaian ' + pct + ' persen.';
    // focus info panel so screen reader reads it
    const ip = document.getElementById('infoPanel'); if (ip) ip.focus();
}
function closeInfoPanel() {
    document.getElementById('infoPanel').classList.remove('visible');
    if (geojsonLayer) geojsonLayer.resetStyle();
    document.querySelectorAll('.pkm-item').forEach(el => el.classList.remove('active'));
    document.getElementById('mapStatus').textContent = 'Peta siap.';
    // return focus to map container
    const m = document.getElementById('map'); if (m) m.focus();
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

        updateStats(data.features);

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
function getKategoriColor(pct) {
    if (pct < 30) return '#e74c3c';      // merah
    if (pct < 50) return '#e67e22';      // oranye
    if (pct < 70) return '#f1c40f';      // kuning
    return '#2ecc71';                    // hijau
}
function renderList(data) {
    document.getElementById('listCount').textContent = data.length;
    const container = document.getElementById('puskesmasList');
    container.innerHTML = data.map(item => {

        const pct = parseFloat(item.persentase_capaian || 0);
        const warna = getKategoriColor(pct);

        return `
            <div style="
                padding:10px;
                border-left:5px solid ${warna};
                background:#fff;
                border-radius:8px;
                margin-bottom:8px;
            ">
                <div style="font-weight:600;">
                    ${item.nama_puskesmas}
                </div>

                <div style="
                    color:${warna};
                    font-weight:bold;
                    font-size:16px;
                ">
                    ${pct.toFixed(1)}%
                </div>
            </div>
        `;
    }).join('');

    document.getElementById('listCount').textContent = data.length;
}

// Map control helpers: zoom and pan via accessible buttons and keyboard
function zoomIn() { map.zoomIn(); document.getElementById('mapStatus').textContent = 'Memperbesar peta'; }
function zoomOut(){ map.zoomOut(); document.getElementById('mapStatus').textContent = 'Memperkecil peta'; }
function panMap(dx, dy){ map.panBy([dx, dy]); document.getElementById('mapStatus').textContent = 'Menggeser peta'; }

// wire up toolbar buttons
document.addEventListener('click', (e)=>{
    if(e.target && e.target.id === 'btnZoomIn') zoomIn();
    if(e.target && e.target.id === 'btnZoomOut') zoomOut();
    if(e.target && e.target.id === 'btnPanUp') panMap(0, -200);
    if(e.target && e.target.id === 'btnPanDown') panMap(0, 200);
    if(e.target && e.target.id === 'btnPanLeft') panMap(-200, 0);
    if(e.target && e.target.id === 'btnPanRight') panMap(200, 0);
});

// keyboard support for map element
const mapContainer = document.getElementById('map');
mapContainer && mapContainer.addEventListener('keydown', (ev)=>{
    switch(ev.key){
        case 'ArrowUp': ev.preventDefault(); panMap(0,-200); break;
        case 'ArrowDown': ev.preventDefault(); panMap(0,200); break;
        case 'ArrowLeft': ev.preventDefault(); panMap(-200,0); break;
        case 'ArrowRight': ev.preventDefault(); panMap(200,0); break;
        case '+': case '=': ev.preventDefault(); zoomIn(); break;
        case '-': case '_': ev.preventDefault(); zoomOut(); break;
    }
});

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
    
    // Sesuaikan range kondisi objek data list puskesmas
    const ranges = { 
        merah:  [0, 29.9], 
        oranye: [30, 49.9], 
        kuning: [50, 69.9], 
        hijau:  [70, 100] 
    };
    const [lo, hi] = ranges[cat];
    renderList(allListData.filter(p => p.persentase_capaian >= lo && p.persentase_capaian <= hi));
}

// ─── Update stats setelah reload ─────────────────────────────────────────────
function updateStats(features) {
    const pcts = features.map(f => f.properties.persentase_capaian);
    const avg  = pcts.length ? (pcts.reduce((a,b)=>a+b,0)/pcts.length).toFixed(1) : 0;
    
    // Jika elemen statTotal & statAvg ada di blade Anda
    if(document.getElementById('statTotal')) document.getElementById('statTotal').textContent = pcts.length;
    if(document.getElementById('statAvg')) document.getElementById('statAvg').textContent = avg + '%';
    
    // Sinkronisasi jumlah counter card berdasarkan pembagian gambar baru
    document.getElementById('k-merah').textContent  = pcts.filter(p => p < 30).length;
    document.getElementById('k-oranye').textContent = pcts.filter(p => p >= 30 && p < 50).length;
    document.getElementById('k-kuning').textContent = pcts.filter(p => p >= 50 && p < 70).length;
    document.getElementById('k-hijau').textContent  = pcts.filter(p => p >= 70).length;
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
