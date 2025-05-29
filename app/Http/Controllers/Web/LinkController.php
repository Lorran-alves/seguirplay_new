<?php 

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Exception;
use Google\Client;
use Google\Service\YouTube;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    protected $tokenYoutube = 'AIzaSyDYMX_-LDxLhLoLnaUaqLNtUndr45LZv7o';

    public function getPlatformData($platform, Request $request)
    {

        $url = $request->input('url');
        $seguidores = $request->input('seguidores') == 3 ? true : false;
        $platform = strtolower($platform);
        $pageToken = $request->input('pageToken', null);

        switch ($platform) {
            case 'youtube':
                return $this->handleYoutube($url, $seguidores, $pageToken);
            case 'instagram':
                return $this->handleInstagram($url);
            case 'facebook':
                return $this->handleFacebook($url);
            case 'tiktok':
                return $this->handleTikTok($url);
            default:
                return response()->json(['error' => 'Plataforma não suportada'], 400);
        }
    }

    // Função para extrair ID do canal ou do vídeo
    public function getYoutubeId($url) {
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $url, $matches)) {
            return ['type' => 'video', 'id' => $matches[1]];
        }

        if (preg_match('/youtube\.com\/channel\/([^\/?]+)/', $url, $matches)) {
            return ['type' => 'channel', 'id' => $matches[1]];
        }

        if (preg_match('/youtube\.com\/@([^\/?]+)/', $url, $matches)) {
            return ['type' => 'username', 'id' => $matches[1]];
        }

        if (preg_match('/youtube\.com\/c\/([^\/?]+)/', $url, $matches)) {
            return ['type' => 'custom', 'id' => $matches[1]];
        }

        return null;
    }

    private function getChannelId($identifier)
    {
        $client = new Client();
        $client->setDeveloperKey($this->tokenYoutube);
        $client->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));

        $youtube = new YouTube($client);
        try {
            $response = $youtube->channels->listChannels('id', [
                'forHandle' => $identifier
            ]);

            if (!empty($response->items)) {
                return $response->items[0]->id;
            }
        } catch (Exception $e) {
            return null;
        }

        return null;
    }

    private function fetchYoutubeData($id, $type, $seguidores, $pageToken = null)
    {
        $client = new Client();
        $client->setDeveloperKey($this->tokenYoutube);
        $client->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));
        $youtube = new YouTube($client);

        try {
            if ($type == "video") {
                $response = $youtube->videos->listVideos('snippet', ['id' => $id]);

            } else {

                if($seguidores){
                    $response = $youtube->channels->listChannels('snippet,statistics', [
                        'id' => $id,
                    ]);

                    if (!empty($response->items)) {
                        $channel = $response->items[0]; // Pega o primeiro item (detalhes do canal)
                        return [
                            'name' => $channel->snippet->title, 
                            'logo' => $channel->snippet->thumbnails->high->url,
                            'subscribers' => $channel->statistics->subscriberCount, 
                            'videos' => $channel->statistics->videoCount,
                            'username' => $channel->snippet->customUrl ?? '' . $channel->snippet->title,
                        ];
                    }

                } else {
                    $params = [
                        'channelId' => $id,
                        'maxResults' => 6,
                        'order' => 'date',
                        'type' => 'video',
                    ];
        
                    if ($pageToken) {
                        $params['pageToken'] = $pageToken;
                    }
        
                    $response = $youtube->search->listSearch('snippet', $params);
                }
            }

            return $response->toSimpleObject();
        } catch (Exception $e) {
            return ['error' => 'Erro ao buscar dados: ' . $e->getMessage()];
        }

        return []; // Retorna um array vazio se não houver resultados
    }


    private function handleYoutube($url, $seguidores, $pageToken = null)
    {
        $data = $this->getYoutubeId($url);
        if ($data) {
            if ($data['type'] === 'username' || $data['type'] === 'custom') {
                $channelId = $this->getChannelId($data['id']);
                if ($channelId) {
                    $data['type'] = 'channel';
                    $data['id'] = $channelId;
                } else {
                    return response()->json(['error' => 'URL inválida ou não suportada.']);
                }
            }

            $youtubeData = $this->fetchYoutubeData($data['id'], $data['type'], $seguidores, $pageToken);
           
            // var_dump($youtubeData); // Debugging: Exibe os dados retornados

            if($seguidores){
                return view('web.link.youtube.canal', ['data' => $youtubeData]);
            }
            
            return view('web.link.youtube.video', [
                'data' => $youtubeData,
                'nextPageToken' => $youtubeData->nextPageToken ?? null,
                'prevPageToken' => $youtubeData->prevPageToken ?? null,
                'channelUrl' => $url
            ]);
        }

        return response()->json(['error' => 'URL inválida ou não suportada.']);

    }

}
