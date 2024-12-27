<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Snow Report Aggregator</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.0.3/tsparticles.confetti.bundle.min.js"></script>

    @livewireStyles

    @vite('resources/css/app.css')
</head>

<body class="antialiased" id="my-canvas">
    <div class="text-white">
        <div style="background-image:
        url(https://images.unsplash.com/photo-1590514845347-76125d976864?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80)"
            class="relative w-full pb-16 bg-top bg-cover md:bg-center">
            <div class="absolute inset-0 w-full h-full bg-gray-900 opacity-25"></div>
            <div class="absolute inset-0 w-full h-64 opacity-50 bg-gradient-to-b from-black to-transparent"></div>
            <div class="relative flex items-center justify-between w-full h-20 pt-0 pb-0 pl-8 pr-8">
                <a
                    class="relative flex items-center h-full pt-0 pb-0 pl-0 pr-6 text-lg font-extrabold text-white">snowgr.info</a>
                <div
                    class="flex flex-col items-center justify-center h-full space-y-3 md:justify-end md:bg-transparent md:space-x-5 md:space-y-0 md:relative md:flex md:flex-row">
                    <a
                        class="relative text-lg font-medium tracking-wide text-purple-400 transition duration-150 ease-out md:text-sm md:text-white">About
                        Us</a>
                </div>
            </div>
            <div class="relative z-10 max-w-6xl pt-10 pb-10 pl-10 pr-10 ml-auto mr-auto md:pt-20 md:pb-40">
                <div class="flex flex-col items-center lg:flex-row">
                    <div
                        class="flex flex-col items-center justify-center w-full pt-0 pb-4 pl-0 pr-0 text-center lg:text-left lg:w-2/3 md:h-full lg:items-start">
                        <p
                            class="inline-block w-auto pt-1 pb-1 pl-3 pr-3 mb-5 text-sm font-medium text-white uppercase bg-purple-400 rounded-full bg-gradient-to-br">
                            ⚙️ Beta version</p>
                        <p
                            class="text-4xl font-extrabold tracking-tight text-white text-tight lg:text-left xl:pr-32 md:text-7xl">
                            Ski η
                            Snowboard?</p>
                        <p class="text-2xl md:text-4xl">
                            <span class="animate-pulse shadow-* text-purple-300">Scrollαρε</span>
                            για περισσότερα!
                        </p>
                        <p></p>
                    </div>
                    <div class="pt-5 pb-5 pl-4 pr-4 sm:p-6">
                        <div class="">
                            <p class="text-lg font-bold text-purple-200">Αγαπημένα μας Χιονοδρομικά</p>
                        </div>
                        <div class="mt-6 mb-0 ml-0 mr-0 space-y-3">
                            <livewire:main-aggregator :favouriteSnowReports="[6, 10, 1, 2]" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <main class="relative w-full bg-slate-900">
            <section
                class="relative flex flex-col items-center justify-center w-full min-h-screen px-4 py-8 mx-auto isolate max-w-screen-2xl gap-y-8 overflow-y-clip">
                <div aria-hidden
                    class="absolute inset-x-0 overflow-hidden sm:-top-80 -top-40 -z-10 transform-gpu blur-3xl">
                    <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2%
              62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%,
              74.1% 44.1%);"
                        class="w-[36.125rem] bg-gradient-to-tr sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]
              aspect-[1155/678] relative left-[calc(50%-11rem)] -translate-x-1/2 rotate-[30deg] to-[#9089fc] opacity-20
              from-[#0014cc]">
                    </div>
                </div>
                <div aria-hidden
                    class="sm:top-[calc(100%-30rem)] absolute inset-x-0 top-[calc(100%-13rem)] -z-10
            transform-gpu overflow-hidden blur-3xl">
                    <div style="null"
                        class="w-[36.125rem] bg-gradient-to-tr sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]
              aspect-[1155/678] relative left-[calc(50%+3rem)] -translate-x-1/2 opacity-20 to-[#0014cc]
              from-[#9089fc]">
                    </div>
                </div>
                <div class="w-3/4 pt-10 space-y-2 lg:w-2/3">
                    <p class="pb-8 text-4xl font-bold tracking-tight text-center lg:text-5xl">
                        Διάλεξε Χιονοδρομικό 🏂
                    </p>
                    <livewire:main-aggregator />
                    <div>
                        <livewire:snow-resort-data />
                    </div>


                    <div class="max-w-3xl pt-24 mx-auto text-center opacity-40 text-md">Copyright
                        {{ \Carbon\Carbon::now()->year }}
                        - All rights
                        reserved | Your
                        friendly
                        neighborhood Snowboarder | Coder</div>
                </div>
            </section>
        </main>
    </div>
    @livewireScripts
</body>

<script>
    (async () => {
        const canvas = document.getElementById("my-canvas");

        canvas.confetti =
            canvas.confetti || (await confetti.create(canvas, {
                resize: true
            }));


        const duration = 15 * 2000,
            animationEnd = Date.now() + duration;

        let skew = 1;

        function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
        }

        (function frame() {
            const timeLeft = animationEnd - Date.now(),
                ticks = Math.max(200, 500 * (timeLeft / duration));

            skew = Math.max(0.8, skew - 0.001);

            confetti({
                particleCount: 2,
                startVelocity: 0,
                ticks: ticks,
                origin: {
                    x: Math.random(),
                    // since particles fall down, skew start toward the top
                    y: Math.random() * skew - 0.2,
                },
                colors: ["#ffffff"],
                shapes: ["image"],
                shapeOptions: {
                    image: [{
                        src: "http://snow-report-aggregator.test/assets/snowflake.svg",
                        width: 20,
                        height: 20
                    }, ],
                },
                gravity: randomInRange(0.4, 0.6),
                scalar: randomInRange(0.4, 1),
                drift: randomInRange(-0.4, 0.4),
            });

            if (timeLeft > 0) {
                requestAnimationFrame(frame);
            }
        })();

    })();
</script>

</html>
