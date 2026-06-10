<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>ADigital Health Application Prototype Integrating Artificial Intelligence for the Analysis and Classification of Anemia in Children to Support Area-Based Health System</title>
    <meta content="นวัตกรรมเพื่อสุขภาพเด็ก: ต้นแบบแอปพลิเคชันสุขภาพดิจิทัลด้วยการบูรณาการเทดโนโลยีปัญญาประดิษฐ์สำหรับวิเคราะห์และจำแนกภาวะโลหิตจางในเด็กเพื่อสนับสนุนระบบสุขภาพระดับพื้นที่ " name="description">
    <link href="<?= base_url('img/favicon.png') ?>" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Prompt', 'Poppins', sans-serif;
            margin: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .fade-in {
            animation: fadeInUp 0.8s ease-out;
        }

        .float-anim {
            animation: float 4s ease-in-out infinite;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(14, 165, 233, 0.4);
        }

        .nav-link {
            transition: all 0.3s;
        }

        .nav-link:hover {
            color: #0ea5e9;
        }

        .gradient-hero {
            background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 50%, #0ea5e9 100%);
        }

        .gradient-section {
            background: linear-gradient(180deg, #f0f9ff 0%, #e0f2fe 100%);
        }

        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .timeline-dot {
            width: 16px;
            height: 16px;
            background: #0ea5e9;
            border-radius: 50%;
            border: 4px solid #e0f2fe;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="#" class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-sky-500 to-sky-700 rounded-xl flex items-center justify-center">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <circle cx="12" cy="12" r="4" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-gray-800">Kid CBC Checker</span>
            </a>
            <div class="hidden md:flex gap-8 items-center">
                <a href="#home" class="nav-link text-gray-600 font-medium" data-lang-th="หน้าแรก" data-lang-en="Home">หน้าแรก</a>
                <a href="#background" class="nav-link text-gray-600 font-medium" data-lang-th="ที่มา" data-lang-en="Background">ที่มา</a>
                <a href="#innovation" class="nav-link text-gray-600 font-medium" data-lang-th="นวัตกรรม" data-lang-en="Innovation">นวัตกรรม</a>
                <a href="#team" class="nav-link text-gray-600 font-medium" data-lang-th="ทีมวิจัย" data-lang-en="Team">ทีมวิจัย</a>
                <a href="#roadmap" class="nav-link text-gray-600 font-medium" data-lang-th="แผนงาน" data-lang-en="Roadmap">แผนงาน</a>
                <a href="#blooddata" class="btn-primary text-white px-5 py-2 rounded-lg font-medium" data-lang-th="ทดลองใช้งาน" data-lang-en="Try Now">ทดลองใช้งาน</a>
                <!-- Language Toggle -->
                <button id="langToggle" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition font-medium text-sm">
                    <span class="text-lg">🌐</span>
                    <span id="langText">TH</span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="gradient-hero min-h-screen flex items-center pt-20">
        <div class="max-w-7xl mx-auto px-6 py-16 grid lg:grid-cols-2 gap-12 items-center">
            <div class="text-white fade-in">
                <div class="inline-block bg-white/20 px-4 py-2 rounded-full text-sm font-medium mb-6" data-lang-th="🏥 โรงพยาบาลอุตรดิตถ์ ร่วมกับ มหาวิทยาลัยราชภัฎอุตรดิตถ์" data-lang-en="🏥 Uttaradit Hospital × Uttaradit Rajabhat University">🏥 โรงพยาบาลอุตรดิตถ์ ร่วมกับ มหาวิทยาลัยราชภัฎอุตรดิตถ์</div>
                <h1 class="text-3xl lg:text-5xl font-bold leading-tight mb-4" data-lang-th="นวัตกรรมเพื่อสุขภาพเด็ก" data-lang-en="Innovation for Child Health">นวัตกรรมเพื่อสุขภาพเด็ก</h1>
                <h2 class="text-xl lg:text-2xl font-medium text-sky-200 mb-6" data-lang-th="ต้นแบบแอปพลิเคชันสุขภาพดิจิทัลด้วยการบูรณาการเทดโนโลยีปัญญาประดิษฐ์สำหรับวิเคราะห์และจำแนกภาวะโลหิตจางในเด็กเพื่อสนับสนุนระบบสุขภาพระดับพื้นที่" data-lang-en="Digital Health Application Prototype Integrating Artificial Intelligence for the Analysis and Classification of Anemia in Children to Support Area-Based Health System">ต้นแบบแอปพลิเคชันสุขภาพดิจิทัลด้วยการบูรณาการเทดโนโลยีปัญญาประดิษฐ์สำหรับวิเคราะห์และจำแนกภาวะโลหิตจางในเด็กเพื่อสนับสนุนระบบสุขภาพระดับพื้นที่</h2>
                <p class="text-lg text-white/90 mb-4 font-light" style="display:none;" data-lang-en="Digital Health Application Prototype Integrating Artificial Intelligence for the Analysis and Classification of Anemia in Children to Support Area-Based Health System">Digital Health Application Prototype Integrating Artificial Intelligence for the Analysis and Classification of Anemia in Children to Support Area-Based Health System</p>
                <p class="text-xl text-sky-100 mb-8 border-l-4 border-sky-300 pl-4 italic"><span data-lang-th="&quot;ยกระดับการคัดกรองสุขภาพเด็กด้วยปัญญาประดิษฐ์<br>รวดเร็ว เข้าถึงง่าย อย่างมีประสิทธิภาพ&quot;" data-lang-en="&quot;Elevating Child Health Screening with AI<br>Fast, Accessible, and Efficient&quot;">"ยกระดับการคัดกรองสุขภาพเด็กด้วยปัญญาประดิษฐ์<br>รวดเร็ว เข้าถึงง่าย อย่างมีประสิทธิภาพ"</span></p>
                <div class="flex flex-wrap gap-4">
                    <a href="#background" class="btn-primary text-white px-8 py-3 rounded-xl font-semibold text-lg" data-lang-th="เกี่ยวกับโครงการ" data-lang-en="About Project">เกี่ยวกับโครงการ</a>
                    <a href="#team" class="bg-white/20 hover:bg-white/30 text-white px-8 py-3 rounded-xl font-semibold text-lg transition" data-lang-th="ทีมวิจัย" data-lang-en="Research Team">ทีมวิจัย</a>
                </div>

                <!-- Download App Section -->
                <div class="mt-8 pt-6 border-t border-white/20">
                    <p class="text-sky-200 text-sm font-medium mb-4" data-lang-th="📱 ดาวน์โหลดแอปพลิเคชัน" data-lang-en="📱 Download Application">📱 ดาวน์โหลดแอปพลิเคชัน</p>
                    <div class="flex flex-wrap gap-4">
                        <!-- Android APK Download -->
                        <a href="<?= base_url('download/KidCBCChecker_v.2.1.1.apk') ?>" class="flex items-center gap-3 bg-black/40 hover:bg-black/60 backdrop-blur px-5 py-3 rounded-xl transition group">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                                <path d="M17.523 2.226L15.93 5.13a7.67 7.67 0 00-3.93-1.08c-1.43 0-2.77.39-3.93 1.08L6.477 2.226a.484.484 0 00-.857.458l1.542 2.9A7.747 7.747 0 004 12.3h16a7.747 7.747 0 00-3.162-6.716l1.542-2.9a.484.484 0 00-.857-.458zM8.5 9.3a1 1 0 110-2 1 1 0 010 2zm7 0a1 1 0 110-2 1 1 0 010 2z" fill="#3DDC84" />
                                <path d="M4 13.3h16v6a3 3 0 01-3 3H7a3 3 0 01-3-3v-6z" fill="#3DDC84" />
                            </svg>
                            <div class="text-left">
                                <div class="text-white/70 text-xs" data-lang-th="ดาวน์โหลด APK" data-lang-en="Download APK">ดาวน์โหลด APK</div>
                                <div class="text-white font-semibold">Android</div>
                            </div>
                            <svg class="w-5 h-5 text-white/50 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>

                        <!-- iOS App Store -->
                        <a href="https://apps.apple.com/th/app/ai-anemia-support-app/id6736351093?l=th" target="_blank" class="flex items-center gap-3 bg-black/40 hover:bg-black/60 backdrop-blur px-5 py-3 rounded-xl transition group">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="white">
                                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z" />
                            </svg>
                            <div class="text-left">
                                <div class="text-white/70 text-xs" data-lang-th="ดาวน์โหลดบน" data-lang-en="Download on">ดาวน์โหลดบน</div>
                                <div class="text-white font-semibold">App Store</div>
                            </div>
                            <svg class="w-5 h-5 text-white/50 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex justify-center float-anim">
                <div class="relative">
                    <div class="w-72 h-72 lg:w-96 lg:h-96 bg-white/10 rounded-full flex items-center justify-center">
                        <div class="w-56 h-56 lg:w-72 lg:h-72 bg-white/20 rounded-full flex items-center justify-center">
                            <div class="text-center">
                                <div class="text-7xl lg:text-8xl mb-2">🩸</div>
                                <div class="text-white text-xl font-bold">Kid CBC Checker</div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute top-0 right-0 bg-white rounded-2xl p-4 shadow-xl"><span class="text-3xl">🧬</span></div>
                    <div class="absolute bottom-10 left-0 bg-white rounded-2xl p-4 shadow-xl"><span class="text-3xl">🔬</span></div>
                    <div class="absolute bottom-0 right-10 bg-white rounded-2xl p-4 shadow-xl"><span class="text-3xl">👶</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blood Data Detection Section -->
    <section id="blooddata" class="py-20 gradient-hero">
        <div class="max-w-3xl mx-auto px-6">
            <div class="text-center mb-8">
                <span class="bg-white/20 text-white px-4 py-2 rounded-full text-sm font-semibold" data-lang-th="🔬 ทดลองใช้งาน" data-lang-en="🔬 TRY IT NOW">🔬 ทดลองใช้งาน</span>
                <h2 class="text-3xl font-bold text-white mt-4">Kid CBC Checker</h2>
                <p class="text-sky-200 mt-2" data-lang-th="ระบบตรวจคัดกรองความผิดปกติของเม็ดเลือดแดงในเด็กอายุ 1-15 ปี" data-lang-en="Red Blood Cell disorder detection for children aged 1-15 years">ระบบตรวจคัดกรองความผิดปกติของเม็ดเลือดแดงในเด็กอายุ 1-15 ปี</p>
                <!-- Request Counter -->
                <div class="mt-4 flex justify-center items-center gap-2 text-white/80 text-sm font-medium">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    <span data-lang-th="จำนวนการประเมินทั้งหมด:" data-lang-en="Total Assessments:">จำนวนการประเมินทั้งหมด:</span>
                    <span id="requestCount" class="text-white font-bold bg-white/20 px-3 py-1 rounded-full">...</span>
                    <span data-lang-th="ครั้ง" data-lang-en="Cases">ครั้ง</span>
                </div>
            </div>
            <div class="glass rounded-3xl p-8 shadow-2xl">
                <form id="formblood">
                    <!-- Error Message Container -->
                    <div id="formErrorMessage" class="hidden bg-red-50 border-2 border-red-300 text-red-700 px-4 py-3 rounded-xl mb-4" role="alert">
                        <div class="flex items-center">
                            <span class="text-xl mr-2">⚠️</span>
                            <span id="errorText" class="font-semibold"></span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2"><span data-lang-th="👶 อายุ (Age)" data-lang-en="👶 Age">👶 อายุ (Age)</span></label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <input type="text" id="Age_year" name="Age_year" inputmode="decimal" placeholder="Years" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-500 focus:outline-none transition">
                                <span id="Age_year_error" class="text-red-600 text-xs mt-1 hidden"></span>
                            </div>
                            <div>
                                <input type="text" id="Age_month" name="Ages_month" inputmode="decimal" placeholder="Months" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-500 focus:outline-none transition">
                                <span id="Age_month_error" class="text-red-600 text-xs mt-1 hidden"></span>
                            </div>
                        </div>
                    </div>
                    <label class="block text-gray-700 font-semibold mb-2"><span data-lang-th="🩸 ข้อมูลเลือดสมบูรณ์ (CBC)" data-lang-en="🩸 Complete Blood Count (CBC) Data">🩸 ข้อมูลเลือดสมบูรณ์ (CBC)</span></label>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <input type="text" id="RBC" name="RBC" inputmode="decimal" placeholder="RBC" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-500 focus:outline-none transition">
                            <span id="RBC_error" class="text-red-600 text-xs mt-1 hidden"></span>
                        </div>
                        <div>
                            <input type="text" id="Hb" name="Hb" inputmode="decimal" placeholder="Hb" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-500 focus:outline-none transition">
                            <span id="Hb_error" class="text-red-600 text-xs mt-1 hidden"></span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <input type="text" id="Hct" name="Hct" inputmode="decimal" placeholder="Hct" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-500 focus:outline-none transition">
                            <span id="Hct_error" class="text-red-600 text-xs mt-1 hidden"></span>
                        </div>
                        <div>
                            <input type="text" id="MCV" name="MCV" inputmode="decimal" placeholder="MCV" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-500 focus:outline-none transition">
                            <span id="MCV_error" class="text-red-600 text-xs mt-1 hidden"></span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <input type="text" id="MCH" name="MCH" inputmode="decimal" placeholder="MCH" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-500 focus:outline-none transition">
                            <span id="MCH_error" class="text-red-600 text-xs mt-1 hidden"></span>
                        </div>
                        <div>
                            <input type="text" id="MCHC" name="MCHC" inputmode="decimal" placeholder="MCHC" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-500 focus:outline-none transition">
                            <span id="MCHC_error" class="text-red-600 text-xs mt-1 hidden"></span>
                        </div>
                    </div>
                    <div class="mb-6">
                        <input type="text" id="RDW" name="RDW" inputmode="decimal" placeholder="RDW" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-sky-500 focus:outline-none transition">
                        <span id="RDW_error" class="text-red-600 text-xs mt-1 hidden"></span>
                    </div>
                    <div class="flex gap-4">
                        <button type="button" id="clearBtn" class="w-1/3 bg-gray-200 hover:bg-gray-300 text-gray-700 py-4 rounded-xl font-bold text-lg transition"><span data-lang-th="🗑️ ล้างค่า" data-lang-en="🗑️ Clear">🗑️ ล้างค่า</span></button>
                        <button type="button" id="predictButton" class="w-2/3 btn-primary text-white py-4 rounded-xl font-bold text-lg"><span data-lang-th="🔍 แปลผล" data-lang-en="🔍 Analyze">🔍 แปลผล</span></button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Results Modal Popup -->
    <div id="resultModal" class="fixed inset-0 z-[100] hidden">
        <!-- Backdrop -->
        <div id="modalBackdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>

        <!-- Modal Content -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-3xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto animate-[fadeInUp_0.3s_ease-out]">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-sky-500 to-sky-700 rounded-t-3xl p-6 text-white z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold flex items-center gap-2"><span data-lang-th="📊 ผลการคัดกรอง" data-lang-en="📊 Screening Results">📊 ผลการคัดกรอง</span></h2>

                        </div>
                        <button id="closeModal" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <div class="grid lg:grid-cols-2 gap-6">
                        <!-- Result Card 1 -->
                        <div id="resultdisplay" class="bg-gradient-to-br from-sky-50 to-white rounded-2xl p-6 shadow-lg border border-sky-100" style="display:none;">
                            <h3 class="text-lg font-bold text-sky-600 mb-5 text-center flex items-center justify-center gap-2">
                                <span class="w-8 h-8 bg-sky-500 rounded-full flex items-center justify-center text-white text-sm">1</span>
                                <span data-lang-th="การประเมินคัดกรอง ปกติ/ผิดปกติ" data-lang-en="RBC Disorders">การประเมินคัดกรอง ปกติ/ผิดปกติ</span>
                            </h3>
                            <div class="grid grid-cols-3 gap-2 mb-3">
                                <div class="bg-white p-3 rounded-xl text-center shadow-sm border">
                                    <div class="text-xs text-gray-500" data-lang-th="อายุ" data-lang-en="Age">อายุ</div>
                                    <div class="font-bold text-sky-700"><span id="ageyear_text">-</span> <span data-lang-th="ปี" data-lang-en="y">ปี</span> <span id="agemonth_text">-</span> <span data-lang-th="ด." data-lang-en="m">ด.</span></div>
                                </div>
                                <div class="bg-white p-3 rounded-xl text-center shadow-sm border">
                                    <div class="text-xs text-gray-500">RBC</div>
                                    <div class="font-bold text-sky-700" id="RBC_text">-</div>
                                </div>
                                <div class="bg-white p-3 rounded-xl text-center shadow-sm border">
                                    <div class="text-xs text-gray-500">Hb</div>
                                    <div class="font-bold text-sky-700" id="Hb_text">-</div>
                                </div>
                            </div>
                            <div class="grid grid-cols-4 gap-2 mb-3">
                                <div class="bg-white p-3 rounded-xl text-center shadow-sm border">
                                    <div class="text-xs text-gray-500">Hct</div>
                                    <div class="font-bold text-sky-700" id="Hct_text">-</div>
                                </div>
                                <div class="bg-white p-3 rounded-xl text-center shadow-sm border">
                                    <div class="text-xs text-gray-500">MCV</div>
                                    <div class="font-bold text-sky-700" id="MCV_text">-</div>
                                </div>
                                <div class="bg-white p-3 rounded-xl text-center shadow-sm border">
                                    <div class="text-xs text-gray-500">MCH</div>
                                    <div class="font-bold text-sky-700" id="MCH_text">-</div>
                                </div>
                                <div class="bg-white p-3 rounded-xl text-center shadow-sm border">
                                    <div class="text-xs text-gray-500">MCHC</div>
                                    <div class="font-bold text-sky-700" id="MCHC_text">-</div>
                                </div>
                            </div>
                            <div class="bg-white p-3 rounded-xl text-center shadow-sm border mb-4">
                                <div class="text-xs text-gray-500">RDW</div>
                                <div class="font-bold text-sky-700" id="RDW_text">-</div>
                            </div>

                            <!-- Prediction Result -->
                            <div class="bg-gradient-to-r from-sky-500 to-sky-700 rounded-2xl p-5 text-white mb-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="text-xs opacity-80 mb-1" data-lang-th="🏥 ภาวะ" data-lang-en="🏥 Interpretation">🏥 ภาวะ</div>
                                        <div class="text-xl font-bold" id="predictedType">-</div>
                                    </div>
                                    <div>
                                        <div class="text-xs opacity-80 mb-1" data-lang-th="📈 ความมั่นใจ" data-lang-en="📈 Confidence">📈 ความมั่นใจ</div>
                                        <div class="text-xl font-bold"><span id="confidencevalue">-</span>%</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Feedback -->
                            <div id="responseAgree" class="bg-green-500 rounded-xl p-4 text-white text-center mb-4" style="display:none;">
                                <span class="text-2xl">✓</span>
                                <div class="font-bold" data-lang-th="ขอบคุณสำหรับความคิดเห็น!" data-lang-en="Thank you for your feedback!">ขอบคุณสำหรับความคิดเห็น!</div>
                            </div>
                            <div id="confirmform" class="text-center">
                                <input type="hidden" id="idRecord">
                                <p class="text-gray-600 text-sm mb-3" data-lang-th="คุณเห็นด้วยกับผลการประเมินหรือไม่?" data-lang-en="Do you agree with this assessment?">คุณเห็นด้วยกับผลการประเมินหรือไม่?</p>
                                <div class="flex gap-3 justify-center">
                                    <button id="agreePredict" class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-xl font-semibold transition text-sm"><span data-lang-th="👍 เห็นด้วย" data-lang-en="👍 Agree">👍 เห็นด้วย</span></button>
                                    <button id="rejectPredict" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl font-semibold transition text-sm"><span data-lang-th="👎 ไม่เห็นด้วย" data-lang-en="👎 Disagree">👎 ไม่เห็นด้วย</span></button>
                                </div>
                            </div>
                        </div>

                        <!-- Result Card 2 -->
                        <div id="resultdisplay2" class="bg-gradient-to-br from-purple-50 to-white rounded-2xl p-6 shadow-lg border border-purple-100" style="display:none;">
                            <h3 class="text-lg font-bold text-purple-600 mb-5 text-center flex items-center justify-center gap-2">
                                <span class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm">2</span>
                                <span data-lang-th="การประเมินคัดกรอง Thalassemia Trait (TT), Thalassemia Disease (TD), Iron Deficiency Anemia (IDA)" data-lang-en="Screening for Thalassemia Trait (TT), Thalassemia Disease (TD), Iron Deficiency Anemia (IDA)">การประเมินคัดกรอง Thalassemia Trait (TT), Thalassemia Disease (TD), Iron Deficiency Anemia (IDA)</span>
                            </h3>
                            <div class="text-center py-8">
                                <div class="text-5xl mb-3">🔬</div>
                                <h4 class="text-lg font-bold text-gray-700" data-lang-th="อยู่ในช่วงพัฒนา Model" data-lang-en="Model Under Development">อยู่ในช่วงพัฒนา Model</h4>
                                <p class="text-gray-500 text-sm" data-lang-th="เร็วๆ นี้..." data-lang-en="Coming Soon...">เร็วๆ นี้...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="sticky bottom-0 bg-gray-50 rounded-b-3xl p-4 border-t">
                    <div class="flex justify-center">
                        <button id="closeModalBtn" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-8 py-3 rounded-xl font-semibold transition">
                            <span data-lang-th="ปิดหน้าต่าง" data-lang-en="Close">ปิดหน้าต่าง</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Background Section -->
    <section id="background" class="gradient-section py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-sky-100 text-sky-600 px-4 py-2 rounded-full text-sm font-semibold">PROJECT BACKGROUND</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mt-4" data-lang-th="ทำไมต้องมีโครงการนี้?" data-lang-en="Why This Project?">ทำไมต้องมีโครงการนี้?</h2>
            </div>
            <div class="grid lg:grid-cols-2 gap-8 mb-12">
                <div class="glass rounded-3xl p-8 shadow-xl card-hover border-l-4 border-red-400">
                    <div class="text-4xl mb-4">⚠️</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4" data-lang-th="ปัญหาที่พบ" data-lang-en="The Problem">ปัญหาที่พบ</h3>
                    <p class="text-gray-600 text-lg leading-relaxed" data-lang-th="ภาวะโลหิตจางและความผิดปกติของเม็ดเลือดแดง (เช่น โรคธาลัสซีเมีย, ภาวะโลหิตจางจากการขาดธาตุเหล็ก) เป็นปัญหาสุขภาพที่พบบ่อยในเด็กไทย การวินิจฉัยแบบดั้งเดิมต้องอาศัยแพทย์เฉพาะทางและต้องแปรผลจำนวนมาก" data-lang-en="Anemia and red blood cell disorders (such as Thalassemia and Iron Deficiency Anemia) are common health issues in Thai children. Traditional diagnosis requires specialized physicians and extensive interpretation.">ภาวะโลหิตจางและความผิดปกติของเม็ดเลือดแดง (เช่น โรคธาลัสซีเมีย, ภาวะโลหิตจางจากการขาดธาตุเหล็ก) เป็นปัญหาสุขภาพที่พบบ่อยในเด็กไทย การวินิจฉัยแบบดั้งเดิมต้องอาศัยแพทย์เฉพาะทางและต้องแปรผลจำนวนมาก</p>
                </div>
                <div class="glass rounded-3xl p-8 shadow-xl card-hover border-l-4 border-green-400">
                    <div class="text-4xl mb-4">💡</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4" data-lang-th="แนวทางแก้ไข" data-lang-en="The Solution">แนวทางแก้ไข</h3>
                    <p class="text-gray-600 text-lg leading-relaxed" data-lang-th="การใช้เทคโนโลยี AI เข้ามาช่วยวิเคราะห์ผลการตรวจความสมบูรณ์ของเม็ดเลือด ช่วยสนับสนุนให้แพทย์คัดกรองเบื้องต้นได้อย่างมีประสิทธิภาพ โดยเฉพาะในพื้นที่ที่ขาดแคลนผู้เชี่ยวชาญเฉพาะทาง" data-lang-en="Using AI technology to analyze complete blood count results helps physicians conduct preliminary screening more efficiently, especially in areas with limited specialist expertise.">การใช้เทคโนโลยี AI เข้ามาช่วยวิเคราะห์ผลการตรวจความสมบูรณ์ของเม็ดเลือด ช่วยสนับสนุนให้แพทย์คัดกรองเบื้องต้นได้อย่างมีประสิทธิภาพ โดยเฉพาะในพื้นที่ที่ขาดแคลนผู้เชี่ยวชาญเฉพาะทาง</p>
                </div>
            </div>
            <div class="glass rounded-3xl p-8 shadow-xl">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center" data-lang-th="🎯 วัตถุประสงค์หลัก" data-lang-en="🎯 Main Objectives">🎯 วัตถุประสงค์หลัก</h3>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center p-6 rounded-2xl bg-sky-50">
                        <div class="w-16 h-16 bg-sky-500 rounded-2xl flex items-center justify-center mx-auto mb-4"><span class="text-3xl">🎯</span></div>
                        <h4 class="font-bold text-gray-800 mb-2" data-lang-th="พัฒนาโมเดล" data-lang-en="Model Development">พัฒนาโมเดล</h4>
                        <p class="text-gray-600 text-sm" data-lang-th="โมเดล AI สำหรับจำแนกความผิดปกติของเม็ดเลือดแดงในเด็ก" data-lang-en="AI model for classifying red blood cell disorders in children">โมเดล AI สำหรับจำแนกความผิดปกติของเม็ดเลือดแดงในเด็ก</p>
                    </div>
                    <div class="text-center p-6 rounded-2xl bg-purple-50">
                        <div class="w-16 h-16 bg-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-4"><span class="text-3xl">⚖️</span></div>
                        <h4 class="font-bold text-gray-800 mb-2" data-lang-th="เปรียบเทียบประสิทธิภาพ" data-lang-en="Performance Comparison">เปรียบเทียบประสิทธิภาพ</h4>
                        <p class="text-gray-600 text-sm" data-lang-th="ค้นหาโมเดลที่เหมาะสมโดยใช้เทคนิคสถิติและ Deep Learning" data-lang-en="Finding optimal models using statistical techniques and Deep Learning">ค้นหาโมเดลที่เหมาะสมโดยใช้เทคนิคสถิติและ Deep Learning</p>
                    </div>
                    <div class="text-center p-6 rounded-2xl bg-green-50">
                        <div class="w-16 h-16 bg-green-500 rounded-2xl flex items-center justify-center mx-auto mb-4"><span class="text-3xl">🖥️</span></div>
                        <h4 class="font-bold text-gray-800 mb-2" data-lang-th="สร้างต้นแบบนวัตกรรมสุขภาพดิจิทัล" data-lang-en="Digital Health Innovation Prototype">สร้างต้นแบบนวัตกรรมสุขภาพดิจิทัล</h4>
                        <p class="text-gray-600 text-sm" data-lang-th="พัฒนาต้นแบบนวัตกรรมสุขภาพดิจิทัลที่ใช้งานง่าย สำหรับบุคลากรทางการแพทย์" data-lang-en="Developing user-friendly digital health innovation prototype for medical personnel">พัฒนาต้นแบบนวัตกรรมสุขภาพดิจิทัลที่ใช้งานง่าย สำหรับบุคลากรทางการแพทย์</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Innovation Section -->
    <section id="innovation" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-purple-100 text-purple-600 px-4 py-2 rounded-full text-sm font-semibold">TECHNOLOGY</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mt-4" data-lang-th="เทคโนโลยีเบื้องหลัง" data-lang-en="Technology Behind">เทคโนโลยีเบื้องหลัง</h2>
                <p class="text-gray-600 mt-2" data-lang-th="นวัตกรรมและวิธีการ" data-lang-en="Our Innovation & Methodology">นวัตกรรมและวิธีการ</p>
            </div>
            <div class="grid lg:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-sky-500 to-sky-700 rounded-3xl p-8 text-white card-hover">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-6"><span class="text-3xl">📊</span></div>
                    <h3 class="text-xl font-bold mb-4">Lognormal Naïve Bayes</h3>
                    <p class="text-white/90 leading-relaxed" data-lang-th="การประยุกต์ใช้การแจกแจงแบบล็อกนอร์มัลเข้ากับโมเดลพื้นฐาน เพื่อให้สอดคล้องกับธรรมชาติของข้อมูลทางการแพทย์" data-lang-en="Applying lognormal distribution to the baseline model to align with the nature of medical data">การประยุกต์ใช้การแจกแจงแบบล็อกนอร์มัลเข้ากับโมเดลพื้นฐาน เพื่อให้สอดคล้องกับธรรมชาติของข้อมูลทางการแพทย์</p>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-3xl p-8 text-white card-hover">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-6"><span class="text-3xl">🧠</span></div>
                    <h3 class="text-xl font-bold mb-4">MLP with Focal Loss</h3>
                    <p class="text-white/90 leading-relaxed" data-lang-th="การใช้โครงข่ายประสาทเทียมร่วมกับ Focal Loss เพื่อแก้ปัญหา Imbalanced Data ทำให้จำแนกโรคที่พบน้อยได้ดียิ่งขึ้น" data-lang-en="Using neural networks with Focal Loss to address imbalanced data, improving classification of rare diseases">การใช้โครงข่ายประสาทเทียมร่วมกับ Focal Loss เพื่อแก้ปัญหา Imbalanced Data ทำให้จำแนกโรคที่พบน้อยได้ดียิ่งขึ้น</p>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-3xl p-8 text-white card-hover">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-6"><span class="text-3xl">💻</span></div>
                    <h3 class="text-xl font-bold mb-4">Digital Platform</h3>
                    <p class="text-white/90 leading-relaxed" data-lang-th="ระบบที่เชื่อมต่อโมเดล AI เข้ากับหน้าจอที่ใช้งานง่าย (User Friendly) รองรับการใช้งานจริงในโรงพยาบาล" data-lang-en="System connecting AI models with user-friendly interface, supporting real-world hospital deployment">ระบบที่เชื่อมต่อโมเดล AI เข้ากับหน้าจอที่ใช้งานง่าย (User Friendly) รองรับการใช้งานจริงในโรงพยาบาล</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="py-20 gradient-section">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold">RESEARCH TEAM</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mt-4" data-lang-th="คณะผู้วิจัย" data-lang-en="Research Team">คณะผู้วิจัย</h2>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="glass rounded-3xl p-6 text-center card-hover shadow-lg border-t-4 border-yellow-400">
                    <div class="w-64 h-64 rounded-full overflow-hidden mx-auto mb-4 border-4 border-yellow-100 bg-yellow-50 flex items-center justify-center">
                        <img src="<?= base_url('/img/team/patcharanapa.png') ?>" alt="พญ.พัชรนภา จงอัจฉริยกุล" class="w-full h-full object-cover" loading="lazy" onerror="this.onerror=null; this.parentElement.innerHTML='<span class=\'text-4xl\'>👩‍⚕️</span>'">
                    </div>
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold" data-lang-th="ที่ปรึกษาโครงการ" data-lang-en="Project Advisor">ที่ปรึกษาโครงการ</span>
                    <h3 class="text-lg font-bold text-gray-800 mt-3" data-lang-th="พญ.พัชรนภา จงอัจฉริยกุล" data-lang-en="Dr. Patcharanapa Chongachariyakul">พญ.พัชรนภา จงอัจฉริยกุล</h3>
                    <p class="text-gray-500 text-sm mt-1" data-lang-th="กุมารแพทย์ โรงพยาบาลอุตรดิตถ์" data-lang-en="Pediatrician, Uttaradit Hospital">กุมารแพทย์ โรงพยาบาลอุตรดิตถ์</p>
                </div>
                <div class="glass rounded-3xl p-6 text-center card-hover shadow-lg border-t-4 border-sky-400">
                    <div class="w-64 h-64 rounded-full overflow-hidden mx-auto mb-4 border-4 border-sky-100 bg-sky-50 flex items-center justify-center">
                        <img src="<?= base_url('/img/team/patcharee.png') ?>" alt="ผศ.ดร.พัชรี มณีรัตน์" class="w-full h-full object-cover" loading="lazy" onerror="this.onerror=null; this.parentElement.innerHTML='<span class=\'text-4xl\'>👩‍🔬</span>'">
                    </div>
                    <span class="bg-sky-100 text-sky-700 px-3 py-1 rounded-full text-xs font-semibold" data-lang-th="หัวหน้าโครงการ" data-lang-en="Project Leader">หัวหน้าโครงการ</span>
                    <h3 class="text-lg font-bold text-gray-800 mt-3" data-lang-th="ผศ.ดร.พัชรี มณีรัตน์" data-lang-en="Asst. Prof. Dr. Patcharee Maneerat">ผศ.ดร.พัชรี มณีรัตน์</h3>
                    <p class="text-gray-500 text-sm mt-1" data-lang-th="สังกัดสาขาวิชาวิศวกรรมคอมพิวเตอร์และปัญญาประดิษฐ์<br> มหาวิทยาลัยราชภัฎอุตรดิตถ์" data-lang-en="Faculty of Science and Technology<br>Uttaradit Rajabhat University">สังกัดสาขาวิชาวิศวกรรมคอมพิวเตอร์และปัญญาประดิษฐ์<br> มหาวิทยาลัยราชภัฎอุตรดิตถ์</p>
                </div>
                <div class="glass rounded-3xl p-6 text-center card-hover shadow-lg border-t-4 border-purple-400">
                    <a href="<?= base_url('download/workshop.html') ?>">
					<div class="w-64 h-64 rounded-full overflow-hidden mx-auto mb-4 border-4 border-purple-100 bg-purple-50 flex items-center justify-center">
                        <img src="<?= base_url('/img/team/pisit.png') ?>" alt="ผศ.ดร.พิศิษฐ์ นาคใจ" class="w-full h-full object-cover" loading="lazy" onerror="this.onerror=null; this.parentElement.innerHTML='<span class=\'text-4xl\'>👨‍💻</span>'">
                    </div>
                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold" data-lang-th="ผู้ร่วมวิจัย" data-lang-en="Co-Researcher">ผู้ร่วมวิจัย </span>
                    <h3 class="text-lg font-bold text-gray-800 mt-3" data-lang-th="ผศ.ดร.พิศิษฐ์ นาคใจ" data-lang-en="Asst. Prof. Dr. Pisit Nakjai">ผศ.ดร.พิศิษฐ์ นาคใจ</h3>
                    <p class="text-gray-500 text-sm mt-1" data-lang-th="สังกัดสาขาวิชาวิศวกรรมคอมพิวเตอร์และปัญญาประดิษฐ์ <br> มหาวิทยาลัยราชภัฎอุตรดิตถ์" data-lang-en="Faculty of Science and Technology<br>Uttaradit Rajabhat University">สังกัดสาขาวิชาวิศวกรรมคอมพิวเตอร์และปัญญาประดิษฐ์ <br> มหาวิทยาลัยราชภัฎอุตรดิตถ์</p>
                </a>
				</div>
                <div class="glass rounded-3xl p-6 text-center card-hover shadow-lg border-t-4 border-green-400">
                    <div class="w-64 h-64 rounded-full overflow-hidden mx-auto mb-4 border-4 border-green-100 bg-green-50 flex items-center justify-center">
                        <img src="<?= base_url('/img/team/niyada.jpg') ?>" alt="อาจารย์ ดร.นิยดา รักวงษ์" class="w-full h-full object-cover" loading="lazy" onerror="this.onerror=null; this.parentElement.innerHTML='<span class=\'text-4xl\'>👩‍🏫</span>'">
                    </div>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold" data-lang-th="ผู้ร่วมวิจัย" data-lang-en="Co-Researcher">ผู้ร่วมวิจัย</span>
                    <h3 class="text-lg font-bold text-gray-800 mt-3" data-lang-th="อาจารย์ ดร.นิยดา รักวงษ์" data-lang-en="Dr. Niyada Rakwong">อาจารย์ ดร.นิยดา รักวงษ์</h3>
                    <p class="text-gray-500 text-sm mt-1" data-lang-th="สังกัดสาขาวิชาเศษฐศาสตร์ดิจิทัล <br> มหาวิทยาลัยราชภัฎอุตรดิตถ์" data-lang-en="Faculty of Management Sciences<br>Uttaradit Rajabhat University">สังกัดสาขาวิชาเศษฐศาสตร์ดิจิทัล <br> มหาวิทยาลัยราชภัฎอุตรดิตถ์</p>
                </div>
                <div class="glass rounded-3xl p-6 text-center card-hover shadow-lg border-t-4 border-orange-400">
                    <div class="w-64 h-64 rounded-full overflow-hidden mx-auto mb-4 border-4 border-orange-100 bg-orange-50 flex items-center justify-center">
                        <img src="<?= base_url('/img/team/suthipod.jpg') ?>" alt="อาจารย์ ดร.สุทธิพจน์ พีรณวงษ์" class="w-full h-full object-cover" loading="lazy" onerror="this.onerror=null; this.parentElement.innerHTML='<span class=\'text-4xl\'>👨‍🎓</span>'">
                    </div>
                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-semibold" data-lang-th="ผู้ร่วมวิจัย" data-lang-en="Co-Researcher">ผู้ร่วมวิจัย</span>
                    <h3 class="text-lg font-bold text-gray-800 mt-3" data-lang-th="อาจารย์ ดร.สุทธิพจน์ พีรณวงษ์" data-lang-en="Dr. Sutthiphod Phiranawong">อาจารย์ ดร.สุทธิพจน์ พีรณวงษ์</h3>
                    <p class="text-gray-500 text-sm mt-1" data-lang-th="สังกัดภาควิชาภาษาศาสตร์ คติชนวิทยา ปรัชญาและศาสนา <br> มหาวิทยาลัยนเรศวร" data-lang-en="Department of Linguistics, Folklore, Philosophy and Religion<br>Naresuan University">สังกัดภาควิชาภาษาศาสตร์ คติชนวิทยา ปรัชญาและศาสนา <br> มหาวิทยาลัยนเรศวร</p>
                </div>
                <div class="glass rounded-3xl p-6 text-center card-hover shadow-lg border-t-4 border-purple-400">
                    <div class="w-64 h-64 rounded-full overflow-hidden mx-auto mb-4 border-4 border-purple-100 bg-purple-50 flex items-center justify-center">
                        <img src="<?= base_url('/img/team/tadchai.jpg') ?>" alt="ผศ.ดร. ธัชชัย อยู่ยิ่ง" class="w-full h-full object-cover" loading="lazy" onerror="this.onerror=null; this.parentElement.innerHTML='<span class=\'text-4xl\'>👨‍🎓</span>'">
                    </div>
                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold" data-lang-th="ผู้ร่วมวิจัย" data-lang-en="Co-Researcher">ผู้ร่วมวิจัย</span>
                    <h3 class="text-lg font-bold text-gray-800 mt-3" data-lang-th="ผศ.ดร.ธัชชัย อยู่ยิ่ง" data-lang-en="Asst. Prof. Dr. Tadchai Yuying">ผศ.ดร.ธัชชัย อยู่ยิ่ง</h3>
                    <p class="text-gray-500 text-sm mt-1" data-lang-th="สังกัดสาขาวิชาคณิตศาสตร์ประยุกต์<br> มหาวิทยาลัยราชภัฎอุตรดิตถ์" data-lang-en="Faculty of Science and Technology<br>Uttaradit Rajabhat University">สังกัดสาขาวิชาคณิตศาสตร์ประยุกต์<br> มหาวิทยาลัยราชภัฎอุตรดิตถ์</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Roadmap Section -->
    <section id="roadmap" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="bg-orange-100 text-orange-600 px-4 py-2 rounded-full text-sm font-semibold">PROJECT ROADMAP</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mt-4" data-lang-th="ระยะเวลาดำเนินงาน" data-lang-en="Timeline">ระยะเวลาดำเนินงาน</h2>
                <p class="text-gray-600 mt-2" data-lang-th="ตุลาคม 2568 - กันยายน 2569" data-lang-en="October 2025 - September 2026">ตุลาคม 2568 - กันยายน 2569</p>
            </div>
            <div class="max-w-4xl mx-auto">
                <div class="flex gap-6 mb-8">
                    <div class="flex flex-col items-center">
                        <div class="timeline-dot"></div>
                        <div class="w-0.5 h-full bg-sky-200"></div>
                    </div>
                    <div class="glass rounded-2xl p-6 shadow-lg flex-1 card-hover">
                        <span class="bg-sky-500 text-white px-3 py-1 rounded-full text-sm font-bold">Phase 1</span>
                        <span class="text-gray-500 text-sm ml-2" data-lang-th="เดือน 1-3" data-lang-en="Month 1-3">เดือน 1-3</span>
                        <h3 class="text-xl font-bold text-gray-800 mt-3" data-lang-th="รวบรวมข้อมูลและทบทวนวรรณกรรม" data-lang-en="Data Collection & Literature Review">รวบรวมข้อมูลและทบทวนวรรณกรรม</h3>
                        <p class="text-gray-600 mt-2" style="display:none;" data-lang-en="Data Collection & Literature Review">Data Collection & Literature Review</p>
                    </div>
                </div>
                <div class="flex gap-6 mb-8">
                    <div class="flex flex-col items-center">
                        <div class="timeline-dot"></div>
                        <div class="w-0.5 h-full bg-sky-200"></div>
                    </div>
                    <div class="glass rounded-2xl p-6 shadow-lg flex-1 card-hover">
                        <span class="bg-purple-500 text-white px-3 py-1 rounded-full text-sm font-bold">Phase 2</span>
                        <span class="text-gray-500 text-sm ml-2" data-lang-th="เดือน 4-6" data-lang-en="Month 4-6">เดือน 4-6</span>
                        <h3 class="text-xl font-bold text-gray-800 mt-3" data-lang-th="พัฒนาและฝึกสอนโมเดล" data-lang-en="Model Training & Development">พัฒนาและฝึกสอนโมเดล</h3>
                        <p class="text-gray-600 mt-2" style="display:none;" data-lang-en="Model Training & Development">Model Training & Development</p>
                    </div>
                </div>
                <div class="flex gap-6 mb-8">
                    <div class="flex flex-col items-center">
                        <div class="timeline-dot"></div>
                        <div class="w-0.5 h-full bg-sky-200"></div>
                    </div>
                    <div class="glass rounded-2xl p-6 shadow-lg flex-1 card-hover">
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-bold">Phase 3</span>
                        <span class="text-gray-500 text-sm ml-2" data-lang-th="เดือน 7-9" data-lang-en="Month 7-9">เดือน 7-9</span>
                        <h3 class="text-xl font-bold text-gray-800 mt-3" data-lang-th="ประเมินผลโมเดลและพัฒนาต้นแบบนวัตกรรมสุขภาพดิจิทัล" data-lang-en="Evaluation & Digital Health Prototype Development">ประเมินผลโมเดลและพัฒนาต้นแบบนวัตกรรมสุขภาพดิจิทัล</h3>
                        <p class="text-gray-600 mt-2" style="display:none;" data-lang-en="Evaluation & Digital Health Prototype Development">Evaluation & Digital Health Prototype Development</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="flex flex-col items-center">
                        <div class="timeline-dot"></div>
                    </div>
                    <div class="glass rounded-2xl p-6 shadow-lg flex-1 card-hover">
                        <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-sm font-bold">Phase 4</span>
                        <span class="text-gray-500 text-sm ml-2" data-lang-th="เดือน 10-12" data-lang-en="Month 10-12">เดือน 10-12</span>
                        <h3 class="text-xl font-bold text-gray-800 mt-3" data-lang-th="ทดสอบการใช้งานต้นแบบนวัตกรรมสุขภาพดิจิทัล" data-lang-en="Digital Health Prototype Testing">ทดสอบการใช้งานต้นแบบนวัตกรรมสุขภาพดิจิทัล</h3>
                        <p class="text-gray-600 mt-2" style="display:none;" data-lang-en="Digital Health Prototype Testing">Digital Health Prototype Testing</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact/Footer Section -->
    <section class="py-16 gradient-section">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800" data-lang-th="🎯 ผลลัพธ์ที่คาดหวัง" data-lang-en="🎯 Expected Outcomes">🎯 ผลลัพธ์ที่คาดหวัง</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6 mb-12">
                <div class="glass rounded-2xl p-6 text-center card-hover">
                    <div class="text-4xl mb-3">👨‍⚕️</div>
                    <h4 class="font-bold text-gray-800" data-lang-th="ลดภาระงานบุคลากรทางการแพทย์" data-lang-en="Reduce Medical Staff Workload">ลดภาระงานบุคลากรทางการแพทย์</h4>
                    <p class="text-gray-600 text-sm mt-2" data-lang-th="ช่วยคัดกรองเบื้องต้นอัตโนมัติ" data-lang-en="Automated preliminary screening assistance">ช่วยคัดกรองเบื้องต้นอัตโนมัติ</p>
                </div>
                <div class="glass rounded-2xl p-6 text-center card-hover">
                    <div class="text-4xl mb-3">⚡</div>
                    <h4 class="font-bold text-gray-800" data-lang-th="เครื่องมือสนับสนุนบุคลากรทางการแพทย์" data-lang-en="Medical Personnel Support Tool">เครื่องมือสนับสนุนบุคลากรทางการแพทย์</h4>
                    <p class="text-gray-600 text-sm mt-2" data-lang-th="ช่วยให้การคัดกรองเร็วขึ้น เด็กได้รับการรักษาทันท่วงที" data-lang-en="Faster screening enables timely treatment for children">ช่วยให้การคัดกรองเร็วขึ้น เด็กได้รับการรักษาทันท่วงที</p>
                </div>
                <div class="glass rounded-2xl p-6 text-center card-hover">
                    <div class="text-4xl mb-3">📚</div>
                    <h4 class="font-bold text-gray-800" data-lang-th="สนับสนุนการเรียนสำหรับนักศึกษาแพทย์" data-lang-en="Educational Support for Medical Students">สนับสนุนการเรียนสำหรับนักศึกษาแพทย์</h4>
                    <p class="text-gray-600 text-sm mt-2" data-lang-th="เครื่องมือช่วยการเรียนรู้และฝึกฝนการคัดกรอง" data-lang-en="Learning and training tool for screening practice">เครื่องมือช่วยการเรียนรู้และฝึกฝนการคัดกรอง</p>
                </div>
            </div>
            <div class="glass rounded-2xl p-6 text-center max-w-2xl mx-auto">
                <h4 class="font-bold text-gray-800 mb-2" data-lang-th="🏥 พื้นที่เป้าหมาย" data-lang-en="🏥 Target Area">🏥 พื้นที่เป้าหมาย</h4>
                <p class="text-gray-600" data-lang-th="โรงพยาบาลอุตรดิตถ์ และโรงพยาบาลใกล้เคียง" data-lang-en="Uttaradit Hospital and nearby hospitals">โรงพยาบาลอุตรดิตถ์ และโรงพยาบาลใกล้เคียง</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="gradient-hero text-white py-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="flex items-center justify-center gap-3 mb-6">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center"><span class="text-2xl">🩸</span></div>
                <span class="text-2xl font-bold">Kid CBC Checker</span>
            </div>
            <p class="text-sky-200 mb-4" data-lang-th="นวัตกรรมเพื่อสุขภาพเด็ก" data-lang-en="Innovation for Child Health">นวัตกรรมเพื่อสุขภาพเด็ก</p>
            <div class="border-t border-white/20 pt-6 mt-6">
                <p class="text-sm text-white/70 mb-2" data-lang-th="คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยราชภัฏอุตรดิตถ์ × โรงพยาบาลอุตรดิตถ์" data-lang-en="Faculty of Science and Technology, Uttaradit Rajabhat University × Uttaradit Hospital">คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยราชภัฏอุตรดิตถ์ × โรงพยาบาลอุตรดิตถ์</p>
                <p class="text-xs text-white/50">© 2568-2569 AI-Powered Digital Platform for RBC Disorder Classification</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- Reject Options Modal -->
    <div id="rejectOptionsModal" class="fixed inset-0 z-[200] hidden">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 animate-[fadeInUp_0.3s_ease-out]">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">👎</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2" data-lang-th="คุณไม่เห็นด้วยกับผลการประเมิน" data-lang-en="You disagree with the assessment">คุณไม่เห็นด้วยกับผลการประเมิน</h3>
                    <p class="text-gray-600 text-sm" data-lang-th="กรุณาเลือกผลการประเมินที่คุณคิดว่าถูกต้อง" data-lang-en="Please select the assessment result you believe is correct">กรุณาเลือกผลการประเมินที่คุณคิดว่าถูกต้อง</p>
                </div>
                <div id="rejectOptionsList" class="space-y-3 mb-6">
                    <!-- Options will be dynamically inserted here -->
                </div>
                <div class="flex gap-3">
                    <button id="cancelRejectModal" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-6 rounded-xl font-semibold transition">
                        <span data-lang-th="ยกเลิก" data-lang-en="Cancel">ยกเลิก</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- LINE Browser Redirect Modal -->
    <div id="lineBrowserModal" class="fixed inset-0 z-[200] hidden">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 text-center animate-[fadeInUp_0.3s_ease-out]">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2C6.48 2 2 5.69 2 10.21c0 4.16 3.69 7.64 8.68 8.28.34.07.8.22.92.51.11.27.07.69.04.96l-.15.89c-.04.26-.2 1.01.88.55 1.08-.46 5.83-3.44 7.96-5.89C21.99 13.62 22 11.96 22 10.21 22 5.69 17.52 2 12 2z" fill="#06C755" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4" data-lang-th="กรุณาเปิดใน Browser ภายนอก" data-lang-en="Please open in external browser">กรุณาเปิดใน Browser ภายนอก</h3>
                <p class="text-gray-600 mb-6" data-lang-th="LINE Browser ไม่สามารถดาวน์โหลดไฟล์ APK ได้โดยตรง กรุณาเปิดในเบราว์เซอร์ภายนอกเพื่อดาวน์โหลด" data-lang-en="LINE Browser cannot download APK files directly. Please open in an external browser to download.">LINE Browser ไม่สามารถดาวน์โหลดไฟล์ APK ได้โดยตรง กรุณาเปิดในเบราว์เซอร์ภายนอกเพื่อดาวน์โหลด</p>
                <div class="space-y-3">
                    <button id="openExternalBrowser" class="w-full bg-gradient-to-r from-sky-500 to-sky-700 text-white py-3 px-6 rounded-xl font-semibold hover:shadow-lg transition">
                        <span data-lang-th="🌐 เปิดในเบราว์เซอร์" data-lang-en="🌐 Open in Browser">🌐 เปิดในเบราว์เซอร์</span>
                    </button>
                    <button id="copyDownloadLink" class="w-full bg-gray-100 text-gray-700 py-3 px-6 rounded-xl font-semibold hover:bg-gray-200 transition">
                        <span data-lang-th="📋 คัดลอกลิงก์ดาวน์โหลด" data-lang-en="📋 Copy Download Link">📋 คัดลอกลิงก์ดาวน์โหลด</span>
                    </button>
                    <button id="closeLineBrowserModal" class="w-full text-gray-500 py-2 font-medium hover:text-gray-700 transition">
                        <span data-lang-th="ปิด" data-lang-en="Close">ปิด</span>
                    </button>
                </div>
                <p id="copySuccess" class="text-green-500 text-sm mt-4 hidden" data-lang-th="✓ คัดลอกลิงก์สำเร็จแล้ว!" data-lang-en="✓ Link copied successfully!">✓ คัดลอกลิงก์สำเร็จแล้ว!</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url('assets/js/backend-bundle.min.js') ?>"></script>
    <script>
        // Language-aware text helper
        function getLangText(th, en) {
            var lang = localStorage.getItem('language') || 'th';
            return lang === 'en' ? en : th;
        }

        // Debug: ตรวจสอบว่า script ทำงาน
        console.log("=== Script เริ่มทำงาน ===");
        console.log("jQuery version:", typeof jQuery !== 'undefined' ? jQuery.fn.jquery : 'Not loaded');
        console.log("Current URL:", window.location.href);

        // จำกัดการป้อนข้อมูลในฟอร์มให้รับเฉพาะตัวเลขและจุดทศนิยม
        $(document).ready(function() {
            // ฟังก์ชันสำหรับแสดง error
            function showError(fieldId, message) {
                // ซ่อน error ทั้งหมดก่อน
                clearAllErrors();

                // แสดง error message ด้านบน
                $("#formErrorMessage").removeClass("hidden");
                $("#errorText").text(message);

                // เปลี่ยนกรอบเป็นสีแดง
                $("#" + fieldId).removeClass("border-gray-200 border-sky-500")
                    .addClass("border-red-500");

                // Focus ที่ field
                $("#" + fieldId).focus();

                // Scroll ไปที่ error message
                $('html, body').animate({
                    scrollTop: $("#formErrorMessage").offset().top - 100
                }, 500);
            }

            // ฟังก์ชันสำหรับล้าง error ทั้งหมด
            function clearAllErrors() {
                $("#formErrorMessage").addClass("hidden");
                $("#errorText").text("");
                $("input[type='text']").removeClass("border-red-500")
                    .addClass("border-gray-200");
            }

            // เมื่อมีการพิมพ์ใน input ให้ล้าง error
            $("#Age_year, #Age_month, #RBC, #Hb, #Hct, #MCV, #MCH, #MCHC, #RDW").on('input', function() {
                clearAllErrors();
            });

            // ฟังก์ชันสำหรับจำกัดการป้อนข้อมูลเฉพาะตัวเลขและจุดทศนิยม
            function restrictToDecimal(event) {
                var charCode = event.which || event.keyCode;
                var currentValue = $(this).val();

                // อนุญาต: backspace (8), delete (46), tab (9), escape (27), enter (13)
                if (charCode === 8 || charCode === 46 || charCode === 9 || charCode === 27 || charCode === 13) {
                    return true;
                }

                // อนุญาต: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                if ((charCode === 65 || charCode === 67 || charCode === 86 || charCode === 88) &&
                    (event.ctrlKey === true || event.metaKey === true)) {
                    return true;
                }

                // อนุญาต: Home, End, ลูกศร
                if (charCode >= 35 && charCode <= 40) {
                    return true;
                }

                // อนุญาตจุดทศนิยมเพียงจุดเดียว
                if (charCode === 46 || charCode === 110 || charCode === 190) {
                    if (currentValue.indexOf('.') !== -1) {
                        event.preventDefault();
                        return false;
                    }
                    return true;
                }

                // อนุญาตเฉพาะตัวเลข 0-9
                if ((charCode < 48 || charCode > 57) && (charCode < 96 || charCode > 105)) {
                    event.preventDefault();
                    return false;
                }

                return true;
            }

            // ใช้งานกับทุก input ในฟอร์ม
            $("#Age_year, #Age_month, #RBC, #Hb, #Hct, #MCV, #MCH, #MCHC, #RDW").keydown(restrictToDecimal);

            // ป้องกันการวางข้อความที่ไม่ใช่ตัวเลข
            $("#Age_year, #Age_month, #RBC, #Hb, #Hct, #MCV, #MCH, #MCHC, #RDW").on('paste', function(e) {
                var pastedData = e.originalEvent.clipboardData.getData('text');
                if (!/^[0-9]*\.?[0-9]*$/.test(pastedData)) {
                    e.preventDefault();
                    showError($(this).attr('id'), getLangText("สามารถวางได้เฉพาะตัวเลขและจุดทศนิยมเท่านั้น", "Only numbers and decimal points are allowed"));
                }
            });

            // ทำให้ showError และ clearAllErrors เป็น global function
            window.showError = showError;
            window.clearAllErrors = clearAllErrors;
        });

        // APK Download URL
        const APK_DOWNLOAD_URL = "<?= base_url('download/ai-amenai-support.apk') ?>";
        const CURRENT_PAGE_URL = window.location.href;

        console.log("APK Download URL:", APK_DOWNLOAD_URL);

        // Detect if running in LINE in-app browser
        function isLineBrowser() {
            const ua = navigator.userAgent || navigator.vendor || window.opera;
            return /Line/i.test(ua);
        }

        // Detect if running in Facebook in-app browser
        function isFacebookBrowser() {
            const ua = navigator.userAgent || navigator.vendor || window.opera;
            return /FBAN|FBAV|FB_IAB/i.test(ua);
        }

        // Detect any in-app browser
        function isInAppBrowser() {
            const ua = navigator.userAgent || navigator.vendor || window.opera;
            const rules = [
                'WebView',
                'Line',
                'FBAN|FBAV',
                'Instagram',
                'Twitter',
                'KAKAOTALK',
                'NAVER',
                'Snapchat',
                'Pinterest'
            ];
            const regex = new RegExp('(' + rules.join('|') + ')', 'i');
            return regex.test(ua);
        }

        // Open in external browser using various methods
        function openInExternalBrowser(url) {
            const ua = navigator.userAgent || navigator.vendor || window.opera;

            // For LINE Browser on Android - try intent scheme
            if (isLineBrowser() && /android/i.test(ua)) {
                // Method 1: Try intent:// scheme for Android
                const intentUrl = 'intent://' + url.replace(/^https?:\/\//, '') +
                    '#Intent;scheme=https;package=com.android.chrome;end';
                window.location.href = intentUrl;

                // Fallback: Try opening in a new window after a delay
                setTimeout(function() {
                    window.open(url, '_system');
                }, 1000);
                return;
            }

            // For LINE Browser on iOS
            if (isLineBrowser() && /iphone|ipad|ipod/i.test(ua)) {
                // Safari will handle this
                window.location.href = url;
                return;
            }

            // Generic fallback
            window.open(url, '_blank');
        }

        // Handle APK download click
        function handleApkDownload(e) {
            if (isInAppBrowser()) {
                e.preventDefault();

                // Show the modal
                document.getElementById('lineBrowserModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                return false;
            }
            // If not in in-app browser, let the default download happen
            return true;
        }

        // Wait for jQuery to load before using it
        function initJQuery() {
            console.log("=== initJQuery ถูกเรียก ===");
            console.log("jQuery defined:", typeof jQuery !== 'undefined');
            console.log("$ defined:", typeof $ !== 'undefined');

            if (typeof jQuery === 'undefined' || typeof $ === 'undefined') {
                // jQuery not loaded yet, wait and try again
                console.log("jQuery ยังไม่โหลด รอ 100ms...");
                setTimeout(initJQuery, 100);
                return;
            }

            console.log("jQuery โหลดแล้ว เริ่มต้น initialization");

            // jQuery is loaded, proceed with initialization
            $(document).ready(function() {
                console.log("=== $(document).ready ถูกเรียก ===");
                // Attach click handler to APK download link
                $('a[href$=".apk"]').on('click', function(e) {
                    if (isInAppBrowser()) {
                        e.preventDefault();
                        document.getElementById('lineBrowserModal').classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                        return false;
                    }
                });
                
                // Function to update request count
                function updateRequestCount() {
                    $.ajax({
                        type: "GET",
                        url: "<?= base_url('index.php/ai/get-count') ?>",
                        dataType: "json",
                        success: function(response) {
                            if (response && response.count !== undefined) {
                                $("#requestCount").text(response.count.toLocaleString());
                            }
                        },
                        error: function(e) {
                            console.error("Error fetching request count:", e);
                        }
                    });
                }

                // Initial fetch
                updateRequestCount();

                // Close LINE Browser modal
                $('#closeLineBrowserModal').on('click', function() {
                    document.getElementById('lineBrowserModal').classList.add('hidden');
                    document.body.style.overflow = 'auto';
                });

                // Open in external browser
                $('#openExternalBrowser').on('click', function() {
                    openInExternalBrowser(APK_DOWNLOAD_URL);
                });

                // Copy download link
                $('#copyDownloadLink').on('click', function() {
                    const tempInput = document.createElement('input');
                    tempInput.value = APK_DOWNLOAD_URL;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);

                    // Show success message
                    $('#copySuccess').removeClass('hidden');
                    setTimeout(function() {
                        $('#copySuccess').addClass('hidden');
                    }, 2000);

                    // Also try modern clipboard API
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(APK_DOWNLOAD_URL);
                    }
                });
                $("#resultdisplay, #resultdisplay2, #responseAgree").hide();

                // Modal functions
                function openModal() {
                    $("#resultModal").removeClass("hidden");
                    $("body").css("overflow", "hidden"); // Prevent background scroll
                }

                function closeModal() {
                    $("#resultModal").addClass("hidden");
                    $("body").css("overflow", "auto"); // Restore background scroll
                }

                // Close modal events
                $("#closeModal, #closeModalBtn, #modalBackdrop").click(function(e) {
                    if (e.target === this) closeModal();
                });

                // Close on ESC key
                $(document).keydown(function(e) {
                    if (e.key === "Escape") closeModal();
                });

                // ฟังก์ชันสำหรับแสดง modal reject options
                function showRejectOptionsModal() {
                    var options = window.rejectOptions || [];
                    var optionsList = $("#rejectOptionsList");
                    optionsList.empty();

                    console.log("=== แสดง Reject Options Modal ===");
                    console.log("Reject Options:", options);
                    console.log("Options Count:", options.length);

                    if (options.length === 0) {
                        console.warn("ไม่มี rejectOptions ถูกเก็บไว้");
                        optionsList.html('<p class="text-gray-500 text-center py-4">' + getLangText('ไม่มีตัวเลือก', 'No options available') + '</p>');
                    } else {
                        // Option labels with language support
                        var optionLabels = {
                            'normal': getLangText('ปกติ (Normal)', 'Normal'),
                            'abnormal': getLangText('ผิดปกติ (Abnormal)', 'Abnormal'),
                            'TT': 'Thalassemia Trait (TT)',
                            'TD': 'Thalassemia Disease (TD)',
                            'IDA': 'Iron Deficiency Anemia (IDA)',
                            'other': getLangText('อื่นๆ (Other)', 'Other')
                        };

                        options.forEach(function(option, index) {
                            var label = optionLabels[option] || option;
                            console.log("Option " + (index + 1) + ":", option, "->", label);

                            var button = $('<button>')
                                .addClass('w-full bg-white hover:bg-red-50 border-2 border-red-200 text-red-700 py-3 px-6 rounded-xl font-semibold transition text-left mb-2')
                                .attr('data-option', option)
                                .html('<span class="flex items-center justify-between"><span>' + label + '</span><span class="text-red-400">→</span></span>');

                            button.on('click', function() {
                                var selectedOption = $(this).attr('data-option');
                                console.log("เลือก Option:", selectedOption);
                                submitRejectConfirmation(selectedOption);
                            });

                            optionsList.append(button);
                        });

                        console.log("สร้างปุ่ม options จำนวน " + options.length + " ปุ่ม");
                    }

                    $("#rejectOptionsModal").removeClass("hidden");
                    $("body").css("overflow", "hidden");
                }

                // ฟังก์ชันสำหรับปิด modal reject options
                function closeRejectOptionsModal() {
                    $("#rejectOptionsModal").addClass("hidden");
                    $("body").css("overflow", "auto");
                }

                // ฟังก์ชันสำหรับส่งข้อมูลเมื่อเลือก option
                function submitRejectConfirmation(selectedOption) {
                    var id = parseFloat($("#idRecord").val());

                    var confirmData = {
                        id: id,
                        RejectOption: selectedOption
                    };

                    console.log("=== ส่งข้อมูลไปยัง AiController/confirm ===");
                    console.log("Action: ไม่เห็นด้วย");
                    console.log("Selected Option:", selectedOption);
                    console.log("Request Data:", confirmData);

                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('index.php/AiController/confirm') ?>",
                        dataType: "json",
                        data: confirmData,
                        success: function(response) {
                            console.log("=== รับข้อมูลจาก AiController/confirm ===");
                            console.log("Response:", response);
                            console.log("Status:", response.info || "success");
                            console.log("Message:", response.message || "");
                            console.log("Reject Option:", response.rejectOption || "");
                            console.log("========================================");

                            closeRejectOptionsModal();
                            $("#confirmform").hide();

                            // แสดงข้อความตาม response
                            if (response.message) {
                                $("#responseAgree").html(
                                    '<span class="text-2xl">✓</span>' +
                                    '<div class="font-bold">' + response.message + '</div>'
                                );
                            } else {
                                $("#responseAgree").html(
                                    '<span class="text-2xl">✓</span>' +
                                    '<div class="font-bold">' + getLangText('ขอบคุณสำหรับความคิดเห็น!', 'Thank you for your feedback!') + '</div>'
                                );
                            }

                            $("#responseAgree").fadeIn();
                        },
                        error: function(e) {
                            console.error("=== Error จาก AiController/confirm ===");
                            console.error("Error Object:", e);
                            console.error("Status:", e.status);
                            console.error("Status Text:", e.statusText);
                            console.error("Response Text:", e.responseText);
                            console.error("=====================================");
                        }
                    });
                }

                // เห็นด้วย
                $("#agreePredict").click(function() {
                    var id = parseFloat($("#idRecord").val());

                    var confirmData = {
                        id: id,
                        RejectOption: 'confirm'
                    };

                    console.log("=== ส่งข้อมูลไปยัง AiController/confirm ===");
                    console.log("Action: เห็นด้วย");
                    console.log("Request Data:", confirmData);

                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('index.php/AiController/confirm') ?>",
                        dataType: "json",
                        data: confirmData,
                        success: function(response) {
                            console.log("=== รับข้อมูลจาก AiController/confirm ===");
                            console.log("Response:", response);
                            console.log("Status:", response.info || "success");
                            console.log("Message:", response.message || "");
                            console.log("========================================");

                            $("#confirmform").hide();

                            // แสดงข้อความตาม response
                            if (response.message) {
                                $("#responseAgree").html(
                                    '<span class="text-2xl">✓</span>' +
                                    '<div class="font-bold">' + response.message + '</div>'
                                );
                            } else {
                                $("#responseAgree").html(
                                    '<span class="text-2xl">✓</span>' +
                                    '<div class="font-bold">' + getLangText('ขอบคุณสำหรับความคิดเห็น!', 'Thank you for your feedback!') + '</div>'
                                );
                            }

                            $("#responseAgree").fadeIn();
                        },
                        error: function(e) {
                            console.error("=== Error จาก AiController/confirm ===");
                            console.error("Error Object:", e);
                            console.error("Status:", e.status);
                            console.error("Status Text:", e.statusText);
                            console.error("Response Text:", e.responseText);
                            console.error("=====================================");
                        }
                    });
                });

                // ไม่เห็นด้วย - แสดง modal
                $("#rejectPredict").click(function() {
                    console.log("=== คลิกปุ่ม 'ไม่เห็นด้วย' ===");
                    console.log("window.rejectOptions:", window.rejectOptions);
                    showRejectOptionsModal();
                });

                // ปิด modal reject options
                $("#cancelRejectModal").click(function() {
                    closeRejectOptionsModal();
                });

                // ปิด modal เมื่อคลิกที่ backdrop
                $("#rejectOptionsModal").click(function(e) {
                    if ($(e.target).attr('id') === 'rejectOptionsModal' || $(e.target).hasClass('absolute')) {
                        closeRejectOptionsModal();
                    }
                });

                // ปุ่มล้างค่า
                $("#clearBtn").click(function() {
                    $("#formblood")[0].reset();
                    clearAllErrors();
                    $("#resultdisplay, #resultdisplay2").hide();
                    $("#confirmform").hide();
                    $("#responseAgree").hide();
                });

                $("#predictButton").click(function() {
                    console.log("=== คลิกปุ่ม 'แปลผล' ===");

                    // ล้าง error ก่อน
                    clearAllErrors();

                    // ดึงค่าจากฟอร์ม
                    var ageYear = $("#Age_year").val() === "" ? 0 : parseFloat($("#Age_year").val());
                    var ageMonth = $("#Age_month").val() === "" ? 0 : parseFloat($("#Age_month").val());
                    var RBC = parseFloat($("#RBC").val());
                    var Hb = parseFloat($("#Hb").val());
                    var Hct = parseFloat($("#Hct").val());
                    var MCV = parseFloat($("#MCV").val());
                    var MCH = parseFloat($("#MCH").val());
                    var MCHC = parseFloat($("#MCHC").val());
                    var RDW = parseFloat($("#RDW").val());

                    // ตรวจสอบค่าอายุ
                    if (ageYear < 0) {
                        showError("Age_year", getLangText("อายุ (ปี) ไม่สามารถติดลบได้", "Age (years) cannot be negative"));
                        return false;
                    }
                    if (ageYear > 15) {
                        showError("Age_year", getLangText("อายุ (ปี) ไม่ควรเกิน 15 ปี", "Age (years) should not exceed 15"));
                        return false;
                    }
                    if (ageMonth < 0) {
                        showError("Age_month", getLangText("เดือน ไม่สามารถติดลบได้", "Month cannot be negative"));
                        return false;
                    }
                    if (ageMonth > 12) {
                        showError("Age_month", getLangText("เดือน ไม่ควรเกิน 12 เดือน", "Month should not exceed 12"));
                        return false;
                    }

                    // ตรวจสอบค่า CBC - ไม่ให้เกิน 100 และไม่ให้ติดลบ
                    var cbcFields = [
                        {name: "RBC", value: RBC, label: "RBC"},
                        {name: "Hb", value: Hb, label: "Hb"},
                        {name: "Hct", value: Hct, label: "Hct"},
                        {name: "MCV", value: MCV, label: "MCV"},
                        {name: "MCH", value: MCH, label: "MCH"},
                        {name: "MCHC", value: MCHC, label: "MCHC"},
                        {name: "RDW", value: RDW, label: "RDW"}
                    ];

                    for (var i = 0; i < cbcFields.length; i++) {
                        var field = cbcFields[i];

                        // ตรวจสอบว่าเป็นตัวเลขหรือไม่
                        if (isNaN(field.value)) {
                            showError(field.name, field.label + getLangText(" ต้องเป็นตัวเลขเท่านั้น", " must be a number"));
                            return false;
                        }

                        // ตรวจสอบค่าติดลบ
                        if (field.value < 0) {
                            showError(field.name, field.label + getLangText(" ไม่สามารถติดลบได้", " cannot be negative"));
                            return false;
                        }

                        // ตรวจสอบค่าเกิน 100
                        if (field.value > 100) {
                            showError(field.name, field.label + getLangText(" ไม่ควรเกิน 100", " should not exceed 100"));
                            return false;
                        }
                    }

                    var Ages_mo_all = (ageYear * 12) + ageMonth;

                    $("#ageyear_text").html(ageYear);
                    $("#agemonth_text").html(ageMonth);
                    $("#RBC_text").html(RBC);
                    $("#Hb_text").html(Hb);
                    $("#Hct_text").html(Hct);
                    $("#MCV_text").html(MCV);
                    $("#MCH_text").html(MCH);
                    $("#MCHC_text").html(MCHC);
                    $("#RDW_text").html(RDW);

                    $("#resultdisplay, #resultdisplay2").hide();
                    // $("#formblood")[0].reset(); // Commented out to keep values in the form

                    // ข้อมูลที่ส่งไปยัง Controller
                    var requestData = {
                        Ages_mo_all: Ages_mo_all,
                        RBC: RBC,
                        HB: Hb,
                        HCT: Hct,
                        MCV: MCV,
                        MCH: MCH,
                        MCHC: MCHC,
                        RDW: RDW
                    };

                    console.log("=== ส่งข้อมูลไปยัง AiController/predict ===");
                    console.log("Request Data:", requestData);

                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('index.php/AiController/predict') ?>",
                        dataType: "json",
                        data: requestData,
                        success: function(r) {
                            console.log("=== รับข้อมูลจาก AiController/predict ===");
                            console.log("Full Response:", r);
                            console.log("ID:", r.id);
                            console.log("Label:", r.label);
                            console.log("Confidence:", (r.confidence * 100).toFixed(2) + "%");
                            console.log("Reject Options:", r.rejectOptions);
                            console.log("========================================");

                            // เก็บ rejectOptions ไว้ในตัวแปร global
                            // ตรวจสอบว่า rejectOptions เป็น array หรือไม่
                            if (r.rejectOptions && Array.isArray(r.rejectOptions)) {
                                window.rejectOptions = r.rejectOptions;
                            } else if (r.rejectOptions) {
                                // ถ้าไม่ใช่ array ให้แปลงเป็น array
                                window.rejectOptions = [r.rejectOptions];
                            } else {
                                window.rejectOptions = [];
                            }

                            console.log("เก็บ rejectOptions ไว้ใน window.rejectOptions:", window.rejectOptions);

                            $("#predictedType").text(r.label);
                            $("#confidencevalue").text((r.confidence * 100).toFixed(2));
                            $("#idRecord").val(r.id);
                            $("#resultdisplay, #resultdisplay2").fadeIn(500);
                            $("#confirmform").show();
                            $("#responseAgree").hide();
                            openModal(); // Show the modal popup
                            updateRequestCount(); // Update count after new prediction
                        },
                        error: function(e) {
                            console.error("=== Error จาก AiController/predict ===");
                            console.error("Error Object:", e);
                            console.error("Status:", e.status);
                            console.error("Status Text:", e.statusText);
                            console.error("Response Text:", e.responseText);
                            console.error("=====================================");
                            alert(getLangText("Error: กรุณาตรวจสอบข้อมูล", "Error: Please check your input"));
                        }
                    });
                });
            }); // End of $(document).ready
        }

        // Start initialization when page loads
        console.log("=== เริ่มต้น initialization ===");
        console.log("Document readyState:", document.readyState);

        if (document.readyState === 'loading') {
            console.log("Document ยังไม่โหลดเสร็จ รอ DOMContentLoaded");
            document.addEventListener('DOMContentLoaded', function() {
                console.log("DOMContentLoaded event ถูกเรียก");
                initJQuery();
            });
        } else {
            // DOM is already ready
            console.log("Document พร้อมแล้ว เรียก initJQuery ทันที");
            initJQuery();
        }

        console.log("=== Script โหลดเสร็จ ===");

        // Language Toggle Functionality
        (function() {
            const langToggle = document.getElementById('langToggle');
            const langText = document.getElementById('langText');
            let currentLang = localStorage.getItem('language') || 'th';

            // Set initial language
            setLanguage(currentLang);

            // Toggle language on button click
            if (langToggle) {
                langToggle.addEventListener('click', function() {
                    currentLang = currentLang === 'th' ? 'en' : 'th';
                    setLanguage(currentLang);
                    localStorage.setItem('language', currentLang);
                });
            }

            function setLanguage(lang) {
                // Update button text
                if (langText) {
                    langText.textContent = lang.toUpperCase();
                }

                // Update all elements with data-lang attributes
                const elements = document.querySelectorAll('[data-lang-th][data-lang-en]');
                elements.forEach(function(el) {
                    const thText = el.getAttribute('data-lang-th');
                    const enText = el.getAttribute('data-lang-en');
                    
                    if (lang === 'th' && thText) {
                        el.innerHTML = thText;
                    } else if (lang === 'en' && enText) {
                        el.innerHTML = enText;
                    }
                });

                // Update HTML lang attribute
                document.documentElement.lang = lang;
            }
        })();
    </script>
</body>

</html>