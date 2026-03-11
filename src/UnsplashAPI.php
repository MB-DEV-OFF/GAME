<?php
require_once __DIR__ . '/../config/config.php';

class UnsplashAPI {
    private $api_key;
    private $base_url;
    private $cache_dir;
    
    public function __construct() {
        $this->api_key = UNSPLASH_API_KEY;
        $this->base_url = UNSPLASH_BASE_URL;
        $this->cache_dir = __DIR__ . '/../public/images/';
    }
    
    // Télécharger 4 images aléatoires d'une catégorie
    public function getRandomImages($query, $count = 4) {
        try {
            $url = $this->base_url . '/photos/random';
            $params = [
                'query' => urlencode($query),
                'count' => $count,
                'w' => 300,
                'h' => 300
            ];
            
            $full_url = $url . '?' . http_build_query($params);
            
            $headers = [
                'Authorization: Client-ID ' . $this->api_key,
                'Accept-Version: v1'
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $full_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($http_code !== 200) {
                return ['success' => false, 'message' => 'Erreur API Unsplash'];
            }
            
            $data = json_decode($response, true);
            
            if (!is_array($data)) {
                $data = [$data];
            }
            
            $images = [];
            foreach ($data as $photo) {
                $images[] = [
                    'url' => $photo['urls']['regular'],
                    'photographer' => $photo['user']['name'] ?? 'Unknown',
                    'id' => $photo['id']
                ];
            }
            
            return ['success' => true, 'images' => $images];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    // Obtenir les images par catégorie spécifique
    public function getImagesByCategory($category) {
        $categories = [
            'ANIMALS' => 'animal',
            'FRUITS' => 'fruit',
            'NATURE' => 'nature',
            'SPORTS' => 'sport',
            'FOOD' => 'food',
            'TECHNOLOGY' => 'technology',
            'BUILDING' => 'building',
            'MUSIC' => 'music'
        ];
        
        $query = $categories[$category] ?? 'random';
        return $this->getRandomImages($query, 4);
    }
    
    // Télécharger et mettre en cache une image
    public function cacheImage($imageUrl, $filename) {
        try {
            $ch = curl_init($imageUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            
            $imageData = curl_exec($ch);
            curl_close($ch);
            
            $filepath = $this->cache_dir . $filename;
            file_put_contents($filepath, $imageData);
            
            return basename($filepath);
            
        } catch (Exception $e) {
            return null;
        }
    }
}
?>
