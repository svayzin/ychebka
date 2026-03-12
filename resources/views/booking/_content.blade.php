<div class="booking-page">
    <div class="container-exact py-5">
    <h2 class="booking-title">Бронирование столика</h2>
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
                <div id="tables-container" class="booking-grid"></div>
                <div id="booking-list-empty" class="booking-empty d-none">
                    Столики не найдены.
                </div>
            </div>

            <div id="booking-schema-view" class="d-none">
                <div class="booking-schema-placeholder">
                    Схема зала появится позже. Сейчас доступен режим списка.
                </div>
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
                        <input type="text" id="booking-name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Телефон *</label>
                        <input type="text" id="booking-phone" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" id="booking-email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Гостей *</label>
                        <input type="number" id="booking-guests" class="form-control" min="1" max="4" required>
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
    }

    .booking-shell {
        background: #bfbfbf;
        border-radius: 28px;
        padding: 28px 28px 22px;
        max-width: 1280px;
        margin: 0 auto;
    }

    .booking-title {
        line-height: 1;
        margin-bottom: 26px;
        font-family: "Adieu-Black", serif;
    }

    .booking-topbar {
        display: grid;
        grid-template-columns: 250px minmax(0, 1fr) 160px;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
    }

    .booking-tabs {
        display: inline-flex;
        background: #ededed;
        border-radius: 999px;
        overflow: hidden;
        height: 50px;
        width: 240px;
    }

    .booking-tab {
        border: none;
        background: transparent;
        color: #c32355;
        font-size: 20px;
        padding: 0 26px;
        min-width: 90px;
    }

    .booking-tab-active {
        background: #c32355;
        color: #fff;
    }

    .booking-date-box {
        width: 160px;
        height: 50px;
        background: #ededed;
        border-radius: 14px;
        display: flex;
        align-items: center;
        padding: 0 12px;
    }

    .booking-date-input {
        width: 100%;
        border: none;
        background: transparent;
        color: #111;
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
    }

    .booking-selected-time {
        position: absolute;
        top: 0;
        left: 0;
        transform: translateX(-50%);
        color: #111;
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
        background: rgba(40, 40, 40, 0.15);
    }

    .booking-timeline-work-track {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 0;
        height: 3px;
        background: rgba(20, 20, 20, 0.55);
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
        background: #111;
        border-radius: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 0 0 0 4px rgba(17, 17, 17, 0.1);
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
        color: #2e2e2e;
        font-size: 12px;
        white-space: nowrap;
    }

    .booking-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .booking-empty {
        color: #222;
        padding: 20px 0;
    }

    .booking-schema-placeholder {
        background: #ececec;
        border-radius: 18px;
        padding: 80px 20px;
        text-align: center;
        color: #444;
    }

    .table-card {
        background: #7a7a7a;
        border-radius: 18px;
        padding: 12px 12px 14px;
        min-height: 225px;
        display: flex;
        flex-direction: column;
    }

    .table-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 8px;
    }

    .table-card-title {
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        line-height: 1.2;
    }

    .table-card-subtitle {
        color: #d7d7d7;
        font-size: 12px;
        margin-top: 2px;
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
        background: #6ee06c;
        color: #1f4f18;
    }

    .table-status-busy {
        background: #c32355;
        color: #fff;
    }

    .table-card-visual {
        height: 86px;
        margin: 8px 0 12px;
        background-image: url("/images/table/table-two.svg");
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        cursor: pointer;
        transition: transform 0.2s ease, opacity 0.2s ease;
    }

    .table-card-visual:hover {
        transform: scale(1.04);
    }

    .table-card-visual.is-disabled {
        cursor: not-allowed;
        opacity: 0.55;
    }

    .table-card-bottom {
        margin-top: auto;
    }

    .table-card-info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 10px;
    }

    .table-card-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 24px;
        padding: 0 8px;
        background: #c32355;
        color: #fff;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .table-card-meta {
        color: #fff;
        text-align: right;
        font-size: 13px;
        line-height: 1.2;
    }

    .table-card-meta-top {
        font-weight: 700;
    }

    .table-card-meta-bottom {
        color: #ececec;
        font-size: 12px;
        margin-top: 2px;
    }

    .booking-modal-content {
        background: #f0f0f0;
        color: #222;
        border-radius: 20px;
    }

    @media (max-width: 1100px) {
        .booking-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 860px) {
        .booking-topbar {
            grid-template-columns: 1fr;
        }

        .booking-date-box {
            width: 100%;
        }

        .booking-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 580px) {
        .booking-shell {
            padding: 18px;
        }

        .booking-title {
            font-size: 38px;
        }

        .booking-grid {
            grid-template-columns: 1fr;
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
    const tablesContainer = document.getElementById('tables-container');
    const emptyBlock = document.getElementById('booking-list-empty');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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

    let tables = [];
    let busyTableIds = [];
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
        selectedTimeLabel.style.left = `${viewportWidth / 2}px`;
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
                // ignore if capture was already released
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
        const res = await fetch('/api/tables');
        tables = await res.json();
        renderTables();
        await loadAvailability();
    }

    async function loadAvailability() {
        console.log('loadAvailability called', new Error().stack);
        if (!dateInput.value) return;

        const params = new URLSearchParams({
            date: dateInput.value,
            time: minutesToTimeString(selectedTimeMinutes),
        });

        const res = await fetch('/api/table-availability?' + params.toString());

        if (!res.ok) {
            busyTableIds = [];
        } else {
            const data = await res.json();
            busyTableIds = data.busy_table_ids || [];
        }

        renderTables();
    }

    function renderTables() {
        tablesContainer.innerHTML = '';

        if (!tables.length) {
            emptyBlock.classList.remove('d-none');
            return;
        }

        emptyBlock.classList.add('d-none');

        tables.forEach(table => {
            const isBusy = busyTableIds.includes(table.id);
            const depositPerPerson = table.deposit_per_person || 2000;

            const card = document.createElement('div');
            card.className = 'table-card';

            card.innerHTML = `
                <div class="table-card-header">
                    <div>
                        <div class="table-card-title">Стол №${table.number}</div>
                        <div class="table-card-subtitle">${table.seats_min}-${table.seats_max} гостей</div>
                    </div>
                    <span class="table-status ${isBusy ? 'table-status-busy' : 'table-status-free'}">
                        ${isBusy ? 'Занято' : 'Свободно'}
                    </span>
                </div>

                <div class="table-card-visual ${isBusy ? 'is-disabled' : ''}"></div>

                <div class="table-card-bottom">
                    <div class="table-card-info-row">
                        <div class="table-card-badge">№${table.number}</div>
                        <div class="table-card-meta">
                            <div class="table-card-meta-top">${depositPerPerson.toLocaleString('ru-RU')} ₽</div>
                            <div class="table-card-meta-bottom">
                                <i class="bi bi-people-fill"></i> ${table.seats_min}-${table.seats_max}
                            </div>
                        </div>
                    </div>
                </div>
            `;

            if (!isBusy) {
                card.querySelector('.table-card-visual').addEventListener('click', () => openBookingModal(table));
            }

            tablesContainer.appendChild(card);
        });
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

        bookingGuests.value = table.seats_min;
        bookingGuests.min = table.seats_min;
        bookingGuests.max = table.seats_max;
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
            guest_name: bookingName.value,
            guest_phone: bookingPhone.value,
            guest_email: bookingEmail.value || null,
            guests_count: guests,
            start_at: `${dateInput.value} ${startTime}`,
            end_at: `${dateInput.value} ${endTime}`,
        };

        try {
            const res = await fetch('/api/table-reservations', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload),
            });

            const data = await res.json();

            if (!res.ok) {
                bookingError.textContent = data.message || 'Не удалось создать бронь.';
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