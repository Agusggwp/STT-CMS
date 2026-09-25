@extends('layouts.app')

@section('title', 'Tentang Kami — ' . ($siteSettings['org_name'] ?? 'STT ArtDevata'))
@section('meta_description', 'Profil lengkap, sejarah, visi, misi, dan nilai filosofi Tri Hita Karana Sekaa Teruna Teruni ArtDevata Banjar ArtDevata.')

@section('content')
{{-- Page Header --}}
<section class="bg-white border-b border-[#E5E5E5] py-14 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Profil Organisasi</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-[#1F1F1F] tracking-tight mt-2">
            Mengenal STT ArtDevata
        </h1>
        <div class="w-16 h-0.5 bg-[#8B1E24] mt-4 mb-4"></div>
        <p class="text-base sm:text-lg text-[#6B6B6B] max-w-3xl leading-relaxed">
            Wadah persaudaraan teruna teruni di Banjar ArtDevata yang memegang teguh adat budaya Bali, memupuk jiwa kepemimpinan, dan mengabdi untuk kemajuan banjar.
        </p>
    </div>
</section>

{{-- Content Grid --}}
<div class="py-16 sm:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">
        {{-- Section 1: Sejarah & Landasan --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 space-y-4">
                <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Sejarah & Pembentukan</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1F1F1F] tracking-tight">
                    Berakar Kuat di Tanah Leluhur Banjar ArtDevata
                </h2>
                <div class="w-12 h-0.5 bg-[#8B1E24]"></div>
                <p class="text-sm sm:text-base text-[#6B6B6B] leading-relaxed">
                    Sekaa Teruna Teruni (STT) ArtDevata didirikan puluhan tahun silam oleh para tetua banjar sebagai sarana kaderisasi krama muda Hindu di lingkungan Banjar ArtDevata, Desa Adat ArtDevata. Nama <em>ArtDevata</em> mengemban amanah suci keluhuran seni, kebajikan, kebenaran (dharma), dan kewajiban ngayah kepada banjar.
                </p>
                <p class="text-sm sm:text-base text-[#6B6B6B] leading-relaxed">
                    Dari generasi ke generasi, STT ArtDevata konsisten bertransformasi tanpa meninggalkan akar tradisi. Saat ini, organisasi menaungi puluhan pemuda dan pemudi aktif yang berkiprah di bidang seni karawitan, pembuatan ogoh-ogoh ramah lingkungan, bakti sosial, serta digitalisasi dokumentasi banjar.
                </p>
            </div>
            <div class="lg:col-span-6">
                <div class="border border-[#E5E5E5] p-2 bg-white">
                    <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1000&q=80"
                         alt="Suasana gotong royong pemuda banjar"
                         class="w-full h-80 sm:h-96 object-cover object-center">
                </div>
            </div>
        </div>

        {{-- Section 2: Visi & Misi --}}
        <div class="border border-[#E5E5E5] p-8 sm:p-12 bg-white">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 border border-[#8B1E24] flex items-center justify-center font-bold text-xs text-[#8B1E24]">V</span>
                        <h3 class="text-xl font-bold text-[#1F1F1F] uppercase tracking-wider">Visi Organisasi</h3>
                    </div>
                    <div class="w-12 h-0.5 bg-[#8B1E24]"></div>
                    <p class="text-base text-[#1F1F1F] font-medium leading-relaxed italic">
                        "Terwujudnya Generasi Muda Banjar ArtDevata yang Berkarakter Luhur, Menjunjung Tinggi Budaya dan Adat Bali, Berjiwa Sosial Tinggi, Serta Berdaya Saing Kreatif di Era Modern."
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 border border-[#8B1E24] flex items-center justify-center font-bold text-xs text-[#8B1E24]">M</span>
                        <h3 class="text-xl font-bold text-[#1F1F1F] uppercase tracking-wider">Misi Utama</h3>
                    </div>
                    <div class="w-12 h-0.5 bg-[#8B1E24]"></div>
                    <ul class="space-y-3 text-sm text-[#6B6B6B]">
                        <li class="flex items-start gap-2.5">
                            <span class="text-[#8B1E24] font-bold mt-0.5">•</span>
                            <span>Melestarikan seni tradisi gamelan, tari sakral, dan kriya budaya Bali melalui regenerasi berkelanjutan.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="text-[#8B1E24] font-bold mt-0.5">•</span>
                            <span>Menanamkan nilai ngayah dan gotong royong tulus ikhlas dalam setiap kegiatan keagamaan dan kemasyarakatan banjar.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="text-[#8B1E24] font-bold mt-0.5">•</span>
                            <span>Mengembangkan potensi minat, bakat, olahraga, dan wirausaha kreatif krama muda.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="text-[#8B1E24] font-bold mt-0.5">•</span>
                            <span>Menjaga keharmonisan dan solidaritas persaudaraan (pasikian menyama braya) antar tempek banjar.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Section 3: Filosofi & Nilai-Nilai Adat --}}
        <div>
            <div class="text-center max-w-2xl mx-auto mb-12 space-y-3">
                <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Landasan Filosofis</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1F1F1F] tracking-tight">
                    Falsafah Hidup Tri Hita Karana
                </h2>
                <div class="w-12 h-0.5 bg-[#8B1E24] mx-auto"></div>
                <p class="text-sm text-[#6B6B6B]">
                    Tiga hubungan harmonis yang menjadi kompas gerak seluruh program dan pengabdian STT.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 border border-[#E5E5E5] bg-white space-y-3 hover:border-[#8B1E24] transition-colors">
                    <span class="text-xs font-bold text-[#8B1E24] uppercase tracking-wider">01. Parahyangan</span>
                    <h3 class="text-lg font-bold text-[#1F1F1F]">Harmonis dengan Sang Pencipta</h3>
                    <p class="text-xs text-[#6B6B6B] leading-relaxed">
                        Diwujudkan melalui pelaksanaan upacara yadnya, ngayah megambel di pura banjar, mebanten, serta menjaga kesucian tempat ibadah.
                    </p>
                </div>

                <div class="p-8 border border-[#E5E5E5] bg-white space-y-3 hover:border-[#8B1E24] transition-colors">
                    <span class="text-xs font-bold text-[#8B1E24] uppercase tracking-wider">02. Pawongan</span>
                    <h3 class="text-lg font-bold text-[#1F1F1F]">Harmonis Sesama Manusia</h3>
                    <p class="text-xs text-[#6B6B6B] leading-relaxed">
                        Menerapkan ajaran <em>Tat Twam Asi</em> (Aku adalah Engkau) dan <em>Menyama Braya</em> melalui musyawarah, bakti sosial, dan tolong-menolong.
                    </p>
                </div>

                <div class="p-8 border border-[#E5E5E5] bg-white space-y-3 hover:border-[#8B1E24] transition-colors">
                    <span class="text-xs font-bold text-[#8B1E24] uppercase tracking-wider">03. Palemahan</span>
                    <h3 class="text-lg font-bold text-[#1F1F1F]">Harmonis dengan Alam</h3>
                    <p class="text-xs text-[#6B6B6B] leading-relaxed">
                        Menjaga kebersihan banjar melalui bank sampah terpadu, aksi resik lingkungan, dan komitmen ogoh-ogoh ramah lingkungan tanpa plastik/styrofoam.
                    </p>
                </div>
            </div>
        </div>

        {{-- Section 4: Pimpinan Inti --}}
        <div>
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-[#E5E5E5]">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Kepemimpinan</span>
                    <h2 class="text-xl sm:text-2xl font-bold text-[#1F1F1F] tracking-tight">Pimpinan Inti Organisasi</h2>
                </div>
                <a href="{{ route('structure') }}" class="text-xs font-semibold text-[#8B1E24] hover:underline">
                    Lihat Struktur Lengkap &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($leaders as $leader)
                    <div class="border border-[#E5E5E5] p-3 bg-white space-y-3">
                        <img src="{{ $leader->photo_url }}"
                             alt="{{ $leader->name }}"
                             class="w-full h-64 object-cover object-center filter grayscale-20">
                        <div>
                            <span class="block text-xs font-semibold uppercase tracking-wider text-[#8B1E24]">{{ $leader->position_title }}</span>
                            <h3 class="text-sm font-bold text-[#1F1F1F] mt-0.5">{{ $leader->name }}</h3>
                            <span class="block text-[11px] text-[#6B6B6B] mt-0.5">{{ $leader->period }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
