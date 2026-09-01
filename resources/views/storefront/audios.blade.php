@extends('layouts.app')

@section('content')

<!-- Header Banner -->
<div class="bg-gradient-to-r from-[#312E81] via-[#7C3AED] to-purple-900 text-white rounded-3xl md:rounded-[2.5rem] p-8 sm:p-12 mb-10 shadow-xl border-4 border-[#FACC15] relative overflow-hidden">
    <div class="relative z-10 max-w-3xl">
        <span class="bg-[#FACC15] text-[#312E81] font-black text-xs px-3.5 py-1 rounded-full uppercase tracking-wider mb-4 inline-flex items-center gap-1.5 shadow-sm">
            <i class="bi bi-spotify text-[#7C3AED]"></i> Spotify Audio Channel
        </span>
        <h1 class="font-whimsical text-3xl sm:text-5xl font-bold text-white mb-3 leading-tight">
            Bedtime Stories & Audiobooks
        </h1>
        <p class="text-purple-100 text-sm sm:text-base leading-relaxed font-medium mb-6">
            Immerse children in magical storytelling and soothing bedtime tales narrated by <strong>WrittenbyPD</strong>. Stream directly on Spotify or listen below!
        </p>
        <div class="flex flex-wrap gap-4">
            <button onclick="openSpotifyModal()" class="bg-[#FACC15] hover:bg-yellow-300 text-[#312E81] font-extrabold px-6 py-3 rounded-full text-xs uppercase tracking-wider shadow-md transition flex items-center gap-2">
                <i class="bi bi-play-circle-fill text-lg text-[#7C3AED]"></i> Open Player Widget
            </button>
            <a href="https://open.spotify.com" target="_blank" class="bg-white/10 hover:bg-white/20 text-white font-extrabold px-6 py-3 rounded-full text-xs uppercase tracking-wider border border-purple-300/40 transition flex items-center gap-2">
                Launch Spotify App <i class="bi bi-box-arrow-up-right text-xs"></i>
            </a>
        </div>
    </div>
</div>

<!-- Audio Episodes Grid -->
<div class="mb-12">
    <div class="flex justify-between items-center mb-6">
        <div>
            <span class="text-[#7C3AED] font-extrabold text-xs uppercase tracking-wider bg-purple-50 px-3 py-1 rounded-full border border-purple-200">Audio Episodes</span>
            <h2 class="font-whimsical font-bold text-2xl sm:text-3xl text-[#312E81] mt-2">Listen & Learn</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
        @forelse($audios as $audio)
            <div class="bg-white border-2 border-purple-100 hover:border-[#7C3AED] rounded-3xl p-6 shadow-sm hover:shadow-xl transition duration-300 flex flex-col sm:flex-row gap-6 items-center">
                <!-- Visual / Icon Box -->
                <div class="w-full sm:w-36 h-36 bg-gradient-to-br from-[#7C3AED] to-[#312E81] rounded-2xl flex flex-col items-center justify-center text-white flex-shrink-0 relative overflow-hidden shadow-md">
                    <i class="bi bi-[#spotify] bi-music-note-beamer text-4xl text-[#FACC15] mb-2"></i>
                    <span class="text-[10px] font-black uppercase text-purple-200">Audio Episode</span>
                    <div class="absolute bottom-2 right-2 bg-[#FACC15] text-[#312E81] text-[9px] font-bold px-2 py-0.5 rounded-md">
                        {{ $audio->specifications['duration'] ?? '15 mins' }}
                    </div>
                </div>

                <!-- Info & Player Buttons -->
                <div class="flex-1 text-center sm:text-left">
                    <span class="text-[10px] font-extrabold text-[#7C3AED] uppercase tracking-wide bg-purple-50 px-2.5 py-0.5 rounded-md inline-block mb-1">
                        Narrated by {{ $audio->specifications['narrator'] ?? 'WrittenbyPD' }}
                    </span>
                    <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-2">{{ $audio->name }}</h3>
                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-4">{{ $audio->description }}</p>

                    <div class="flex items-center justify-center sm:justify-start gap-3">
                        <button onclick="openSpotifyModal()" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold text-xs px-4 py-2.5 rounded-full flex items-center gap-2 shadow transition">
                            <i class="bi bi-play-fill text-base text-[#FACC15]"></i> Listen Now
                        </button>
                        <a href="https://open.spotify.com" target="_blank" class="bg-purple-50 hover:bg-purple-100 text-[#7C3AED] font-extrabold text-xs px-4 py-2.5 rounded-full border border-purple-200 transition flex items-center gap-1.5">
                            <i class="bi bi-spotify"></i> Spotify
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-slate-500 bg-white border border-purple-200 rounded-3xl">
                <i class="bi bi-spotify text-5xl text-[#7C3AED] mb-3"></i>
                <p class="font-bold text-sm">No audio episodes available yet.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $audios->links() }}
    </div>
</div>

@endsection
