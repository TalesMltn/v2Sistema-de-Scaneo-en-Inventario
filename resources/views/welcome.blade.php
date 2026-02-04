<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Inventario Taller - Escaneo de Inventario</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

    <style>
        :root {
            --cyan-neon: #A67B5B;
            --orange-neon: #8B5A2B;
            --orange-light: #A67B5B;
            --bg-dark: #3a2a1e;
            --card-dark: #2a1f14;
            --text-light: #f5e8d3;
            --gray-light: #D4A373;
        }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: radial-gradient(circle at top, #3a2a1e, #1f150e);
        }
        .neon-title {
            text-shadow: 0 0 10px var(--cyan-neon), 0 0 20px var(--cyan-neon), 0 0 30px rgba(166,123,91,0.5);
        }
        .neon-button {
            box-shadow: 0 0 15px rgba(139,90,43,0.5), inset 0 0 10px rgba(139,90,43,0.3);
        }
        .neon-button:hover {
            box-shadow: 0 0 30px rgba(139,90,43,0.8), inset 0 0 15px rgba(139,90,43,0.5);
        }

        .tool-card {
            perspective: 1000px;
            transition: transform 0.4s ease-out;
        }
        .tool-card:hover {
            transform: translateY(-12px) rotateX(6deg) rotateY(8deg);
            box-shadow: 0 25px 50px -12px rgba(166,123,91,0.5);
        }

        #scanner-container {
            position: relative;
            width: 100%;
            max-width: 420px;
            height: 280px;
            margin: 0 auto 1.5rem;
            border: 4px solid #A67B5B;
            border-radius: 1rem;
            overflow: hidden;
            background: black;
            transition: all 0.3s ease;
        }
        #live-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .guide-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 85%;
            height: 20%;
            border: 4px dashed #E3BC9A;
            border-radius: 0.5rem;
            pointer-events: none;
            box-shadow: 0 0 15px rgba(227,188,154,0.6);
        }
        .guide-text {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            color: #E3BC9A;
            font-size: 0.9rem;
            background: rgba(0,0,0,0.6);
            padding: 4px 12px;
            border-radius: 9999px;
            pointer-events: none;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col text-[#f5e8d3] antialiased">

    <header class="w-full py-6 px-6 lg:px-12 flex justify-between items-center border-b border-[#A67B5B]/20 bg-[#3a2a1e]/70 backdrop-blur-md sticky top-0 z-50">
        <div class="text-3xl font-bold neon-title flex items-center gap-3">
            <i class="fas fa-tools text-[#8B5A2B]"></i>
            Inventario Huancayo
        </div>

        <div>
            <a href="/login" class="px-8 py-3 bg-[var(--orange-neon)] hover:bg-[var(--orange-light)] text-black font-semibold rounded-xl shadow-lg neon-button transition-all duration-300 text-lg flex items-center gap-2">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </a>
        </div>
    </header>

    <main class="flex-grow py-16 px-6 lg:px-12">
        <div class="max-w-7xl mx-auto">
            <div class="mb-16 bg-[#2a1f14]/90 backdrop-blur-md p-10 rounded-3xl border border-[#A67B5B]/30 shadow-2xl">
                <h2 class="text-4xl font-bold text-[#D4A373] text-center mb-8">ESCANEAR HERRAMIENTA</h2>

                <div class="max-w-xl mx-auto space-y-8">
                    <!-- CÁMARA -->
                    <div id="scanner-container">
                        <video id="live-video" autoplay playsinline muted></video>
                        <div class="guide-box"></div>
                        <div class="guide-text">Apunta SOLO al código de barras</div>
                    </div>

                    <!-- Input oculto para escáneres físicos USB/Bluetooth (modo teclado) -->
                    <input type="text" id="barcode-input" autofocus autocomplete="off" class="hidden absolute opacity-0 pointer-events-none" style="left: -9999px; top: -9999px;">

                    <!-- Resultado -->
                    <div id="result" class="min-h-[140px] text-center text-2xl"></div>

                    <!-- Historial -->
                    <div id="last-scans">
                        <h3 class="text-2xl text-[#D4A373] mb-4 text-center">Últimos movimientos</h3>
                        <div id="scans-list" class="space-y-4 max-h-80 overflow-y-auto"></div>
                    </div>
                </div>
            </div>

            <!-- Herramientas Disponibles (se actualizará automáticamente) -->
            <div class="text-center" id="tools-section">
                <h2 class="text-4xl lg:text-6xl font-extrabold text-center mb-12 neon-title">
                    Herramientas Disponibles
                </h2>

                <div id="tools-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    <!-- Las tarjetas se cargan aquí vía JS -->
                </div>
            </div>
        </div>
    </main>

    <footer class="py-10 text-center text-base text-[#D4A373] border-t border-[#A67B5B]/20 bg-[#3a2a1e]/70 backdrop-blur-md">
        <p>© {{ now()->year }} Inventario Huancayo • Proyecto Escaneo Inventario • Junín, Perú</p>
    </footer>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resultDiv = document.getElementById('result');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const toolsGrid = document.getElementById('tools-grid');
            const barcodeInput = document.getElementById('barcode-input');

            let quaggaStarted = false;
            let lastDetectedCode = null;
            let lastDetectionTime = 0;
            const cooldown = 5000; // 5 segundos entre detecciones del mismo código

            // Cargar herramientas iniciales
            function loadTools() {
                fetch('/tools/available')
                    .then(res => res.json())
                    .then(tools => {
                        toolsGrid.innerHTML = ''; // Limpia tarjetas anteriores

                        if (tools.length === 0) {
                            toolsGrid.innerHTML = '<p class="col-span-full text-center text-2xl text-[#D4A373]">No hay herramientas disponibles</p>';
                            return;
                        }

                        tools.forEach(tool => {
                            const card = document.createElement('div');
                            card.className = 'tool-card bg-[#2a1f14]/80 backdrop-blur-md rounded-2xl overflow-hidden border border-[#A67B5B]/20';
                            card.innerHTML = `
                                <div class="image-wrapper">
                                    ${tool.image ? 
                                        `<img src="${tool.image}" alt="${tool.name}" class="w-full h-56 object-cover">` :
                                        `<div class="w-full h-56 bg-gradient-to-br from-[#2a1f14] to-[#1f150e] flex items-center justify-center">
                                            <i class="fas fa-tools text-7xl text-[#A67B5B]/30"></i>
                                        </div>`
                                    }
                                </div>
                                <div class="p-6 text-center">
                                    <h3 class="text-2xl font-bold mb-2 neon-cyan">${tool.name}</h3>
                                    <p class="text-sm text-[#D4A373] mb-1">${tool.code}</p>
                                    <p class="text-base text-[#D4A373] mb-3">${tool.category}</p>
                                    <div class="flex justify-center gap-6 text-sm">
                                        <div><span class="font-bold text-[#A67B5B]">Stock:</span> ${tool.stock}</div>
                                        <div>
                                            <span class="${tool.status === 'optimo' ? 'text-green-400' : tool.status === 'mantenimiento' ? 'text-yellow-400' : 'text-red-400'} font-bold">
                                                ${tool.status.charAt(0).toUpperCase() + tool.status.slice(1)}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            `;
                            toolsGrid.appendChild(card);
                        });
                    })
                    .catch(err => console.log('Error cargando herramientas:', err));
            }

            // Cargar herramientas al inicio
            loadTools();

            function initCamera() {
                if (quaggaStarted) return;

                navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'environment',
                        width: { ideal: 1920 },
                        height: { ideal: 1080 }
                    } 
                })
                .then(stream => {
                    const video = document.getElementById('live-video');
                    video.srcObject = stream;
                    video.onloadedmetadata = () => {
                        video.play().catch(e => console.log("Play error:", e));
                    };
                    console.log("Cámara conectada y reproduciendo");
                    startQuagga();
                    quaggaStarted = true;
                })
                .catch(err => {
                    console.error("Error al acceder a cámara:", err);
                    resultDiv.innerHTML += '<p class="text-yellow-400 mt-6 text-center">No se pudo abrir la cámara. Verifica permisos.</p>';
                });
            }

            initCamera();

            document.body.addEventListener('click', () => {
                if (!quaggaStarted) initCamera();
            }, { once: true });

            function startQuagga() {
                Quagga.init({
                    inputStream: {
                        name: "Live",
                        type: "LiveStream",
                        target: document.querySelector('#scanner-container')
                    },
                    locator: {
                        patchSize: "x-large",
                        halfSample: false
                    },
                    numOfWorkers: 4,
                    frequency: 40,
                    decoder: {
                        readers: ["code_128_reader"]
                    },
                    locate: true
                }, err => {
                    if (err) {
                        console.error("Error Quagga:", err);
                        resultDiv.innerHTML += '<p class="text-red-400 mt-4">Error iniciando escáner.</p>';
                        return;
                    }
                    Quagga.start();
                    console.log("Escáner iniciado - acerca mucho el código y mantén quieto");
                });

                Quagga.onDetected(data => {
                    const now = Date.now();
                    let code = data.codeResult.code.trim();
                    code = code.toUpperCase().replace(/[^HR0-9]/g, '');

                    console.log("¡CÓDIGO DETECTADO!:", code);

                    if (code === lastDetectedCode && (now - lastDetectionTime) < cooldown) {
                        console.log("→ Ignorado (mismo código en cooldown)");
                        return;
                    }

                    if (code.startsWith('HR') && code.length === 7) {
                        console.log("Código válido → procesando:", code);

                        lastDetectedCode = code;
                        lastDetectionTime = now;

                        processScan(code);

                        document.getElementById('scanner-container').classList.add('border-green-500', 'shadow-2xl', 'shadow-green-500/50');
                        setTimeout(() => {
                            document.getElementById('scanner-container').classList.remove('border-green-500', 'shadow-2xl', 'shadow-green-500/50');
                            resultDiv.innerHTML = '';
                        }, 4000);
                    } else {
                        console.log("→ Ignorado (formato inválido)");
                    }
                });
            }

            function processScan(code) {
                console.log('Enviando al backend:', code);

                fetch('/scan/process', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ code })
                })
                .then(res => {
                    console.log('Status respuesta:', res.status);
                    if (!res.ok) throw new Error(`HTTP ${res.status}`);
                    return res.json();
                })
                .then(data => {
                    console.log('Respuesta completa del servidor:', data);
                    if (data.success) {
                        const actionText = data.action === 'salida' ? 'SALIDA' : 'DEVOLUCIÓN';
                        const colorClass = data.action === 'salida' ? 'text-red-400' : 'text-green-400';
                        const icon = data.action === 'salida' ? '🚪' : '🔙';

                        resultDiv.innerHTML = `
                            <div class="text-7xl mb-4">${icon}</div>
                            <div class="text-4xl font-bold ${colorClass}">
                                ${actionText} REGISTRADA
                            </div>
                            <div class="text-2xl mt-4 text-[#D4A373]">${data.tool_name}</div>
                            <div class="text-5xl font-mono mt-6 text-[#E3BC9A]">${data.code}</div>
                            <div class="text-xl mt-6 text-[#A67B5B]">
                                Stock actual: <span class="font-bold">${data.new_stock}</span>
                            </div>
                        `;

                        // Esperar 2 segundos y actualizar historial + tarjetas
                        setTimeout(() => {
                            updateLastScans();
                            loadTools();
                            console.log("Historial y tarjetas actualizadas automáticamente después de 2 segundos");
                        }, 2000);
                    } else {
                        resultDiv.innerHTML = `<div class="text-red-400 text-3xl">❌ ${data.message}</div>`;
                    }
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    resultDiv.innerHTML = `<div class="text-red-400 text-3xl">Error: ${err.message}</div>`;
                });
            }

            function updateLastScans() {
                fetch('/scan/last-movements')
                    .then(res => res.json())
                    .then(data => {
                        const list = document.getElementById('scans-list');
                        list.innerHTML = '';

                        data.slice(0, 6).forEach(m => {
                            const div = document.createElement('div');
                            div.className = `p-4 rounded-xl ${m.action === 'salida' ? 'bg-red-950/40 border-red-600/40' : 'bg-green-950/40 border-green-600/40'} border`;
                            div.innerHTML = `
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="font-bold text-lg">${m.tool_name}</span>
                                        <div class="text-sm text-[#D4A373]">${m.code}</div>
                                    </div>
                                    <span class="${m.action === 'salida' ? 'text-red-400' : 'text-green-400'} font-bold">
                                        ${m.action === 'salida' ? '🚪 SALIDA' : '🔙 DEVOLUCIÓN'}
                                    </span>
                                </div>
                                <div class="text-sm mt-2 text-[#D4A373]">${m.time_ago}</div>
                            `;
                            list.appendChild(div);
                        });

                        if (data.length === 0) {
                            list.innerHTML = '<p class="text-center text-gray-500">No hay movimientos recientes</p>';
                        }
                    })
                    .catch(err => console.log('Polling error:', err));
            }

            function loadTools() {
                fetch('/tools/available')
                    .then(res => res.json())
                    .then(tools => {
                        toolsGrid.innerHTML = '';

                        if (tools.length === 0) {
                            toolsGrid.innerHTML = '<p class="col-span-full text-center text-2xl text-[#D4A373]">No hay herramientas disponibles</p>';
                            return;
                        }

                        tools.forEach(tool => {
                            const card = document.createElement('div');
                            card.className = 'tool-card bg-[#2a1f14]/80 backdrop-blur-md rounded-2xl overflow-hidden border border-[#A67B5B]/20';
                            card.innerHTML = `
                                <div class="image-wrapper">
                                    ${tool.image ? 
                                        `<img src="${tool.image}" alt="${tool.name}" class="w-full h-56 object-cover">` :
                                        `<div class="w-full h-56 bg-gradient-to-br from-[#2a1f14] to-[#1f150e] flex items-center justify-center">
                                            <i class="fas fa-tools text-7xl text-[#A67B5B]/30"></i>
                                        </div>`
                                    }
                                </div>
                                <div class="p-6 text-center">
                                    <h3 class="text-2xl font-bold mb-2 neon-cyan">${tool.name}</h3>
                                    <p class="text-sm text-[#D4A373] mb-1">${tool.code}</p>
                                    <p class="text-base text-[#D4A373] mb-3">${tool.category}</p>
                                    <div class="flex justify-center gap-6 text-sm">
                                        <div><span class="font-bold text-[#A67B5B]">Stock:</span> ${tool.stock}</div>
                                        <div>
                                            <span class="${tool.status === 'optimo' ? 'text-green-400' : tool.status === 'mantenimiento' ? 'text-yellow-400' : 'text-red-400'} font-bold">
                                                ${tool.status.charAt(0).toUpperCase() + tool.status.slice(1)}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            `;
                            toolsGrid.appendChild(card);
                        });
                    })
                    .catch(err => console.log('Error cargando herramientas:', err));
            }

            // Captura códigos de escáner físico (USB o Bluetooth en modo teclado)
            barcodeInput.addEventListener('input', function(e) {
                const code = this.value.trim();

                // Solo si es un código válido
                if (code.startsWith('HR') && code.length === 7) {
                    console.log("Código detectado por escáner físico:", code);
                    processScan(code);  // Usa la misma función que ya tienes para Quagga
                    this.value = '';    // Limpia para el siguiente escaneo

                    // Feedback visual rápido (opcional)
                    resultDiv.innerHTML = `<div class="text-2xl text-green-400 mt-4">Escaneado con éxito: ${code}</div>`;
                    setTimeout(() => { resultDiv.innerHTML = ''; }, 1500);
                }

                // Limpieza si se escribe algo raro o muy largo
                if (this.value.length > 15) {
                    this.value = '';
                }
            });

            // Mantener el foco siempre en el input oculto (para que el escáner funcione sin clic)
            setInterval(() => {
                if (document.activeElement !== barcodeInput) {
                    barcodeInput.focus();
                }
            }, 500);

            // Actualizar historial cada 2 segundos
            setInterval(updateLastScans, 2000);

            // Cargar historial y herramientas al inicio
            updateLastScans();
            loadTools();
        });
    </script>
</body>
</html>