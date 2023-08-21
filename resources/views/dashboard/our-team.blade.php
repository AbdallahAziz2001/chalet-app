@extends('dashboard.parent')

@section('title', 'Our Team')
@section('icon', '')
@section('page-large-name', 'Our Team')

@section('page-path')
    <li class="breadcrumb-item active">Our Team</li>
@endsection

@section('styles')
    <style>
        [x-cloak] {
            display: none
        }
    </style>
    <style>
        /* ! tailwindcss v3.3.2 | MIT License | https://tailwindcss.com */
        *,
        ::after,
        ::before {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb
        }

        ::after,
        ::before {
            --tw-content: ''
        }

        html {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            -moz-tab-size: 4;
            tab-size: 4;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-feature-settings: normal;
            font-variation-settings: normal
        }

        body {
            margin: 0;
            line-height: inherit
        }

        hr {
            height: 0;
            color: inherit;
            border-top-width: 1px
        }

        abbr:where([title]) {
            -webkit-text-decoration: underline dotted;
            text-decoration: underline dotted
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: inherit;
            font-weight: inherit
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        b,
        strong {
            font-weight: bolder
        }

        code,
        kbd,
        pre,
        samp {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 1em
        }

        small {
            font-size: 80%
        }

        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline
        }

        sub {
            bottom: -.25em
        }

        sup {
            top: -.5em
        }

        table {
            text-indent: 0;
            border-color: inherit;
            border-collapse: collapse
        }

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit;
            font-size: 100%;
            font-weight: inherit;
            line-height: inherit;
            color: inherit;
            margin: 0;
            padding: 0
        }

        button,
        select {
            text-transform: none
        }

        [type=button],
        [type=reset],
        [type=submit],
        button {
            -webkit-appearance: button;
            background-color: transparent;
            background-image: none
        }

        :-moz-focusring {
            outline: auto
        }

        :-moz-ui-invalid {
            box-shadow: none
        }

        progress {
            vertical-align: baseline
        }

        ::-webkit-inner-spin-button,
        ::-webkit-outer-spin-button {
            height: auto
        }

        [type=search] {
            -webkit-appearance: textfield;
            outline-offset: -2px
        }

        ::-webkit-search-decoration {
            -webkit-appearance: none
        }

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            font: inherit
        }

        summary {
            display: list-item
        }

        blockquote,
        dd,
        dl,
        figure,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        hr,
        p,
        pre {
            margin: 0
        }

        fieldset {
            margin: 0;
            padding: 0
        }

        legend {
            padding: 0
        }

        menu,
        ol,
        ul {
            list-style: none;
            margin: 0;
            padding: 0
        }

        textarea {
            resize: vertical
        }

        input::placeholder,
        textarea::placeholder {
            opacity: 1;
            color: #9ca3af
        }

        [role=button],
        button {
            cursor: pointer
        }

        :disabled {
            cursor: default
        }

        audio,
        canvas,
        embed,
        iframe,
        img,
        object,
        svg,
        video {
            display: block;
            vertical-align: middle
        }

        img,
        video {
            max-width: 90%;
            height: auto
        }

        [hidden] {
            display: none
        }

        *,
        ::before,
        ::after {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia:
        }

        ::-webkit-backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia:
        }

        ::backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia:
        }

        .container {
            width: 100%
        }

        @media (min-width: 640px) {
            .container {
                max-width: 640px
            }
        }

        @media (min-width: 768px) {
            .container {
                max-width: 768px
            }
        }

        @media (min-width: 1024px) {
            .container {
                max-width: 1024px
            }
        }

        @media (min-width: 1280px) {
            .container {
                max-width: 1280px
            }
        }

        @media (min-width: 1536px) {
            .container {
                max-width: 1536px
            }
        }

        .fixed {
            position: fixed
        }

        .relative {
            position: relative
        }

        .inset-x-4 {
            left: 1rem;
            right: 1rem
        }

        .bottom-20 {
            bottom: 5rem
        }

        .z-50 {
            z-index: 50
        }

        .-mx-2 {
            margin-left: -0.5rem;
            margin-right: -0.5rem
        }

        .mx-2 {
            margin-left: 0.5rem;
            margin-right: 0.5rem
        }

        .mx-4 {
            margin-left: 1rem;
            margin-right: 1rem
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .my-6 {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem
        }

        .mr-4 {
            margin-right: 1rem
        }

        .mt-2 {
            margin-top: 0.5rem
        }

        .mt-3 {
            margin-top: 0.75rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .mt-6 {
            margin-top: 1.5rem
        }

        .mt-8 {
            margin-top: 2rem
        }

        .inline-block {
            display: inline-block
        }

        .flex {
            display: flex
        }

        .grid {
            display: grid
        }

        .aspect-square {
            aspect-ratio: 1 / 1
        }

        .h-5 {
            height: 1.25rem
        }

        .h-6 {
            height: 1.5rem
        }

        .h-7 {
            height: 1.75rem
        }

        .min-h-screen {
            min-height: 80vh
        }

        .w-5 {
            width: 1.25rem
        }

        .w-6 {
            width: 1.5rem
        }

        .w-auto {
            width: auto
        }

        .w-full {
            width: 100%
        }

        .max-w-2xl {
            max-width: 42rem
        }

        .translate-x-0 {
            --tw-translate-x: 0px;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
        }

        .-translate-x-20 {
            --tw-translate-x: -5rem;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
        }

        .transform {
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr))
        }

        .flex-col {
            flex-direction: column
        }

        .items-start {
            align-items: flex-start
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .justify-between {
            justify-content: space-between
        }

        .gap-8 {
            gap: 2rem
        }

        .space-x-6> :not([hidden])~ :not([hidden]) {
            --tw-space-x-reverse: 0;
            margin-right: calc(1.5rem * var(--tw-space-x-reverse));
            margin-left: calc(1.5rem * calc(1 - var(--tw-space-x-reverse)))
        }

        .rounded-lg {
            border-radius: 0.5rem
        }

        .rounded-md {
            border-radius: 0.375rem
        }

        .rounded-xl {
            border-radius: 0.75rem
        }

        .border {
            border-width: 1px
        }

        .border-blue-600 {
            --tw-border-opacity: 1;
            border-color: rgb(37 99 235 / var(--tw-border-opacity))
        }

        .bg-blue-600 {
            --tw-bg-opacity: 1;
            background-color: rgb(37 99 235 / var(--tw-bg-opacity))
        }

        .bg-gray-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(243 244 246 / var(--tw-bg-opacity))
        }

        .bg-gray-800 {
            --tw-bg-opacity: 1;
            background-color: rgb(31 41 55 / var(--tw-bg-opacity))
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity))
        }

        .fill-current {
            fill: currentColor
        }

        .object-cover {
            object-fit: cover
        }

        .p-1 {
            padding: 0.25rem
        }

        .px-1 {
            padding-left: 0.25rem;
            padding-right: 0.25rem
        }

        .px-1\.5 {
            padding-left: 0.375rem;
            padding-right: 0.375rem
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .px-8 {
            padding-left: 2rem;
            padding-right: 2rem
        }

        .py-10 {
            padding-top: 1px;
            padding-bottom: 1px
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem
        }

        .py-6 {
            padding-top: 26.5rem;
            padding-bottom: 26.5rem
        }

        .text-center {
            text-align: center
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem
        }

        .font-medium {
            font-weight: 500
        }

        .font-semibold {
            font-weight: 600
        }

        .capitalize {
            text-transform: capitalize
        }

        .tracking-wide {
            letter-spacing: 0.025em
        }

        .text-blue-600 {
            --tw-text-opacity: 1;
            color: rgb(37 99 235 / var(--tw-text-opacity))
        }

        .text-gray-100 {
            --tw-text-opacity: 1;
            color: rgb(243 244 246 / var(--tw-text-opacity))
        }

        .text-gray-300 {
            --tw-text-opacity: 1;
            color: rgb(209 213 219 / var(--tw-text-opacity))
        }

        .text-gray-500 {
            --tw-text-opacity: 1;
            color: rgb(107 114 128 / var(--tw-text-opacity))
        }

        .text-gray-600 {
            --tw-text-opacity: 1;
            color: rgb(75 85 99 / var(--tw-text-opacity))
        }

        .text-gray-700 {
            --tw-text-opacity: 1;
            color: rgb(55 65 81 / var(--tw-text-opacity))
        }

        .text-gray-800 {
            --tw-text-opacity: 1;
            color: rgb(31 41 55 / var(--tw-text-opacity))
        }

        .text-white {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }

        .underline {
            -webkit-text-decoration-line: underline;
            text-decoration-line: underline
        }

        .opacity-100 {
            opacity: 1
        }

        .opacity-0 {
            opacity: 0
        }

        .transition-colors {
            transition-property: color, background-color, border-color, fill, stroke, -webkit-text-decoration-color;
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, -webkit-text-decoration-color;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms
        }

        .transition {
            transition-property: color, background-color, border-color, fill, stroke, opacity, box-shadow, transform, filter, -webkit-text-decoration-color, -webkit-backdrop-filter;
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-text-decoration-color, -webkit-backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms
        }

        .duration-300 {
            transition-duration: 300ms
        }

        .duration-200 {
            transition-duration: 200ms
        }

        .ease-in {
            transition-timing-function: cubic-bezier(0.4, 0, 1, 1)
        }

        .hover\:bg-blue-600:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(37 99 235 / var(--tw-bg-opacity))
        }

        .hover\:bg-gray-600:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(75 85 99 / var(--tw-bg-opacity))
        }

        .hover\:bg-gray-700:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(55 65 81 / var(--tw-bg-opacity))
        }

        .hover\:bg-opacity-25:hover {
            --tw-bg-opacity: 0.25
        }

        .hover\:text-blue-400:hover {
            --tw-text-opacity: 1;
            color: rgb(96 165 250 / var(--tw-text-opacity))
        }

        .hover\:text-blue-500:hover {
            --tw-text-opacity: 1;
            color: rgb(59 130 246 / var(--tw-text-opacity))
        }

        .hover\:text-white:hover {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }

        .focus\:border-blue-500:focus {
            --tw-border-opacity: 1;
            border-color: rgb(59 130 246 / var(--tw-border-opacity))
        }

        .focus\:outline-none:focus {
            outline: 2px solid transparent;
            outline-offset: 2px
        }

        .focus\:ring:focus {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)
        }

        .focus\:ring-blue-300:focus {
            --tw-ring-opacity: 1;
            --tw-ring-color: rgb(147 197 253 / var(--tw-ring-opacity))
        }

        .focus\:ring-opacity-40:focus {
            --tw-ring-opacity: 0.4
        }

        :is(.dark .dark\:border-blue-400) {
            --tw-border-opacity: 1;
            border-color: rgb(96 165 250 / var(--tw-border-opacity))
        }

        :is(.dark .dark\:bg-gray-900) {
            --tw-bg-opacity: 1;
            background-color: rgb(17 24 39 / var(--tw-bg-opacity))
        }

        :is(.dark .dark\:text-blue-400) {
            --tw-text-opacity: 1;
            color: rgb(96 165 250 / var(--tw-text-opacity))
        }

        :is(.dark .dark\:text-gray-300) {
            --tw-text-opacity: 1;
            color: rgb(209 213 219 / var(--tw-text-opacity))
        }

        :is(.dark .dark\:text-white) {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }

        :is(.dark .dark\:hover\:text-blue-400:hover) {
            --tw-text-opacity: 1;
            color: rgb(96 165 250 / var(--tw-text-opacity))
        }

        :is(.dark .dark\:hover\:text-white:hover) {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }

        @media (min-width: 640px) {
            .sm\:left-12 {
                left: 3rem
            }

            .sm\:h-6 {
                height: 1.5rem
            }

            .sm\:h-9 {
                height: 2.25rem
            }

            .sm\:w-6 {
                width: 1.5rem
            }

            .sm\:w-full {
                width: 100%
            }

            .sm\:max-w-md {
                max-width: 28rem
            }
        }

        @media (min-width: 768px) {
            .md\:mx-8 {
                margin-left: 2rem;
                margin-right: 2rem
            }

            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }

            .md\:px-12 {
                padding-left: 3rem;
                padding-right: 3rem
            }

            .md\:py-3 {
                padding-top: 0.75rem;
                padding-bottom: 0.75rem
            }
        }

        @media (min-width: 1024px) {
            .lg\:text-3xl {
                font-size: 1.875rem;
                line-height: 2.25rem
            }
        }

        @media (min-width: 1280px) {
            .xl\:mt-16 {
                margin-top: 4rem
            }

            .xl\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr))
            }

            .xl\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }
        }
    </style>
