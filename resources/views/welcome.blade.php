<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $app_name ?? 'RuralEmpower' }} - Serene &amp; Professional Impact</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        html {
            scroll-behavior: smooth;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-scroll {
            animation: scroll 35s linear infinite;
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white font-display antialiased overflow-x-hidden selection:bg-primary selection:text-background-dark">
    <nav class="fixed top-0 left-0 right-0 z-50 border-b border-white/10 bg-[#0a192f]/90 backdrop-blur-md">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-3">
                    <x-application-logo class="flex items-center justify-center text-primary" />
                </div>
                <div class="hidden md:flex items-center gap-8">
                    <a class="text-gray-300 hover:text-white text-sm font-semibold transition-colors"
                        href="#mission">Who We Are</a>
                    <a class="text-gray-300 hover:text-white text-sm font-semibold transition-colors"
                        href="#focus">Focus Areas</a>
                    <a class="text-gray-300 hover:text-white text-sm font-semibold transition-colors"
                        href="#impact">Impact</a>
                    <a class="text-gray-300 hover:text-white text-sm font-semibold transition-colors"
                        href="{{ route('library.index') }}">Library</a>
                    <a class="text-gray-300 hover:text-white text-sm font-semibold transition-colors"
                        href="#news">Updates</a>
                </div>
                <div class="flex items-center gap-4">
                    <button
                        class="hidden sm:flex h-10 px-5 items-center justify-center rounded-md border border-white/20 hover:border-white/40 bg-transparent text-white text-sm font-bold transition-all">
                        Partner With Us
                    </button>
                    <button
                        class="flex h-10 px-6 items-center justify-center rounded-md bg-primary hover:bg-primary-hover text-[#0a192f] text-sm font-bold shadow-[0_0_15px_rgba(100,181,246,0.3)] transition-all transform hover:scale-105">
                        Donate
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <section class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-background-dark/40 to-background-dark z-10">
            </div>
            <div class="w-full h-full bg-cover bg-center" data-alt="Cinematic wide shot of rural landscape"
                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuA8k8VED7ffVGu5FEcmJsE1m8cug6ZnN-twPt3QBqRytN8zMaPHkUw3jISDbkO_PEjguTOdvBpsh8n38OO_U8hpg6QNVBFvgIWTba2tsW8zYNReWpoaKr3G2CrqvzkoyGcQ-b4Bu1Xy8hADhjLzNxUhfy4A9P1mAECm_kW0a_J6PiZyrBusHfntMnBvLzug_sVmL5uF5vLgUg2nYPbfBkLFegIXr7XRs83zfzJ50HFwBsqk7z6UtQuyrSaJm6zr-aTvOrKhMsNjxQ');">
            </div>
        </div>
        <div class="relative z-20 container mx-auto px-4 flex flex-col items-center text-center max-w-5xl">
            <div
                class="mb-6 inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 backdrop-blur-sm">
                <span class="size-2 rounded-full bg-primary animate-pulse"></span>
                <span class="text-xs font-bold text-primary tracking-wider uppercase">Join the Movement</span>
            </div>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white tracking-tighter leading-tight mb-8">
                Empowering Rural Communities <br />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary via-blue-200 to-white">for a
                    Sustainable Future</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-300 font-medium max-w-2xl mb-10 leading-relaxed">
                Creating opportunities through education, livelihood, and innovation. We bridge the gap between intent
                and impact.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                <button
                    class="h-14 px-8 rounded-md bg-primary text-[#0a192f] text-base font-bold tracking-wide hover:bg-primary-hover transition-colors shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                    Get Involved
                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </button>
                <button
                    class="h-14 px-8 rounded-md bg-white/5 border border-white/10 text-white text-base font-bold tracking-wide hover:bg-white/10 backdrop-blur-sm transition-colors flex items-center justify-center gap-2">
                    Our Programs
                </button>
            </div>
            <div class="mt-20 mb-24 w-full grid grid-cols-2 md:grid-cols-5 gap-8 items-start">
                <!-- Item 1 -->
                <div class="flex flex-col items-center">
                    <div class="w-32 h-32 md:w-36 md:h-36 bg-yellow-400 flex items-center justify-center mb-4 transition-transform hover:scale-105 shadow-xl shadow-yellow-400/20"
                        style="border-radius: 54% 46% 38% 62% / 46% 41% 59% 54%;">
                        <span class="text-3xl md:text-3xl font-black text-slate-900">500+</span>
                    </div>
                    <span
                        class="text-sm md:text-base font-bold text-white text-center leading-tight max-w-[150px]">Villages
                        Reached</span>
                </div>

                <!-- Item 2 -->
                <div class="flex flex-col items-center">
                    <div class="w-32 h-32 md:w-36 md:h-36 bg-yellow-400 flex items-center justify-center mb-4 transition-transform hover:scale-105 shadow-xl shadow-yellow-400/20 delay-75"
                        style="border-radius: 41% 59% 49% 51% / 46% 42% 58% 54%;">
                        <span class="text-3xl md:text-3xl font-black text-slate-900">100k+</span>
                    </div>
                    <span
                        class="text-sm md:text-base font-bold text-white text-center leading-tight max-w-[150px]">Families
                        Empowered</span>
                </div>

                <!-- Item 3 -->
                <div class="flex flex-col items-center">
                    <div class="w-32 h-32 md:w-36 md:h-36 bg-yellow-400 flex items-center justify-center mb-4 transition-transform hover:scale-105 shadow-xl shadow-yellow-400/20 delay-100"
                        style="border-radius: 64% 36% 27% 73% / 55% 58% 42% 45%;">
                        <span class="text-3xl md:text-3xl font-black text-slate-900">45k+</span>
                    </div>
                    <span
                        class="text-sm md:text-base font-bold text-white text-center leading-tight max-w-[150px]">Women
                        Supported</span>
                </div>

                <!-- Item 4 -->
                <div class="flex flex-col items-center">
                    <div class="w-32 h-32 md:w-36 md:h-36 bg-yellow-400 flex items-center justify-center mb-4 transition-transform hover:scale-105 shadow-xl shadow-yellow-400/20 delay-150"
                        style="border-radius: 51% 49% 26% 74% / 53% 51% 49% 47%;">
                        <span class="text-3xl md:text-3xl font-black text-slate-900">25k+</span>
                    </div>
                    <span
                        class="text-sm md:text-base font-bold text-white text-center leading-tight max-w-[150px]">Youth
                        Trained</span>
                </div>

                <!-- Item 5 -->
                <div class="flex flex-col items-center col-span-2 md:col-span-1">
                    <div class="w-32 h-32 md:w-36 md:h-36 bg-yellow-400 flex items-center justify-center mb-4 transition-transform hover:scale-105 shadow-xl shadow-yellow-400/20 delay-200"
                        style="border-radius: 62% 38% 30% 70% / 57% 33% 67% 43%;">
                        <span class="text-3xl md:text-3xl font-black text-slate-900">15+</span>
                    </div>
                    <span
                        class="text-sm md:text-base font-bold text-white text-center leading-tight max-w-[150px]">Years
                        of
                        Service</span>
                </div>
            </div>
        </div>
    </section>
    <section class="py-24 bg-surface-dark border-b border-white/5" id="mission">
        <div class="container mx-auto px-4 max-w-4xl text-center">
            <h2 class="text-sm font-bold text-primary uppercase tracking-[0.3em] mb-4">Who We Are</h2>
            <h3 class="text-3xl md:text-5xl font-black text-white mb-8">Why Rural Empowerment Matters</h3>
            <p class="text-xl text-gray-300 leading-relaxed font-light">
                Our purpose is to ignite self-sustaining growth in underserved regions. We envision a world where every
                rural community possesses the tools, knowledge, and health to thrive independently. Our impact focuses
                on holistic development from the ground up.
            </p>
        </div>
    </section>
    <section class="py-24 bg-background-dark" id="focus">
        <div class="container mx-auto px-4 max-w-6xl">
            <h2 class="text-3xl md:text-5xl font-black text-white mb-16 text-center">OUR FOCUS AREAS</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    class="group bg-surface-dark p-8 rounded-lg border border-white/5 hover:border-primary/50 transition-all duration-300">
                    <div class="p-3 bg-white/5 rounded-md text-primary mb-6 inline-block">
                        <span class="material-symbols-outlined text-4xl">payments</span>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-4">Economic Empowerment</h4>
                    <p class="text-gray-400 text-sm">Providing financial tools and opportunities for sustainable income
                        generation.</p>
                </div>
                <div
                    class="group bg-surface-dark p-8 rounded-lg border border-white/5 hover:border-primary/50 transition-all duration-300">
                    <div class="p-3 bg-white/5 rounded-md text-primary mb-6 inline-block">
                        <span class="material-symbols-outlined text-4xl">school</span>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-4">Education &amp; Skill Development</h4>
                    <p class="text-gray-400 text-sm">Equipping the next generation with knowledge and vocational skills.
                    </p>
                </div>
                <div
                    class="group bg-surface-dark p-8 rounded-lg border border-white/5 hover:border-primary/50 transition-all duration-300">
                    <div class="p-3 bg-white/5 rounded-md text-primary mb-6 inline-block">
                        <span class="material-symbols-outlined text-4xl">female</span>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-4">Women Empowerment</h4>
                    <p class="text-gray-400 text-sm">Fostering leadership and financial independence for rural women.
                    </p>
                </div>
                <div
                    class="group bg-surface-dark p-8 rounded-lg border border-white/5 hover:border-primary/50 transition-all duration-300">
                    <div class="p-3 bg-white/5 rounded-md text-primary mb-6 inline-block">
                        <span class="material-symbols-outlined text-4xl">medical_services</span>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-4">Health &amp; Nutrition</h4>
                    <p class="text-gray-400 text-sm">Ensuring access to essential healthcare and nutritious food
                        security.</p>
                </div>
                <div
                    class="group bg-surface-dark p-8 rounded-lg border border-white/5 hover:border-primary/50 transition-all duration-300">
                    <div class="p-3 bg-white/5 rounded-md text-primary mb-6 inline-block">
                        <span class="material-symbols-outlined text-4xl">devices</span>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-4">Digital &amp; Technological Inclusion</h4>
                    <p class="text-gray-400 text-sm">Connecting remote villages to the global digital economy.</p>
                </div>
                <div
                    class="group bg-surface-dark p-8 rounded-lg border border-white/5 hover:border-primary/50 transition-all duration-300">
                    <div class="p-3 bg-white/5 rounded-md text-primary mb-6 inline-block">
                        <span class="material-symbols-outlined text-4xl">potted_plant</span>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-4">Sustainable Agriculture &amp; Environment</h4>
                    <p class="text-gray-400 text-sm">Promoting eco-friendly farming practices and environmental
                        protection.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-24 bg-surface-dark relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-blue-glow opacity-30 pointer-events-none"></div>
        <div class="container mx-auto px-4 max-w-6xl relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div class="max-w-xl">
                    <h2 class="text-3xl md:text-5xl font-black text-white mb-4">PROGRAMS &amp; INITIATIVES</h2>
                    <p class="text-gray-400 text-lg">Direct action through targeted programs that drive real progress.
                    </p>
                </div>
                <button class="flex items-center gap-2 text-primary font-bold hover:text-white transition-colors">
                    View All Programs <span class="material-symbols-outlined">arrow_outward</span>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div
                    class="bg-background-dark/50 p-6 rounded-lg border border-white/5 hover:border-primary/30 transition-all">
                    <h5 class="text-white font-bold mb-2">Livelihood Development</h5>
                    <p class="text-gray-500 text-xs">Job creation and market access programs.</p>
                </div>
                <div
                    class="bg-background-dark/50 p-6 rounded-lg border border-white/5 hover:border-primary/30 transition-all">
                    <h5 class="text-white font-bold mb-2">Women SHGs</h5>
                    <p class="text-gray-500 text-xs">Supporting Self-Help Groups for micro-entrepreneurship.</p>
                </div>
                <div
                    class="bg-background-dark/50 p-6 rounded-lg border border-white/5 hover:border-primary/30 transition-all">
                    <h5 class="text-white font-bold mb-2">Farmer Support</h5>
                    <p class="text-gray-500 text-xs">Training in modern and sustainable farming.</p>
                </div>
                <div
                    class="bg-background-dark/50 p-6 rounded-lg border border-white/5 hover:border-primary/30 transition-all">
                    <h5 class="text-white font-bold mb-2">Youth Skill Dev</h5>
                    <p class="text-gray-500 text-xs">Vocational training for rural youth employment.</p>
                </div>
                <div
                    class="bg-background-dark/50 p-6 rounded-lg border border-white/5 hover:border-primary/30 transition-all">
                    <h5 class="text-white font-bold mb-2">Digital Literacy</h5>
                    <p class="text-gray-500 text-xs">Educational camps for basic digital skills.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-24 bg-background-dark border-t border-white/5" id="impact">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 max-w-[1280px] mx-auto">
                <h2 class="text-3xl md:text-5xl font-black text-white uppercase">Stories from the Ground</h2>
                <div class="flex gap-2 mt-4 md:mt-0">
                    <button
                        class="size-12 rounded-full border border-white/10 hover:border-primary hover:text-primary text-white flex items-center justify-center transition-all bg-surface-dark">
                        <span class="material-symbols-outlined">arrow_back</span>
                    </button>
                    <button
                        class="size-12 rounded-full border border-white/10 hover:border-primary hover:text-primary text-white flex items-center justify-center transition-all bg-surface-dark">
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
            </div>
            <div
                class="flex overflow-x-auto hide-scrollbar gap-6 pb-8 snap-x snap-mandatory px-4 xl:px-0 max-w-[1280px] mx-auto">
                <div class="snap-start min-w-[300px] md:min-w-[400px] flex flex-col gap-4 group cursor-pointer">
                    <div class="relative w-full aspect-[3/4] overflow-hidden rounded-lg">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-background-dark via-transparent to-transparent opacity-80 z-10">
                        </div>
                        <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                            data-alt="Portrait of farmer"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCO9m8NqGHAAc2fF736ofbhRbdchBfm0jeEEkhbRjOWo3HYxUsQ_E_EpQoIuPRoAhNyDXvnbOpT4ptq9Ozb18RPE-ihsKCdM5c_LR__I4jZlya3kn56vwBeCiYcB-yM0q6NQz4PWIYbHzXBRSkKQluJsZHhtxxwPCHs2RuuOiZQaVBRzNIpqeNO7e2oKw04oetTbGsJ_HCalvtJVSOXASI0IjBOcohuMm4TdWbTGJwqQQW0ziyT5uQ1EjYJWaI_tjtIs7-hjFR_ZQ');">
                        </div>
                        <div class="absolute bottom-0 left-0 p-6 z-20">
                            <span
                                class="bg-primary text-[#0a192f] text-xs font-bold px-2 py-1 rounded mb-2 inline-block uppercase">Economic
                                Success</span>
                            <h3 class="text-2xl font-bold text-white leading-tight">Farmer Transformation</h3>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">How a small-scale farmer increased his yield by
                        200% using our training and support. <br /> <a class="text-primary font-bold mt-2 block"
                            href="#">Read More Stories</a></p>
                </div>
                <div class="snap-start min-w-[300px] md:min-w-[400px] flex flex-col gap-4 group cursor-pointer">
                    <div class="relative w-full aspect-[3/4] overflow-hidden rounded-lg">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-background-dark via-transparent to-transparent opacity-80 z-10">
                        </div>
                        <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                            data-alt="Portrait of child in classroom"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBPZ2T8eAKQZVJiD4UVGaAvvhxwFylU0pv0tUES8cQ-YS0FZHWB8nkxQrKbWb_BZRqGYr2EfU6BDZyHwyVnREqpHzj88EpkAE95mRPS3JSClAb49lt641pdOmNqzq5Y4Wlgf03n13vhNkho_fEO8pSbcTLUpY73eV8UPX2UiZtZJFvsuv7MMICgVunVFQDGf2ESRJOlN_2UOLznKjzwp4FemzsrQ916uM4bh7lCJvKu4Od97bvlMllLXdq78YeTu0DgG7T7XEiZEw');">
                        </div>
                        <div class="absolute bottom-0 left-0 p-6 z-20">
                            <span
                                class="bg-primary text-[#0a192f] text-xs font-bold px-2 py-1 rounded mb-2 inline-block uppercase">Education
                                Story</span>
                            <h3 class="text-2xl font-bold text-white leading-tight">Youth Literacy Camp</h3>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">Bridging the digital divide for rural children,
                        opening new worlds of knowledge. <br /> <a class="text-primary font-bold mt-2 block"
                            href="#">Read More Stories</a></p>
                </div>
                <div class="snap-start min-w-[300px] md:min-w-[400px] flex flex-col gap-4 group cursor-pointer">
                    <div class="relative w-full aspect-[3/4] overflow-hidden rounded-lg">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-background-dark via-transparent to-transparent opacity-80 z-10">
                        </div>
                        <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                            data-alt="Solar panels"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuD6vxzDRWGTOdcw3tchUDF0DRtNrCW6XWZwbMcrkvITVM-HKTzQYh-5fkwMqZK53TTCOum258jxduhmbfp9dTEmitZywFcl22R8IodtNIYFXzmtCoAusIuTi7-AEICTNZ-KhM03GBDhfPY3dbyYtoWfwOjPe8JQzW4dqb4emahECwlLtPlvcwKxSJvWHs_GDb4_Al9T-hT2Tp9LFPpIwG0C4JgHJiBciWjYkxEvp_MMFFh23unt4BKLxM_yMvcr0z0MbADn7O0TFg');">
                        </div>
                        <div class="absolute bottom-0 left-0 p-6 z-20">
                            <span
                                class="bg-primary text-[#0a192f] text-xs font-bold px-2 py-1 rounded mb-2 inline-block uppercase">Infrastructure</span>
                            <h3 class="text-2xl font-bold text-white leading-tight">Clean Energy Access</h3>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">Village-wide solar grids that powered clinics and
                        businesses overnight. <br /> <a class="text-primary font-bold mt-2 block" href="#">Read More
                            Stories</a></p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-24 bg-surface-dark">
        <div class="container mx-auto px-4 max-w-6xl">
            <h2 class="text-3xl md:text-5xl font-black text-white mb-16 text-center">HOW WE WORK</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="relative flex flex-col items-center text-center">
                    <div
                        class="size-16 rounded-full bg-primary/10 border border-primary text-primary flex items-center justify-center text-2xl font-bold mb-6">
                        1</div>
                    <h5 class="text-white font-bold mb-2">Community Engagement</h5>
                    <p class="text-gray-400 text-xs">Deep listening to understand local needs.</p>
                </div>
                <div class="relative flex flex-col items-center text-center">
                    <div
                        class="size-16 rounded-full bg-primary/10 border border-primary text-primary flex items-center justify-center text-2xl font-bold mb-6">
                        2</div>
                    <h5 class="text-white font-bold mb-2">Training &amp; Capacity Building</h5>
                    <p class="text-gray-400 text-xs">Teaching skills for long-term independence.</p>
                </div>
                <div class="relative flex flex-col items-center text-center">
                    <div
                        class="size-16 rounded-full bg-primary/10 border border-primary text-primary flex items-center justify-center text-2xl font-bold mb-6">
                        3</div>
                    <h5 class="text-white font-bold mb-2">Partnerships &amp; Collaboration</h5>
                    <p class="text-gray-400 text-xs">Working with NGOs and Govt for scale.</p>
                </div>
                <div class="relative flex flex-col items-center text-center">
                    <div
                        class="size-16 rounded-full bg-primary/10 border border-primary text-primary flex items-center justify-center text-2xl font-bold mb-6">
                        4</div>
                    <h5 class="text-white font-bold mb-2">Sustainable Implementation</h5>
                    <p class="text-gray-400 text-xs">Ensuring projects outlast our direct involvement.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-24 bg-background-dark">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl md:text-5xl font-black text-white mb-8">GET INVOLVED</h2>
                    <div class="space-y-4">
                        <div
                            class="flex items-center justify-between p-6 bg-surface-dark rounded-lg border border-white/5 hover:border-primary/40 transition-all group">
                            <div class="flex items-center gap-4">
                                <span class="material-symbols-outlined text-primary text-3xl">volunteer_activism</span>
                                <span class="text-white font-bold">Volunteer With Us</span>
                            </div>
                            <button
                                class="bg-primary px-4 py-2 rounded text-[#0a192f] text-sm font-bold uppercase">Join</button>
                        </div>
                        <div
                            class="flex items-center justify-between p-6 bg-surface-dark rounded-lg border border-white/5 hover:border-primary/40 transition-all group">
                            <div class="flex items-center gap-4">
                                <span class="material-symbols-outlined text-primary text-3xl">corporate_fare</span>
                                <span class="text-white font-bold">Partner With Us</span>
                            </div>
                            <button
                                class="bg-primary px-4 py-2 rounded text-[#0a192f] text-sm font-bold uppercase">Contact</button>
                        </div>
                        <div
                            class="flex items-center justify-between p-6 bg-surface-dark rounded-lg border border-white/5 hover:border-primary/40 transition-all group">
                            <div class="flex items-center gap-4">
                                <span class="material-symbols-outlined text-primary text-3xl">payments</span>
                                <span class="text-white font-bold">Donate / Support</span>
                            </div>
                            <button
                                class="bg-primary px-4 py-2 rounded text-[#0a192f] text-sm font-bold uppercase">Give</button>
                        </div>
                        <div
                            class="flex items-center justify-between p-6 bg-surface-dark rounded-lg border border-white/5 hover:border-primary/40 transition-all group">
                            <div class="flex items-center gap-4">
                                <span class="material-symbols-outlined text-primary text-3xl">handshake</span>
                                <span class="text-white font-bold">CSR Collaboration</span>
                            </div>
                            <button
                                class="bg-primary px-4 py-2 rounded text-[#0a192f] text-sm font-bold uppercase">Enquire</button>
                        </div>
                    </div>
                </div>
                <div class="bg-surface-dark p-10 rounded-2xl border border-white/10">
                    <h3 class="text-2xl font-bold text-white mb-8">Partners &amp; Supporters</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <p class="text-primary text-xs font-bold uppercase mb-4 tracking-widest">NGO Partners</p>
                            <div class="flex flex-wrap gap-4 opacity-70">
                                <span class="text-white font-semibold">GlobalReach</span>
                                <span class="text-white font-semibold">CareTrust</span>
                                <span class="text-white font-semibold">EcoFund</span>
                            </div>
                        </div>
                        <div class="pt-6 border-t border-white/10">
                            <p class="text-primary text-xs font-bold uppercase mb-4 tracking-widest">CSR Partners</p>
                            <div class="flex flex-wrap gap-4 opacity-70">
                                <span class="text-white font-semibold">TechCorp</span>
                                <span class="text-white font-semibold">InnovaGroup</span>
                                <span class="text-white font-semibold">BlueSky Inc</span>
                            </div>
                        </div>
                        <div class="pt-6 border-t border-white/10">
                            <p class="text-primary text-xs font-bold uppercase mb-4 tracking-widest">Government /
                                Institutional Supporters</p>
                            <div class="flex flex-wrap gap-4 opacity-70">
                                <span class="text-white font-semibold">RuralDev Ministry</span>
                                <span class="text-white font-semibold">Health Bureau</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-24 bg-surface-dark" id="news">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <div>
                    <h2 class="text-3xl font-black text-white mb-10">Testimonials</h2>
                    <div class="space-y-8">
                        <div class="border-l-4 border-primary pl-6 py-2">
                            <p class="text-gray-300 italic mb-4">"The digital literacy camp changed how I see my future.
                                I'm now applying for online courses!"</p>
                            <p class="text-white font-bold">Beneficiary — Priya, Village Student</p>
                        </div>
                        <div class="border-l-4 border-primary pl-6 py-2">
                            <p class="text-gray-300 italic mb-4">"Partnering with RuralEmpower allowed our CSR funds to
                                reach the most impactful projects directly."</p>
                            <p class="text-white font-bold">Partner — John Doe, TechCorp CSR</p>
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-white mb-10">Latest Updates &amp; News</h2>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div
                                class="min-w-[80px] h-[80px] bg-background-dark rounded-lg flex flex-col items-center justify-center border border-white/5">
                                <span class="text-primary font-black text-xl">12</span>
                                <span class="text-gray-500 text-[10px] uppercase font-bold">OCT</span>
                            </div>
                            <div>
                                <h6 class="text-white font-bold hover:text-primary transition-colors cursor-pointer">
                                    Ongoing Project: 20 New Solar Wells Installed</h6>
                                <p class="text-gray-500 text-xs mt-1">Sustainability Update • 3 min read</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div
                                class="min-w-[80px] h-[80px] bg-background-dark rounded-lg flex flex-col items-center justify-center border border-white/5">
                                <span class="text-primary font-black text-xl">05</span>
                                <span class="text-gray-500 text-[10px] uppercase font-bold">OCT</span>
                            </div>
                            <div>
                                <h6 class="text-white font-bold hover:text-primary transition-colors cursor-pointer">
                                    Event: Annual Rural Empowerment Summit 2024</h6>
                                <p class="text-gray-500 text-xs mt-1">Announcements • 5 min read</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div
                                class="min-w-[80px] h-[80px] bg-background-dark rounded-lg flex flex-col items-center justify-center border border-white/5">
                                <span class="text-primary font-black text-xl">28</span>
                                <span class="text-gray-500 text-[10px] uppercase font-bold">SEP</span>
                            </div>
                            <div>
                                <h6 class="text-white font-bold hover:text-primary transition-colors cursor-pointer">
                                    Blog: Why Digital Literacy is the New Rural Lifeline</h6>
                                <p class="text-gray-500 text-xs mt-1">Blog Highlights • 8 min read</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-32 relative overflow-hidden bg-background-dark">
        <div class="absolute inset-0 bg-blue-glow opacity-20 pointer-events-none"></div>
        <div class="container relative z-10 mx-auto px-4 max-w-4xl text-center">
            <span class="material-symbols-outlined text-6xl text-primary mb-6">handshake</span>
            <h2 class="text-4xl md:text-6xl font-black text-white mb-6 tracking-tight">Together, We Can <br /><span
                    class="text-primary">Transform Rural Lives</span></h2>
            <p class="text-xl text-gray-400 mb-10 max-w-2xl mx-auto">
                Your support provides the foundation for self-reliance. Be the catalyst for lasting change in the heart
                of our nations.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button
                    class="h-14 px-10 rounded-md bg-primary text-[#0a192f] text-lg font-bold shadow-[0_0_30px_rgba(100,181,246,0.4)] hover:scale-105 transition-all">
                    Join the Movement
                </button>
                <button
                    class="h-14 px-10 rounded-md bg-white/10 text-white text-lg font-bold border border-white/20 hover:bg-white/20 transition-all backdrop-blur-sm">
                    Contact Us
                </button>
            </div>
        </div>
    </section>
    <footer class="bg-[#050b11] border-t border-white/5 pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-3">
                        <x-application-logo class="flex items-center justify-center text-primary" />
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        A professional NGO dedicated to creating high-impact sustainable growth for rural populations
                        through education and livelihood training.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6">Initiatives</h4>
                    <ul class="flex flex-col gap-3">
                        <li><a class="text-gray-400 hover:text-primary text-sm transition-colors" href="#">Economic
                                Empowerment</a></li>
                        <li><a class="text-gray-400 hover:text-primary text-sm transition-colors" href="#">Education
                                &amp; Skills</a></li>
                        <li><a class="text-gray-400 hover:text-primary text-sm transition-colors" href="#">Women
                                SHGs</a></li>
                        <li><a class="text-gray-400 hover:text-primary text-sm transition-colors" href="#">Sustainable
                                Ag</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6">Resources</h4>
                    <ul class="flex flex-col gap-3">
                        <li><a class="text-gray-400 hover:text-primary text-sm transition-colors" href="#">Latest
                                News</a></li>
                        <li><a class="text-gray-400 hover:text-primary text-sm transition-colors" href="#">Success
                                Stories</a></li>
                        <li><a class="text-gray-400 hover:text-primary text-sm transition-colors" href="#">Volunteer
                                Login</a></li>
                        <li><a class="text-gray-400 hover:text-primary text-sm transition-colors" href="#">Privacy
                                Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6">Stay Connected</h4>
                    <form class="flex flex-col gap-3">
                        <input
                            class="h-10 px-4 rounded-md bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm"
                            placeholder="Enter your email" type="email" />
                        <button
                            class="h-10 rounded-md bg-white/10 text-white font-bold text-sm hover:bg-primary hover:text-[#0a192f] transition-colors"
                            type="button">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
            <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-600 text-xs">© 2024 RuralEmpower NGO. Serene &amp; Professional Excellence.</p>
                <div class="flex gap-6">
                    <a class="text-gray-600 hover:text-white text-xs transition-colors" href="#">Terms of Service</a>
                    <a class="text-gray-600 hover:text-white text-xs transition-colors" href="#">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>