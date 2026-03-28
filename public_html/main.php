<?php
session_start();

// 1. Define the variable FIRST
$is_logged_in = isset($_SESSION['user_id']); 

// 2. Now you can use it safely
$user_name = $is_logged_in ? $_SESSION['full_name'] : "Guest_Node";
$display_name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : "Guest_Node";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>SplitFair | Global Multi-Currency Intelligence</title>
    <style>
        /* Zero-JS Dropdown Logic */
        #dropdown-gate:checked ~ #profileDropdown {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* Float Animation */
        @keyframes subtle-float {
            0% { transform: translateY(0px) rotate(2deg); }
            50% { transform: translateY(-10px) rotate(3deg); }
            100% { transform: translateY(0px) rotate(2deg); }
        }
        .float-dashboard { animation: subtle-float 6s ease-in-out infinite; }
        
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .hero-gradient {
            background: radial-gradient(circle at 20% 30%, #1e293b 0%, #0f172a 100%);
        }

        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-[#0f172a] text-slate-300 font-sans scroll-smooth overflow-x-hidden min-h-screen flex flex-col">

    <header class="border-b border-slate-800/50 bg-[#0f172a]/80 backdrop-blur-lg px-6 py-3 flex items-center justify-between sticky top-0 z-50 h-[72px]">
        <div class="flex items-center gap-8 flex-1">
            <div class="font-black text-2xl tracking-tighter text-blue-500 italic uppercase cursor-pointer hover:scale-105 transition-transform">SplitFair</div>
            <nav class="hidden lg:flex space-x-6">
                <a href="#currency" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-blue-400 transition">Global Access</a>
                <a href="#tech" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-blue-400 transition">Infrastructure</a>
            </nav>
        </div>

        <div class="flex items-center justify-end gap-5 flex-1 relative">
            <a href="kyc.php" class="hidden md:block bg-blue-600/10 border border-blue-500/50 text-blue-400 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 hover:text-white transition">
                KYC Portal
            </a>

            <div class="relative inline-block text-left">
                <input type="checkbox" id="dropdown-gate" class="hidden peer">
                <label for="dropdown-gate" class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center border border-slate-700 cursor-pointer hover:border-blue-500 transition-all">
                    <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </label>
                <div id="profileDropdown" class="hidden absolute right-0 mt-4 w-56 bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl py-2 z-[100]">
                    <div class="px-4 py-3 border-b border-slate-800 mb-1">
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Account Status</p>
                        <p class="text-sm font-black text-blue-400"><?php echo htmlspecialchars($user_name); ?></p>
                    </div>

                    <?php if($is_logged_in): ?>
                        <a href="workspace.php" class="block px-4 py-2 text-xs font-black uppercase text-slate-300 hover:bg-slate-800 hover:text-blue-400">Workspace</a>
                        <a href="assets/php/logout.php" class="block px-4 py-2 text-xs font-black uppercase text-red-400 hover:bg-slate-800">Log Out</a>
                    <?php else: ?>
                        <a href="login.php" class="block px-4 py-2 text-xs font-black uppercase text-slate-300 hover:bg-slate-800 hover:text-blue-400">Log In</a>
                        <a href="create_account.html" class="block px-4 py-2 text-xs font-black uppercase text-slate-300 hover:bg-slate-800 hover:text-blue-400">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <section class="hero-gradient relative py-24 px-6 overflow-hidden">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center relative z-10">
                <div class="space-y-10">
                    <div class="inline-flex items-center gap-2 bg-blue-500/10 border border-blue-500/20 px-3 py-1 rounded-full">
                        <span class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Multi-Currency Engine Active</span>
                    </div>
                    <h1 class="text-6xl md:text-8xl font-black text-white leading-[0.9] tracking-tighter uppercase">
                        Split <br><span class="text-blue-500 italic">Global.</span>
                    </h1>
                    <p class="text-slate-400 text-lg max-w-lg leading-relaxed font-medium">
                        The premium protocol for group expenses. No matter the currency, we calculate the fairness so you don't have to.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="assets/php/add_expense.php">
                        <button onclick="checkAccess()" class="bg-blue-600 text-white px-10 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-blue-500 transition shadow-xl transform hover:-translate-y-1">
                            Get Stared
                        </button>
                        </a>
                    </div>
                </div>

                <div class="relative float-dashboard hidden lg:block">
                    <div class="glass p-8 rounded-[40px] shadow-2xl relative overflow-hidden">
                        <div class="flex justify-between items-start mb-12">
                            <div>
                                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Portfolio</p>
                                <h3 class="text-5xl font-black text-white tracking-tighter italic uppercase">Network</h3>
                            </div>
                            <div class="text-blue-400 font-black text-xl italic">₹ / $ / €</div>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-slate-800/40 p-4 rounded-2xl flex justify-between items-center border border-slate-700/50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-orange-500/20 rounded-xl flex items-center justify-center text-orange-500 font-bold text-xs italic">INR</div>
                                    <div><p class="text-xs font-black text-white uppercase">Event Split</p><p class="text-[10px] text-slate-500 font-bold uppercase">India</p></div>
                                </div>
                                <p class="font-black text-white text-sm">₹12,500</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

 <section class="py-32 px-6 bg-[#0f172a] overflow-hidden border-t border-slate-800/50">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-24 space-y-6">
            <div class="inline-flex items-center gap-3 bg-blue-500/10 border border-blue-500/20 px-4 py-2 rounded-full">
                <span class="w-2 h-2 bg-blue-500 rounded-full animate-ping"></span>
                <span class="text-[10px] font-black text-blue-400 uppercase tracking-[0.3em]">Advanced Math Module Active</span>
            </div>
            <h2 class="text-5xl md:text-7xl font-black text-white tracking-tighter uppercase leading-[0.9]">
                The SplitEngine <br>
                <span class="text-blue-500 italic">Financial Protocol.</span>
            </h2>
            <p class="text-slate-400 text-lg max-w-3xl mx-auto font-medium leading-relaxed">
                We’ve engineered a proprietary logic layer that sits between your group expenses and your bank account. It doesn't just divide by 'X'; it analyzes the debt network to eliminate redundant transfers and secure your data.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-stretch">
            
            <div class="relative group flex flex-col">
                <div class="absolute -inset-4 bg-blue-600/5 rounded-[4rem] blur-[120px]"></div>
                
                <div class="relative bg-slate-900/60 border border-slate-800 p-10 md:p-16 rounded-[4rem] shadow-2xl flex-grow">
                    
                    <div class="space-y-0 relative">
                        <div class="absolute left-8 top-10 bottom-10 w-px border-l border-dashed border-slate-700"></div>

                        <div class="relative pl-20 pb-16 group/item">
                            <div class="absolute left-5 top-0 w-6 h-6 bg-slate-800 border border-slate-600 rounded-full flex items-center justify-center z-10 group-hover/item:border-blue-500 transition-colors">
                                <div class="w-2 h-2 bg-slate-600 rounded-full group-hover/item:bg-blue-500"></div>
                            </div>
                            <h4 class="text-blue-500 font-black text-[11px] uppercase tracking-[0.2em] mb-2">Phase 01: Data Ingestion</h4>
                            <p class="text-white font-bold text-lg mb-1">Multi-Source Input</p>
                            <p class="text-slate-500 text-sm leading-relaxed">Upload physical receipts via OCR, manual entries, or recurring subscription logs. Our system categorizes every cent instantly.</p>
                        </div>

                        <div class="relative pl-20 pb-16 group/item">
                            <div class="absolute left-4 -top-1 w-8 h-8 bg-blue-600 rounded-xl flex items-center justify-center z-10 shadow-[0_0_20px_rgba(37,99,235,0.4)] animate-pulse">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h4 class="text-blue-400 font-black text-[11px] uppercase tracking-[0.2em] mb-2">Phase 02: Logic Optimization</h4>
                            <p class="text-white font-bold text-lg mb-1">Debt Minimization Engine</p>
                            <p class="text-slate-500 text-sm leading-relaxed">The algorithm runs 1,000+ permutations to find the path of least resistance, reducing total group transfers by up to 70%.</p>
                        </div>

                        <div class="relative pl-20 group/item">
                            <div class="absolute left-5 top-0 w-6 h-6 bg-emerald-500/20 border border-emerald-500/50 rounded-full flex items-center justify-center z-10">
                                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                            </div>
                            <h4 class="text-emerald-500 font-black text-[11px] uppercase tracking-[0.2em] mb-2">Phase 03: Final Settlement</h4>
                            <p class="text-white font-bold text-lg mb-1">Zero-Balance Protocol</p>
                            <p class="text-slate-500 text-sm leading-relaxed">Generate secure payment links or QR codes. One click moves the funds, and the ledger updates in real-time for all nodes.</p>
                        </div>
                    </div>

                    <div class="mt-16 p-4 bg-black/40 rounded-2xl border border-white/5 font-mono">
                        <div class="flex justify-between items-center text-[10px] mb-2">
                            <span class="text-slate-500">SYSTEM_LOG_CORE</span>
                            <span class="text-emerald-500">● SECURE</span>
                        </div>
                        <p class="text-[9px] text-slate-400 leading-tight">
                            > optimizing_redundant_tx... <br>
                            > cross_referencing_balances... <br>
                            > result: 12_debts_collapsed_into_3_actions
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-600 to-indigo-800 rounded-[4rem] p-12 md:p-20 flex flex-col justify-center relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-[120px] -mr-40 -mt-40"></div>
                
                <h3 class="text-4xl md:text-5xl font-black text-white leading-[1] mb-10 relative z-10 uppercase tracking-tighter italic">
                    Engineered for <br>Total Financial <br>
                    <span class="text-blue-200 underline decoration-blue-400 decoration-8">Simplicity.</span>
                </h3>

                <div class="space-y-12 relative z-10">
                    <div class="flex items-start gap-8 group">
                        <div class="w-16 h-16 shrink-0 bg-white/10 backdrop-blur-xl rounded-[2rem] flex items-center justify-center border border-white/20 group-hover:bg-white transition-all duration-500 group-hover:rotate-6">
                            <svg class="w-8 h-8 text-white group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xl font-black text-white leading-tight mb-2">Military-Grade Encryption</p>
                            <p class="text-blue-100 text-sm font-medium leading-relaxed opacity-80">We treat your group dinner as seriously as a bank transaction. Your financial data and personal details are encrypted at rest and in transit using SHA-256 protocols.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-8 group">
                        <div class="w-16 h-16 shrink-0 bg-white/10 backdrop-blur-xl rounded-[2rem] flex items-center justify-center border border-white/20 group-hover:bg-white transition-all duration-500 group-hover:-rotate-6">
                            <svg class="w-8 h-8 text-white group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xl font-black text-white leading-tight mb-2">Automated Dispute Resolution</p>
                            <p class="text-blue-100 text-sm font-medium leading-relaxed opacity-80">By maintaining a transparent, uneditable audit trail of every receipt, SplitFair eliminates the "who-paid-what" arguments before they even start. Fairness is built into the code.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-8 group">
                        <div class="w-16 h-16 shrink-0 bg-white/10 backdrop-blur-xl rounded-[2rem] flex items-center justify-center border border-white/20 group-hover:bg-white transition-all duration-500 group-hover:scale-110">
                            <svg class="w-8 h-8 text-white group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xl font-black text-white leading-tight mb-2">Intelligent Nudges</p>
                            <p class="text-blue-100 text-sm font-medium leading-relaxed opacity-80">Our smart notification system knows when to remind your friends. It sends perfectly timed, friendly prompts so you never have to be the one asking for money back.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    .animate-bounce-slow { animation: bounce-slow 3s ease-in-out infinite; }
</style>

        <section id="currency" class="py-24 px-6 border-t border-slate-800/50 relative">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16 space-y-4">
                    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Borderless Intelligence</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="glass p-10 rounded-[32px] border border-slate-800 hover:border-blue-500/50 transition-all group">
                        <h3 class="text-lg font-black text-white mb-4 uppercase italic">Live Rates</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Direct global market connection. Spend in any currency, settle in your own instantly.</p>
                    </div>
                    <div class="glass p-10 rounded-[32px] border border-slate-800 hover:border-emerald-500/50 transition-all group">
                        <h3 class="text-lg font-black text-white mb-4 uppercase italic">Zero Friction</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Automated calculations across 150+ regions. No manual math, no error margins.</p>
                    </div>
                    <div class="glass p-10 rounded-[32px] border border-slate-800 hover:border-purple-500/50 transition-all group">
                        <h3 class="text-lg font-black text-white mb-4 uppercase italic">Global Sync</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Real-time ledger updates for every member in the group, regardless of geographic location.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-[#0b1222] border-t border-slate-800/60 h-[60px] flex items-center overflow-hidden">
        <div class="max-w-7xl w-full mx-auto px-6 flex justify-between items-center">
            
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                <span class="font-black text-white text-xs uppercase tracking-[0.3em] italic">SplitFair</span>
            </div>

            <div class="hidden md:flex gap-8">
                <a href="#" class="text-[9px] font-black uppercase text-slate-500 hover:text-white transition tracking-widest">Privacy</a>
                <a href="#" class="text-[9px] font-black uppercase text-slate-500 hover:text-white transition tracking-widest">Network_Terms</a>
            </div>

            <div class="flex items-center gap-5">
                <a href="#" class="text-slate-500 hover:text-pink-500 hover:drop-shadow-[0_0_8px_rgba(236,72,153,0.5)] transition-all transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
                <a href="#" class="text-slate-500 hover:text-white hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.5)] transition-all transform hover:-translate-y-0.5">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <a href="#" class="text-slate-500 hover:text-[#ff4500] hover:drop-shadow-[0_0_8px_rgba(255,69,0,0.5)] transition-all transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm7.5 13.5c0 .69-.56 1.25-1.25 1.25-.133 0-.256-.021-.371-.06-.525.795-1.305 1.345-2.229 1.555.05.158.079.325.079.5 0 .966-.784 1.75-1.75 1.75s-1.75-.784-1.75-1.75c0-.175.029-.342.079-.5-.924-.21-1.704-.76-2.229-1.555-.115.039-.238.06-.371.06-1.242 0-2.25-1.008-2.25-2.25 0-.756.375-1.422.951-1.821-.133-.357-.201-.735-.201-1.114 0-1.89 2.062-3.428 4.604-3.428 2.542 0 4.604 1.538 4.604 3.428 0 .379-.068.757-.201 1.114.576.399.951 1.065.951 1.821 0 .402-.106.777-.291 1.101zm-10.458-1.101c-.482 0-.875.393-.875.875s.393.875.875.875.875-.393.875-.875-.393-.875-.875-.875zm5.916 0c-.482 0-.875.393-.875.875s.393.875.875.875.875-.393.875-.875-.393-.875-.875-.875zm-1.458 2.875c-.5 0-.916-.416-.916-.916s.416-.916.916-.916.916.416.916.916-.416.916-.916.916z"/></svg>
                </a>
                <a href="#" class="text-slate-500 hover:text-[#0077b5] hover:drop-shadow-[0_0_8px_rgba(0,119,181,0.5)] transition-all transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>
                </a>
            </div>
        </div>
    </footer>

    <script>
        function checkAccess() {
            // 1. Check Login status from PHP session variable
            const isLoggedIn = <?php echo $is_logged_in ? 'true' : 'false'; ?>;
            
            // 2. Check KYC status from browser localStorage
            const isKycComplete = localStorage.getItem('kyc_status') === 'completed';

            if (!isLoggedIn) {
                alert("ACCESS DENIED: Please log in to your SplitFair account first.");
                window.location.href = "login.php";
                return;
            }

            if (!isKycComplete) {
                alert("SECURITY CHECK: Please complete your KYC verification portal.");
                window.location.href = "kyc.php";
                return;
            }

            // 3. Success: Redirect to workspace
            window.location.href = "workspace.php";
        }
    </script>

</body>
</html>