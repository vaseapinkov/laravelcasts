<?php

namespace App\Livewire;

use App\Models\Video;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class VideoPlayer extends Component
{
    public Video $video;

    public Collection $courseVideos;

    public function mount(): void
    {
        $this->courseVideos = $this->video->course->videos;
    }

    public function render(): View
    {
        return view('livewire.video-player');
    }

    public function markVideoAsCompleted(): void
    {
        auth()->user()->watchedVideos()->attach($this->video);
    }

    public function markVideoAsNotCompleted(): void
    {
        auth()->user()->watchedVideos()->detach($this->video);
    }

    public function isCurrentVideo(Video $videoToCheck): bool
    {
        return $this->video->id === $videoToCheck->id;
    }
}
