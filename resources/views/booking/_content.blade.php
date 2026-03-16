<div class="booking-page" data-tables-url="{{ url('/api/tables') }}" data-availability-url="{{ url('/api/table-availability') }}" data-reservations-url="{{ url('/api/table-reservations') }}">
    <h2 class="section-title-exact">Бронирование столика</h2>
        <div class="booking-shell">
            
            <div class="booking-topbar">
                <div class="booking-tabs">
                    <button type="button" class="booking-tab booking-tab-active" id="view-list">Список</button>
                    <button type="button" class="booking-tab" id="view-schema">Схема</button>
                </div>

                <div class="booking-time-panel">
                    <div class="booking-selected-time-wrap">
                        <div class="booking-selected-time" id="booking-selected-time">08:00</div>
                    </div>

                    <div class="booking-timeline-stage">
                        <div class="booking-timeline-viewport" id="booking-timeline">
                            <div class="booking-timeline-content" id="booking-timeline-content">
                                <div class="booking-timeline-track booking-timeline-track-inactive"></div>
                                <div class="booking-timeline-work-track" id="booking-timeline-work-track"></div>
                                <div class="booking-timeline-ticks" id="booking-timeline-ticks"></div>
                            </div>
                            <div class="booking-timeline-thumb" id="booking-timeline-thumb"></div>
                        </div>
                    </div>

                    <div class="booking-timeline-bottom">
                        <div class="booking-timeline-hours-viewport">
                            <div class="booking-timeline-hours" id="booking-timeline-hours"></div>
                        </div>
                    </div>
                </div>

                <div class="booking-date-box">
                    <input type="date" id="booking-date"
                           class="booking-date-input"
                           min="{{ now()->format('Y-m-d') }}">
                </div>
            </div>

            <div id="booking-list-view">
                <div class="booking-tables-wrap">
                    <button type="button" class="booking-arrow" id="booking-prev" aria-label="Назад" disabled>
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <div class="booking-grid-viewport" id="booking-grid-viewport">
                        <div class="booking-tables-track" id="booking-tables-track">
                        </div>
                    </div>
                    <button type="button" class="booking-arrow" id="booking-next" aria-label="Вперёд">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
                <div class="booking-pagination-info" id="booking-pagination-info" aria-live="polite"></div>
                <div id="booking-list-empty" class="booking-empty d-none">
                    <p class="mb-2">Список столиков пуст.</p>
                </div>
            </div>

            <div id="booking-schema-view" class="d-none">
                <div class="booking-schema-placeholder">
                    Схема зала появится позже. Сейчас доступен режим списка.
                </div>
            </div>
        </div>

</div>

