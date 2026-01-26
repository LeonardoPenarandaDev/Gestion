<x-app-layout>
    <x-slot name="header">
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div style="padding: 2rem; text-align: center;">
                <h2 style="color: white; font-size: 2rem; font-weight: bold; margin: 0;">
                    Reportar Resultados - Mesa #{{ $mesa->numero_mesa }}
                </h2>
                <p style="color: rgba(255,255,255,0.9); margin-top: 0.5rem; font-size: 0.9rem;">
                    {{ $mesa->puesto->nombre }} - Zona {{ $testigo->fk_id_zona }}
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
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #4facfe;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 172, 254, 0.4);
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #2d3748;
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary:hover {
            background: #cbd5e0;
            color: #2d3748;
        }

        .image-preview {
            margin-top: 1rem;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            display: none;
        }

        .image-preview img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .current-image {
            margin-top: 1rem;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 400px;
        }

        .current-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .error-message {
            color: #e53e3e;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .info-box {
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%);
            border-left: 4px solid #4facfe;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .char-counter {
            text-align: right;
            font-size: 0.75rem;
            color: #718096;
            margin-top: 0.25rem;
        }

        .char-counter.warning {
            color: #ed8936;
        }

        .char-counter.danger {
            color: #e53e3e;
        }

        /* Estilos para botones de captura de imagen */
        .capture-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .btn-capture {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1.5rem 1rem;
            border: 2px dashed #cbd5e0;
            border-radius: 12px;
            background: #f7fafc;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            color: #4a5568;
        }

        .btn-capture:hover {
            border-color: #4facfe;
            background: rgba(79, 172, 254, 0.05);
            color: #4facfe;
        }

        .btn-capture:active {
            transform: scale(0.98);
        }

        .btn-camera {
            border-color: #48bb78;
            background: linear-gradient(135deg, rgba(72, 187, 120, 0.1) 0%, rgba(56, 161, 105, 0.05) 100%);
            color: #276749;
        }

        .btn-camera:hover {
            border-color: #38a169;
            background: linear-gradient(135deg, rgba(72, 187, 120, 0.2) 0%, rgba(56, 161, 105, 0.1) 100%);
            color: #22543d;
        }

        .btn-gallery {
            border-color: #4facfe;
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.05) 100%);
            color: #2b6cb0;
        }

        .btn-gallery:hover {
            border-color: #3182ce;
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.2) 0%, rgba(0, 242, 254, 0.1) 100%);
            color: #2c5282;
        }

        .image-preview {
            margin-top: 1rem;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            display: none;
            border: 2px solid #48bb78;
        }

        .preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .btn-remove-preview {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-remove-preview:hover {
            background: rgba(255,255,255,0.3);
        }

        #previewImg {
            max-width: 100%;
            height: auto;
            display: block;
        }

        /* Responsive para móviles */
        @media (max-width: 480px) {
            .capture-buttons {
                flex-direction: column;
            }

            .btn-capture {
                padding: 1.25rem;
            }
        }
    </style>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div style="background: linear-gradient(135deg, #f56565 0%, #c53030 100%); color: white; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(245, 101, 101, 0.3);">
                    <strong>✗</strong> {{ session('error') }}
                </div>
            @endif

            @if($mesa->resultado)
                <div class="info-box">
                    <strong>ℹ Información:</strong> Esta mesa ya fue reportada el {{ $mesa->resultado->created_at->format('d/m/Y H:i') }}.
                    Puede actualizar la información si es necesario.
                </div>
            @endif

            <div class="modern-container">
                <div style="padding: 2rem; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #2d3748; margin: 0;">
                        Formulario de Reporte
                    </h3>
                    <p style="color: #718096; margin-top: 0.5rem; margin-bottom: 0;">
                        Complete la información del acta de votación
                    </p>
                </div>

                <form action="{{ route('testigo.guardar-reporte', $mesa->id) }}" method="POST" enctype="multipart/form-data" style="padding: 2rem;">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">
                            <svg style="width: 1rem; height: 1rem; display: inline; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Foto del Formulario E14
                        </label>

                        <!-- Contenedor de botones para captura -->
                        <div class="capture-buttons">
                            <button type="button" class="btn-capture btn-camera" onclick="document.getElementById('camera_input').click()">
                                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>Tomar Foto</span>
                            </button>

                            <button type="button" class="btn-capture btn-gallery" onclick="document.getElementById('gallery_input').click()">
                                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>Subir Imagen</span>
                            </button>
                        </div>

                        <!-- Input oculto para cámara -->
                        <input
                            type="file"
                            id="camera_input"
                            accept="image/*"
                            capture="environment"
                            style="display: none;"
                            onchange="handleImageSelect(event, 'camera')"
                        >

                        <!-- Input oculto para galería -->
                        <input
                            type="file"
                            id="gallery_input"
                            accept="image/jpeg,image/png,image/jpg"
                            style="display: none;"
                            onchange="handleImageSelect(event, 'gallery')"
                        >

                        <!-- Input real que se enviará con el formulario -->
                        <input type="file" id="imagen_acta" name="imagen_acta" style="display: none;">

                        <p style="color: #718096; font-size: 0.875rem; margin-top: 0.75rem; text-align: center;">
                            Formatos permitidos: JPG, PNG. Tamaño máximo: 5MB
                        </p>

                        @error('imagen_acta')
                            <p class="error-message">{{ $message }}</p>
                        @enderror

                        @if($mesa->resultado && $mesa->resultado->imagen_acta)
                            <div class="current-image" id="currentImage">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem; background: #f7fafc;">
                                    <p style="font-size: 0.875rem; color: #718096; margin: 0;">
                                        Imagen actual:
                                    </p>
                                    <button type="button" onclick="removeCurrentImage()" style="background: #e53e3e; color: white; border: none; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; cursor: pointer;">
                                        Cambiar
                                    </button>
                                </div>
                                <img src="{{ Storage::url($mesa->resultado->imagen_acta) }}" alt="Acta actual">
                            </div>
                        @endif

                        <!-- Preview de nueva imagen -->
                        <div id="imagePreview" class="image-preview">
                            <div class="preview-header">
                                <span>Nueva imagen:</span>
                                <button type="button" onclick="clearImagePreview()" class="btn-remove-preview">
                                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Quitar
                                </button>
                            </div>
                            <img id="previewImg" src="" alt="Preview">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="total_votos" class="form-label">
                            <svg style="width: 1rem; height: 1rem; display: inline; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Total de Votos (Opcional)
                        </label>
                        <input
                            type="number"
                            id="total_votos"
                            name="total_votos"
                            class="form-input"
                            placeholder="Ej: 350"
                            min="0"
                            value="{{ old('total_votos', $mesa->resultado->total_votos ?? '') }}"
                        >
                        @error('total_votos')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="observacion" class="form-label">
                            <svg style="width: 1rem; height: 1rem; display: inline; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Observaciones <span style="color: #e53e3e;">*</span>
                        </label>
                        <textarea
                            id="observacion"
                            name="observacion"
                            class="form-input form-textarea"
                            placeholder="Describa los resultados de la votación, observaciones importantes, irregularidades detectadas, etc."
                            required
                            maxlength="1000"
                            oninput="updateCharCount()"
                        >{{ old('observacion', $mesa->resultado->observacion ?? '') }}</textarea>
                        <div id="charCounter" class="char-counter">
                            <span id="charCount">0</span> / 1000 caracteres
                        </div>
                        @error('observacion')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="display: flex; gap: 1rem; margin-top: 2rem; flex-wrap: wrap;">
                        <button type="submit" class="btn-primary">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $mesa->resultado ? 'Actualizar Reporte' : 'Enviar Reporte' }}
                        </button>

                        <a href="{{ route('testigo.portal') }}" class="btn-secondary">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Volver
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Variable para almacenar el archivo seleccionado
        let selectedFile = null;

        function handleImageSelect(event, source) {
            const file = event.target.files[0];

            if (file) {
                // Validar tamaño (5MB máximo)
                if (file.size > 5 * 1024 * 1024) {
                    alert('La imagen es demasiado grande. El tamaño máximo es 5MB.');
                    event.target.value = '';
                    return;
                }

                // Validar tipo de archivo
                if (!file.type.match(/^image\/(jpeg|jpg|png)$/i)) {
                    alert('Formato no válido. Solo se permiten imágenes JPG y PNG.');
                    event.target.value = '';
                    return;
                }

                selectedFile = file;

                // Transferir el archivo al input real del formulario
                const realInput = document.getElementById('imagen_acta');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                realInput.files = dataTransfer.files;

                // Mostrar preview
                const preview = document.getElementById('imagePreview');
                const previewImg = document.getElementById('previewImg');
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';

                    // Ocultar imagen actual si existe
                    const currentImage = document.getElementById('currentImage');
                    if (currentImage) {
                        currentImage.style.display = 'none';
                    }
                }
                reader.readAsDataURL(file);

                // Actualizar estilo de botones para indicar éxito
                updateCaptureButtons(source);
            }
        }

        function updateCaptureButtons(source) {
            const cameraBtn = document.querySelector('.btn-camera');
            const galleryBtn = document.querySelector('.btn-gallery');

            // Resetear estilos
            cameraBtn.innerHTML = `
                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>Tomar Foto</span>
            `;

            galleryBtn.innerHTML = `
                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>Subir Imagen</span>
            `;

            // Marcar el botón usado con checkmark
            const activeBtn = source === 'camera' ? cameraBtn : galleryBtn;
            activeBtn.innerHTML = `
                <svg style="width: 1.5rem; height: 1.5rem; color: #48bb78;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span style="color: #48bb78;">Imagen Capturada</span>
            `;
        }

        function clearImagePreview() {
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const realInput = document.getElementById('imagen_acta');
            const cameraInput = document.getElementById('camera_input');
            const galleryInput = document.getElementById('gallery_input');

            // Limpiar preview
            preview.style.display = 'none';
            previewImg.src = '';

            // Limpiar inputs
            realInput.value = '';
            cameraInput.value = '';
            galleryInput.value = '';
            selectedFile = null;

            // Mostrar imagen actual si existe
            const currentImage = document.getElementById('currentImage');
            if (currentImage) {
                currentImage.style.display = 'block';
            }

            // Resetear botones
            resetCaptureButtons();
        }

        function removeCurrentImage() {
            const currentImage = document.getElementById('currentImage');
            if (currentImage) {
                currentImage.style.display = 'none';
            }
        }

        function resetCaptureButtons() {
            const cameraBtn = document.querySelector('.btn-camera');
            const galleryBtn = document.querySelector('.btn-gallery');

            cameraBtn.innerHTML = `
                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>Tomar Foto</span>
            `;

            galleryBtn.innerHTML = `
                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>Subir Imagen</span>
            `;
        }

        function updateCharCount() {
            const textarea = document.getElementById('observacion');
            const counter = document.getElementById('charCount');
            const counterContainer = document.getElementById('charCounter');
            const length = textarea.value.length;

            counter.textContent = length;

            counterContainer.classList.remove('warning', 'danger');
            if (length > 900) {
                counterContainer.classList.add('danger');
            } else if (length > 750) {
                counterContainer.classList.add('warning');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateCharCount();
        });
    </script>
</x-app-layout>
