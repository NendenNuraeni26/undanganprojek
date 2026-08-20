<?php
// ==================== PENGATURAN RSVP ====================
// Data RSVP disimpan di rsvp.csv pada folder yang sama.
$notice = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rsvp_name'])) {
    $name = trim($_POST['rsvp_name']);
    $attendance = trim($_POST['attendance'] ?? '');
    $guests = trim($_POST['guests'] ?? '1');
    $message = trim($_POST['message'] ?? '');

    if ($name !== '' && $attendance !== '') {
        $file = __DIR__ . DIRECTORY_SEPARATOR . 'rsvp.csv';
        $handle = fopen($file, 'a');
        if ($handle) {
            fputcsv($handle, [date('Y-m-d H:i:s'), $name, $attendance, $guests, $message]);
            fclose($handle);
            $notice = 'Terima kasih, konfirmasi kehadiranmu sudah kami terima.';
        }
    } else {
        $notice = 'Mohon lengkapi nama dan konfirmasi kehadiran.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nenden &amp; Januar | Wedding Invitation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@500;600;700&family=Pacifico&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=20260820-2">
</head>

<body>
    <main class="invite">
        <!-- MUSIK: ganti URL pada src jika ingin memakai lagu lain. -->
        <button class="music" id="music" type="button" aria-label="Putar musik">♫</button>
        <audio id="song" loop src="aset/musik.mp3"></audio>

        <!-- HALAMAN 1: Cover / halaman pembuka. -->
        <section class="page page-cover" id="slide-1">
            <div class="cover-content">
                <p class="small-title">The Wedding of</p>
                <h1>Nenden <span>&amp;</span><br>Januar</h1>
                <p class="cover-date">Senin, 20 Agustus 2026</p>
                <button class="hero-button" type="button" onclick="openInvitation()"><span>✉</span> Buka Undangan</button>
            </div>
        </section>
        <div class="floral-bridge" aria-hidden="true"></div>

        <!-- HALAMAN 2: Sapaan tamu dan tombol menuju halaman mempelai. -->
        <section class="page page-greeting" id="slide-2">
            <p class="small-title">Assalamu'alaikum warahmatullahi wabarakatuh</p>
            <h2>Kepada Bapak/Ibu/<br>Saudara/i</h2>
            <p class="lead">Tanpa mengurangi rasa hormat, kami memohon kehadirannya dalam acara kami.</p>
            <div class="illustration couple-illustration" aria-label="Ilustrasi pasangan pengantin"></div>
            <button class="hero-button" type="button" onclick="goTo('slide-4')"><span>♡</span> Lihat Mempelai</button>
        </section>
        <div class="floral-bridge" aria-hidden="true"></div>

        <!-- HALAMAN 3: Save the date dan ilustrasi pasangan. -->
        <section class="page page-save" id="slide-3">
            <h2 class="script-title">Save The Date</h2>
            <p class="save-subtitle">You Are Invited to the Wedding of</p>
            <div class="illustration wedding-illustration" aria-label="Ilustrasi pernikahan"></div>
            <h1 class="names">Nenden <span>&amp;</span> Januar</h1>
            <p class="save-date">Senin, 20 Agustus 2026</p>
            <p class="lead">Dengan penuh kebahagiaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan menjadi bagian dari momen istimewa kami.</p>
        </section>
        <div class="floral-bridge" aria-hidden="true"></div>

        <!-- HALAMAN 4: Profil mempelai dan orang tua. Ganti nama/foto di sini. -->
        <section class="page page-couple" id="slide-4">
            <p class="lead strong">Dengan memohon ridho Allah SWT, kami bermaksud mengantarkan putra-putri kami menuju jenjang pernikahan</p>
            <div class="person-block">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&amp;fit=crop&amp;w=500&amp;q=85" alt="Foto mempelai pria">
                <h2 class="script-title">Januar Rizky Mahendra</h2>
                <p>Putra Bpk Edi &amp; Ibu Yayuk<br>Semanding Tuban</p>
            </div>
            <div class="person-block">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&amp;fit=crop&amp;w=500&amp;q=85" alt="Foto mempelai wanita">
                <h2 class="script-title">Nenden Nuraeni</h2>
                <p>Putri Bpk Dara &amp; Ibu Yuli<br>Sukolilo Tuban</p>
            </div>
        </section>
        <div class="floral-bridge" aria-hidden="true"></div>

        <!-- HALAMAN 5: Detail akad, resepsi, dan Google Maps. -->
        <section class="page page-events" id="slide-5">
            <p class="lead strong">Insyaallah acara akan dilaksanakan pada:</p>
            <div class="event-item">
                <h2 class="script-title">Akad Nikah</h2>
                <p>Senin, 20 Agustus 2026<br><strong>08.00 s/d selesai</strong></p>
            </div>
            <div class="event-item">
                <h2 class="script-title">Resepsi</h2>
                <p>Senin, 20 Agustus 2026<br><strong>10.00 s/d selesai</strong></p>
            </div>
            <p class="lead strong">Bertempat di kediaman mempelai pria</p>
            <p>Belakang Polres Semanding</p>
            <!-- Ganti href dengan link Google Maps lokasi acara. -->
            <a class="hero-button map-button" href="https://maps.google.com/?q=Semanding+Tuban" target="_blank" rel="noopener"><span class="map-icon" aria-hidden="true"></span>Maps</a>
        </section>
        <div class="floral-bridge" aria-hidden="true"></div>

        <!-- HALAMAN 6: Galeri. Ganti URL setiap gambar sesuai foto pribadi. -->
        <section class="page page-gallery" id="slide-6">
            <p class="small-title">Captured Moments</p>
            <h2 class="script-title">Galeri Foto</h2>
            <div class="gallery-grid">
                <img src="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&amp;fit=crop&amp;w=700&amp;q=85" alt="Momen pernikahan">
                <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&amp;fit=crop&amp;w=700&amp;q=85" alt="Dekorasi pernikahan">
                <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?auto=format&amp;fit=crop&amp;w=700&amp;q=85" alt="Momen bahagia">
                <img src="https://images.unsplash.com/photo-1520854221256-17451cc331bf?auto=format&amp;fit=crop&amp;w=700&amp;q=85" alt="Cincin pernikahan">
                <img src="https://images.unsplash.com/photo-1520854221256-17451cc331bf?auto=format&amp;fit=crop&amp;w=700&amp;q=85" alt="Dekorasi bunga pernikahan">
            </div>
        </section>
        <div class="floral-bridge" aria-hidden="true"></div>

        <!-- HALAMAN 7: RSVP. Data tersimpan di rsvp.csv. -->
        <section class="page page-rsvp" id="slide-7">
            <p class="small-title">Kindly Reply</p>
            <h2 class="script-title">Kesediaan Hadir</h2>
            <p class="lead">Kehadiran dan doa restu Anda adalah hadiah terindah bagi kami.</p>
            <?php if ($notice): ?><div class="notice"><?php echo htmlspecialchars($notice); ?></div><?php endif; ?>
            <form method="post">
                <input name="rsvp_name" placeholder="Nama lengkap" required>
                <select name="attendance" required>
                    <option value="">Konfirmasi kehadiran</option>
                    <option value="Hadir">Dengan senang hati, hadir</option>
                    <option value="Tidak hadir">Maaf, tidak dapat hadir</option>
                </select>
                <select name="guests">
                    <option value="1">1 orang</option>
                    <option value="2">2 orang</option>
                    <option value="3">3 orang</option>
                </select>
                <textarea name="message" placeholder="Ucapan untuk kedua mempelai"></textarea>
                <button class="hero-button" type="submit">Kirim Konfirmasi</button>
            </form>
        </section>
        <div class="floral-bridge" aria-hidden="true"></div>

        <!-- HALAMAN HADIAH: Ganti bank, nomor rekening, dan nama pemilik. -->
        <section class="page page-gift" id="slide-8">
            <p class="small-title">Wedding Gift</p>
            <h2 class="script-title">Tanda Kasih</h2>
            <p class="lead">Doa dan kehadiranmu telah lebih dari cukup. Bila ingin berbagi tanda kasih:</p>
            <div class="gift-card"><strong>BCA</strong><span>1234 5678 90<br><small>NENDEN NURAENI</small></span><button type="button" onclick="copyText('1234567890', this)">Salin</button></div>
            <div class="gift-card"><strong>Mandiri</strong><span>9876 5432 10<br><small>JANUAR RIZKY</small></span><button type="button" onclick="copyText('9876543210', this)">Salin</button></div>
        </section>
    </main>

    <div class="copy-toast" id="copyToast" role="status" aria-live="polite">Nomor rekening berhasil disalin</div>

    <!-- NAVIGASI: semua tombol mengarah ke halaman yang sesuai. -->
    <nav class="side-nav" aria-label="Navigasi undangan">
        <button type="button" onclick="goTo('slide-1')" aria-label="Beranda">⌂</button>
        <button type="button" onclick="goTo('slide-2')" aria-label="Sapaan tamu">✉</button>
        <button type="button" onclick="goTo('slide-3')" aria-label="Save the date">▣</button>
        <button type="button" onclick="goTo('slide-4')" aria-label="Mempelai">●</button>
        <button type="button" onclick="goTo('slide-5')" aria-label="Lokasi acara">⌖</button>
        <button type="button" onclick="goTo('slide-6')" aria-label="Galeri">▧</button>
        <button type="button" onclick="goTo('slide-7')" aria-label="Konfirmasi hadir">✓</button>
        <button type="button" onclick="goTo('slide-8')" aria-label="Hadiah">♡</button>
    </nav>

    <script>
        function goTo(id) {
            const target = document.getElementById(id);
            if (target) target.scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Buka Undangan langsung menuju halaman mempelai dan memulai musik.
        function openInvitation() {
            goTo('slide-4');
            playSong();
        }

        const song = document.getElementById('song');
        const music = document.getElementById('music');

        function playSong() {
            song.play().then(() => {
                music.textContent = '◖';
            }).catch(() => {});
        }

        music.addEventListener('click', () => {
            if (song.paused) {
                playSong();
            } else {
                song.pause();
                music.textContent = '♫';
            }
        });

        function copyText(value, button) {
            const finishCopy = () => {
                button.textContent = 'Tersalin';
                document.getElementById('copyToast').classList.add('show');
                setTimeout(() => {
                    button.textContent = 'Salin';
                    document.getElementById('copyToast').classList.remove('show');
                }, 1600);
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(value).then(finishCopy).catch(() => fallbackCopy(value, finishCopy));
            } else {
                fallbackCopy(value, finishCopy);
            }
        }

        function fallbackCopy(value, done) {
            const helper = document.createElement('textarea');
            helper.value = value;
            helper.style.position = 'fixed';
            helper.style.opacity = '0';
            document.body.appendChild(helper);
            helper.select();
            document.execCommand('copy');
            helper.remove();
            done();
        }
    </script>
    <script src="animasi.js?v=20260820-2"></script>
</body>

</html>