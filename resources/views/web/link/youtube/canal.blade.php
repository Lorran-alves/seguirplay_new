<section class="channel-details text-center" style="color: #fff; padding: 5px; ">
    <div class="channel-header" style="display: flex; flex-direction: row;">
        <img src="{{ $data['logo'] }}" alt="Logo do Canal" class="channel-logo" style="width: 70px; height: 70px; border-radius: 50%; margin-bottom: 10px;">
        <div style="display: flex; flex-direction:column; align-items: start; padding-left: 5px;">
            <h2 style="margin: 0; font-size: 20px;">{{ $data['name'] }}</h2>
            <p style="margin: 5px 0; font-size: 13px; text-align: left;">
                {{ $data['username'] }}
                <strong>{{ number_format($data['subscribers']) }}</strong> inscritos · 
                <strong>{{ $data['videos'] }}</strong> vídeos
            </p>
        </div>
    </div>
</section>