<x-app-layout>
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div style="padding: 2rem; text-align: center;">
                <h2 style="color: white; font-size: 2rem; font-weight: bold; margin: 0;">
                    {{ __('Importar Testigos') }}
                </h2>
                <p style="color: rgba(255,255,255,0.8); margin-top: 0.5rem; font-size: 0.9rem;">
                    Carga masiva de testigos desde archivo CSV
                </p>
            </div>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif !important;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%) !important;
            min-height: 100vh;
        }

        .modern-container {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.8) 100%);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            overflow: hidden;
            max-width: 800px;
            margin: 0 auto;
        }

        .header-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding: 2rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            cursor: pointer;
        }

        .btn-primary:hover {
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-secondary:hover {
            box-shadow: 0 8px 25px rgba(107, 114, 128, 0.4);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: #374151;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        .info-box {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border: 1px solid #93c5fd;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .info-box h4 {
            color: #1e40af;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .info-box ul {
            color: #1e40af;
            margin: 0;
            padding-left: 1.25rem;
        }

        .info-box li {
            margin-bottom: 0.25rem;
        }

        .file-upload {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .file-upload:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .file-upload.dragover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 1rem;
            background: #f9fafb;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .checkbox-label:hover {
            background: #f3f4f6;
        }

        .checkbox-label input[type="checkbox"] {
            width: 1.25rem;
            height: 1.25rem;
            accent-color: #667eea;
        }

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
        }
    </style>

    <div style="padding: 3rem 0;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 1.5rem;">
            <div class="modern-container">
                <div class="header-section">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <h3 style="color: #1f2937; font-size: 1.5rem; font-weight: 700; margin: 0;">Cargar Archivo CSV</h3>
                            <p style="color: #6b7280; margin: 0.5rem 0 0 0;">Importe multiples testigos de forma rapida</p>
                        </div>
                        <div style="display: flex; gap: 0.75rem;">
                            <a href="{{ route('testigos.import.template') }}" class="btn-success">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Descargar Plantilla
                            </a>
                            <a href="{{ route('testigos.index') }}" class="btn-secondary">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Volver
                            </a>
                        </div>
                    </div>
                </div>

                <div style="padding: 2rem;">
                    @if ($errors->any())
                        <div class="error-message">
                            <strong>Error:</strong>
                            <ul style="margin: 0.5rem 0 0 1rem; padding: 0;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="info-box">
                        <h4>Formato del archivo CSV</h4>
                        <ul>
                            <li><strong>documento</strong> - Numero de documento (obligatorio, unico)</li>
                            <li><strong>nombre</strong> - Nombre completo (obligatorio, max 30 caracteres)</li>
                            <li><strong>zona</strong> - Numero de zona, ej: 01, 02, 03 (obligatorio)</li>
                            <li><strong>puesto</strong> - Numero de puesto dentro de la zona, ej: 01, 02 (obligatorio)</li>
                            <li><strong>mesas</strong> - Numeros de mesa separados por coma, ej: 1,2,3 (obligatorio)</li>
                            <li><strong>alias</strong> - Alias del testigo (opcional)</li>
                            <li><strong>email</strong> - Email para acceso al portal (opcional, se genera automaticamente si no se incluye)</li>
                            <li><strong>password</strong> - Contrasena (opcional, si no se proporciona: testigo + documento)</li>
                        </ul>
                        <p style="margin-top: 0.75rem; font-size: 0.875rem;">
                            <strong>Ejemplo:</strong> Para el puesto "COL SAN JOSE" que esta en Zona 01, Puesto 01, use: zona=01, puesto=01
                        </p>
                        <p style="margin-top: 0.5rem; font-size: 0.875rem;">
                            <strong>Nota:</strong> Use punto y coma (;) o coma (,) como separador de columnas.
                        </p>
                        <div style="margin-top: 0.75rem; padding: 0.75rem; background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-radius: 8px; border: 1px solid #86efac;">
                            <p style="margin: 0; font-size: 0.85rem; color: #166534;">
                                <strong>Usuario automático:</strong> Al importar, se crea automáticamente un usuario para cada testigo.
                                Si no incluye email, se genera como <code>nombre.documento@testigo.com</code>.
                            </p>
                            <p style="margin: 0.5rem 0 0 0; font-size: 0.85rem; color: #166534;">
                                <strong>Contraseñas:</strong> Puede especificar una contraseña predeterminada en el formulario (se aplicará a todos), 
                                incluir contraseñas individuales en el CSV, o dejar que se generen automáticamente como <code>testigo + documento</code>.
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('testigos.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">Archivo CSV</label>
                            <div class="file-upload" id="dropzone" onclick="document.getElementById('archivo_csv').click()">
                                <input type="file" name="archivo_csv" id="archivo_csv" accept=".csv,.txt" style="display: none;" required>
                                <svg width="48" height="48" fill="none" stroke="#9ca3af" viewBox="0 0 24 24" style="margin: 0 auto 1rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p style="color: #6b7280; margin: 0;" id="file-name">
                                    Haga clic o arrastre el archivo CSV aqui
                                </p>
                                <p style="color: #9ca3af; font-size: 0.875rem; margin: 0.5rem 0 0 0;">
                                    Maximo 2MB
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Contraseña Predeterminada (Opcional)</label>
                            <input type="password" name="password_predeterminada" id="password_predeterminada" class="form-input" minlength="6" placeholder="Dejar vacío para usar contraseñas del CSV o auto-generar">
                            <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.5rem;">
                                Si especifica una contraseña aquí, se aplicará a <strong>todos</strong> los testigos importados, 
                                ignorando las contraseñas del CSV. Si deja este campo vacío, se usarán las contraseñas del CSV 
                                o se generarán automáticamente como <code>testigo + documento</code>.
                            </p>
                        </div>

                        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                            <a href="{{ route('testigos.index') }}" class="btn-secondary">Cancelar</a>
                            <button type="submit" class="btn-primary">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Importar Testigos
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mostrar nombre del archivo seleccionado
        document.getElementById('archivo_csv').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Haga clic o arrastre el archivo CSV aqui';
            document.getElementById('file-name').textContent = fileName;
        });

        // Drag and drop
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('archivo_csv');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => dropzone.classList.add('dragover'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => dropzone.classList.remove('dragover'), false);
        });

        dropzone.addEventListener('drop', function(e) {
            const files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files;
                document.getElementById('file-name').textContent = files[0].name;
            }
        });
    </script>
</x-app-layout>
