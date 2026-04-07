<?php

namespace App\Livewire\Public;

use App\Models\Gallery;
use App\Services\PublicWebsiteData;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontbase')]
class GalleryPage extends Component
{
    /** @var array<int, array{id:int,url:string,caption:string}> */
    public array $galleryImages = [];

    public bool $galleryHasMore = true;

    public int $galleryBatchSize = 12;

    public bool $loadingGallery = false;

    /** @var array<int, array{id:int,video_id:string,caption:string}> */
    public array $galleryVideos = [];

    public bool $galleryVideosHasMore = true;

    public int $galleryVideoBatchSize = 12;

    public int $videoDbOffset = 0;

    public bool $loadingVideos = false;

    public function mount(): void
    {
        $this->galleryImages = [];
        $this->galleryHasMore = true;
        $this->loadMoreGalleryImages();

        $this->galleryVideos = [];
        $this->videoDbOffset = 0;
        $this->galleryVideosHasMore = true;
        $this->loadMoreVideos();
    }

    public function loadMoreGalleryImages(): void
    {
        if (! $this->galleryHasMore || $this->loadingGallery) {
            return;
        }

        $this->loadingGallery = true;

        try {
            $offset = count($this->galleryImages);
            $batch = Gallery::query()
                ->where('media_type', 'image')
                ->whereNotNull('image')
                ->where('image', '!=', '')
                ->oldest('id')
                ->skip($offset)
                ->take($this->galleryBatchSize)
                ->get();

            foreach ($batch as $img) {
                $this->galleryImages[] = [
                    'id' => $img->id,
                    'url' => $this->galleryImageUrl($img),
                    'caption' => (string) ($img->caption ?? ''),
                ];
            }

            $this->galleryHasMore = $batch->count() === $this->galleryBatchSize;
        } finally {
            $this->loadingGallery = false;
        }
    }

    public function loadMoreVideos(): void
    {
        if (! $this->galleryVideosHasMore || $this->loadingVideos) {
            return;
        }

        $this->loadingVideos = true;

        try {
            $batch = Gallery::query()
                ->whereNotNull('youtube_link')
                ->where('youtube_link', '!=', '')
                ->oldest('id')
                ->skip($this->videoDbOffset)
                ->take($this->galleryVideoBatchSize)
                ->get();

            $this->videoDbOffset += $batch->count();

            foreach ($batch as $video) {
                $vid = $video->youtube_video_id;
                if (! $vid) {
                    continue;
                }
                $this->galleryVideos[] = [
                    'id' => $video->id,
                    'video_id' => $vid,
                    'caption' => (string) ($video->caption ?? ''),
                ];
            }

            $this->galleryVideosHasMore = $batch->count() === $this->galleryVideoBatchSize;
        } finally {
            $this->loadingVideos = false;
        }
    }

    protected function galleryImageUrl(Gallery $img): string
    {
        $path = $img->image;
        if ($path && (strpos($path, 'gallery/') === 0 || strpos($path, '/') !== false)) {
            return asset('storage/'.$path);
        }

        return asset('storage/images/gallery/'.$path);
    }

    public function render()
    {
        return view('frontend.gallery', PublicWebsiteData::galleryPageStatic());
    }
}
