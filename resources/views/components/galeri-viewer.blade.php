@props(['fotoGaleri', 'videoGaleri', 'groupKey'])

@if ($fotoGaleri->isNotEmpty() || $videoGaleri->isNotEmpty())
    @once
        <style>
            .galeri-viewer-thumb {
                position: relative;
                display: block;
                border-radius: 10px;
                overflow: hidden;
                aspect-ratio: 1 / 1;
                background-color: #1f2937;
                box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .galeri-viewer-thumb:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 18px rgba(15, 23, 42, 0.18);
            }

            .galeri-viewer-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }

            .galeri-viewer-overlay {
                position: absolute;
                inset: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(17, 24, 39, 0.35);
                color: #fff;
                font-size: 1.4rem;
                opacity: 0;
                transition: opacity 0.2s ease;
            }

            .galeri-viewer-thumb:hover .galeri-viewer-overlay {
                opacity: 1;
            }

            .galeri-viewer-thumb-video .galeri-viewer-overlay {
                opacity: 1;
                background: linear-gradient(160deg, #334155, #0f172a);
                font-size: 1.8rem;
            }

            .galeri-viewer-thumb-video:hover .galeri-viewer-overlay {
                background: linear-gradient(160deg, #3490dc, #0f172a);
            }
        </style>
    @endonce

    <div class="card card-body bg-light mb-3">
        <h4 class="mb-3"><i class="fas fa-images text-info"></i> Galeri Foto &amp; Video</h4>
        <div class="row">
            @foreach ($fotoGaleri as $foto)
                <div class="col-6 col-md-3 mb-3">
                    <a href="{{ $foto->getUrl() }}" class="glightbox galeri-viewer-thumb" data-gallery="galeri-{{ $groupKey }}" data-type="image">
                        <img src="{{ $foto->getUrl('thumb') }}" alt="{{ $foto->file_name }}">
                        <span class="galeri-viewer-overlay"><i class="fas fa-search-plus"></i></span>
                    </a>
                </div>
            @endforeach

            @foreach ($videoGaleri as $video)
                <div class="col-6 col-md-3 mb-3">
                    <a href="{{ $video->getUrl() }}" class="glightbox galeri-viewer-thumb galeri-viewer-thumb-video" data-gallery="galeri-{{ $groupKey }}" data-type="video">
                        <span class="galeri-viewer-overlay"><i class="fas fa-play"></i></span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
