<footer class="bg-gray-900 text-gray-400 py-12">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-8 mb-8">
            <div>
                <h3 class="text-white text-lg font-bold mb-3">Sponsor<span class="text-indigo-400">ea</span></h3>
                <p class="text-sm leading-relaxed">
                    Platform marketplace sponsorship yang menghubungkan penyelenggara event mahasiswa dengan perusahaan sponsor.
                </p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Platform</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('register') }}" class="hover:text-white transition">Daftar Gratis</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-white transition">Login</a></li>
                    <li><a href="#how-it-works" class="hover:text-white transition">Cara Kerja</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Kontak</h4>
                <ul class="space-y-2 text-sm">
                    <li>Email: info@sponsorea.id</li>
                    <li>Telepon: (021) 123-4567</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-6 text-center text-sm">
            <p>&copy; {{ date('Y') }} Sponsorea. All Rights Reserved.</p>
        </div>
    </div>
</footer>