@endsection

@section('content')

    <body x-data="{ open: true, darkMode: false }" :class="darkMode ? 'dark' : ''" class="">
        <div class="relative min-h-screen bg-gray-100 dark:bg-gray-900">
            <section class="bg-white dark:bg-gray-900">
                <div class="container px-6 py-10 mx-auto">

                    <div class="grid grid-cols-1 gap-8 mt-8 xl:mt-16 md:grid-cols-2 xl:grid-cols-2">
                        <div class="flex flex-col items-center">
                            <img class="object-cover w-full rounded-xl aspect-square"
                                src="{{ asset('dashboard/dist/img/team/Abdallah_Aziz.jpg') }}"
                                alt="">
                            <h1 class="mt-4 text-2xl font-semibold text-gray-700 capitalize dark:text-white">Abdallah Aziz
                            </h1>
                            <p class="mt-2 text-gray-500 capitalize dark:text-gray-300">Lead Web Back-End Developer</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <img class="object-cover w-full rounded-xl aspect-square"
                                src="{{ asset('dashboard/dist/img/team/Yousef_Ammar.jpg') }}"
                                alt="">
                            <h1 class="mt-4 text-2xl font-semibold text-gray-700 capitalize dark:text-white">Yousef Ammar
                            </h1>
                            <p class="mt-2 text-gray-500 capitalize dark:text-gray-300">Web Back-End Developer</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <img class="object-cover w-full rounded-xl aspect-square"
                                src="{{ asset('dashboard/dist/img/team/Ahmed_AlSakani.jpg') }}"
                                alt="">
                            <h1 class="mt-4 text-2xl font-semibold text-gray-700 capitalize dark:text-white">Ahmed Al-Sakani
                            </h1>
                            <p class="mt-2 text-gray-500 capitalize dark:text-gray-300">UIUX Dedign</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <img class="object-cover w-full rounded-xl aspect-square"
                                src="{{ asset('dashboard/dist/img/team/Anas_AlDerfil.jpg') }}"
                                alt="">
                            <h1 class="mt-4 text-2xl font-semibold text-gray-700 capitalize dark:text-white">Anas Al-Derfil
                            </h1>
                            <p class="mt-2 text-gray-500 capitalize dark:text-gray-300">Mobile Developer</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection

    @section('scripts')
    @endsection