<div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content booking-modal-content">
            <form id="booking-form">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Бронирование столика</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="booking-table-id">

                    <div class="mb-3">
                        <label class="form-label">Столик</label>
                        <input type="text" id="booking-table-info" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Дата</label>
                        <input type="text" id="booking-date-display" class="form-control" readonly>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">С</label>
                            <input type="time" id="booking-start-time" class="form-control" step="300" min="08:00" max="22:00" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">До</label>
                            <input type="time" id="booking-end-time" class="form-control" step="300" min="08:00" max="22:00" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ваше имя *</label>
                        <input type="text" id="booking-name" class="form-control" required maxlength="255" placeholder="Только буквы"
                               pattern="[a-zA-Zа-яА-ЯёЁ\s\-']{2,}" title="Минимум 2 символа, только буквы, пробел, дефис или апостроф" autocomplete="name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Телефон *</label>
                        <input type="tel" id="booking-phone" class="form-control" required placeholder="+7 (___) ___-__-__" autocomplete="tel">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" id="booking-email" class="form-control" autocomplete="email">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Гостей *</label>
                        <input type="number" id="booking-guests" class="form-control d-none" min="1" max="4" required readonly tabindex="-1">
                        <div class="booking-guests-controls d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm booking-guests-btn booking-guests-minus" aria-label="Меньше">−</button>
                            <span id="booking-guests-value" class="booking-guests-value">1</span>
                            <button type="button" class="btn btn-sm booking-guests-btn booking-guests-plus" aria-label="Больше">+</button>
                        </div>
                        <div class="form-text" id="booking-guests-hint"></div>
                    </div>

                    <div class="alert alert-danger d-none" id="booking-error"></div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn-exact" id="booking-submit-btn">Забронировать</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .booking-page {
        min-height: 100vh;
        overflow-x: hidden;
    }

    .booking-shell {
        background: var(--bg-dark, #171717);
        max-width: 1280px;
        width: 100%;
        box-sizing: border-box;
        margin: 0 auto;
    }

    .booking-title {
        line-height: 1;
        margin-bottom: 26px;
        font-family: "Adieu-Black", serif;
    }

    .booking-topbar {
        display: grid;
        grid-template-columns: minmax(0, 250px) minmax(0, 1fr) minmax(0, 160px);
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
        min-width: 0;
    }

    .booking-tabs {
        display: inline-flex;
        background: var(--bg-card, #1F1F1F);
        border: 1px solid var(--border, #333333);
        border-radius: 999px;
        overflow: hidden;
        height: 50px;
        width: 100%;
        max-width: 240px;
        min-width: 0;
    }

    .booking-tab {
        border: none;
        background: transparent;
        color: var(--text-gray, #B0B0B0);
        font-size: 20px;
        padding: 0 26px;
        min-width: 90px;
    }

    .booking-tab-active {
        background: var(--accent, #AD1C43);
        color: #fff;
    }

    .booking-date-box {
        width: 100%;
        max-width: 160px;
        min-width: 0;
        height: 50px;
        background: var(--bg-card, #1F1F1F);
        border: 1px solid var(--border, #333333);
        border-radius: 14px;
        display: flex;
        align-items: center;
        padding: 0 12px;
    }

    .booking-date-input {
        width: 100%;
        border: none;
        background: transparent;
        color: var(--text-light, #fff);
        font-size: 16px;
        outline: none;
    }

    .booking-time-panel {
        min-width: 0;
    }

    .booking-selected-time-wrap {
        position: relative;
        height: 34px;
        margin-bottom: 8px;
        min-width: 0;
        overflow: hidden;
    }

    .booking-selected-time {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        color: var(--text-light, #fff);
        font-weight: 700;
        font-size: 16px;
        white-space: nowrap;
        pointer-events: none;
    }

    .booking-timeline-stage {
        position: relative;
        width: 100%;
    }

    .booking-timeline-viewport {
        position: relative;
        height: 50px;
        cursor: pointer;
        user-select: none;
        overflow: hidden;
    }

    .booking-timeline-content {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        will-change: transform;
    }

    .booking-timeline-track {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        height: 3px;
        border-radius: 999px;
    }

    .booking-timeline-track-inactive {
        left: 0;
        width: 100%;
        background: rgba(255, 255, 255, 0.15);
    }

    .booking-timeline-work-track {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 0;
        height: 3px;
        background: var(--accent, #AD1C43);
        border-radius: 999px;
    }

    .booking-timeline-ticks {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        pointer-events: none;
    }

    .booking-timeline-tick {
        position: absolute;
        width: 1px;
        height: 18px;
        background: rgba(20, 20, 20, 0.65);
    }

    .booking-timeline-tick.major {
        height: 28px;
        background: rgba(20, 20, 20, 0.95);
    }

    .booking-timeline-thumb {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 12px;
        height: 12px;
        background: var(--accent, #AD1C43);
        border-radius: 50%;
        box-shadow: 0 0 0 4px rgba(173, 28, 67, 0.3);
        pointer-events: none;
    }

    .booking-timeline-bottom {
        position: relative;
        margin-top: 6px;
        min-height: 18px;
        overflow: hidden;
    }

    .booking-timeline-hours-viewport {
        position: relative;
        overflow: hidden;
        height: 18px;
    }

    .booking-timeline-hours {
        position: absolute;
        left: 0;
        top: 0;
        height: 18px;
        will-change: transform;
    }

    .booking-timeline-hour {
        position: absolute;
        top: 0;
        transform: translateX(-50%);
        color: var(--text-gray, #B0B0B0);
        font-size: 12px;
        white-space: nowrap;
    }

    .booking-tables-wrap {
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 auto;
        width: 100%;
        max-width: 100%;
        min-width: 0;
    }

    .booking-arrow {
        flex-shrink: 0;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        border: 1px solid var(--border, #333333);
        background: var(--bg-card, #1F1F1F);
        color: var(--text-light, #fff);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
    }

    .booking-arrow:hover:not(:disabled) {
        background: var(--accent, #AD1C43);
        border-color: var(--accent, #AD1C43);
    }

    .booking-arrow:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .booking-pagination-info {
        text-align: center;
        margin-top: 12px;
        font-size: 14px;
        color: var(--text-gray, #B0B0B0);
    }

    .booking-grid-viewport {
        flex: 1 1 0;
        min-width: 0;
        overflow: hidden;
        transition: height 0.35s ease-in-out;
        isolation: isolate;
        contain: layout style paint;
    }

    .booking-tables-track {
        display: flex;
        align-items: flex-start;
        transition: transform 0.35s ease-in-out;
    }

    .booking-grid-page {
        flex: 0 0 auto;
        width: max-content;
        min-width: 0;
    }

    .booking-grid {
        display: grid;
        width: 100%;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        align-content: start;
    }

    #booking-list-view {
        min-height: 200px;
    }
    .booking-empty {
        color: var(--text-gray, #B0B0B0);
        padding: 24px 0;
        text-align: center;
    }

    .booking-schema-placeholder {
        background: var(--bg-card, #1F1F1F);
        border: 1px solid var(--border, #333333);
        border-radius: 18px;
        padding: 80px 20px;
        text-align: center;
        color: var(--text-gray, #B0B0B0);
    }

    .table-card {
        background: var(--bg-card, #1F1F1F);
        border: 1px solid var(--border, #333333);
        border-radius: 16px;
        padding: 16px;
        min-height: 240px;
        display: flex;
        flex-direction: column;
        align-self: start;
    }

    .table-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .table-card-title-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-card-number-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 50%;
        background: var(--accent, #AD1C43);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        border: 2px solid rgba(255,255,255,0.3);
    }

    .table-card-title {
        color: var(--text-light, #fff);
        font-size: 18px;
        font-weight: 700;
        line-height: 1.2;
    }

    .table-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 78px;
        height: 28px;
        padding: 0 12px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
    }

    .table-status-free {
        background: rgba(110, 224, 108, 0.25);
        color: #6ee06c;
        border: 1px solid #6ee06c;
    }

    .table-status-busy {
        background: rgba(173, 28, 67, 0.3);
        color: var(--accent, #AD1C43);
        border: 1px solid var(--accent, #AD1C43);
    }

    .table-card-visual {
        height: 80px;
        margin: 10px 0 14px;
        background-image: url("/images/table/table-two.svg");
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        pointer-events: none;
        opacity: 0.9;
    }

    .table-card-visual.is-disabled {
        opacity: 0.4;
    }

    .table-card-bottom {
        margin-top: auto;
    }

    .table-card-meta-row {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 10px;
    }

    .table-card-meta-wrap {
        text-align: right;
    }

    .table-card-meta-top {
        color: var(--text-light, #fff);
        font-size: 15px;
        font-weight: 700;
        line-height: 1.2;
    }

    .table-card-meta-bottom {
        color: var(--text-gray, #B0B0B0);
        font-size: 13px;
        margin-top: 2px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 4px;
    }

    .table-card-btn {
        display: block;
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: none;
        background: var(--accent, #AD1C43);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, transform 0.2s;
    }

    .table-card-btn:hover:not(:disabled) {
        background: #c92355;
        transform: translateY(-1px);
    }

    .table-card-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .booking-modal-content {
        background: var(--bg-card, #1F1F1F);
        color: var(--text-light, #fff);
        border-radius: 20px;
        border: 1px solid var(--border, #333333);
    }

    .booking-modal-content .form-label {
        color: var(--text-gray, #B0B0B0);
    }

    .booking-modal-content .form-control {
        background: var(--bg-light, #2A2A2A);
        border: 1px solid var(--border, #333333);
        color: var(--text-light, #fff);
    }

    .booking-modal-content .form-control::placeholder {
        color: var(--text-gray, #B0B0B0);
    }

    .booking-modal-content .btn-light {
        background: var(--bg-light, #2A2A2A);
        border: 1px solid var(--border, #333333);
        color: var(--text-light, #fff);
    }

    .booking-modal-content .btn-light:hover {
        background: var(--border, #333333);
        color: var(--text-light, #fff);
    }

    .booking-modal-content #booking-submit-btn {
        background: var(--accent, #AD1C43);
        color: #fff;
        border: none;
    }

    .booking-modal-content #booking-submit-btn:hover {
        background: #c92355;
        color: #fff;
    }
    .booking-guests-controls {
        margin-top: 4px;
    }
    .booking-modal-content .booking-guests-btn {
        width: 36px;
        height: 36px;
        padding: 0;
        border-radius: 8px;
        border: 1px solid var(--border, #333333);
        background: var(--bg-light, #2A2A2A);
        color: var(--text-light, #fff);
        font-size: 18px;
        line-height: 1;
    }
    .booking-modal-content .booking-guests-btn:hover {
        border-color: var(--accent, #AD1C43);
        color: var(--accent, #AD1C43);
    }
    .booking-guests-value {
        min-width: 24px;
        text-align: center;
        font-weight: 600;
        color: var(--text-light, #fff);
    }

    @media (max-width: 1200px) {
        .booking-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 900px) {
        .booking-topbar {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .booking-tabs {
            max-width: 100%;
        }

        .booking-date-box {
            max-width: 100%;
        }

        .booking-time-panel {
            order: -1;
        }
    }

    @media (max-width: 860px) {
        .booking-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .booking-arrow {
            width: 40px;
            height: 40px;
            font-size: 18px;
        }
    }

    @media (max-width: 620px) {
        .booking-title {
            font-size: 38px;
        }

        .booking-grid {
            grid-template-columns: minmax(0, 1fr);
        }

        .booking-tabs {
            width: 100%;
        }

        .booking-tab {
            flex: 1;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const dateInput = document.getElementById('booking-date');
    const tablesTrack = document.getElementById('booking-tables-track');
    const gridViewport = document.getElementById('booking-grid-viewport');
    const emptyBlock = document.getElementById('booking-list-empty');
    const bookingPage = document.querySelector('.booking-page');
    const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const tablesUrl = bookingPage?.getAttribute('data-tables-url') || '/api/tables';
    const availabilityUrl = bookingPage?.getAttribute('data-availability-url') || '/api/table-availability';
    const reservationsUrl = bookingPage?.getAttribute('data-reservations-url') || '/api/table-reservations';

    const listViewBtn = document.getElementById('view-list');
    const schemaViewBtn = document.getElementById('view-schema');
    const listView = document.getElementById('booking-list-view');
    const schemaView = document.getElementById('booking-schema-view');

    const timeline = document.getElementById('booking-timeline');
    const timelineContent = document.getElementById('booking-timeline-content');
    const timelineWorkTrack = document.getElementById('booking-timeline-work-track');
    const timelineThumb = document.getElementById('booking-timeline-thumb');
    const timelineTicks = document.getElementById('booking-timeline-ticks');
    const timelineHours = document.getElementById('booking-timeline-hours');
    const selectedTimeLabel = document.getElementById('booking-selected-time');

    const WORK_START = 8;
    const WORK_END = 22;
    const STEP_MINUTES = 5;
    const DISPLAY_START = 6;
    const DISPLAY_END = 24;
    const PIXELS_PER_STEP = 10;
    const CAP_PX = 800;  // серая линия слева/справа от 8–22

    const START_MINUTES = WORK_START * 60;
    const END_MINUTES = WORK_END * 60;
    const TOTAL_STEPS = (END_MINUTES - START_MINUTES) / STEP_MINUTES;
    const WORK_WIDTH_PX = TOTAL_STEPS * PIXELS_PER_STEP;
    const DISPLAY_START_MINUTES = DISPLAY_START * 60;
    const DISPLAY_END_MINUTES = DISPLAY_END * 60;
    const TOTAL_DISPLAY_STEPS = (DISPLAY_END_MINUTES - DISPLAY_START_MINUTES) / STEP_MINUTES;

    function getPerPage() {
        const w = window.innerWidth;
        if (w >= 1200) return 8;
        if (w >= 860) return 6;
        if (w >= 620) return 4;
        return 2;
    }

    let tables = [];
    let busyTableIds = [];
    let currentPage = 0;
    let selectedTimeMinutes = START_MINUTES;
    let isDraggingTimeline = false;
    let activePointerId = null;
    let dragStartX = 0;
    let dragStartMinutes = START_MINUTES;
    let lastAvailabilityTimeMinutes = null;  // время, для которого уже запрашивали занятость

    listViewBtn.addEventListener('click', () => {
        listViewBtn.classList.add('booking-tab-active');
        schemaViewBtn.classList.remove('booking-tab-active');
        listView.classList.remove('d-none');
        schemaView.classList.add('d-none');
    });

    schemaViewBtn.addEventListener('click', () => {
        listViewBtn.classList.remove('booking-tab-active');
        schemaViewBtn.classList.add('booking-tab-active');
        listView.classList.add('d-none');
        schemaView.classList.remove('d-none');
    });

    document.getElementById('booking-prev').addEventListener('click', () => {
        if (currentPage <= 0) return;
        currentPage--;
        updateViewportSize();
        applyTrackTransform();
        updateArrows();
    });

    document.getElementById('booking-next').addEventListener('click', () => {
        const perPage = getPerPage();
        const totalPages = Math.ceil(tables.length / perPage) || 1;
        if (currentPage >= totalPages - 1) return;
        currentPage++;
        updateViewportSize();
        applyTrackTransform();
        updateArrows();
    });

    window.addEventListener('resize', () => {
        const perPage = getPerPage();
        const totalPages = Math.ceil(tables.length / perPage) || 1;
        if (currentPage >= totalPages) currentPage = Math.max(0, totalPages - 1);
        renderTables();
    });

    function pad(n) {
        return n < 10 ? '0' + n : '' + n;
    }

    function minutesToTimeString(totalMinutes) {
        const h = Math.floor(totalMinutes / 60);
        const m = totalMinutes % 60;
        return `${pad(h)}:${pad(m)}`;
    }

    function timeStringToMinutes(timeString) {
        const [h, m] = timeString.split(':').map(Number);
        return (h * 60) + m;
    }

    function buildTimeline() {
        timelineTicks.innerHTML = '';
        timelineHours.innerHTML = '';
        const contentWidth = 2 * CAP_PX + WORK_WIDTH_PX;
        timelineContent.style.width = `${contentWidth}px`;
        timelineHours.style.width = `${contentWidth}px`;

        timelineWorkTrack.style.left = `${CAP_PX}px`;
        timelineWorkTrack.style.width = `${WORK_WIDTH_PX}px`;

        for (let i = 0; i <= TOTAL_STEPS; i++) {
            const tick = document.createElement('span');
            tick.className = 'booking-timeline-tick';

            if (i % (60 / STEP_MINUTES) === 0) {
                tick.classList.add('major');

                const hourLabel = document.createElement('span');
                hourLabel.className = 'booking-timeline-hour';
                const hourMinutes = START_MINUTES + (i * STEP_MINUTES);
                const hour = Math.floor(hourMinutes / 60);
                hourLabel.textContent = `${hour}:00`;
                hourLabel.style.left = `${CAP_PX + i * PIXELS_PER_STEP}px`;
                timelineHours.appendChild(hourLabel);
            }

            tick.style.left = `${CAP_PX + i * PIXELS_PER_STEP}px`;
            timelineTicks.appendChild(tick);
        }
    }

    function setInitialDateAndTime() {
        const now = new Date();
        const todayStr = now.toISOString().slice(0, 10);
        dateInput.value = todayStr;

        let mins = (now.getHours() * 60) + now.getMinutes();
        mins = Math.ceil(mins / STEP_MINUTES) * STEP_MINUTES;

        if (mins < START_MINUTES) mins = START_MINUTES;
        if (mins > END_MINUTES) mins = END_MINUTES;

        selectedTimeMinutes = mins;
        updateTimelinePointer();
    }

    function updateTimelinePointer() {
        const timeString = minutesToTimeString(selectedTimeMinutes);
        const viewportWidth = timeline.getBoundingClientRect().width;
        const selectedPositionPx = CAP_PX + ((selectedTimeMinutes - START_MINUTES) / STEP_MINUTES) * PIXELS_PER_STEP;
        const translateX = (viewportWidth / 2) - selectedPositionPx;

        timelineContent.style.transform = `translateX(${translateX}px)`;
        timelineHours.style.transform = `translateX(${translateX}px)`;
        selectedTimeLabel.textContent = timeString;
    }

    function clampSelectedTime(value) {
        return Math.max(START_MINUTES, Math.min(value, END_MINUTES));
    }
    function getMinSelectableMinutes() {
        const dateStr = dateInput.value;
        if (!dateStr) return START_MINUTES;
        const now = new Date();
        const todayStr = now.toISOString().slice(0, 10);
        if (dateStr !== todayStr) return START_MINUTES;
        const mins = (now.getHours() * 60) + now.getMinutes();
        const rounded = Math.ceil(mins / STEP_MINUTES) * STEP_MINUTES;
        return Math.min(Math.max(rounded, START_MINUTES), END_MINUTES);
    }

    function endTimelineDrag() {
        if (activePointerId !== null) {
            try {
                timeline.releasePointerCapture?.(activePointerId);
            } catch (e) {
            }
        }

        isDraggingTimeline = false;
        activePointerId = null;
        timeline.removeEventListener('pointermove', onTimelinePointerMove);
        timeline.removeEventListener('pointerup', onTimelinePointerUp);
        timeline.removeEventListener('pointercancel', onTimelinePointerUp);
        window.removeEventListener('pointerup', onTimelinePointerUp);
        window.removeEventListener('pointercancel', onTimelinePointerUp);
    }

    function onTimelinePointerMove(e) {
        if (!isDraggingTimeline) return;
        if (activePointerId !== null && e.pointerId !== activePointerId) return;
        // Всегда сбрасываем drag, если кнопка уже не нажата (в т.ч. «залипший» drag)
        if (typeof e.buttons !== 'undefined' && e.buttons === 0) {
            endTimelineDrag();
            return;
        }
        // Не обновлять время при простом движении без нажатой кнопки (hover над маркером)
        if (!e.buttons) return;

        if (!timeline.hasPointerCapture(e.pointerId)) {
            endTimelineDrag();
            return;
        }

        const deltaX = e.clientX - dragStartX;
        const minutesDelta = Math.round((deltaX / PIXELS_PER_STEP)) * STEP_MINUTES;
        selectedTimeMinutes = clampSelectedTime(dragStartMinutes - minutesDelta);
        updateTimelinePointer();
    }

    function onTimelinePointerUp(e) {
        if (activePointerId !== null && e.pointerId !== activePointerId) return;
        endTimelineDrag();
        loadAvailability();
    }

    function setTimeFromViewportPosition(clientX) {
        const rect = timeline.getBoundingClientRect();
        const viewportWidth = rect.width;
        const contentX = (clientX - rect.left) - (viewportWidth / 2) + (CAP_PX + WORK_WIDTH_PX / 2) + (selectedTimeMinutes - START_MINUTES) / STEP_MINUTES * PIXELS_PER_STEP;
        const clampedX = Math.max(CAP_PX, Math.min(CAP_PX + WORK_WIDTH_PX, contentX));
        const steppedMinutes = Math.round((clampedX - CAP_PX) / PIXELS_PER_STEP) * STEP_MINUTES;
        selectedTimeMinutes = clampSelectedTime(START_MINUTES + steppedMinutes - (START_MINUTES - (clampedX - CAP_PX) / PIXELS_PER_STEP * STEP_MINUTES));
        selectedTimeMinutes = clampSelectedTime(Math.round((clampedX - CAP_PX) / PIXELS_PER_STEP) * STEP_MINUTES + START_MINUTES);
        updateTimelinePointer();
        loadAvailability();
    }

    async function loadTables() {
        try {
            const res = await fetch(tablesUrl);
            const data = await res.json();
            tables = Array.isArray(data) ? data : [];
            if (!res.ok) tables = [];
        } catch (e) {
            tables = [];
        }
        const perPage = getPerPage();
        const totalPages = Math.ceil(tables.length / perPage) || 1;
        currentPage = Math.min(currentPage, Math.max(0, totalPages - 1));
        renderTables();
        await loadAvailability();
    }

    async function loadAvailability() {
        if (!dateInput.value) return;

        const params = new URLSearchParams({
            date: dateInput.value,
            time: minutesToTimeString(selectedTimeMinutes),
        });

        const res = await fetch(availabilityUrl + '?' + params.toString());

        if (!res.ok) {
            busyTableIds = [];
        } else {
            const data = await res.json();
            busyTableIds = data.busy_table_ids || [];
        }

        renderTables();
    }

    function getVisibleTables() {
        const perPage = getPerPage();
        const start = currentPage * perPage;
        return tables.slice(start, start + perPage);
    }

    function updateArrows() {
        const prevBtn = document.getElementById('booking-prev');
        const nextBtn = document.getElementById('booking-next');
        const infoEl = document.getElementById('booking-pagination-info');
        if (!prevBtn || !nextBtn) return;
        const perPage = getPerPage();
        const totalPages = Math.ceil(tables.length / perPage) || 1;
        prevBtn.disabled = currentPage <= 0;
        nextBtn.disabled = currentPage >= totalPages - 1;
        if (infoEl && tables.length > 0) {
            infoEl.textContent = totalPages > 1 ? `Страница ${currentPage + 1} из ${totalPages}` : '';
        }
    }

    function buildCard(table) {
        const isBusy = busyTableIds.includes(table.id);
        const depositPerPerson = table.deposit_per_person || 2000;
        const card = document.createElement('div');
        card.className = 'table-card';
        card.innerHTML = `
            <div class="table-card-header">
                <div class="table-card-title-row">
                    <span class="table-card-number-badge">№${table.number}</span>
                    <span class="table-card-title">стол</span>
                </div>
                <span class="table-status ${isBusy ? 'table-status-busy' : 'table-status-free'}">
                    ${isBusy ? 'Занято' : 'Свободно'}
                </span>
            </div>
            <div class="table-card-visual ${isBusy ? 'is-disabled' : ''}"></div>
            <div class="table-card-bottom">
                <div class="table-card-meta-row">
                    <div class="table-card-meta-wrap">
                        <div class="table-card-meta-top">${depositPerPerson.toLocaleString('ru-RU')} ₽</div>
                        <div class="table-card-meta-bottom">
                            <i class="bi bi-people-fill"></i> ${table.seats_min}-${table.seats_max}
                        </div>
                    </div>
                </div>
                <button type="button" class="table-card-btn" ${isBusy ? 'disabled' : ''} data-table-id="${table.id}">
                    Забронировать
                </button>
            </div>
        `;
        if (!isBusy) {
            card.querySelector('.table-card-btn').addEventListener('click', () => openBookingModal(table));
        }
        return card;
    }

    function getViewportWidth() {
        return gridViewport && gridViewport.offsetWidth > 0 ? gridViewport.offsetWidth : 0;
    }

    function getSlideOffset() {
        if (!tablesTrack || !tablesTrack.children.length) return 0;
        const w = getViewportWidth();
        return w > 0 ? Math.floor(currentPage * w) : 0;
    }

    function applyTrackTransform() {
        if (!tables.length || !tablesTrack) return;
        const offset = getSlideOffset();
        tablesTrack.style.transform = `translateX(-${offset}px)`;
    }

    function updateViewportSize() {
        if (!gridViewport || !tablesTrack || !tablesTrack.children[currentPage]) return;
        const slide = tablesTrack.children[currentPage];
        const viewportW = getViewportWidth();
        const slideH = slide.offsetHeight;
        const perPage = getPerPage();
        const totalPages = Math.ceil(tables.length / perPage) || 1;
        if (viewportW > 0) {
            tablesTrack.style.width = (totalPages * viewportW) + 'px';
            for (let i = 0; i < tablesTrack.children.length; i++) {
                const s = tablesTrack.children[i];
                s.style.width = viewportW + 'px';
                s.style.minWidth = viewportW + 'px';
            }
        }
        gridViewport.style.height = Math.ceil(slideH) + 'px';
    }

    function renderTables() {
        if (!tablesTrack) return;
        tablesTrack.innerHTML = '';

        if (!tables.length) {
            emptyBlock.classList.remove('d-none');
            const wrap = document.querySelector('.booking-tables-wrap');
            if (wrap) wrap.style.display = 'none';
            const infoEl = document.getElementById('booking-pagination-info');
            if (infoEl) infoEl.textContent = '';
            return;
        }

        emptyBlock.classList.add('d-none');
        const wrap = document.querySelector('.booking-tables-wrap');
        if (wrap) wrap.style.display = 'flex';

        const perPage = getPerPage();
        const totalPages = Math.ceil(tables.length / perPage) || 1;

        for (let p = 0; p < totalPages; p++) {
            const pageEl = document.createElement('div');
            pageEl.className = 'booking-grid-page';
            const grid = document.createElement('div');
            grid.className = 'booking-grid';
            const start = p * perPage;
            const pageTables = tables.slice(start, start + perPage);
            pageTables.forEach(table => grid.appendChild(buildCard(table)));
            pageEl.appendChild(grid);
            tablesTrack.appendChild(pageEl);
        }

        function doLayout() {
            updateViewportSize();
            applyTrackTransform();
            if (getViewportWidth() === 0) requestAnimationFrame(doLayout);
        }
        requestAnimationFrame(doLayout);
        updateArrows();
    }

    const bookingModalEl = document.getElementById('bookingModal');
    const bookingForm = document.getElementById('booking-form');
    const bookingTableIdInput = document.getElementById('booking-table-id');
    const bookingTableInfoInput = document.getElementById('booking-table-info');
    const bookingDateDisplay = document.getElementById('booking-date-display');
    const bookingStartTimeInput = document.getElementById('booking-start-time');
    const bookingEndTimeInput = document.getElementById('booking-end-time');
    const bookingName = document.getElementById('booking-name');
    const bookingPhone = document.getElementById('booking-phone');
    const bookingEmail = document.getElementById('booking-email');
    const bookingGuests = document.getElementById('booking-guests');
    const bookingGuestsHint = document.getElementById('booking-guests-hint');
    const bookingError = document.getElementById('booking-error');
    const bookingSubmitBtn = document.getElementById('booking-submit-btn');

    const bookingModal = new bootstrap.Modal(bookingModalEl);
    const bookingGuestsValueEl = document.getElementById('booking-guests-value');
    const bookingGuestsMinusBtn = document.querySelector('.booking-guests-minus');
    const bookingGuestsPlusBtn = document.querySelector('.booking-guests-plus');

    // Маска телефона: +7 (XXX) XXX-XX-XX
    function formatPhoneInput(value) {
        const digits = (value || '').replace(/\D/g, '');
        let d = digits;
        if (d.length > 0 && d[0] === '8') d = '7' + d.slice(1);
        if (d.length > 0 && d[0] !== '7') d = '7' + d;
        d = d.slice(0, 11);
        if (d.length === 0) return '';
        if (d.length <= 1) return '+7';
        if (d.length <= 4) return '+7 (' + d.slice(1);
        if (d.length <= 7) return '+7 (' + d.slice(1, 4) + ') ' + d.slice(4);
        return '+7 (' + d.slice(1, 4) + ') ' + d.slice(4, 7) + '-' + d.slice(7, 9) + '-' + d.slice(9, 11);
    }
    function phoneDigits(displayValue) {
        return (displayValue || '').replace(/\D/g, '').replace(/^8/, '7').slice(0, 11);
    }
    bookingPhone.addEventListener('input', function() {
        const pos = this.selectionStart;
        const oldLen = this.value.length;
        const digits = phoneDigits(this.value);
        this.value = formatPhoneInput(digits);
        const newLen = this.value.length;
        let newPos = Math.max(0, pos + (newLen - oldLen));
        if (newPos > this.value.length) newPos = this.value.length;
        this.setSelectionRange(newPos, newPos);
    });

    bookingName.addEventListener('input', function() {
        this.value = (this.value || '').replace(/[^\p{L}\s\-']/gu, '');
        if (this.value.length > 255) this.value = this.value.slice(0, 255);
    });

    function updateGuestsDisplay() {
        const min = parseInt(bookingGuests.min, 10) || 1;
        const max = parseInt(bookingGuests.max, 10) || 4;
        let n = parseInt(bookingGuests.value, 10);
        if (isNaN(n)) n = min;
        n = Math.max(min, Math.min(max, n));
        bookingGuests.value = n;
        if (bookingGuestsValueEl) bookingGuestsValueEl.textContent = n;
    }
    bookingGuestsMinusBtn.addEventListener('click', function() {
        const min = parseInt(bookingGuests.min, 10) || 1;
        let n = parseInt(bookingGuests.value, 10) || min;
        if (n > min) {
            bookingGuests.value = n - 1;
            updateGuestsDisplay();
        }
    });
    bookingGuestsPlusBtn.addEventListener('click', function() {
        const max = parseInt(bookingGuests.max, 10) || 4;
        let n = parseInt(bookingGuests.value, 10) || 1;
        if (n < max) {
            bookingGuests.value = n + 1;
            updateGuestsDisplay();
        }
    });
    bookingGuests.addEventListener('input', updateGuestsDisplay);
    bookingGuests.addEventListener('change', updateGuestsDisplay);

    function openBookingModal(table) {
        const selectedTime = minutesToTimeString(selectedTimeMinutes);
        const suggestedEndMinutes = Math.min(selectedTimeMinutes + 120, END_MINUTES);
        const suggestedEndTime = minutesToTimeString(suggestedEndMinutes);

        bookingTableIdInput.value = table.id;
        bookingTableInfoInput.value = `Стол №${table.number}, ${table.seats_min}-${table.seats_max} гостей`;
        bookingDateDisplay.value = dateInput.value;
                const now = new Date();
        const todayStr = now.toISOString().slice(0, 10);
        const minStartMinutes = dateInput.value === todayStr
            ? Math.ceil(((now.getHours() * 60) + now.getMinutes()) / STEP_MINUTES) * STEP_MINUTES
            : START_MINUTES;
        const minStartTime = minutesToTimeString(Math.min(Math.max(minStartMinutes, START_MINUTES), END_MINUTES));
        bookingStartTimeInput.min = minStartTime;
        bookingStartTimeInput.max = minutesToTimeString(END_MINUTES);
        if (selectedTimeMinutes < minStartMinutes) {
            bookingStartTimeInput.value = minStartTime;
            const endMins = Math.min(minStartMinutes + 120, END_MINUTES);
            bookingEndTimeInput.value = minutesToTimeString(endMins);
        } else {
            bookingStartTimeInput.value = selectedTime;
            bookingEndTimeInput.value = suggestedEndTime;
        }

        bookingGuests.min = table.seats_min;
        bookingGuests.max = table.seats_max;
        bookingGuests.value = table.seats_min;
        updateGuestsDisplay();
        bookingGuestsHint.textContent = `Допустимое количество гостей: от ${table.seats_min} до ${table.seats_max}.`;

        bookingError.classList.add('d-none');
        bookingModal.show();
    }

    bookingForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        bookingError.classList.add('d-none');

        const tableId = bookingTableIdInput.value;
        const guests = parseInt(bookingGuests.value || '0', 10);
        const startTime = bookingStartTimeInput.value;
        const endTime = bookingEndTimeInput.value;

        const name = (bookingName.value || '').trim();
        const phone = (bookingPhone.value || '').trim();
        const phoneDig = phone.replace(/\D/g, '');
        if (!name || name.length < 2) {
            bookingError.textContent = 'Введите ваше имя (минимум 2 символа).';
            bookingError.classList.remove('d-none');
            return;
        }
        if (/[0-9]/.test(name)) {
            bookingError.textContent = 'В имени допустимы только буквы, пробел, дефис или апостроф.';
            bookingError.classList.remove('d-none');
            return;
        }
        if (phoneDig.length < 10) {
            bookingError.textContent = 'Введите корректный номер телефона (минимум 10 цифр).';
            bookingError.classList.remove('d-none');
            return;
        }
        if (!tableId || !dateInput.value || !startTime || !endTime) {
            bookingError.textContent = 'Заполните дату и время бронирования.';
            bookingError.classList.remove('d-none');
            return;
        }

        if (timeStringToMinutes(endTime) <= timeStringToMinutes(startTime)) {
            bookingError.textContent = 'Время окончания должно быть позже времени начала.';
            bookingError.classList.remove('d-none');
            return;
        }

        const startAt = new Date(`${dateInput.value}T${startTime}`);
        if (startAt.getTime() < Date.now()) {
            bookingError.textContent = 'Нельзя забронировать столик на прошедшее время.';
            bookingError.classList.remove('d-none');
            return;
        }

        bookingSubmitBtn.disabled = true;
        bookingSubmitBtn.textContent = 'Отправка...';

        const payload = {
            table_id: tableId,
            guest_name: name,
            guest_phone: bookingPhone.value.trim(),
            guest_email: (bookingEmail.value || '').trim() || null,
            guests_count: guests,
            start_at: `${dateInput.value} ${startTime}`,
            end_at: `${dateInput.value} ${endTime}`,
        };

        try {
            const res = await fetch(reservationsUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload),
            });

            const data = await res.json();

            if (!res.ok) {
                const firstError = data.errors && typeof data.errors === 'object'
                    ? Object.values(data.errors).flat()[0]
                    : null;
                bookingError.textContent = firstError || data.message || 'Не удалось создать бронь.';
                bookingError.classList.remove('d-none');
            } else {
                await loadAvailability();
                bookingForm.reset();
                bookingModal.hide();
            }
        } catch (err) {
            bookingError.textContent = 'Произошла ошибка сети. Попробуйте ещё раз.';
            bookingError.classList.remove('d-none');
        } finally {
            bookingSubmitBtn.disabled = false;
            bookingSubmitBtn.textContent = 'Забронировать';
        }
    });

    dateInput.addEventListener('change', () => {
        selectedTimeMinutes = clampSelectedTime(selectedTimeMinutes);
        updateTimelinePointer();
        loadAvailability();
    });

    timeline.addEventListener('pointerdown', (e) => {
        if (e.button !== 0) return;
        isDraggingTimeline = true;
        activePointerId = e.pointerId;
        dragStartX = e.clientX;
        dragStartMinutes = selectedTimeMinutes;
        timeline.setPointerCapture?.(e.pointerId);
        timeline.addEventListener('pointermove', onTimelinePointerMove);
        timeline.addEventListener('pointerup', onTimelinePointerUp);
        timeline.addEventListener('pointercancel', onTimelinePointerUp);
        window.addEventListener('pointerup', onTimelinePointerUp);
        window.addEventListener('pointercancel', onTimelinePointerUp);
        e.preventDefault();
    });

    timeline.addEventListener('lostpointercapture', endTimelineDrag);
    window.addEventListener('blur', endTimelineDrag);

    buildTimeline();
    setInitialDateAndTime();
    loadTables();
});
</script>