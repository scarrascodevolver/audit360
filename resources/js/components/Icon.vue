<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="1.7"
        stroke-linecap="round"
        stroke-linejoin="round"
        aria-hidden="true"
    >
        <template v-for="(d, i) in paths" :key="i">
            <path v-if="typeof d === 'string'" :d="d" />
            <component v-else :is="d.tag" v-bind="d.attrs" />
        </template>
    </svg>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    name: { type: String, required: true },
});

const ICONS = {
    building: [
        'M3 21h18',
        'M5 21V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v16',
        'M15 21V9h2a2 2 0 0 1 2 2v10',
        'M9 7h2 M9 11h2 M9 15h2',
    ],
    scale: [
        'M12 3v18',
        'M8 21h8',
        'M5 6h14',
        'M7 6 4 12a3 3 0 0 0 6 0L7 6z',
        'M17 6l-3 6a3 3 0 0 0 6 0l-3-6z',
    ],
    calculator: [
        { tag: 'rect', attrs: { x: 4, y: 2, width: 16, height: 20, rx: 2 } },
        'M8 6h8',
        'M8 11h.01 M12 11h.01 M16 11h.01',
        'M8 15h.01 M12 15h.01 M16 15v3',
        'M8 18h4',
    ],
    shield: [
        'M12 3l7 3v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3z',
        'M9 12l2 2 4-4',
    ],
    trending: [
        'M3 17l6-6 4 4 7-7',
        'M14 7h6v6',
    ],
    globe: [
        { tag: 'circle', attrs: { cx: 12, cy: 12, r: 9 } },
        'M3 12h18',
        'M12 3a14 14 0 0 1 0 18 14 14 0 0 1 0-18z',
    ],
    check: [
        'M5 12l4 4L19 6',
    ],
    phone: [
        'M5 4h3l2 5-2 1a11 11 0 0 0 5 5l1-2 5 2v3a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z',
    ],
    users: [
        { tag: 'circle', attrs: { cx: 9, cy: 8, r: 3 } },
        'M3 20a6 6 0 0 1 12 0',
        'M16 5.5a3 3 0 0 1 0 5.5',
        'M17 14a6 6 0 0 1 4 6',
    ],
    upload: [
        'M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5z',
        'M14 3v5h5',
        'M12 18v-6',
        'M9.5 14.5 12 12l2.5 2.5',
    ],
    folder: [
        'M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z',
    ],
    document: [
        'M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5z',
        'M14 3v5h5',
        'M9 13h6 M9 17h6',
    ],
    clock: [
        { tag: 'circle', attrs: { cx: 12, cy: 12, r: 9 } },
        'M12 7v5l3 2',
    ],
    stopwatch: [
        'M9 2h6',
        'M12 2v2',
        { tag: 'circle', attrs: { cx: 12, cy: 13, r: 8 } },
        'M12 13l3-2.5',
        'M18.5 6.5l1.5-1.5',
    ],
    headset: [
        'M4 13v-1a8 8 0 0 1 16 0v1',
        'M4 14a2 2 0 0 1 2-2h1v6H6a2 2 0 0 1-2-2v-2z',
        'M20 14a2 2 0 0 0-2-2h-1v6h1a2 2 0 0 0 2-2v-2z',
        'M20 18v1a3 3 0 0 1-3 3h-2',
    ],
    target: [
        { tag: 'circle', attrs: { cx: 12, cy: 12, r: 8 } },
        { tag: 'circle', attrs: { cx: 12, cy: 12, r: 4 } },
        { tag: 'circle', attrs: { cx: 12, cy: 12, r: 0.6 } },
    ],
    bulb: [
        'M9 18h6',
        'M10 21h4',
        'M12 3a6 6 0 0 1 4 10.5c-.8.7-1 1.2-1 2.5H9c0-1.3-.2-1.8-1-2.5A6 6 0 0 1 12 3z',
    ],
    arrow: [
        'M5 12h14',
        'M13 6l6 6-6 6',
    ],
    alert: [
        'M12 4 3 19h18L12 4z',
        'M12 10v4',
        'M12 17h.01',
    ],
    wrench: [
        'M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z',
    ],
    sparkles: [
        'M12 4l1.5 4.5L18 10l-4.5 1.5L12 16l-1.5-4.5L6 10l4.5-1.5L12 4z',
        'M18.5 15l.7 2 2 .7-2 .7-.7 2-.7-2-2-.7 2-.7.7-2z',
    ],
    euro: [
        { tag: 'circle', attrs: { cx: 12, cy: 12, r: 9 } },
        'M15 9.5a4 4 0 1 0 0 5',
        'M8.5 11h4.5 M8.5 13h4.5',
    ],
    bolt: [
        'M13 2 4 14h6l-1 8 9-12h-6l1-8z',
    ],
};

const paths = computed(() => ICONS[props.name] || []);
</script>
