<section>
    <ul id="videoGrid" class="row g-3">
        {{-- Exibe os vídeos se a variável $data estiver preenchida --}}
        @if (!empty($data) && isset($data->items))
            @php
                $isSingleVideo = count($data->items) === 1; // Verifica se há apenas um vídeo
            @endphp

            @foreach ($data->items as $video)
                @php
                    // Verifica se o ID do vídeo está disponível
                    $videoId = $video->id->videoId ?? $video->id ?? null;
                    $thumbnail = $video->snippet->thumbnails->high->url ?? '';
                    $title = $video->snippet->title ?? 'Sem título';
                    $videoUrl = $videoId ? "https://www.youtube.com/watch?v={$videoId}" : '#';
                @endphp

                @if ($videoId)
                    <li class="{{ $isSingleVideo ? 'col-12' : 'col-6 col-md-6' }}">
                        <div class="video" style="background-image: url('{{ $thumbnail }}');">
                            <input type="checkbox" name="selectedVideos" value="{{ $videoUrl }}" title="{{ $title }}">
                        </div>
                    </li>
                @endif
            @endforeach
        @else
            <p>Nenhum vídeo encontrado.</p>
        @endif
    </ul>
    @if (!$isSingleVideo)
        <div class="pagination-buttons mt-3 d-flex justify-content-center" style="height: 50px;">
            <nav>
                <ul class="pagination">
                    {{-- Botão para voltar --}}
                    <li class="page-item {{ empty($prevPageToken) ? 'disabled' : '' }}">
                        <a href="javascript:void(0);" class="page-link" 
                        onclick="{{ !empty($prevPageToken) ? "loadPage('$prevPageToken', '$channelUrl')" : '' }}">
                            Voltar
                        </a>
                    </li>

                    {{-- Botão para avançar --}}
                    <li class="page-item {{ empty($nextPageToken) ? 'disabled' : '' }}">
                        <a href="javascript:void(0);" class="page-link" 
                        onclick="{{ !empty($nextPageToken) ? "loadPage('$nextPageToken', '$channelUrl')" : '' }}">
                            Avançar
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    @endif
</section>